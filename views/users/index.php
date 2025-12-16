<?php
$pageTitle = 'Registered Users';
require_once 'views/layouts/header.php';
?>

<div class="container table_container">
    <h2>Registered Users</h2>

    <?php
    // Check if there's a database error
    if (isset($connectionError)): ?>
        <p style='color:red;'><?php echo $connectionError; ?></p>
    <?php endif; ?>

    <?php if (empty($users)): ?>
        <p class="no-data">Currently, there are no users in the database.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Telephone</th>
                <th>Gender</th>
                <th>Nationality</th>
                <th colspan='2'>Actions</th>
            </tr>

            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['userId']); ?></td>
                    <td><?php echo htmlspecialchars($user['firstName']); ?></td>
                    <td><?php echo htmlspecialchars($user['lastName']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['telephone']); ?></td>
                    <td><?php echo htmlspecialchars($user['gender']); ?></td>
                    <td><?php echo htmlspecialchars($user['nationality']); ?></td>
                    <td class='action-links'>
                        <a href='<?php echo BASE_URL; ?>user/edit/<?php echo $user['userId']; ?>'>Edit</a>
                    </td>
                    <td class='action-links delete'>
                        <a class='delete'
                            href='<?php echo BASE_URL; ?>user/delete/<?php echo $user['userId']; ?>'
                            onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <br>
    <div class="action-links">
        <a href='<?php echo BASE_URL; ?>user/create'>Add Another User</a>
        <a href='<?php echo BASE_URL; ?>user/search'>Search Users</a>
        <a href='<?php echo BASE_URL; ?>'>Back to Home</a>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>