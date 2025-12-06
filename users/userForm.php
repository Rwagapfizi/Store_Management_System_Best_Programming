<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Account Registration</title>
	<link rel="stylesheet" href="../style.css">
</head>

<body>
	<h1>STORE MANAGEMENT SYSTEM</h1>
	<div class="container form_container">
		<h2>REGISTER USER</h2>
		<form action="regUser.php" method="POST">
			<div class="row">
				<label for="firstname">First name: </label>
				<input
					type="text"
					name="firstname"
					id="firstname"
					placeholder="First Name"
					required="required" />
			</div>
			<div class="row">
				<label for="lastname">Last name: </label>
				<input
					type="text"
					name="lastname"
					id="lastname"
					placeholder="Last Name"
					required="required" />
			</div>
			<div class="row">
				<label for="telephone">Telephone: </label>
				<input
					type="tel"
					name="telephone"
					id="telephone"
					placeholder="Telephone"
					required="required" />
			</div>
			<div class="row">
				<label>Gender: </label>
				<input type="radio" name="gender" id="gender" value="Male" required/>
				<label for="male">Male</label>
				<input type="radio" name="gender" id="gender" value="Female" />
				<label for="female">Female</label>
			</div>
			<div class="row">
				<label for="nationality">Nationality: </label>
				<select name="nationality" id="nationality" required>
					<option value="">-Select-</option>
					<option value="Rwanda">Rwanda</option>
					<option value="Kenya">Kenya</option>
					<option value="Burundi">Burundi</option>
					<option value="Uganda">Uganda</option>
					<option value="Tanzania">Tanzania</option>
					<option value="DRC">DRC</option>
					<option value="Russia">Russia</option>
					<option value="Italy">Italy</option>
					<option value="other">other</option>
				</select>
			</div>
			<div class="row">
				<label for="Email">Email: </label>
				<input
					type="email"
					name="email"
					id="email"
					placeholder="Email"
					required="required" />
			</div>
			<div class="row">
				<label for="username">User Name: </label>
				<input type="text" name="username" id="username" placeholder="User Name" required="required" />
			</div>
			<div class="row">
				<label for="password">Password: </label>
				<input type="password" name="password" id="password" placeholder="Password" required />
			</div>
			<div class="row">
				<label for="confirmpassword">Confirm Password: </label>
				<input type="password" name="cpassword" id="confirmpassword" placeholder="Confirm Password" required="required" />
			</div>
			<input type="submit" value="Register User" name="Register" />
		</form>
		<a href="../home.php">Back to Home</a>
	</div>
</body>

</html>