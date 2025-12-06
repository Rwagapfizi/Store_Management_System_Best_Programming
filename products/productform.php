<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Registration</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <h1>STORE MANAGEMENT SYSTEM</h1>
    <div class="container">
        <h2>REGISTER PRODUCT</h2>
        <form action="regproduct.php" method="POST">
            <div class="row">
                <label for="productname">Product name: </label>
                <input
                    type="text"
                    name="productname"
                    id="productname"
                    placeholder="Product Name"
                    required="required" />
            </div>
            <div class="row">
                <label for="brand">Brand: </label>
                <input
                    type="text"
                    name="brand"
                    id="brand"
                    placeholder="Brand"
                    required="required" />
            </div>
            <div class="row">
                <label for="userID">Registered user: </label>
                <select name="userID" id="userID" required>
                    <?php
                    include "../connect.php";
                    if (!$connection) {
                        die("Connect to the database failed...") . mysqli_connect_error($connection);
                    } else {
                        echo '<option value="">Select User</option>';
                        $query = "SELECT userId, firstName, lastName FROM stk_users";
                        $result = mysqli_query($connection, $query);
                        while (list($id, $fname, $lname) = mysqli_fetch_array($result)) {
                            echo "\n<option value=\"$id\">$fname $lname</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="row">
                <label for="supplier">Supplier: </label>
                <input
                    type="text"
                    name="supplier"
                    id="supplier"
                    placeholder="Supplier Name"
                    required="required" />
            </div>
            <div class="row">
                <label for="suppliertel">Supplier Telephone: </label>
                <input type="text" name="suppliertel" id="suppliertel" placeholder="Supplier Telephone" required="required" />
            </div>
            <input type="submit" value="Register" name="Register" />
        </form>
        <a href="../home.php">Back to Home</a>
    </div>
</body>

</html>