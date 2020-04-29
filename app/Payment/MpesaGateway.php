<?php

namespace App\Payment;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
class MpesaGateway
{
    public function get_access_token()
    {
        $Consumer_Key = "NFvAmAESuF667Bvleo2o71wbKluPnkfX";
        $Consumer_Secret = "gY4Lg6osipYRIgwA";
        $key_sec = $Consumer_Key . ":" . $Consumer_Secret;
        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $headers = ['Content-Type: application/json;charset=UTF-8'];
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_USERPWD, $key_sec);



        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result = json_decode($result);
        $access_token = $result->access_token;
        return $access_token;
    }
    public function make_payment()
    {

        $api_url = "https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest";
        $access_token = $this->get_access_token();
        $Shortcode = "600620";
        $time = date('YmdHis');
        $InitiatorName = "TestInit620";
        $TestMSISDN = "254708374149";
        $LipaNaMpesaOnlineShortcode = "174379";
        $LipaNaMpesaOnlinePassKey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        $SecurityCredential  = base64_encode($Shortcode.$LipaNaMpesaOnlinePassKey .$time);
        $client = new Client();
        $headers = [
            'Authorization' => 'Bearer ' . $access_token,
            'Content-Type' => 'application/json',
        ];
        $data = [
                "InitiatorName"=> $InitiatorName ,
                "SecurityCredential"=> $SecurityCredential ,
                "CommandID"=> "BusinessPayment",
                "Amount"=> "50",
                "PartyA"=> $Shortcode,
                "PartyB"=> $TestMSISDN,
                "Remarks"=> "Pay goods",
                // "QueueTimeOutURL"=>  route('queue_timeout_api') ,
                // "ResultURL"=>  route('handle_result_api') ,
                "QueueTimeOutURL"=>  "http://paviham.com/about" ,
                "ResultURL"=>  "http://paviham.com/about",
                "Occasion"=> "Pay goods"
        ];
        try {
            $request = $client->request('POST', $api_url, [
                'headers' => $headers,
                'json' => $data,
            ]);
            $response = $request->getBody()->getContents();
            $response = json_decode($response, true);
            return  $response;
        } catch (\Throwable $th) {

            return $th ;
        }

    }


}
