<?php

namespace App\Http\Controllers;

use App\Mpesa;
use App\Payment\MpesaGateway;
use Illuminate\Http\Request;

class MpesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MpesaGateway $mpesaGateway)
    {
        return  $mpesaGateway->get_access_token()  ;
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
     * @param  \App\Mpesa  $mpesa
     * @return \Illuminate\Http\Response
     */
    public function show(Mpesa $mpesa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mpesa  $mpesa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mpesa $mpesa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mpesa  $mpesa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mpesa $mpesa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mpesa  $mpesa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mpesa $mpesa)
    {
        //
    }
}
