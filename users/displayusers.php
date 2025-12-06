<?php
$users = array();
include "../connect.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Display Users</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <h1>STORE MANAGEMENT SYSTEM</h1>
    <div class="container table_container">
        <h2>Registered Users</h2>

        <?php
        if (!$connection) {
            echo "<p style='color:red;'>Connection failed: " . mysqli_connect_error() . "</p>";
        } else {
            $query = "SELECT * FROM stk_users";
            $result = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                array_push($users, $row);
            }

            if (count($users) < 1) {
                echo "<caption>Currently, there are no users in the database.</caption>";
            } else {
                echo "<table>";
                echo "<tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Telephone</th>
                        <th>Gender</th>
                        <th>Nationality</th>
                        <th colspan='2'>Actions</th>
                    </tr>";
                foreach ($users as $user) {
                    echo "<tr>
                            <td>{$user['userId']}</td>
                            <td>{$user['firstName']}</td>
                            <td>{$user['lastName']}</td>
                            <td>{$user['username']}</td>
                            <td>{$user['email']}</td>
                            <td>{$user['telephone']}</td>
                            <td>{$user['gender']}</td>
                            <td>{$user['nationality']}</td>
                            <td class='action-links'>
                                <a href='edituser.php?record={$user['userId']}'>Edit</a>
                            </td>
                            <td class='action-links'>
                                <a class='delete' href='deleteuser.php?record={$user['userId']}'>Delete</a>
                            </td>
                        </tr>";
                }
                echo "</table>";
            }

            echo "<br><a href='../home.php'>Back to Home</a>";
            echo "<a href='userForm.php'>Add Another User</a>";
        }
        ?>
    </div>
</body>

</html>