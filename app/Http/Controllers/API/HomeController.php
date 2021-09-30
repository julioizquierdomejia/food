<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Carousel;
use App\Models\Category;
use App\Models\Raffle;
use App\Models\Ticket;
use App\Models\RaffleFavorite;
class HomeController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Get(
     *     path="/home",
     *     summary="Retorna los datos a mostrar en el inicio",
     *     tags={"Home"},
     *     @OA\Response(
     *         response=200,
     *         description="Home page data"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     ),
     *
     *
     *     security={{"apiAuth": {} }},
     *
     *     deprecated=false
     *
     * )
     */
    public function index()
    {
        try {
            $carousel = Carousel::all();
            $categories = Category::select('id','name','icon')->get();
            $raffles = Raffle::join('items','raffles.item_id', '=' , 'items.id')
            ->where('raffles.status','=','0')
            ->where('raffles.active','=','0')
            ->where('winner_id','=',null)
            ->select('raffles.id','raffles.item_id','start_date','end_date','raffle_goal_amount','progress','category_id','name','description','image','price')
            ->get();
            
            for ($i = 0; $i < count($raffles); $i++ ) {
                $favorite = RaffleFavorite::where('raffle_id',$raffles[$i]['raffle_id'])
                ->where('user_id',auth()->guard('api')->user()->id)
                ->get()->first();
                
                $favorite != null ? $raffles[$i]['favorite'] = true : $raffles[$i]['favorite'] = false;
            }

        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'data' => [
                'carousel' => $carousel,
                'categories' => $categories,
                'raffles' => $raffles
            ],
        ]);
    }
    /**
     * @OA\Get(
     *     path="/category/{id_category}",
     *     summary="Retorna las rifas por categoria",
     *     tags={"Category"},
     *     @OA\Parameter(
     *          name="id_category",
     *          description="id de categoria",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Page category data"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     ),
     *
     *
     *     security={{"apiAuth": {} }},
     *
     *     deprecated=false
     *
     * )
     */
    public function items_category($id_category)
    {
        try {
            $raffles = Raffle::join('items','raffles.item_id', '=' , 'items.id')
            ->where('raffles.status','=','0')
            ->where('raffles.active','=','0')
            ->where('winner_id','=',null)
            ->where('category_id','=',$id_category)
            ->select('raffles.id','raffles.item_id','start_date','end_date','raffle_goal_amount','progress','category_id','name','description','image','price')
            ->get();
            
            for ($i = 0; $i < count($raffles); $i++ ) {
                $favorite = RaffleFavorite::where('raffle_id',$raffles[$i]['raffle_id'])
                ->where('user_id',auth()->guard('api')->user()->id)
                ->get()->first();
                
                $favorite != null ? $raffles[$i]['favorite'] = true : $raffles[$i]['favorite'] = false;
            }

        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'data' => $raffles
            ,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/winners",
     *     summary="Retorna los datos a mostrar en el inicio",
     *     tags={"Home"},
     *     @OA\Response(
     *         response=200,
     *         description="Home page data"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     ),
     *
     *
     *     security={{"apiAuth": {} }},
     *
     *     deprecated=false
     *
     * )
     */
    public function winners()
    {
        try {
            $raffles = Raffle::join('items','raffles.item_id', '=' , 'items.id')
            ->where('winner_id','!=',null)
            ->join('raffle_winners','raffle_winners.raffle_id','=','raffles.id')
            ->join('users','raffles.winner_id','=','users.id')
            ->get();
            

        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'data' => $raffles,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/detailRaffle/{id_raffle}",
     *     summary="Retorna el detalle de una rifa.",
     *     tags={"Home"},
     *     @OA\Parameter(
     *          name="id_raffle",
     *          description="id de rifa",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Home page data"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     ),
     *
     *
     *     security={{"apiAuth": {} }},
     *
     *     deprecated=false
     *
     * )
     */
    public function detail($id_raffle)
    {
        try {
            $raffles = Raffle::find($id_raffle);

            $raffles['tickets'] = Ticket::where('raffle_id',$id_raffle)->select('id','quantity','price')->get();
            
            
            $favorite = RaffleFavorite::where('raffle_id',$id_raffle)
            ->where('user_id',auth()->guard('api')->user()->id)
            ->get()->first();
                
            $favorite != null ? $raffles[$i]['favorite'] = true : $raffles[$i]['favorite'] = false;


        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'data' => $raffles,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/favoritesRaffles",
     *     summary="Retorna tus rifas favoritas.",
     *     tags={"Home"},
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Home page data"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     ),
     *
     *
     *     security={{"apiAuth": {} }},
     *
     *     deprecated=false
     *
     * )
     */
    public function favorites()
    {
        try {
            $raffles = Raffle::join('raffle_favorites','raffles.id','=','raffle_favorites.raffle_id')
            ->where('raffle_favorites.user_id',auth()->guard('api')->user()->id)
            ->get();
            

        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'data' => $raffles,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/users/favorites",
     *     summary="New favorite",
     *     tags={"Usuarios"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="id_raffle",
     *                     type="integer"
     *                 ),
     *                 example={"id_raffle": "123456"}
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
    public function NewFavorite(Request $request)
    {
        try {

            $favorites = RaffleFavorite::where('raffle_id', $request->get('id_raffle'))
            ->where('user_id', auth()->guard('api')->user()->id)
            ->get()->first();

            if (!is_null($favorites)) {
                return $this->errorResponse('Ya es tu favorito', 400);
            }

            $newFavorite = new RaffleFavorite();
            $newFavorite->user_id = auth()->guard('api')->user()->id;
            $newFavorite->raffle_id = $request->get('id_raffle');
            $newFavorite->save();

            return $this->successResponse([
                'status' => 200,
                'message' => 'Favorite register',
                'data' => $newFavorite
            ]);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/users/favorites",
     *     summary="Delete favorite",
     *     tags={"Usuarios"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="id_raffle",
     *                     type="integer"
     *                 ),
     *                 example={"id_raffle": "123456"}
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
    public function DeleteFavorite(Request $request)
    {
        try {

            $favorites = RaffleFavorite::where('raffle_id', $request->get('id_raffle'))
            ->where('user_id', auth()->guard('api')->user()->id)
            ->get()->first();

            if (!is_null($favorites)) {
                return $this->errorResponse('No se encontro favorito', 400);
            }

           $favorites->delete();

            return $this->successResponse([
                'status' => 200,
                'message' => 'Favorite deleted'
            ]);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }
}
