<!DOCTYPE html>
<?php 
    session_start(); 
    unset($_SESSION["cart"]);
?>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
            crossorigin="anonymous">
  <script
    src="https://www.paypal.com/sdk/js?client-id=Aa3whO6Fqbghp3fTu0yK_OtjMfID-bXdM8m9dm7zyEr8V_EemSNqVytyguupqQQuy-9klr4F_CfZ1zcK">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<style>
   input[type=text], select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        }
</style>

<body>
  <div class="container">
    <h1>Order Confirmation</h1>
    <div class="row">
      <div class="col-md-6">
        <div id="results"></div>  
        <div id="paypal-button-container"></div>
      </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        var serviceurl = "http://LAPTOP-9M0FB286:8082/lastOrder";
        $.get(serviceurl, function(data){
            var order_items = data.order_items;
            var counter = 0;
            total = data.totalPrice.toFixed(2);
            var table = "<table class='table table-striped' id='results-table' border='1'><tr>" +
                    "<thead><th>No.</th>" +
                    "<th>Title</th>" +
                    "<th>Quantity</th>" +
                    "<th>Price</th>"+
                    "<th>Amount</th>"+
                    "</tr></thead><tbody>";

            for (var i = 0; i < order_items.length; i ++){
                counter += 1;
                var amount = order_items[i].price * order_items[i].qty;
                table += "<tr>" +
                '<td>' + counter + '</td>' +
                '<td>' + order_items[i].Pname + '</td>' +
                '<td>' + order_items[i].qty + '</td>' +
                '<td>$ ' + order_items[i].price + '</td>' +
                '<td>$ ' + amount.toFixed(2) + '</td>'+
                "</tr>";
            }
            table = table + "<tr>"+
                    "<td colspan='4' align='right'>Total</td>"+
                    "<td id='total_price'></td>" +
                    "</tr></tbody></table>";

        $('#results').html(table);
        $('#total_price').html("$ " + total);
        });
    });

    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
            purchase_units: [{
                amount: {
                    value: total
                }
            }]
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            //instead of alert put payment has been made html display
            alert('Transaction completed by ' + details.payer.name.given_name);
//          alert(data.orderID);

            //store orderID into cookie session
            var orderid_data = data.orderID;
            document.cookie = "myorderid="+orderid_data;
            window.location.href="payment_processing.php";

            // Call your server to save the transaction
            return fetch('/paypal-transaction-complete', {
                method: 'post',
                body: JSON.stringify({                    
                orderID: data.orderID
                })
            });
        });
            
    }
}).render('#paypal-button-container');

</script>

</html>