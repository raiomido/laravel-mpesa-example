<?php

namespace App\Http\Controllers\Api\V1\Payment\Mpesa;

use App\Http\Controllers\Controller;
use App\Misc\Payment\Mpesa\Apis\C2B;
use App\Misc\Payment\Mpesa\Apis\C2BRegister;
use App\Misc\Payment\Mpesa\TokenGenerator;
use App\MpesaC2B;
use Illuminate\Http\Request;

class C2BController extends Controller
{
    protected $result_desc = null;
    protected $result_code = 1;

    public function confirmTrx(Request $request)
    {
        $env = config('misc.mpesa.env');
        $confirmation_key = config("misc.mpesa.c2b.{$env}.confirmation_key");
        $short_code = config("misc.mpesa.c2b.{$env}.short_code");

        if ($request->confirmation_key != $confirmation_key) {
            $this->result_desc = 'Confirmation key mismatch';
        }

        if ($request->BusinessShortCode != $short_code) {
            $this->result_desc = 'Short code mismatch';
        }

        //If no error, Change to success
        if (!$this->result_desc) {
            $data = [
                'trans_time' => $request->TransTime,
                'trans_amount' => $request->TransAmount,
                'business_short_code' => $request->BusinessShortCode,
                'bill_ref_number' => $request->BillRefNumber,
                'invoice_number' => $request->InvoiceNumber,
                'org_account_balance' => $request->OrgAccountBalance,
                'third_party_trans_id' => $request->ThirdPartyTransID,
                'msisdn' => $request->MSISDN,
                'first_name' => $request->FirstName,
                'middle_name' => $request->MiddleName,
                'last_name' => $request->LastName,
                'trans_id' => $request->TransID,
                'transaction_type' => $request->TransactionType
            ];

            MpesaC2B::create($data);

            $this->result_desc = 'Transaction saved successfully';
            $this->result_code = 0;
        }

        return response()->json([
            "ResultDesc" => $this->result_desc,
            "ResultCode" => $this->result_code
        ]);
    }

    public function validateTrx()
    {

    }

    /**
     * @param Request $request
     * @return bool|string|void
     */
    public function simulate(Request $request)
    {
        try {
            $feedback = (new C2B())->setShortCode($request->short_code)
                ->setAmount($request->amount)
                ->setBillRefNumber($request->bill_ref_number)
                ->setMsisdn($request->msisdn)
                ->simulate();

        } catch (\ErrorException $e) {
            return $e->getMessage();
        }
        return $feedback;
    }

    public function register() {

        try {
            $env = config('misc.mpesa.env');
            $config = config("misc.mpesa.c2b.{$env}");
            $token = (new TokenGenerator())->generateToken($env);

            $confirmation_url = route('api.mpesa.c2b.confirm', $config['confirmation_key']);
            $validation_url = route('api.mpesa.c2b.validate', $config['validation_key']);
            $short_code = $config['short_code'];

            $response = (new C2BRegister())->setShortCode($short_code)
                ->setValidationUrl($validation_url)
                ->setConfirmationUrl($confirmation_url)
                ->setToken($token)
                ->register($env);

        } catch (\ErrorException $e) {
            return $e->getMessage();
        }
        return $response;
    }
}
