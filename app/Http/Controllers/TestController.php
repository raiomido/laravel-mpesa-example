<?php

namespace App\Http\Controllers;

use App\Misc\Payment\Mpesa\TokenGenerator;

class TestController extends Controller
{
    public function index() {

        $env = config('misc.mpesa.env');

        try {
            $token = (new TokenGenerator())->generateToken($env);
        } catch (\ErrorException $e) {
            return $e->getFile()." ".$e->getMessage();
        }
        return $token;
    }
}
