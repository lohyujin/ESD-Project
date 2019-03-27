<?php
    // use url to get PID
    $pid = $_SERVER['QUERY_STRING'];

    $pname =  "<script>document.writeln(pname);</script>";
    $price =  "<script>document.writeln(price);</script>";
    $qty =  "<script>document.writeln(qty);</script>";

    $cart_item = array($pid, $pname, $price, $qty);

    // create cart session
    if (isset($_SESSION['cart']))   {
        $cart = $_SESSION['cart'];
        $_SESSION['cart'] = array_push($cart, $cart_item);
    }
    else    {
        session_start();
        $_SESSION['cart'] = $cart_item;
    }
    // 2d array
    $cart_to_show = $_SESSION['cart'];
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
                    <div id="results"></div>

                    <tr>
                        <td colspan="4" align="right">Total</td>
                        <td>ADD THE TOTAL SUM</td>
                    </tr>
                </table>
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

                    var cart = <?php echo json_encode($cart_to_show, JSON_PRETTY_PRINT); ?>;
                    var TableContent = "";
                    console.log(cart);

                    // for (var i = 0; i < cart.length; i++)   {
                    //     no = i+1
                    //     eachrow =   "<td>" + no + "</td>" +
                    //                 "<td>" + cart[i].
                    // }
                });
            });





        </script>


    </body>
</html>