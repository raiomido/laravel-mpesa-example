<?php

namespace App\Http\Controllers\Api\V1\Payment\Mpesa;

use App\Http\Controllers\Controller;
use App\Http\Requests\STKPushSimulateRequest;
use App\Misc\Payment\Mpesa\Apis\STKPush;
use App\Misc\Services\Notifier;
use App\Notifications\MpesaCallbackFailedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class STKPushController extends Controller
{
    private $result_code = 1; // Reject transaction
    private $response_code = 400;
    private $response_message = 'An error occurred';

    public function simulate(STKPushSimulateRequest $request)
    {
        $env = config('misc.mpesa.env', 'sandbox');

        if ($config = config("misc.mpesa.stk_push.{$env}")) {
            $init = (new STKPush())
                ->setShortCode($config['short_code'])
                ->setPassKey($config['pass_key'])
                ->setAmount($request->amount)
                ->setSenderPhone($request->sender_phone)
                ->setPayerPhone($request->payer_phone)
                ->setAccountReference($request->account_reference)
                ->setReceivingShortcode($config['short_code'])
                ->setCallbackUrl(route('api.mpesa.stk-push.confirm', $config['confirmation_key']))
                ->simulate($env);

            if (!$init->failed()) {
                $this->response_code = 200;
            }

            $this->response_message = $init->getResponse();

        } else if (!$config) {
            $this->response_message = 'Some important parameters are missing';
        }

        return response()->json([
            'message' => $this->response_message
        ], $this->response_code);
    }

    public function confirm(Request $request)
    {
        $env = config('misc.mpesa.env', 'sandbox');
        $confirmation_key = config("misc.mpesa.stk_push.{$env}.confirmation_key");

        if ($request->confirmation_key == $confirmation_key) {

            $stk_push_confirm = (new STKPush())->confirm($request);

            if ($stk_push_confirm->failed()) {

                # Send slack notification if fails
                (new Notifier())->sendSlackNotification($stk_push_confirm->getResponse());

            } else {
                //Accept transaction
                $this->result_code = '00000000';
                $this->response_message = 'Success';
            }

            return response()->json([
                'ResultCode' => $this->result_code,
                'ResultDesc' => $this->response_message,
            ]);

        } else {

            $this->response_message = 'STK Push failed: Confirmation key mismatch';

            (new Notifier())->sendSlackNotification($this->response_message);

            //Respond to Safaricom = Reject transaction
            return response()->json([
                'ResultCode' => 1,
                'ResultDesc' => $this->response_message,
            ]);
        }
    }
}
