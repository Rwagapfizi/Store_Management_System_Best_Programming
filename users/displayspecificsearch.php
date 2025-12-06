<?php

$search = $_POST['search'];

$searchResults = array();

include "../connect.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Searched Users</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <h1>STORE MANAGEMENT SYSTEM</h1>
    <div class="container table_container">
        <h2>Searched Users</h2>
        <?php
        if (!$connection) {
            echo "<p style='color:red;'>Connection failed: " . mysqli_connect_error() . "</p>";
        } else {
            $query = "SELECT * FROM stk_users WHERE username LIKE '%$search%'";
            $searchQuery = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($searchQuery)) {
                array_push($searchResults, $row);
            }

            if (count($searchResults) < 1) {
                echo "<caption>No user found</caption>";
            } else {
                echo "<table>";
                echo "<tr>
                        <th>No</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Telephone</th>
                        <th>Gender</th>
                        <th>Nationality</th>
                        <th>Username</th>
                        <th>Email</th>
                    </tr>";
                foreach ($searchResults as $user) {
                    echo "<tr>
                            <td>{$user['userId']}</td>
                            <td>{$user['firstName']}</td>
                            <td>{$user['lastName']}</td>
                            <td>{$user['telephone']}</td>
                            <td>{$user['gender']}</td>
                            <td>{$user['nationality']}</td>
                            <td>{$user['username']}</td>
                            <td>{$user['email']}</td>
                        </tr>";
                }
                echo "</table>";
            }
            echo "<br><a href=\"../home.php\">Back to home</a>";
            echo "<a href=\"search.php\">Back to search</a>";
        }
        ?>
    </div>
</body>

</html>