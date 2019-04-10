<?php

include_once "authentication.php";

//header("Access-Control-Allow-Origin: *");

$access_token = $_SESSION["access_token"];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.sandbox.paypal.com/v2/checkout/orders/'.$_COOKIE['myorderid']);
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
// echo $orderID;

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
     //       header("Access-Control-Allow-Origin: *");
     //       header("Access-Control-Allow-Methods: PUT, GET, POST");
     //       header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        
        ?>

        <script>

            $(document).ready(function() {
                var serviceURL = 'http://LAPTOP-9M0FB286:8083/pstatus_update2';
                var OrderserviceURL = 'http://LAPTOP-9M0FB286:8082/lastOrder';

                $.get(OrderserviceURL, function(data){
                    var last_oid =  data.OID;

                    $.ajaxSetup({
                        headers:{
                            'Content-Type': "application/json"
                        }
                    });


                    jQuery.ajax({
                        url: serviceURL,
                        crossDomain: true,
                        type: "put",
                        data: JSON.stringify({
                                "PID": 1,
                                "OID":last_oid,
                                "Pstatus": "<?php echo ("PAYMENT " . $pstatus) ?>",
                                "price": parseFloat(<?php echo $price ?>)
                            }),
                        dataType: "json",
                        success: function() {
                            window.location.href='payment_completion.php';
                        }
                    });
                    });
                });
        </script>
    </body>
</html>