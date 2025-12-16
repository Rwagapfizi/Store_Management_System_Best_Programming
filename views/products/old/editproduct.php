<?php

$id = $_REQUEST['record'];
$productname = "";
$brand = "";
$userId = "";
$supplier = "";
$suppliertel = "";

include "../connect.php";
if (!$connection) {
	die("Connection Failed..." . mysqli_connect_error($connection));
} else {
	$query = "SELECT * FROM stk_products WHERE productId=$id";
	$result = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_assoc($result)) {
		$productname = $row['product_Name'];
		$brand = $row['brand'];
		$userId = $row['userID'];
		$supplier = $row['supplier'];
		$suppliertel = $row['supplier_phone'];
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Edit Product</title>
	<link rel="stylesheet" href="../style.css">
</head>

<body>
	<h1>STORE MANAGEMENT SYSTEM</h1>
	<div class="container">
		<h2>EDIT PRODUCT <?php echo $id; ?></h2>
		<form action="updateproduct.php?id=<?php echo $id; ?>" method="POST">
			<div class="row">
				<label for="productname">Product name: </label>
				<input
					type="text"
					name="productname"
					id="productname"
					placeholder="productname"
					required="required"
					value="<?php echo $productname; ?>" />
			</div>
			<div class="row">
				<label for="brand">Brand: </label>
				<input
					type="text"
					name="brand"
					id="brand"
					placeholder="brand"
					required="required"
					value="<?php echo $brand; ?>" />
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
			<div class="row">
				<label for="supplier">Supplier: </label>
				<input
					type="text"
					name="supplier"
					id="supplier"
					placeholder="supplier name"
					required="required"
					value="<?php echo $supplier; ?>" />
			</div>
			<div class="row">
				<label for="suppliertel">Supplier Telephone: </label>
				<input type="text" name="suppliertel" id="suppliertel" placeholder="supplier tel" required="required" value="<?php echo $suppliertel; ?>" />
			</div>
			<input type="submit" value="Update Product" name="Register" />
		</form>
		<a href="displayproducts.php">Back to Products</a>
		<a href="../home.php">Back to Home</a>
	</div>
</body>

</html>