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

    private $response;
    private $failed = false;

    public function simulate(string $env)
    {

        $this->validateEndpoints($env);
        $token = (new TokenGenerator())->generateToken($env);

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

        if($response->Body->stkCallback->ResultCode == '0') {
            \App\STKPush::create([
                'merchant_request_id' => $response->Body->stkCallback->MerchantRequestID,
                'checkout_request_id' => $response->Body->stkCallback->CheckoutRequestID,
            ]);
        }

        $this->response = $response;

        return $this;
    }

    public function confirm(Request $request) {

        $merchant_request_id = $request->Body->stkCallback->MerchantRequestID;
        $checkout_request_id = $request->Body->stkCallback->CheckoutRequestID;

        $stk_push = \App\STKPush::where('merchant_request_id', $merchant_request_id)
            ->where('checkout_request_id', $checkout_request_id)
            ->first();

        if ($request->Body->stkCallback->ResultCode == '0') {

            $data = [
                'result_desc' => $request->Body->stkCallback->ResultDesc,
                'result_code' => $request->Body->stkCallback->ResultCode,
                'merchant_request_id' => $merchant_request_id,
                'checkout_request_id' => $checkout_request_id,
                'amount' => $request->stkCallback->Body->CallbackMetadata->Item[0]->Value,
                'mpesa_receipt_number' => $request->Body->stkCallback->CallbackMetadata->Item[1]->Value,
                'balance' => $request->stkCallback->Body->CallbackMetadata->Item[2]->Value,
                'b2c_utility_account_available_funds' => $request->Body->stkCallback->CallbackMetadata->Item[3]->Value,
                'transaction_date' => $request->Body->stkCallback->CallbackMetadata->Item[4]->Value,
                'phone_number' => $request->Body->stkCallback->CallbackMetadata->Item[5]->Value,
            ];

            if($stk_push) {
                $stk_push->fill($data)->save();
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
        $this->$pass_key = $pass_key;

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

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    public function failed()
    {
        return $this->failed;
    }
}
