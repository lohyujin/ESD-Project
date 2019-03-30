<?php

include_once "authentication.php";

$access_token = $_SESSION["access_token"];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.sandbox.paypal.com/v2/checkout/orders/07X15596MS3802522');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: Bearer '. $access_token;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
$json = json_decode($result);
$orderID = $json->id;
echo $orderID;

$pstatus = $json->status;
// print_r("status = ".$pstatus);

$purchase_units = $json->purchase_units;    //amount stored in a object in an array in purchase_units
$price = ($purchase_units[0]->amount->value);
// echo gettype($price);
// print_r("price = ".$price);

curl_close($ch);

unset($_SESSION["assess_token"]);

?>

<html>
    <head>
        <title>Order</title>
        <!-- HEAD
                This is where you put your jQuery, Bootstrap JS library imports
            -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
            crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.min.js"></script>

    </head>

    <body>
        <!-- call post payment -->
        <?php 
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: PUT, GET, POST");
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        ?>
        <script>
            $(document).ready(function() {
                // alert("hello");
                var serviceURL = 'http://DESKTOP-GDMA71H:7777/payment';
                jQuery.ajax({
                    url: serviceURL,
                    crossDomain: true,
                    type: "post",
                    data: JSON.stringify({
                            "PID": 1,
                            "OID": 1,
                            "Pstatus": "Complete",
                            "price": 20
                        }),
                    dataType: "json",
                    success: function(){
                        alert('success');
                    },
                    error: function(){
                        alert('failure');
                    }
                });
            });
        </script>
    </body>
</html>