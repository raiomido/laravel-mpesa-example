<?php

namespace App\Http\Controllers\Api\V1\Payment\Mpesa;

use App\Http\Controllers\Controller;
use App\Misc\Payment\Mpesa\Registrar;
use App\Misc\Payment\Mpesa\TokenGenerator;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function register() {

        try {
            $env = config('misc.mpesa.env');
            $config = config("misc.mpesa.c2b.{$env}");
            $token = (new TokenGenerator())->generateToken($env);

            $confirmation_url = route('api.mpesa.c2b.confirm', $config['confirmation_key']);
            $validation_url = route('api.mpesa.c2b.validate', $config['validation_key']);
            $short_code = $config['short_code'];

            $response = (new Registrar())->setShortCode($short_code)
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
