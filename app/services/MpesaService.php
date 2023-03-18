<?php
namespace App\services;

use Illuminate\Support\Facades\Http;

class MpesaService
{
    /**
     * properties
     */
    private $consumer_key;
    private $consumer_secret;
    private $initiator_name;
    private $initiator_password;
    private $short_code;
    private $callback_url;
    private $pass_key;


    /**
     * MpesaService constructor.
     */
    public function __construct()
    {
        $this->consumer_key = config('app.mpesa.consumer_key');
        $this->consumer_secret = config('app.mpesa.consumer_secret');
        $this->initiator_name = config('app.mpesa.initiator_name');
        $this->initiator_password = config('app.mpesa.initiator_password');
        $this->short_code = config('app.mpesa.short_code');
        $this->callback_url = config('app.mpesa.callback_url');
        $this->pass_key = config('app.mpesa.pass_key');
    }
    
    /**
     * generate access token
     * @return none
     * @return string
     */
    private function generateAccessToken():string
    {
        $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        $response = Http::withBasicAuth($this->consumer_key, $this->consumer_secret)->get($url);
        return $response->json()['access_token'];
    }
    /**
     * Generate the security credential
     * @return string
     */
    private function generatePassword() : string {
        $time = date('YmdHis');
        // dd($this->short_code);
        $SecurityCredential  = base64_encode($this->short_code . $this->pass_key . $time);
        return  $SecurityCredential;
    }

    /**
     * lipa na mpesa online payment
     * @param string $phone
     * @param int $amount
     * @param string $account_reference
     * @param string $transaction_description
     * @return response
     */
    public function lipaNaMpesaOnline(string $phone, int $amount, string $account_reference, string $transaction_description)
    {
        $api_url = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";
        $access_token = $this->generateAccessToken();
        $headers = [
            'Authorization' => 'Bearer ' . $access_token,
            'Content-Type' => 'application/json',
        ];
        $data = [ 
            "BusinessShortCode"=> $this->short_code,
            "Password"=>  $this->generatePassword(),
            "Timestamp"=> date('YmdHis'),
            "TransactionType"=> "CustomerPayBillOnline",
            "Amount"=> $amount,
            "PartyA"=> $phone,
            "PartyB"=> $this->short_code,
            "PhoneNumber"=> $phone,
            "CallBackURL"=> $this->callback_url,
            "AccountReference"=> $account_reference,
            "TransactionDesc"=> $transaction_description
        ];

        $response = Http::withHeaders($headers)->post($api_url, $data);
        return $response->json();
    }

}