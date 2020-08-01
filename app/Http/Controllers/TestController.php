<?php

namespace App\Http\Controllers;

use App\Misc\Payment\Mpesa\TokenGenerator;
use App\STKPush;
use Illuminate\Http\Request;

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
            'Amount' => '2',
            'PartyA' => '254708374149',
            'PartyB' => $BusinessShortCode,
            'PhoneNumber' => '254741266296',
            'CallBackURL' => $confirmation_url,
            'AccountReference' => 'JHASIYA',
            'TransactionDesc' => 'Please pay your bill'
        );

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_HEADER, false);

        $response = json_encode(curl_exec($curl));
        if ($response->ResponseCode == '0') {
            $data = [
                'checkout_request_id' => $response->CheckoutRequestID,
                'merchant_request_id' => $response->MerchantRequestID,
            ];
            STKPush::create($data);
        }
        return ;
    }

    private $error;

    public function confirm(Request $request)
    {
        $env = config('misc.mpesa.env');
        $confirmation_key = config("misc.mpesa.stk_push.{$env}.confirmation_key");

        if ($request->confirmation_key != $confirmation_key) {
            $this->error = 'Confirmation key mismatch';
        }

        if ($request->ResultCode == '0') {
            $merchant_request_id = $request->Body->stkCallback->MerchantRequestID;
            $checkout_request_id = $request->Body->stkCallback->CheckoutRequestID;

            $data = [
                "result_desc" => $request->Body->stkCallback->ResultDesc,
                "result_code" => $request->Body->stkCallback->ResultCode,
                "merchant_request_id" => $merchant_request_id,
                "checkout_request_id" => $checkout_request_id,
                "amount" => $request->stkCallback->Body->CallbackMetadata->Item[0]->Value,
                "mpesa_receipt_number" => $request->Body->stkCallback->CallbackMetadata->Item[1]->Value,
                "balance" => $request->stkCallback->Body->CallbackMetadata->Item[2]->Value,
                "b2c_utility_account_available_funds" => $request->Body->stkCallback->CallbackMetadata->Item[3]->Value,
                "transaction_date" => $request->Body->stkCallback->CallbackMetadata->Item[4]->Value,
                "phone_number" => $request->Body->stkCallback->CallbackMetadata->Item[5]->Value
            ];

            if ($stk_push = STKPush::where('merchant_request_id', $merchant_request_id)->where('checkout_request_id', $checkout_request_id)->first()) {
                $stk_push->fill($data)->save();
            } else {
                STKPush::create($data);
            }
            return true;
        }
        return false;
    }

    public function getError()
    {
        return $this->error;
    }

}
