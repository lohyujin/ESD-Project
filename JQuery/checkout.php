<?php
    session_start();
    if (isset($_SESSION['cart']))   {
        $counter = 0;
        $total = 0;
        $output = '';

        foreach ($_SESSION['cart'] as $index => $values)  {
            $counter += 1;
            $price = (float) $values['price'];
            $subtotal = $price * (int) $values['qty'];

            $output .= '
            <tr>
                <td>' . $counter . '</td>' .
                '<td>' . $values['pname'] . '</td>' .
                '<td>' . $price . '</td>' .
                '<td>' . $values['qty'] . '</td>' .
                '<td>' . $subtotal . '</td>
            </tr>';
        }
        $totalprice = $_POST['totalprice'];
        
    }
?>

<html>
    <head>
        <title>Checkout</title>
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
            <h1>Order</h1>

            <div class="row">
            <div class="col-md-6">
                
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
                <form method="POST" action="checkout.php">
                    <label for="name">My name</label>
                    <input type='text' id='cname' name="name" placeholder="" />
                    <input class="btn btn-primary" type="submit" value="Make Payment" />
                </form>
            </div> <!-- col-md-6 -->
           </div> <!-- row -->
    <script>
        $(document).ready(function() {
            // SUMTING WRONG
            $('.items').html("<?php echo $output ?>");
            $('#total_price').text("<?php echo $totalprice ?>");
            
        });
    </script>
    </body>
</html>