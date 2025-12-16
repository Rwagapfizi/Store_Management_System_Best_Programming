<?php

$productId = $_POST['productID'];
$quantity = $_POST['quantity'];
$userID = $_POST['userID'];

include "../connect.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Outgoing Addition</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <h1>STORE MANAGEMENT SYSTEM</h1>
    <div class="container reg_container">
        <h2>Outgoing Addition</h2>

        <?php
        if (!$connection) {
            echo "<p style='color: red;'>Connection failed: " . mysqli_connect_error() . "</p>";
        } else {
            $checkQuery = "SELECT quantity FROM stk_outgoing WHERE productId = '$productId' AND userId = '$userID'";
            $result = mysqli_query($connection, $checkQuery);

            if (mysqli_num_rows($result) > 0) {
                // 2. Product exists: update quantity
                $row = mysqli_fetch_assoc($result);
                $newQuantity = $row['quantity'] + $quantity;

                $updateQuery = "UPDATE stk_outgoing SET quantity = '$newQuantity' WHERE productId = '$productId' AND userId = '$userID'";
                if (mysqli_query($connection, $updateQuery)) {
                    echo "<p style='color: green;' class='reg_message'>Inventory updated: Product ID $productId now has quantity $newQuantity.</p>";
                } else {
                    echo "<p style='color: red;' class='reg_message'>Error updating inventory: " . mysqli_error($connection) . "</p>";
                }
            } else {
                // 3. Product does not exist: insert new
                $insertQuery = "INSERT INTO stk_outgoing(productId, quantity, userId) VALUES('$productId', '$quantity', '$userID')";
                if (mysqli_query($connection, $insertQuery)) {
                    echo "<p style='color: green;' class='reg_message'>Product ID $productId successfully added to outgoing.</p>";
                } else {
                    echo "<p style='color: red;' class='reg_message'>Error adding product: " . mysqli_error($connection) . "</p>";
                }
            }
        }
        echo "<br><a href=\"displayoutgoing.php\">Display products in Outgoing</a>";
        echo "<a href=\"../home.php\">Back to Home</a>";
        ?>
    </div>
</body>

</html>