<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\services\MpesaService;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function lipaOnline(MpesaService $mpesaService)
    {
        $phone = 254707585566;
        $amount = 1;
        $account_reference = 'Abraham';
        $transaction_description = 'Testing';

      return   $mpesaService->lipaNaMpesaOnline($phone, $amount, $account_reference, $transaction_description );
    }

    /**
     * callback url
     * @Request $request
     * @return void
     */
    public function callback(Request $request): void
    {
        $data = $request->all();
        $response = json_encode($data);
        // log the response
        Log::info($response);
    }
    

}
