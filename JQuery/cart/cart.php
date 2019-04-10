<?php
    // session_start();
    // use url to get PID
    $pid = intval($_GET['id']);
    
    session_start();
    if (isset($_SESSION['cart']))   {
        $cart = $_SESSION['cart'];
    }
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
        input[id=checkout] {
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
                <form>
                    <label for="cname">My name:</label>
                    <input type='text' id='cname' name='cname'>
                    <input id='checkout' class="btn btn-primary" type="button" value="Checkout" onclick='createOrder();' />
                    <!-- <output type="label" id="totalprice" name="totalprice"> -->
                    <input class="btn btn-primary" type="button" value="Continue Shopping" onclick="window.location.href='../main-page.php'" />
                </form>

                <!-- <div id='error'></div> -->
            </div> <!-- col-md-6 -->
           </div> <!-- row -->
    
        <script>
            // load cart items
            $(document).ready(function() {
                var pid = <?php echo $pid; ?>;
                var serviceURL = "http://LAPTOP-9M0FB286:8080/getproduct/" + pid;
                $.get(serviceURL, function (data)   {
                    var pname = data.Pname;
                    var pdesc = data.Pdesc;
                    var price = data.price;
                    var qty = 1;
                    
                    $.ajax({
                        url: 'cart_ajax.php',
                        type: 'post',
                        data: {
                            // 'item': item
                            'pid': pid, 
                            'pname': pname, 
                            'pdesc': pdesc, 
                            'price': price, 
                            'qty': qty
                        },
                        success: function(data) {
                            var obj = JSON.parse(data);
                            $('.items').html(obj.items_details);
                            // for displaying
                            $('#total_price').html("$" + obj.total_price);
                            // for creating order
                            totalprice = obj.total_price;
                            updatedCart = obj.updated;
                        }
                    });
                });
            });
            </script>

            <script>
            function createOrder()  {
                // {
                //     "CID": "string",
                //     "totalPrice": 0,
                //     "Pstatus": "string",
                //     "add_order_items": [
                //         {
                //             "PID": 0,
                //             "Pname": "string",
                //             "price": 0,
                //             "qty": 0
                //         },
                //         {
                //             "PID": 0,
                //             "Pname": "string",
                //             "price": 0,
                //             "qty": 0
                //         }
                //     ]
                // }

                var cid = document.getElementById('cname').value;
                var totalprice2 = totalprice;
                var Pstatus = 'Order Created';

                var add_order_items = [];
                for (var key in updatedCart)   {
                    var toappend = new Object()
                    toappend.PID = parseInt(key);
                    toappend.Pname = updatedCart[key][0];
                    toappend.price = parseFloat(updatedCart[key][2]);
                    toappend.qty = parseInt(updatedCart[key][3]);

                    add_order_items.push(toappend);
                }
                data = JSON.stringify({
                            "CID": cid,
                            "totalPrice": totalprice2,
                            "Pstatus": Pstatus,
                            "add_order_items": add_order_items
                        });
                
                // call service
                var serviceURL = 'http://LAPTOP-9M0FB286:8082/orders';
                $.ajax({
                    url: serviceURL,
                    type: "post",
                    contentType: "application/json; charset=utf-8",
                    data: data,
                    dataType: "json",
                    success: function(){
                        window.location.href='../payment/payment.php';

                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        alert(errorThrown);
                    }
                });
            };
            </script>
    </body>
</html>