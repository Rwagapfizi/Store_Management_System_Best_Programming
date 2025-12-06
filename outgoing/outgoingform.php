<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Add to Outgoing</title>
	<link rel="stylesheet" href="../style.css">
</head>

<body>
	<h1>STORE MANAGEMENT SYSTEM</h1>
	<h2>ADD TO OUTGOING</h2>
	<div class="container">
		<form action="regoutgoing.php" method="POST">
			<div class="row">
				<label for="productID">Product: </label>
				<select name="productID" id="productID" required>
					<?php
					include "../connect.php";
					if (!$connection) {
						die("Connect to the database failed...") . mysqli_connect_error($connection);
					} else {
						echo '<option value="">Select Product</option>';
						$query = "SELECT productId, product_Name, brand FROM stk_products";
						$result = mysqli_query($connection, $query);
						while (list($id, $pname, $brand) = mysqli_fetch_array($result)) {
							echo "\n<option value=\"$id\">$pname, $brand</option>";
						}
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
					placeholder="Quantity"
					required="required" />
			</div>
			<div class="row">
				<label for="userID">User Name</label>
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
			<input type="submit" value="Add to Outgoing" name="Register" />
		</form>
		<a href="../home.php">Back to Home</a>
	</div>
</body>

</html>