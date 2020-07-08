<?php

namespace App\Http\Controllers;

use App\Misc\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class TestController extends Controller
{
    public function index() {
//        return (new HeadingRowImport)->toArray(public_path('files/users.xlsx'));
        $collection = Excel::import(new UsersImport, public_path('files/database.xlsx'));
        return json_encode($collection);
    }
}
