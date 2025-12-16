<?php

$id = $_REQUEST['id'];
$productId = $_POST['productid'];
$quantity = $_POST['quantity'];
$userID = $_POST['userID'];

include "../connect.php";

?>
<!DOCTYPE html>
<html>

<head>
    <title>Inventory Update</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <h1>STORE MANAGEMENT SYSTEM</h1>
    <div class="container reg_container">
        <h2>Inventory Update</h2>

        <?php
        if (!$connection) {
            echo "<p style='color: red;'>Connection failed: " . mysqli_connect_error() . "</p>";
        } else {
            $query = "UPDATE stk_inventory SET productId='$productId', quantity='$quantity', userId='$userID' WHERE inventory_id=$id";
            // $query = "UPDATE stk_inventory SET productId='$productId', quantity='$quantity' WHERE inventory_id=$id";
            $updateQuery = mysqli_query($connection, $query);
            if ($updateQuery) {
                echo "<p style='color: green;' class='reg_message'>Inventory (ID $id) successfully updated!</p>";
            } else {
                echo "<p style='color: red;' class='reg_message>ERROR: " . mysqli_error($connection) . "</p>";
            }
        }
        echo "<br><a href=\"displayinventory.php\">Display Products in Inventory</a>";
        echo "<a href=\"../home.php\">Back to Home</a>";
        ?>
    </div>
</body>

</html>