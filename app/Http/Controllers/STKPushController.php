<?php

namespace App\Http\Controllers;

use App\STKPush;
use Illuminate\Http\Request;

class STKPushController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.mpesa.stk-push.index', [
            'data' => STKPush::paginate(20),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\STKPush  $sTKPush
     * @return \Illuminate\Http\Response
     */
    public function show(STKPush $sTKPush)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\STKPush  $sTKPush
     * @return \Illuminate\Http\Response
     */
    public function edit(STKPush $sTKPush)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\STKPush  $sTKPush
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, STKPush $sTKPush)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\STKPush  $sTKPush
     * @return \Illuminate\Http\Response
     */
    public function destroy(STKPush $sTKPush)
    {
        //
    }
}
