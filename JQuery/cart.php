<?php
    // session_start();
    // use url to get PID
    $pid = intval($_GET['id']);
?>

<html>
    <head>
        <title>Cart</title>
        <!-- HEAD
                This is where you put your jQuery, Bootstrap JS library imports
            -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
            crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.min.js"></script>
    </head>
    
    <style>
        /* Style inputs */
        input[type=text], select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        }

        /* Style the submit button */
        input[type=submit] {
        width: 100%;
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        }
    </style>
    
    <body>
        <div class="container">
            <h1>Shopping Cart</h1>

            <div class="row">
            <div class="col-md-6">
                <table class='table table-striped' id='cart-list' border='1'>
                    <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                    </tr>

                    <!-- add all cart items -->
                    <tbody class="items"></tbody>

                    <tr>
                        <td colspan="4" align="right">Total</td>
                        <!-- add total price -->
                        <td id='total_price'></td>
                    </tr>
                </table>
                <form action="checkout.php">
                    <input class="btn btn-primary" type="submit" value="Checkout" />
                    <input class="btn btn-primary" type="button" value="Continue Shopping" onclick="window.location.href='main-page.php'" />
                </form>
            </div> <!-- col-md-6 -->
           </div> <!-- row -->
            


        <!-- call get product service -->
        <script>
            $(document).ready(function() {
                var pid = <?php echo $pid; ?>;
                var serviceURL = "http://DESKTOP-8BPHEDQ:8080/getproduct/" + pid;
                $.get(serviceURL, function (data)   {
                    var pname = data.Pname;
                    var pdesc = data.Pdesc;
                    var price = data.price;
                    var qty = 1;

                    var item =          {'pid': pid, 
                                        'pname': pname, 
                                        'pdesc': pdesc, 
                                        'price': price, 
                                        'qty': qty};

                    $.ajax({
                        url: 'cart_ajax.php',
                        type: 'post',
                        data: {
                            'item': item
                        },
                        success: function(data) {
                            var obj = JSON.parse(data);
                            $('.items').html(obj.items_details);
                            $('#total_price').text(obj.total_price);
                        }
                    });
                });
            });
        </script>
    </body>
</html>