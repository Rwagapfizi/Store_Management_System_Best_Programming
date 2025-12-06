<?php

$products = array();

include "../connect.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Display Products</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <h1>STORE MANAGEMENT SYSTEM</h1>
    <div class="container table_container">
        <h2>Registered Products</h2>

        <?php
        if (!$connection) {
            echo "<p style='color:red;'>Connection failed: " . mysqli_connect_error() . "</p>";
        } else {
            $query = "SELECT pro.*, user.* 
                    FROM stk_products pro JOIN stk_users user
                    ON pro.userID = user.userId";
            $result = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                array_push($products, $row);
            }
            if (count($products) < 1) {
                echo "<caption>Currently, There no products in the database.</caption>";
            } else {
                echo "<table>";
                echo "<tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Brand</th>
                        <th>Supplier</th>
                        <th>Supplier Phone</th>
                        <th>Registered User</th>
                        <th>Edit product</th>
                        <th>Delete product</th>";
                for ($x = 0; $x < count($products); $x++) {
                    echo "<tr>
                            <td>" . $products[$x]['productId'] . "</td>
                            <td>" . $products[$x]['product_Name'] . "</td>
                            <td>" . $products[$x]['brand'] . "</td>
                            <td>" . $products[$x]['supplier'] . "</td>
                            <td>" . $products[$x]['supplier_phone'] . "</td>
                            <td>" . $products[$x]['firstName'] . " " . $products[$x]['lastName'] .  "</td>
                            <td><a href=\"editproduct.php?record=" . $products[$x]['productId'] . "\">Edit product</a></td>
                            <td><a class='delete' href=\"deleteproduct.php?record=" . $products[$x]['productId'] . "\">Delete product</a></td>
                            </tr>
                            ";
                }
                echo "</table>";
            }
            echo "<br><a href=\"../home.php\">Back to home</a>";
            echo "<a href=\"productform.php\">Add a product</a>";
        }

        ?>
    </div>
</body>

</html>