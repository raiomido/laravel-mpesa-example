<?php


namespace App\Misc\Payment\Mpesa\Apis;


use App\Misc\Payment\Mpesa\TokenGenerator;
use App\Misc\Payment\Mpesa\Validator;

class C2B extends Validator
{
    private $command_id = 'CustomerPayBillOnline';
    private $amount = null;
    private $bill_ref_number = null;
    private $short_code = null;
    private $msisdn= null;

    protected $default_endpoints = [
        'live' => 'https://api.safaricom.co.ke/mpesa/c2b/v1/simulate',
        'sandbox' => 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate',
    ];

    /**
     * @return bool|string|void
     * @throws \ErrorException
     */
    public function simulate() {

        $env = config('misc.mpesa.env');

        try {
            $this->validateEndpoints($env);
            $token = (new TokenGenerator())->generateToken($env);
        } catch (\ErrorException $e) {
            throw  new \ErrorException($e->getMessage());
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$token));

        $curl_post_data = array(
            'ShortCode' => $this->short_code,
            'CommandID' => $this->command_id,
            'Amount' => $this->amount,
            'Msisdn' => $this->msisdn,
            'BillRefNumber' => $this->bill_ref_number
        );

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
//        curl_setopt($curl, CURLOPT_HEADER, false);

        return curl_exec($curl);
    }

    /**
     * @param $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param $bill_ref_number
     * @return $this
     */
    public function setBillRefNumber($bill_ref_number)
    {
        $this->bill_ref_number = $bill_ref_number;
        return $this;
    }

    /**
     * @param $msisdn
     * @return $this
     */
    public function setMsisdn($msisdn)
    {
        $this->msisdn = $msisdn;
        return $this;
    }

    /**
     * @param string $command_id
     * @return $this
     */
    public function setCommandId(string $command_id)
    {
        $this->command_id = $command_id;
        return $this;
    }

    /**
     * @param $short_code
     * @return $this
     */
    public function setShortCode($short_code)
    {
        $this->short_code = $short_code;
        return $this;
    }
}
