<?php

namespace App\Http\Controllers;

use App\Misc\Payment\Mpesa\TokenGenerator;

class TestController extends Controller
{
    public function index(){


        $env = config('misc.mpesa.env');
        $config = config("misc.mpesa.stk_push.{$env}");
        $BusinessShortCode = $config['short_code'];
        $passkey = $config['pass_key'];
        $timestamp='20'.date(    "ymdhis");
        $confirmation_url = route('api.mpesa.stk-push.confirm', $config['confirmation_key']);
        $token = (new TokenGenerator())->generateToken($env);

        $password=base64_encode($BusinessShortCode.$passkey.$timestamp);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$token));


        $curl_post_data = array(
            'BusinessShortCode' => $BusinessShortCode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => '1000',
            'PartyA' => '254748383000',
            'PartyB' => $BusinessShortCode,
            'PhoneNumber' => '254748383000',
            'CallBackURL' => $confirmation_url,
            'AccountReference' => 'JHASIYA',
            'TransactionDesc' => 'Please pay your bill'
        );

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_HEADER, false);

        return curl_exec($curl);
    }

}
