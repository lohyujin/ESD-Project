<?php
    session_start();
    $pid = $_POST['pid'];
    $pname = $_POST['pname'];
    $pdesc = $_POST['pdesc'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];

    if (isset($_POST['pid']))    {
        // cart is found
        if (isset($_SESSION['cart']))   {
            // item exists so add qty only
            if(array_key_exists($pid, $_SESSION["cart"])){
                $_SESSION["cart"][$pid][3] += 1;
            }
            // new item to add
            else    {
                $_SESSION['cart'][$pid] = [$pname, $pdesc, $price, $qty];
            }
        }
        // cart not found
        else    {
            $_SESSION['cart'][$pid] = [$pname, $pdesc, $price, $qty];
        }

        $counter = 0;
        $total = 0;
        $output = '';

        foreach ($_SESSION['cart'] as $index => $values)  {
            $counter += 1;
            $price = (float) $values[2];
            $subtotal = $price * (int) $values[3];

            $output .= '
            <tr>
                <td>' . $counter . '</td>' .
                '<td>' . $values[0] . '</td>' .
                '<td>$' . $price . '</td>' .
                '<td>' . $values[3] . '</td>' .
                '<td>$' . $subtotal . '</td>
            </tr>';
            
            $total += $subtotal;
        }
        
        $data = array(
            'updated' => $_SESSION['cart'],
            'items_details' => $output,
            'total_price' => number_format($total, 2, '.', '')
        );
        
        echo json_encode($data);
    }
    else    {
        echo "Something went wrong";
    }
?>