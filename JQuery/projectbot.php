<?php
$bot_token = "752360117:AAG7E90P4KVnBg3_ygSjjSW2yqGBdxdfnHA";

$url = "https://api.telegram.org/bot". $bot_token;

$update = json_decode(file_get_contents('php://input') ,true);

//$update = file_get_contents($url."/getUpdates");
//$updateArray = json_decode($update, True);

print_r($update['result']);
//$results = $update['result'];
$chat_id = $update['message']['chat']['id'];

$name = $update['message']['from']['first_name'];
$text = $update['message']['text']; 

//test command on project bot
if($text == "/start"){
    $message = urlencode("Hi " .$name. "\nEnter /getorders to start");
    file_get_contents($url."/sendmessage?text=".$message."&chat_id=".$chat_id); 
}

if($text == '/getorders'){
    $message = urlencode("Hi " .$name. "\n Please enter Order ID");
    file_get_contents($url."/sendmessage?text=".$message."&chat_id=".$chat_id);
};

if(is_numeric($text)){
    $oid = $text;
    $send_url = "http://LAPTOP-9M0FB286:8082/order/" . $oid;
    $curl2 = curl_init();
    curl_setopt_array($curl2, [
        CURLOPT_RETURNTRANSFER => 1, 
        CURLOPT_URL => $send_url]);
    $output = curl_exec($curl2);
    curl_close($curl2);
    $result = json_decode($output);
    $pstatus = $result->Pstatus;
    $price = $result->totalPrice;
    $message = urlencode("Your Order\n".
                        "OID: $oid\n".
                        "Status: $pstatus\n".
                        "Total Price: $price");
    //print_r($message);
    file_get_contents($url."/sendmessage?text=".$message."&chat_id=".$chat_id);    
     };
// else{
//     $message = urlencode("Please enter a valid OID");
//     file_get_contents($url."/sendmessage?text=".$message."&chat_id=".$chat_id);
// };

?>
