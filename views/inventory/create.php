<?php
$pageTitle = 'Add to Inventory';
require_once 'views/layouts/header.php';
?>

<div class="container">
    <h2>ADD TO INVENTORY</h2>

    <form action="<?php echo BASE_URL; ?>inventory/store" method="POST">
        <div class="row">
            <label for="productID">Product: </label>
            <select name="productID" id="productID" required>
                <option value="">Select Product</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?php echo htmlspecialchars($product['productId']); ?>">
                        <?php echo htmlspecialchars($product['product_Name'] . ', ' . $product['brand']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <label for="quantity">Quantity: </label>
            <input
                type="number"
                name="quantity"
                id="quantity"
                placeholder="Quantity"
                min="1"
                required="required" />
        </div>

        <div class="row">
            <label for="userID">User Name</label>
            <select name="userID" id="userID" required>
                <option value="">Select User</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo htmlspecialchars($user['userId']); ?>">
                        <?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="submit" value="Add to Inventory" name="Register" />
    </form>

    <div class="action-links">
        <a href="<?php echo BASE_URL; ?>inventory">Back to Inventory</a>
        <a href="<?php echo BASE_URL; ?>">Back to Home</a>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>