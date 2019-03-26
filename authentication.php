<?php

$ch = curl_init();
$clientId = "Aa3whO6Fqbghp3fTu0yK_OtjMfID-bXdM8m9dm7zyEr8V_EemSNqVytyguupqQQuy-9klr4F_CfZ1zcK";
$secret = "EBgTjJmPjBX3_JEr6JckpUKOTcyUu0caKX4q4lPyVtRILlpS_7e48htY1Se--MfjuGZ7wJU3SMUJmrhw";

curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

$result = curl_exec($ch);

if(empty($result))die("Error: No response.");
else
{
    $json = json_decode($result);
    print_r($json->access_token);
}

curl_close($ch);

?>