<?php

$products = array();

include "../../connect.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Display Inventory</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <h1>STORE MANAGEMENT SYSTEM</h1>
    <div class="container table_container">
        <h2>Products in Inventory</h2>

        <?php
        if (!$connection) {
            echo "<p style='color:red;'>Connection failed: " . mysqli_connect_error() . "</p>";
        } else {
            $query = "SELECT inv.inventory_id, inv.quantity, inv.productID, pro.product_Name, pro.brand, user.*
                FROM stk_inventory inv JOIN stk_products pro JOIN stk_users user
                ON inv.productID = pro.productID AND inv.userID = user.userId";
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
                            <td>" . $products[$x]['inventory_id'] . "</td>
                            <td>" . $products[$x]['productID'] . "</td>
                            <td>" . $products[$x]['product_Name'] . ", " . $products[$x]['brand'] . "</td>
                            <td>" . $products[$x]['quantity'] . "</td>
                            <td>" . $products[$x]['firstName'] . " " . $products[$x]['lastName'] .  "</td>
                            <td><a href=\"editinventory.php?record=" . $products[$x]['inventory_id'] . "\">Edit product</a></td>
                            <td><a href=\"deleteinventory.php?record=" . $products[$x]['inventory_id'] . "\" class='delete'>Delete product</a></td>
                            </tr>
                            ";
                }
                echo "</table>";
            }
            echo "<br><a href=\"../home.php\">Back to home</a>";
            echo "<a href=\"inventoryform.php\">Add a product into Inventory</a>";
        }

        ?>
    </div>
</body>

</html>