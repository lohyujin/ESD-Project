<?php

require_once('TwitterAPIExchange.php');

$settings = array(
// add keys
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