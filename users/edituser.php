<?php

$id = $_REQUEST['record'];
$firstname = "";
$lastname = "";
$telephone = "";
$gender = "";
$nationality = "";
$username = "";
$email = "";
$countries = ['Rwanda', 'Kenya', 'Burundi', 'Uganda', 'Tanzania', 'DRC', 'Russia', 'Italy', 'other'];

include "../connect.php";
if (!$connection) {
	die("Connection Failed..." . mysqli_connect_error($connection));
} else {
	$query = "SELECT * FROM stk_users WHERE userId=$id";
	$result = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_assoc($result)) {
		$firstname = $row['firstName'];
		$lastname = $row['lastName'];
		$gender = $row['gender'];
		$telephone = $row['telephone'];
		$nationality = $row['nationality'];
		$email = $row['email'];
		$username = $row['username'];
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Edit User</title>
	<link rel="stylesheet" href="../style.css">
</head>

<body>
	<h1>STORE MANAGEMENT SYSTEM</h1>
	<div class="container form_container">
		<h2>UPDATE USER <?php echo $id; ?></h2>
		<form action="updateuser.php?id=<?php echo $id; ?>" method="POST">
			<div class="row">
				<label for="firstname">First name: </label>
				<input
					type="text"
					name="firstname"
					id="firstname"
					placeholder="firstname"
					required="required"
					value="<?php echo $firstname; ?>" />
			</div>
			<div class="row">
				<label for="lastname">Last name: </label>
				<input
					type="text"
					name="lastname"
					id="lastname"
					placeholder="lastname"
					required="required"
					value="<?php echo $lastname; ?>" />
			</div>
			<div class="row">
				<label for="telephone">Telephone: </label>
				<input
					type="tel"
					name=" telephone"
					id="telephone"
					placeholder="telephone"
					required="required"
					value="<?php echo $telephone; ?>" />
			</div>
			<div class="row">
				<label>Gender: </label>
				<?php
				if ($gender == 'male') {
					echo "<input type=\"radio\" name=\"gender\" id=\"male\" value=\"Male\" checked required />";
				} else {
					echo "<input type=\"radio\" name=\"gender\" id=\"male\" value=\"Male\" required />";
				}
				?>
				<label for="male">Male</label>
				<?php
				if ($gender == 'female') {
					echo "<input type=\"radio\" name=\"gender\" id=\"female\" value=\"Female\" checked required />";
				} else {
					echo "<input type=\"radio\" name=\"gender\" id=\"female\" value=\"Female\" required />";
				}
				?>
				<label for="female">Female</label>
			</div>
			<div class="row">
				<label for="nationality">Nationality: </label>
				<select name="nationality" id="nationality" required>
					<?php
					for ($i = 0; $i < count($countries) - 1; $i++) {
						if ($countries[$i] == $nationality) {
							echo "<option>$nationality</option>";
							// unset($countries[$i]);
							// array_values($countries);
						}
					}
					for ($k = 0; $k < count($countries) - 1; $k++) {
						if ($countries[$i] != $nationality) {
							echo "<option>" . $countries[$k] . "</option>";
						}
					}
					?>
				</select>
			</div>
			<div class="row">
				<label for="username">User Name: </label>
				<input type="text" name="username" id="username" placeholder="user name" required="required" value="<?php echo $username; ?>" />
			</div>
			<div class="row">
				<label for="Email">Email: </label>
				<input
					type="email"
					name="email"
					id="email"
					placeholder="email"
					required="required"
					value="<?php echo $email; ?>" />
			</div>
			<div class="row">
				<label for="password">Password: </label>
				<input type="password" name="password" id="password" placeholder="password" required />
			</div>
			<div class="row">
				<label for="confirmpassword">Confirm Password: </label>
				<input type="password" name="cpassword" id="confirmpassword" placeholder="confirm password" required="required" />
			</div>
			<input type="submit" value="Update User" name="Register" />
		</form>
		<a href="displayusers.php">Back to Users</a>
		<a href="../home.php">Back to Home</a>
	</div>
</body>

</html>