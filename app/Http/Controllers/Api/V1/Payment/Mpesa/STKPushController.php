<?php

namespace App\Http\Controllers\Api\V1\Payment\Mpesa;

use App\Http\Controllers\Controller;
use App\Http\Requests\MpesaSTKPushSimulateRequest;
use App\Misc\Payment\Mpesa\Apis\STKPush;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class STKPushController extends Controller
{
    private $result_desc = 'An error occurred';
    private $result_code = 1;
    private $http_code = 400;

    public function simulate(MpesaSTKPushSimulateRequest $request)
    {
        $env = config('misc.mpesa.env', 'sandbox');

        if ($config = config("misc.mpesa.stk_push.{$env}")) {

            $stk_push_simulator = (new STKPush())
                ->setShortCode($config['short_code'])
                ->setPassKey($config['pass_key'])
                ->setAmount($request->amount)
                ->setSenderPhone($request->sender_phone)
                ->setPayerPhone($request->payer_phone)
                ->setAccountReference($request->account_reference)
                ->setReceivingShortcode($config['short_code'])
                ->setCallbackUrl(route('api.mpesa.stk-push.confirm', $config['confirmation_key']))
                ->setRemarks('Pay your bill')
                ->simulate($env);

            if (! $stk_push_simulator->failed()) {

                $this->http_code = 200;

            }

            $this->result_desc = $stk_push_simulator->getResponse();

        } elseif (!$config) {
            $this->result_desc = 'STK Push request failed: Missing important parameters';
        }

        return response()->json([
            'message' => $this->result_desc
        ], $this->http_code);

    }

    public function confirm(Request $request)
    {
        $env = config('misc.mpesa.env', 'sandbox');
        $confirmation_key = config("misc.mpesa.stk_push.{$env}.confirmation_key");

        if ($request->confirmation_key == $confirmation_key) {

            $stk_push_confirm = (new STKPush())->confirm($request);

            if ($stk_push_confirm->failed()) {

                Log::error($stk_push_confirm->getResponse());

            } else {
                $this->result_code = 0;
                $this->result_desc = 'Success';
            }

        } else {

            $this->result_desc = 'STK Push confirmation failed: Confirmation key mismatch';
            Log::error($this->result_desc);

        }

        return response()->json([
            'ResultCode' => $this->result_code,
            'ResultDesc' => $this->result_desc,
        ]);
    }
}
