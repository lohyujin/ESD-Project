<!DOCTYPE html>
<?php session_start(); ?>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <script
    src="https://www.paypal.com/sdk/js?client-id=Aa3whO6Fqbghp3fTu0yK_OtjMfID-bXdM8m9dm7zyEr8V_EemSNqVytyguupqQQuy-9klr4F_CfZ1zcK">
  </script>
</head>

<body>
    <div id="paypal-button-container"></div>

</body>
  
<script>
    paypal.Buttons({
      createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: '23'
            }
          }]
        });
      },
      onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
          //alert('Transaction completed by ' + details.payer.name.given_name);
          alert(data.orderID);

          // Call your server to save the transaction
          return fetch('/paypal-transaction-complete', {
            method: 'post',
            body: JSON.stringify({                    
              orderID: data.orderID
            })
          });

        });

        var orderid_data = data.orderID;

        $.ajax({
//          dataType:'json',
            url: "test_parse.php",
            type: "POST",
            data: {order_ID: orderid_data },
//            success: function(data){
//                alert(data);
        });

      }
}).render('#paypal-button-container');

  </script>

</html>