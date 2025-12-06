<?php
$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
$telephone = $_POST['telephone'];
$gender = $_POST['gender'];
$nationality = $_POST['nationality'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];

include "../connect.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Account Registration</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <h1>STORE MANAGEMENT SYSTEM</h1>
    <div class="container reg_container">
        <h2>Account Registration</h2>

        <?php
        if (!$connection) {
            echo "<p style='color: red;'>Connection failed: " . mysqli_connect_error() . "</p>";
        } else {
            // if (strlen($password) < 6) {
            //     echo "The password must be at least 6 characters long.";
            //     echo "<a href=\"reguser.html\">Go back to signup</a>";
            // } 
            // else 
            //     {
            if ($password != $cpassword) {
                echo "<p style='color: red;' class='reg_message>The two passwords must match.</p>";
                echo "<a href=\"reguser.php\">Go back to signup</a>";
            } else {
                // $password = hash('SHA512', $password);
                $query = "INSERT INTO stk_users(firstName, lastName, telephone, gender, nationality, username, email, password) 
                        VALUES('$firstName', '$lastName', '$telephone', '$gender', '$nationality', '$username', '$email', '$password')";
                $insertQuery = mysqli_query($connection, $query);

                if ($insertQuery) {
                    echo "<p style='color: green;' class='reg_message'>Welcome, <strong>$firstName</strong>! Your account has been created successfully.</p>";
                } else {
                    echo "<p style='color: red;' class='reg_message>ERROR: " . mysqli_error($connection) . "</p>";
                }
            }
            // }
            echo "<br><a href=\"displayusers.php\">Display Users</a>";
            echo "<a href=\"../home.php\">Back to Home</a>";
        }
        ?>
    </div>
</body>

</html>