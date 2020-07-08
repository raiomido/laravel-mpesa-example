<?php

namespace App\Http\Controllers;

use App\MpesaC2B;
use Illuminate\Http\Request;

class C2BController extends Controller
{
    public function index()
    {
        return view('admin.mpesa.c2b.index', [
            'data' => MpesaC2B::paginate(20),
        ]);
    }
}
