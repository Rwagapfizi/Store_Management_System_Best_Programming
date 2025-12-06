<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Search</title>
	<link rel="stylesheet" href="../style.css">
</head>

<body>
	<h1>STORE MANAGEMENT SYSTEM</h1>
	<h2>SEARCH BY USERNAME</h2>
	<div class="search_container">
		<form action="displayspecificsearch.php" method="POST">
			<div class="row">
				<label for="search">Search</label>
				<input
					type="text"
					name="search"
					id="search"
					placeholder="Search"
					required="required" />
			</div>
			<input type="submit" value="Search" name="Search" />
		</form>
		<a href="../home.php">Back to Home</a>
	</div>
</body>

</html>