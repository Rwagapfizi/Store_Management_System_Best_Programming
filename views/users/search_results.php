<?php
$pageTitle = 'Search Results';
require_once 'views/layouts/header.php';
?>

<div class="container table_container">
    <h2>Searched Users</h2>

    <?php
    // Check for connection error (passed from controller)
    if (isset($connectionError)): ?>
        <p style='color:red;'><?php echo $connectionError; ?></p>
    <?php endif; ?>

    <?php if (empty($users)): ?>
        <p class="no-data">No user found</p>
    <?php else: ?>
        <table>
            <tr>
                <th>No</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Telephone</th>
                <th>Gender</th>
                <th>Nationality</th>
                <th>Username</th>
                <th>Email</th>
            </tr>

            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['userId']); ?></td>
                    <td><?php echo htmlspecialchars($user['firstName']); ?></td>
                    <td><?php echo htmlspecialchars($user['lastName']); ?></td>
                    <td><?php echo htmlspecialchars($user['telephone']); ?></td>
                    <td><?php echo htmlspecialchars($user['gender']); ?></td>
                    <td><?php echo htmlspecialchars($user['nationality']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <br>
    <div class="action-links">
        <a href="<?php echo BASE_URL; ?>">Back to home</a>
        <a href="<?php echo BASE_URL; ?>user/search">Back to search</a>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>