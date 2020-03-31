<?php
session_start();

$ch = curl_init();
$clientId = "";
$secret = "";

curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

$result = curl_exec($ch);
$err = curl_error($ch);

$access_token="";
if ($err) {
  echo "cURL Error #:" . $err;
}
else
{
    // var_dump($result);
    $json = json_decode($result);
    $access_token = $json->access_token;
    // print_r($access_token);
}
$_SESSION['access_token'] = $access_token;

?>
