<?php
    session_start();
    $item = $_POST['item'];

    if (isset($_POST['item']))    {
        // cart is found
        if (isset($_SESSION['cart']))   {
            $avail = 0;
            // PROBLEM
            foreach ($_SESSION['cart'] as $index => $values) {
                // similar item is found
                if ($values['pid'] == $item['pid'])    {
                    $values['qty'] += 1;
                    $values['price'] += $item['price'];
                    $avail += 1;
                }
            }
            // new item to add
            if ($avail == 0)    {
                $_SESSION['cart'][] = $item;
            }
        }
        // cart not found
        else    {
            $_SESSION['cart'][] = $item;
        }
        // session_destroy();
        // unset($_SESSION['cart']);
        // var_dump($_SESSION['cart']);
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
            
            $total += $subtotal;
        }
        
        $data = array(
            'items_details' => $output,
            'total_price' => '$' . number_format($total, 2)
        );
        
        echo json_encode($data);
    }
    else    {
        echo "Something went wrong";
    }
?>