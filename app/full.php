<?php

$shortcode="YOUR_SHORT_CODE_HERE";
$initiatorname="USER_NAME_FROM_MPESA_PORTAL_HERE";
$initiatorpassword="YOUR_PASSWORD_HERE";


$consumerkey    ="YOUR_CONSUMER_SECRET_HERE";
$consumersecret ="YOUR_CONSUMER_SECRET_HERE";


$commandid='BusinessPayment';
$recipient="25472XXXXXXX";
$amount="100";
$remarks='TEST BUSINESS DISBURSAL';
$occassion='JANUARY 2019';


$QueueTimeOutURL="YOUR_QUEUE_TIMEOUT_URL_HERE";
$ResultURL="YOUR_RESULT_URLHERE";



/*The below are production URLS CHANGE TO SANDBOX IF YOU HAVEN'T GONE LIVE */

$authorizationurl='https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$paymentrequesturl="https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest";



/* FIRST WE AUTHENTICATE OUR API CALL */

/* BEGIN AUTHENTICATION TO GET ACCESS TOKEN*/

  // Request headers
  $headers = array(
    'Content-Type: application/json; charset=utf-8'
  );

  // Request
  $ch = curl_init($authorizationurl);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  //curl_setopt($ch, CURLOPT_HEADER, TRUE); // Includes the header in the output
  curl_setopt($ch, CURLOPT_HEADER, FALSE); // excludes the header in the output

  curl_setopt($ch, CURLOPT_USERPWD, $consumerkey . ":" . $consumersecret); // HTTP Basic Authentication
  $result = curl_exec($ch);

if(curl_errno($ch)){
    echo 'Request Error:' . curl_error($ch);
    exit();
}



$result = json_decode($result);

$access_token=$result->access_token;

curl_close($ch);


/* END AUTHENTICATION */



