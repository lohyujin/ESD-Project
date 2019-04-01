<?php
include_once 'include/sql.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<?php
$sql = "SELECT * from corder;";
$result = mysqli_query($conn,$sql);
$resultCheck = mysqli_num_rows($result);
$date = "";


if($resultCheck > 0 ){
    while($row = mysqli_fetch_assoc($result)){
        $date = $row['timestamp'];   
         
    }
}
?>

<?php
$sql2 = "SELECT * from order_items WHERE OID=3;";
$result2 = mysqli_query($conn,$sql2);
$resultCheck2 = mysqli_num_rows($result2);
$ProductName = "";
$qty= 0;
$price= 0;


if($resultCheck2 > 0 ){
    while($row = mysqli_fetch_assoc($result2)){
        $ProductName = $row['Pname'];
        $price += $row['price'];
        $qty += $row['qty']; 
    }
}
$payment = $qty * $price
?>
</body>
</html>

<?php

$botToken = "638107071:AAGBk_bzOJ3HOsTXnnrU-dw8GAIKOsRkZzs";
$url = "https://api.telegram.org/bot".$botToken;

$update = file_get_contents($url."/getupdates");
$updateArray = json_decode($update, True);


$chatid = $updateArray["result"][0]["message"]["from"]["id"];
$line2 = "Payment details";
$line3 = "Payment is successful";
$line4 = "Trans.Date: ".$date;
$line5 = "Product name: ".$ProductName;
$line6 = "Payment: ".$payment;
$line7 = "Payment method: Master/Visa card";




file_get_contents($url."/sendmessage?chat_id=".$chatid."&text=".$line1);
file_get_contents($url."/sendmessage?chat_id=".$chatid."&text=".$line2);
file_get_contents($url."/sendmessage?chat_id=".$chatid."&text=".$line3);
file_get_contents($url."/sendmessage?chat_id=".$chatid."&text=".$line4);
file_get_contents($url."/sendmessage?chat_id=".$chatid."&text=".$line5);
file_get_contents($url."/sendmessage?chat_id=".$chatid."&text=".$line6);
file_get_contents($url."/sendmessage?chat_id=".$chatid."&text=".$line7);






?>