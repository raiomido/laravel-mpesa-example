<?php

namespace App\Http\Controllers\Api\V1\Payment\Mpesa;

use App\Http\Controllers\Controller;
use App\Http\Requests\STKPushSimulateRequest;
use App\Misc\Payment\Mpesa\Apis\STKPush;
use Illuminate\Http\Request;

class STKPushController extends Controller
{
    public function simulate(STKPushSimulateRequest $request)
    {
        $env = config('misc.mpesa.stk_push', 'sandbox');

        if ($config = config("misc.mpesa.stk_push.{$env}")) {
            $init = (new STKPush())
                ->setShortCode($config['short_code'])
                ->setPassKey($config['pass_key'])
                ->setAmount($request->amount)
                ->setSenderPhone($request->sender_phone)
                ->setPayerPhone($request->payer_phone)
                ->setReceivingShortcode($config['short_code'])
                ->setCallbackUrl(route('api.mpesa.stk-push.confirm', $config['confirmation_key']))
                ->simulate($env);

            if ($init->failed()) {
                //do whatever
            }
            return $init->getResponse();
        }
        return response()->json([
            'message' => 'Some config params are missing'
        ], 400);
    }

    public function confirm(Request $request)
    {
        $env = config('misc.mpesa.stk_push', 'sandbox');
        $confirmation_key = config("misc.mpesa.stk_push.{$env}.confirmation_key");

        if ($request->confirmation_key == $confirmation_key) {
            (new STKPush())->confirm($request);
        } else {
            // Send your self a notification
        }
    }
}