/* BEGIN PAYMENT REQUEST IF WE GOT ACCESS TOKEN*





if(!$access_token)

{

  echo " Invalid access token ". print_r($result);

}

else


{



$publicKey = "-----BEGIN CERTIFICATE-----
MIIGkzCCBXugAwIBAgIKXfBp5gAAAD+hNjANBgkqhkiG9w0BAQsFADBbMRMwEQYK
CZImiZPyLGQBGRYDbmV0MRkwFwYKCZImiZPyLGQBGRYJc2FmYXJpY29tMSkwJwYD
VQQDEyBTYWZhcmljb20gSW50ZXJuYWwgSXNzdWluZyBDQSAwMjAeFw0xNzA0MjUx
NjA3MjRaFw0xODAzMjExMzIwMTNaMIGNMQswCQYDVQQGEwJLRTEQMA4GA1UECBMH
TmFpcm9iaTEQMA4GA1UEBxMHTmFpcm9iaTEaMBgGA1UEChMRU2FmYXJpY29tIExp
bWl0ZWQxEzARBgNVBAsTClRlY2hub2xvZ3kxKTAnBgNVBAMTIGFwaWdlZS5hcGlj
YWxsZXIuc2FmYXJpY29tLmNvLmtlMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIB
CgKCAQEAoknIb5Tm1hxOVdFsOejAs6veAai32Zv442BLuOGkFKUeCUM2s0K8XEsU
t6BP25rQGNlTCTEqfdtRrym6bt5k0fTDscf0yMCoYzaxTh1mejg8rPO6bD8MJB0c
FWRUeLEyWjMeEPsYVSJFv7T58IdAn7/RhkrpBl1dT7SmIZfNVkIlD35+Cxgab+u7
+c7dHh6mWguEEoE3NbV7Xjl60zbD/Buvmu6i9EYz+27jNVPI6pRXHvp+ajIzTSsi
eD8Ztz1eoC9mphErasAGpMbR1sba9bM6hjw4tyTWnJDz7RdQQmnsW1NfFdYdK0qD
RKUX7SG6rQkBqVhndFve4SDFRq6wvQIDAQABo4IDJDCCAyAwHQYDVR0OBBYEFG2w
ycrgEBPFzPUZVjh8KoJ3EpuyMB8GA1UdIwQYMBaAFOsy1E9+YJo6mCBjug1evuh5
TtUkMIIBOwYDVR0fBIIBMjCCAS4wggEqoIIBJqCCASKGgdZsZGFwOi8vL0NOPVNh
ZmFyaWNvbSUyMEludGVybmFsJTIwSXNzdWluZyUyMENBJTIwMDIsQ049U1ZEVDNJ
U1NDQTAxLENOPUNEUCxDTj1QdWJsaWMlMjBLZXklMjBTZXJ2aWNlcyxDTj1TZXJ2
aWNlcyxDTj1Db25maWd1cmF0aW9uLERDPXNhZmFyaWNvbSxEQz1uZXQ/Y2VydGlm
aWNhdGVSZXZvY2F0aW9uTGlzdD9iYXNlP29iamVjdENsYXNzPWNSTERpc3RyaWJ1
dGlvblBvaW50hkdodHRwOi8vY3JsLnNhZmFyaWNvbS5jby5rZS9TYWZhcmljb20l
MjBJbnRlcm5hbCUyMElzc3VpbmclMjBDQSUyMDAyLmNybDCCAQkGCCsGAQUFBwEB
BIH8MIH5MIHJBggrBgEFBQcwAoaBvGxkYXA6Ly8vQ049U2FmYXJpY29tJTIwSW50
ZXJuYWwlMjBJc3N1aW5nJTIwQ0ElMjAwMixDTj1BSUEsQ049UHVibGljJTIwS2V5
JTIwU2VydmljZXMsQ049U2VydmljZXMsQ049Q29uZmlndXJhdGlvbixEQz1zYWZh
cmljb20sREM9bmV0P2NBQ2VydGlmaWNhdGU/YmFzZT9vYmplY3RDbGFzcz1jZXJ0
aWZpY2F0aW9uQXV0aG9yaXR5MCsGCCsGAQUFBzABhh9odHRwOi8vY3JsLnNhZmFy
aWNvbS5jby5rZS9vY3NwMAsGA1UdDwQEAwIFoDA9BgkrBgEEAYI3FQcEMDAuBiYr
BgEEAYI3FQiHz4xWhMLEA4XphTaE3tENhqCICGeGwcdsg7m5awIBZAIBDDAdBgNV
HSUEFjAUBggrBgEFBQcDAgYIKwYBBQUHAwEwJwYJKwYBBAGCNxUKBBowGDAKBggr
BgEFBQcDAjAKBggrBgEFBQcDATANBgkqhkiG9w0BAQsFAAOCAQEAC/hWx7KTwSYr
x2SOyyHNLTRmCnCJmqxA/Q+IzpW1mGtw4Sb/8jdsoWrDiYLxoKGkgkvmQmB2J3zU
ngzJIM2EeU921vbjLqX9sLWStZbNC2Udk5HEecdpe1AN/ltIoE09ntglUNINyCmf
zChs2maF0Rd/y5hGnMM9bX9ub0sqrkzL3ihfmv4vkXNxYR8k246ZZ8tjQEVsKehE
dqAmj8WYkYdWIHQlkKFP9ba0RJv7aBKb8/KP+qZ5hJip0I5Ey6JJ3wlEWRWUYUKh
gYoPHrJ92ToadnFCCpOlLKWc0xVxANofy6fqreOVboPO0qTAYpoXakmgeRNLUiar
0ah6M/q/KA==
-----END CERTIFICATE-----
";


openssl_public_encrypt($initiatorpassword, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);

//GENERATE SECURITY CREDENTIAL USING THE PUBLIC KEY ABOVE

$securitycredential=base64_encode($encrypted);

/* MAKE PAYMENT REQUEST */


$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $paymentrequesturl);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token));

$curl_post_data = array(

  'InitiatorName' => $initiatorname,
  'SecurityCredential' => $securitycredential,
  'CommandID' =>  $commandid,
  'Amount' =>  $amount,
  'PartyA' => $shortcode,
  'PartyB' =>  $recipient,
  'Remarks' => $remarks,
  'QueueTimeOutURL' => $QueueTimeOutURL,
  'ResultURL' => $ResultURL,
  'Occassion' => $occassion
);

$data_string = json_encode($curl_post_data);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
$curl_response = curl_exec($curl);


  $response = json_decode($curl_response);

  if(!isset($response->ConversationID))

  {
  echo "There was an error when submitting your request: $response->errorMessage";

  }

  else

  {
  echo "Success, $response->ResponseDescription ";
  }


}


?>
