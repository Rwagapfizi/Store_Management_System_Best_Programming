<?php

$products = array();

include "../connect.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Display Outgoing</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <h1>STORE MANAGEMENT SYSTEM</h1>
    <div class="container table_container">
        <h2>Products in Outgoing</h2>

        <?php
        if (!$connection) {
            echo "<p style='color:red;'>Connection failed: " . mysqli_connect_error() . "</p>";
        } else {
            // $query = "SELECT * FROM stk_outgoing";
            $query = "SELECT outg.outgoingId, outg.quantity, outg.productID, pro.product_Name, pro.brand, user.*
                FROM stk_outgoing outg JOIN stk_products pro JOIN stk_users user
                ON outg.productID = pro.productID AND outg.userID = user.userId";
            $result = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($products, $row);
            }

            if (count($products) < 1) {
                echo "<caption>Currently, There no products in the inventory.</caption>";
            } else {
                echo "<table>";
                echo "<tr>
                        <th>No</th>
                        <th>Product Id</th>
                        <th>Product Name, Brand</th>
                        <th>Quantity</th>
                        <th>Registered User</th>
                        <th>Edit product</th>
                        <th>Delete product</th>";
                for ($x = 0; $x < count($products); $x++) {
                    echo "<tr>
                    <td>" . $products[$x]['outgoingId'] . "</td>
                    <td>" . $products[$x]['productID'] . "</td>
                    <td>" . $products[$x]['product_Name'] . ", " . $products[$x]['brand'] . "</td>
                    <td>" . $products[$x]['quantity'] . "</td>
                    <td>" . $products[$x]['firstName'] . " " . $products[$x]['lastName'] .  "</td>
                    <td><a href=\"editoutgoing.php?record=" . $products[$x]['outgoingId'] . "\">Edit product</a></td>
                    <td><a class='delete' href=\"deleteoutgoing.php?record=" . $products[$x]['outgoingId'] . "\">Delete product</a></td>
                    </tr>
                    ";
                }
                echo "</table>";
            }
            echo "<br><a href=\"../home.php\">Back to home</a>";
            echo "<a href=\"outgoingform.php\">Add a product into Outgoing</a>";
        }
        ?>
    </div>
</body>

</html>