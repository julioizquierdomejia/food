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

        $raffles_id = $requet->get('raffles_id');
        $amount = $requet->get('amount');
        $iduser = $requet->get('iduser');

        $pan = $requet->get('pan');
        $expiryMonth = $requet->get('expiryMonth');
        $expiryYear = $requet->get('expiryYear');
        $securityCode = $requet->get('securityCode');

        $user = User::where('id',$iduser)->get()->first();
        $raffle = Raffle::where('id',$raffles_id)->get()->first();

        if ($user == null || $raffle== null) {
            return $this->errorResponse('No se encontro el usuario o el ticket', 400);
        }

        $price = $raffle->raffle_goal_amount * $amount * 100;

        $order_id = Str::uuid();

        $url = 'https://api.micuentaweb.pe/api-payment/V4/Charge/CreatePayment';
        $account = "44623003:testpassword_Rtn87ByTJlAHVXQZ3e3oSaDb8WX2kLzZ2UtSABKyJdSsC";
        $b64account = base64_encode($account);
        $headers = ['Authorization' => 'Basic ' . $b64account,
        'Content-Type'=> 'application/json'];
        $body = [
            "amount"=> $price,
            "currency"=> "PEN",
            "paymentForms"=> [
                  "paymentMethodType"=> "CARD",
                  "pan"=> $pan,
                  "expiryMonth"=> $expiryMonth,
                  "expiryYear"=> $expiryYear,
                  "securityCode"=> $securityCode

            ],
            "customer"=> [
                "email"=> $user->email,
                "billingDetails"=> [
                    "phoneNumber"=> $user->phone,
                    "firstName" => $user->name
                ]
            ],
            "orderId"=> $order_id
        ];



        /* $response = Http::withHeaders($headers)->post($url, $body); */
        $RESPONSE = json_encode($body);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $RESPONSE);

        $response = curl_exec($ch);

        $res = json_decode($response);

        $sell = new UserTicket();
        $sell->user_id = $iduser;
        $sell->raffles_id = $raffles_id;
        $sell->quantity = $amount;
        if ($res->status == "ERROR") {
            $sell->status = 'failed';
            $sell->oreder_id = $order_id;
            $sell->save();
        }else{
            $sell->status = 'confirmed';
            $sell->oreder_id = $order_id;
            $sell->save();
        }

        return $this->successResponse([
            'status' => 200,
            'message' => 'Registro de pago completo',
            'data' =>$res
        ]);
    }
}
