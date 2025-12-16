<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - <?php echo isset($pageTitle) ? $pageTitle : 'Home'; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>

<body>
    <div class="main-header">
        <h1>STORE MANAGEMENT SYSTEM</h1>
    </div>

    <div class="home_container">
        <div id="crud">
            <h2>HOME MENU</h2>

            <div class="section">
                <h3>USERS MANAGEMENT</h3>
                <a href="<?php echo BASE_URL; ?>users" class="btn btn-action">Show Users</a>
                <a href="<?php echo BASE_URL; ?>users/create" class="btn btn-action">Create User</a>
                <a href='<?php echo BASE_URL; ?>user/search' class="btn btn-action">Search Users</a>
            </div>

            <div class="section">
                <h3>PRODUCTS MANAGEMENT</h3>
                <a href="<?php echo BASE_URL; ?>product" class="btn btn-action">Show All Products</a>
                <a href="<?php echo BASE_URL; ?>product/create" class="btn btn-action">Register Products</a>
            </div>

            <div class="section">
                <h3>INVENTORY MANAGEMENT</h3>
                <a href="<?php echo BASE_URL; ?>inventory" class="btn btn-action">Show Inventory</a>
                <a href="<?php echo BASE_URL; ?>inventory/create" class="btn btn-action">Add to Inventory</a>
            </div>

            <div class="section">
                <h3>OUTGOING MANAGEMENT</h3>
                <a href="<?php echo BASE_URL; ?>outgoing" class="btn btn-action">Show Outgoing</a>
                <a href="<?php echo BASE_URL; ?>outgoing/create" class="btn btn-action">Add to Outgoing</a>
                <a href="<?php echo BASE_URL; ?>outgoing/report" class="btn btn-action">View Report</a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?> - By Rwagapfizi Igor, 27329</p>
    </footer>
</body>

</html>