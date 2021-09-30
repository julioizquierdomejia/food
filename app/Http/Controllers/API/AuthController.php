<?php

namespace App\Http\Controllers\API;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class AuthController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     summary="Autentificación de usuarios",
     *     tags={"Autentificación"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email": "email@gmail.com", "password": "987654321"}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *
     *     @OA\Response(
     *         response="400",
     *         description="Failed",
     *     ),
     *
     *     deprecated=false
     * )
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:5'
            ], [
                'email.required' => 'Correo electrónico es un campo requerido',
                'email.email' => 'Correo electrónico invalido',
                'password.required' => 'Contraseña es un campo requerido',
                'password.min' => 'Mínimo de caracteres no válido {5}',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 400);
            }

            $infoUsers = User::where('email', $request->get('email'))->get()->first();
            if ($infoUsers == null) {
                return $this->errorResponse('Lo sentimos su usuario no existe en el sistema.', 400);
            }

            $credencial = array('email' => $infoUsers->email, 'password' => $request->get('password'));

            if (!$token = auth()->guard('api')->attempt($credencial)) {
                return $this->errorResponse('Contraseña incorrecta', 400);
            }
            auth()->guard('api')->setUser($infoUsers);

            DB::table('users')
                ->where(['id' => $infoUsers->id])
                ->update(['token' => $token]);

            return $this->successResponse([
                'id' => $infoUsers->id,
                'email' => $infoUsers->email,
                'name' => $infoUsers->name,
                'access_token' => $token
            ]);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }
    /**
     * @OA\Post(
     *     path="/auth/storeToken",
     *     summary="Guardar token de dispositivo",
     *     tags={"Autentificación"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="token",
     *                     type="string"
     *                 ),
     *                 example={"token": "admin@gmail.com"}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *
     *     @OA\Response(
     *         response="400",
     *         description="Failed",
     *     ),
     *     security={{"apiAuth": {} }},
     *     deprecated=false
     * )
     */
    public function storeToken(Request $request)
    {
        $users = User::where('id', auth()->guard('api')->user()->id)->first();
        $users->device_token = $request->token;
        $users->update();
        return response()->json(['Token successfully stored.']);
    }

    /**
     * @OA\Post(
     *     path="/auth/register",
     *     summary="Registro de usuario",
     *     tags={"Autentificación"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string"
     *                 ),
     *                 example={"email": "email@gmail.com", "password": "123456789", "name": "Pepe", "phone": "phone"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="OK",
     *     ),
     *
     *     @OA\Response(
     *         response="400",
     *         description="Failed",
     *     ),
     *
     *     deprecated=false
     * )
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'name' => 'required|string|min:3',
                'phone' => 'required|digits:9',
                'password' => 'required|min:5',
            ], [
                'email.required' => 'Correo electrónico es un campo requerido',
                'email.email' => 'Correo electrónico invalido',
                'name.required' => 'Nombre es un campo requerido',
                'name.min' => 'Mínimo de caracteres no válido {name}',
                'phone.required' => 'Número telefónico es un campo requerido',
                'phone.digits' => 'Número telefónico incorrecto',
                'password.required' => 'Contraseña es un campo requerido',
                'password.min' => 'Contraseña es demasiado corta',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 400);
            }

            $user = User::where('email', $request->get('email'))->get()->first();
            if ($user != null) {
                return $this->errorResponse('El correo electrónico ya está registrado', 400);
            }

            $user = User::where('phone', $request->get('phone'))->get()->first();
            if ($user != null) {
                return $this->errorResponse('Ya el número de telefono está registrado', 400);
            }

            $users = new User();
            $users->email = $request->get('email');
            $users->password = Hash::make($request->get('password'));
            $users->name = $request->get('name');
            $users->role = 2;
            $users->save();


            return $this->createResponse([
                'status' => 201,
                'message' => 'Usuario registrado',
                'data' => $users,
            ]);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }
     /**
     * @OA\Get(
     *     path="/auth/info",
     *     summary="Información del usuario logeado",
     *     tags={"Autentificación"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *
     *     @OA\Response(
     *         response="400",
     *         description="Failed",
     *     ),
     *
     *     security={{"apiAuth": {} }},
     *
     *     deprecated=false
     * )
     */
    public function info()
    {
        try {
            $users = User::findOrFail(auth()->guard('api')->user()->id);
            return $this->successResponse($users);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }
    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     summary="Finaliza la sessión del usuario",
     *     tags={"Autentificación"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *
     *     @OA\Response(
     *         response="400",
     *         description="Failed",
     *     ),
     *
     *     security={{"apiAuth": {} }},
     *
     *     deprecated=false
     * )
     */
    public function logout()
    {
        $users = UsersMovilModel::where('iduser', auth()->guard('api')->user()->iduser)->get()->first();
        auth()->logout(true);
        $users->token = null;
        $users->device_token = null;
        $users->update();

        return $this->successResponse([
            'status' => 200,
            'message' => 'Ha salido del sistema'
        ]);
    }
    /**
     * @OA\Put(
     *     path="/users/{id_user}",
     *     summary="Modifiy user information",
     *     tags={"Usuarios"},
     *
     *     @OA\Parameter(
     *          name="id_user",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string"
     *                 ),
     *                 example={"name": "Pepe", "surnames": "Garcia Fuentes","phone":"984575821"}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *
     *     @OA\Response(
     *         response="400",
     *         description="Failed",
     *     ),
     *
     *     security={{"apiAuth": {} }},
     *
     *     deprecated=false
     * )
     */
    public function update(Request $request, $idUser)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:3',
                'phone' => 'required|min:9|max:10|string',
            ], [
                'name.required' => 'Name is required',
                'name.min' => 'Mínimo de caracteres no válido {name}',
                'phone.required' => 'Phone is required',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 400);
            }

            $users = User::find($idUser);
            $users->name = $request->get('name');

            $phone_exists = User::where('phone', $request->get('phone'))->first();
            if ($phone_exists && $phone_exists->iduser != $users->iduser) {
                return $this->errorResponse('Phone already exists', 400);
            }

            $users->phone = $request->get('phone');
            $users->update();

            return $this->successResponse([
                'status' => 200,
                'message' => 'Updated Successfully'
            ]);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/users/public/resetpass/{email}",
     *     summary="email to reset password, send code to email",
     *     tags={"Usuarios"},
     *
     *     @OA\Parameter(
     *          name="email",
     *          description="Email",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *
     *     @OA\Response(
     *         response="400",
     *         description="Failed",
     *     ),
     *
     *     deprecated=false
     * )
     */

    public function sendEmailPassword($user_email)
    {
        try {
            $data = User::where('email', $user_email)->first();
            if ($data != null) {
                $data->reset_token = random_int(100000, 999999);
                $data->save();
                Mail::to($user_email)->send(new ResetPassword("Reset Password", $data));

                return $this->successResponse([
                    'status' => 200,
                    'message' => 'Mail was sent to reset password'
                ]);
            } else {
                return $this->errorResponse('Email not found', 400);
            }
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    /**
     * @OA\Post(
     *     path="/users/public/resetpass",
     *     summary="Reset password",
     *     tags={"Usuarios"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="token",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"password": "123456","token":"123456"}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *
     *     @OA\Response(
     *         response="400",
     *         description="Failed",
     *     ),
     *
     *     deprecated=false
     * )
     */
    public function NewPass(Request $request)
    {
        try {

            $user = UsersMovilModel::where('reset_token', $request->get('token'))->first();

            if (is_null($user)) {
                return $this->errorResponse('Code has been expired', 400);
            }

            $user->password = Hash::make($request->get('password'));
            $user->reset_token = null;
            $user->token = null;
            $user->save();

            return $this->successResponse([
                'status' => 200,
                'message' => 'Password has been updated successfully'
            ]);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }
    
}
