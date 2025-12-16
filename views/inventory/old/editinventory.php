<?php

$id = $_REQUEST['record'];
$productId = "";
$quantity = "";
$userId = "";

include "../connect.php";
if (!$connection) {
	die("Connection Failed..." . mysqli_connect_error($connection));
} else {
	$query = "SELECT * FROM stk_inventory WHERE inventory_id=$id";
	$result = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_assoc($result)) {
		$productId = $row['productId'];
		$quantity = $row['quantity'];
		$userId = $row['userID'];
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Edit Product in Inventory</title>
	<link rel="stylesheet" href="../style.css">
</head>

<body>
	<h1>STORE MANAGEMENT SYSTEM</h1>
	<h2>EDIT PRODUCT IN INVENTORY</h2>
	<div class="container">
		<form action="updateinventory.php?id=<?php echo $id; ?>" method="POST">
			<!-- Product Dropdown -->
			<div class="row">
				<label for="profuctid">Product: </label>
				<select name="productid" id="productid" required>
					<option value="">Select Product</option>
					<?php
					$query = "SELECT productId, product_Name, brand FROM stk_products";
					$result = mysqli_query($connection, $query);
					while (list($pID, $pname, $brand) = mysqli_fetch_array($result)) {
						$selected = ($pID == $productId) ? "selected" : "";
						echo "<option value=\"$pID\" $selected>$pname, $brand</option>";
					}
					?>
				</select>
			</div>
			<div class="row">
				<label for="quantity">Quantity: </label>
				<input
					type="number"
					name="quantity"
					id="quantity"
					placeholder="quantity"
					required="required"
					value="<?php echo $quantity ?>" />
			</div>
			<div class="row">
				<label for="userID">User: </label>
				<select name="userID" id="userID" required>
					<option value="">Select User</option>
					<?php
					$query = "SELECT userId, firstName, lastName FROM stk_users";
					$result = mysqli_query($connection, $query);
					while (list($uID, $fname, $lname) = mysqli_fetch_array($result)) {
						$selected = ($uID == $userId) ? "selected" : "";
						echo "<option value=\"$uID\" $selected>$fname $lname</option>";
					}
					?>
				</select>
			</div>
			<input type="submit" value="Update Inventory" name="Register" />
		</form>
		<a href="displayinventory.php">Back to Inventories</a>
		<a href="../home.php">Back to Home</a>
	</div>
</body>

</html>