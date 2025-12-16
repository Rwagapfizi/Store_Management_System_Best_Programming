<?php

$id = $_REQUEST['id'];
$productName = $_POST['productname'];
$brand = $_POST['brand'];
$supplierTel = $_POST['suppliertel'];
$supplier = $_POST['supplier'];
$userId = $_POST['userID'];

include "../connect.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Product Update</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <h1>STORE MANAGEMENT SYSTEM</h1>
    <div class="container reg_container">
        <h2>Product Update</h2>

        <?php
        if (!$connection) {
            echo "<p style='color: red;'>Connection failed: " . mysqli_connect_error() . "</p>";
        } else {

            $query = "UPDATE stk_products SET product_Name='$productName', brand='$brand',supplier_phone='$supplierTel',supplier='$supplier', userId='$userId' WHERE productId=$id";
            // $query = "UPDATE stk_products SET product_Name='$productName', brand='$brand',supplier_phone='$supplierTel',supplier='$supplier' WHERE productId=$id";
            $updateQuery = mysqli_query($connection, $query);
            if ($updateQuery) {
                echo "<p style='color: green;' class='reg_message'>Product \"$productName\" successfully updated!</p>";
            } else {
                echo "<p style='color: red;' class='reg_message>ERROR: " . mysqli_error($connection) . "</p>";
            }
        }
        echo "<br><a href=\"displayproducts.php\">Display products</a>";
        echo "<a href=\"../home.php\">Back to Home</a>";
        ?>
    </div>
</body>

</html>
