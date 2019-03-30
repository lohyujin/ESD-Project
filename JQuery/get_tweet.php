<?php

require_once('TwitterAPIExchange.php');

$settings = array(
    'oauth_access_token' => "1107643411438305285-xplsDik3gGWTS7ABpR3WkO26QAB7VJ",
    'oauth_access_token_secret' => "WIeeb6S5P3mFtpClT1sJ6wR3hrl9ufdoTxWFM0C2YI0AN",
    'consumer_key' => "Qv7fBJLsw7RUd7VVWHr2IwEC9",
    'consumer_secret' => "U0UL4yXP1ONPc3c4CBShctyY7lFWtntaYSncLc8XjRzRDBppIn"
);

$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = "?q=" . $_POST['pname'] . "&lang=en";
//$getfield = '?q="nasa"' . '&lang=en';
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
$data = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest(true, array(CURLOPT_CAINFO => dirname(__FILE__) . '/cacert.pem'));
echo(json_encode($data));
?>