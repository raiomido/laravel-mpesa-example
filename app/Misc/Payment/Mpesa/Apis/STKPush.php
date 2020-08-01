<?php

namespace App\Misc\Payment\Mpesa\Apis;

use App\Misc\Payment\Mpesa\TokenGenerator;
use App\Misc\Payment\Mpesa\Validator;
use Illuminate\Http\Request;

class STKPush extends Validator
{
    protected $default_endpoints = [
        'live' => 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest',
        'sandbox' => 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest',
    ];

    private $pass_key;
    private $short_code;
    private $amount;
    private $sender_phone;
    private $payer_phone;
    private $receiving_shortcode;
    private $callback_url;
    private $account_reference;
    private $transaction_type = 'CustomerPayBillOnline';
    private $remarks;

    private $failed = false;
    private $response = 'An an unknown error occurred';

    public function simulate(string $env)
    {

        try {
            $this->validateEndpoints($env);
            $token = (new TokenGenerator())->generateToken($env);

        } catch (\Exception $e) {
            $this->failed = true;
            $this->response = $e->getMessage();
        }

        $timestamp = '20' . date("ymdhis");

        $password = base64_encode($this->short_code . $this->pass_key . $timestamp);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token));


        $curl_post_data = array(
            'BusinessShortCode' => $this->short_code,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => $this->transaction_type,
            'Amount' => $this->amount,
            'PartyA' => $this->sender_phone,
            'PartyB' => $this->receiving_shortcode,
            'PhoneNumber' => $this->payer_phone,
            'CallBackURL' => $this->callback_url,
            'AccountReference' => $this->account_reference,
            'TransactionDesc' => $this->remarks
        );

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_HEADER, false);

        $response = json_decode(curl_exec($curl));

        if (property_exists($response, 'Body') && $response->Body->stkCallback->ResultCode == '0') {

            \App\STKPush::create([
                'merchant_request_id' => $response->Body->stkCallback->MerchantRequestID,
                'checkout_request_id' => $response->Body->stkCallback->CheckoutRequestID
            ]);

        } else {

            $this->failed = true;

        }

        $this->response = $response;

        return $this;
    }

    public function confirm(Request $request)
    {
        $payload = json_decode($request->getContent());

        if (property_exists($payload, 'Body') && $payload->Body->stkCallback->ResultCode == '0') {

            $merchant_request_id = $payload->Body->stkCallback->MerchantRequestID;
            $checkout_request_id = $payload->Body->stkCallback->CheckoutRequestID;

            $stk_push_model = \App\STKPush::where('merchant_request_id', $merchant_request_id)
                ->where('checkout_request_id', $checkout_request_id)->first();

            $data = [
                'result_desc' => $payload->Body->stkCallback->ResultDesc,
                'result_code' => $payload->Body->stkCallback->ResultCode,
                'merchant_request_id' => $merchant_request_id,
                'checkout_request_id' => $checkout_request_id,
                'amount' => $payload->Body->stkCallback->CallbackMetadata->Item[0]->Value,
                'mpesa_receipt_number' => $payload->Body->stkCallback->CallbackMetadata->Item[1]->Value,
                'transaction_date' => $payload->Body->stkCallback->CallbackMetadata->Item[2]->Value,
                'phone_number' => $payload->Body->stkCallback->CallbackMetadata->Item[3]->Value,
            ];

            if ($stk_push_model) {

                $stk_push_model->fill($data)->save();

            } else {
                \App\STKPush::create($data);
            }

        } else {
            $this->failed = true;
        }

        return $this;
    }

    public function setPassKey(string $pass_key)
    {
        $this->pass_key = $pass_key;

        return $this;
    }

    public function setShortCode(string $short_code)
    {
        $this->short_code = $short_code;

        return $this;
    }

    public function setAmount(int $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    public function setSenderPhone(string $phone)
    {
        $this->sender_phone = $phone;

        return $this;
    }

    public function setPayerPhone(string $phone)
    {
        $this->payer_phone = $phone;

        return $this;
    }

    public function setReceivingShortcode(string $receiving_shortcode)
    {
        $this->receiving_shortcode = $receiving_shortcode;

        return $this;
    }

    public function setCallbackUrl(string $callback_url)
    {
        $this->callback_url = $callback_url;

        return $this;
    }

    public function setAccountReference(string $account_reference)
    {
        $this->account_reference = $account_reference;

        return $this;
    }

    public function setRemarks(string $remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    public function failed()
    {
        return $this->failed;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
