<?php

namespace App\Http\Controllers;

use App\services\MpesaService;

class PaymentController extends Controller
{
    public function lipaOnline(MpesaService $mpesaService)
    {
        $phone = '254707585566';
        $amount = 1;
        $account_reference = 'Abraham';
        $transaction_description = 'Testing';

      return   $mpesaService->lipaNaMpesaOnline($phone, $amount, $account_reference, $transaction_description );
    }
    

}
