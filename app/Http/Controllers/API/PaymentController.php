<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    use ApiResponse;

    public function paymentTest()
    {
        $url = 'https://api.micuentaweb.pe/api-payment/V4/Charge/SDKTest';
        $account = "89289758:testpassword_7vAtvN49E8Ad6e6ihMqIOvOHC6QV5YKmIXgxisMm0V7Eq";
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

        $idticket = $requet->get('idticket');
        $iduser = $requet->get('iduser');

        $pan = $requet->get('pan');
        $expiryMonth = $requet->get('expiryMonth');
        $expiryYear = $requet->get('expiryYear');
        $securityCode = $requet->get('securityCode');

        $user = User::where('id',$iduser)->get()->first();
        $ticket = Ticket::where('id',$idticket)->get()->first();

        if ($user == null || $ticket== null) {
            return $this->errorResponse('No se encontro el usuario o el ticket', 400);
        }

        $price = $ticket->price * 100;

        $url = 'https://api.micuentaweb.pe/api-payment/V4/Charge/CreatePayment';
        $account = "89289758:testpassword_7vAtvN49E8Ad6e6ihMqIOvOHC6QV5YKmIXgxisMm0V7Eq";
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
            "orderId"=> "myOrderId-585920"
        ];



        $response = Http::withHeaders($headers)->post($url, $body);


        return $this->successResponse([
            'status' => 200,
            'message' => 'Mail was sent to reset password',
            'data' =>$response->status()
        ]);
    }
}
