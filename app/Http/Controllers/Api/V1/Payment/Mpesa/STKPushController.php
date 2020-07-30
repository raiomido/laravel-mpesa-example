<?php

namespace App\Http\Controllers\Api\V1\Payment\Mpesa;

use App\Http\Controllers\Controller;
use App\STKPush;
use Illuminate\Http\Request;

class STKPushController extends Controller
{
    private $error;

    public function confirm(Request $request)
    {
        $env = config('misc.mpesa.env');
        $confirmation_key = config("misc.mpesa.stk_push.{$env}.confirmation_key");

        if ($request->confirmation_key != $confirmation_key) {
            $this->error = 'Confirmation key mismatch';
        }


        //If no error, Change to success
        if (!$this->error) {

            $data = [
                "result_desc"=>$request->Body->stkCallback->ResultDesc,
                "result_code"=>$request->Body->stkCallback->ResultCode,
                "merchant_request_id"=>$request->Body->stkCallback->MerchantRequestID,
                "checkout_request_id"=>$request->Body->stkCallback->CheckoutRequestID,
                "amount"=>$request->stkCallback->Body->CallbackMetadata->Item[0]->Value,
                "mpesa_receipt_number"=>$request->Body->stkCallback->CallbackMetadata->Item[1]->Value,
                "balance"=>$request->stkCallback->Body->CallbackMetadata->Item[2]->Value,
                "b2c_utility_account_available_funds"=>$request->Body->stkCallback->CallbackMetadata->Item[3]->Value,
                "transaction_date"=>$request->Body->stkCallback->CallbackMetadata->Item[4]->Value,
                "phone_number"=>$request->Body->stkCallback->CallbackMetadata->Item[5]->Value
            ];

            STKPush::create($data);

        }
        return response()->json([
            "error" => $this->error
        ]);
    }
}
