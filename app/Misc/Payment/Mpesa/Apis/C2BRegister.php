<?php


namespace App\Misc\Payment\Mpesa\Apis;
use App\Misc\Payment\Mpesa\Validator;

class C2BRegister  extends Validator
{
    protected $default_endpoints = [
        'live' => 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl',
        'sandbox' => 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl',
    ];

    private $token = null;
    private $confirmation_url = null;
    private $validation_url = null;
    private $short_code = null;
    private $response_type = 'Cancelled';

    /**
     * @param string $env
     * @return bool|string|void
     * @throws \ErrorException
     */
    public function register(string $env) {

        $this->validateEndpoints($env);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json',"Authorization:Bearer {$this->token}"));


        $curl_post_data = array(
            'ShortCode' => $this->short_code,
            'ResponseType' => $this->response_type,
            'ConfirmationURL' => $this->confirmation_url,
            'ValidationURL' => $this->validation_url
        );

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        return curl_exec($curl);
    }

    /**
     * @param string $endpoint
     * @return $this
     */
    public function setEndpoint(string $endpoint)
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    /**
     * @param $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }
    /**
     * @param $confirmation_url
     * @return $this
     */
    public function setConfirmationUrl($confirmation_url)
    {
        $this->confirmation_url = $confirmation_url;
        return $this;
    }

    /**
     * @param $validation_url
     * @return $this
     */
    public function setValidationUrl($validation_url)
    {
        $this->validation_url = $validation_url;
        return $this;
    }

    /**
     * @param string $response_type
     * @return $this
     */
    public function setResponseType(string $response_type)
    {
        $this->response_type = $response_type;
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
