<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Raffle;
use App\Models\Ticket;
use App\Models\User;
use App\Models\UserTicket;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use PhpParser\JsonDecoder;

class PaymentController extends Controller
{
    use ApiResponse;

    public function paymentTest()
    {
        $url = 'https://api.micuentaweb.pe/api-payment/V4/Charge/SDKTest';
        $account = "72672204:Larifa@@2021";
        $b64account = base64_encode($account);
        $headers = ['Authorization' => 'Basic ' . $b64account,
        'Content-Type'=> 'application/json'];
        $body = [
            'value'=> 'my testing value'
        ];

        $response = Http::withHeaders($headers)->post($url, $body);


        return $this->successResponse([
            'status' => 200,
            'message' => 'Mail was sent to reset password',
            'data' =>$response->status()
        ]);
    }
    public function paymentCreate(Request $requet)
    {
        try {
        $data = request()->json()->all();


        $car = $data['car'];
        $amount = $data['amount'];
        $iduser = $data['iduser'];
        $pan = $data['pan'];
        $expiryMonth = $data['expiryMonth'];
        $expiryYear = $data['expiryYear'];
        $securityCode = $data['securityCode'];

        $user = User::where('id',$iduser)->get()->first();
        if ($user == null) {
            return $this->errorResponse('No se encontro el usuario'.' '.$user, 400);
        }
        foreach ($car as $key) {

            $raffle = Raffle::where('id',$key['raffle_id'])->get()->first();
            if ($raffle == null) {
                return $this->errorResponse('No se encontro la rifa'.' '.$key['raffle_id'], 400);
            }
        }

        $price = $data['price']* 100;

        $order_id = Str::uuid();
        $username = "44623003";
        $password = "prodpassword_6LAbudTQG0n381ZefWtuya7W4K0TM7W6TyblWeNHBedBz";
        $url = 'https://api.micuentaweb.pe/api-payment/V4/Charge/CreatePayment';
        /* $account = "44623003:testpassword_Rtn87ByTJlAHVXQZ3e3oSaDb8WX2kLzZ2UtSABKyJdSsC";
        $b64account = base64_encode($account); */
        $body = array(
            "amount"=> $price,
            "currency"=> "PEN",
            "orderId" => $order_id,
            "customer"=> array(
                "email"=> $user->email
            )
        );



        /* $response = Http::withHeaders($headers)->post($url, $body); */
        $RESPONSE = json_encode($body);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $RESPONSE);

        $response = curl_exec($ch);

        curl_close($ch);

        $res = json_decode($response);

        foreach ($car as $key) {

            $sell = new UserTicket();
            $sell->user_id = $iduser;
            $sell->raffles_id = $key['raffle_id'];
            $sell->quantity = $key['amount'];
            if ($res->status == "ERROR") {
                $sell->status = 'failed';
                $sell->oreder_id = $order_id;
                $sell->save();
            }else{
                $sell->status = 'confirmed';
                $sell->oreder_id = $order_id;
                $sell->save();
            }
        }
    } catch (\Exception $exception) {
        return $this->errorResponse($exception->getMessage(), 400);
    }

        return $this->successResponse([
            'status' => 200,
            'message' => 'Registro de pago completo',
            'data' =>$res
        ]);
    }
}
