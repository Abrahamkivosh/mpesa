<?php

namespace App\Http\Controllers;

use App\Mpesa;
use App\Payment\MpesaGateway;
use Illuminate\Http\Request;

class PayOrderController extends Controller
{
    public function pay(MpesaGateway $mpesaGateway)
    {
        return $mpesaGateway->make_payment() ;

    }

    public function handle_result(Request $request)
    {
        $data = $request->all();
        $result = json_encode($data) ;
        Mpesa::create([
            'result' => $result
            ]);
    }

    public function queue_timeout(Request $request)
    {
        $data = $request->all();
        $result = json_encode($data) ;
        Mpesa::create([
            'timeout' => $result
            ]);

    }


}
