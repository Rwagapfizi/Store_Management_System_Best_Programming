<?php
$pageTitle = 'Edit Product in Inventory';
require_once 'views/layouts/header.php';
?>

<div class="container">
    <h2>EDIT PRODUCT IN INVENTORY</h2>

    <form action="<?php echo BASE_URL; ?>inventory/update/<?php echo isset($inventoryItem['inventory_id']) ? $inventoryItem['inventory_id'] : ''; ?>" method="POST">
        <!-- Product Dropdown -->
        <div class="row">
            <label for="productID">Product: </label>
            <select name="productID" id="productID" required>
                <option value="">Select Product</option>
                <?php foreach ($products as $product):
                    $selected = (isset($inventoryItem['productId']) && $inventoryItem['productId'] == $product['productId']) ? "selected" : "";
                ?>
                    <option value="<?php echo htmlspecialchars($product['productId']); ?>" <?php echo $selected; ?>>
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
                placeholder="quantity"
                min="1"
                required="required"
                value="<?php echo isset($inventoryItem['quantity']) ? htmlspecialchars($inventoryItem['quantity']) : ''; ?>" />
        </div>

        <div class="row">
            <label for="userID">User: </label>
            <select name="userID" id="userID" required>
                <option value="">Select User</option>
                <?php foreach ($users as $user):
                    $selected = (isset($inventoryItem['userID']) && $inventoryItem['userID'] == $user['userId']) ? "selected" : "";
                ?>
                    <option value="<?php echo htmlspecialchars($user['userId']); ?>" <?php echo $selected; ?>>
                        <?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="submit" value="Update Inventory" name="Register" />
    </form>

    <div class="action-links">
        <a href="<?php echo BASE_URL; ?>inventory">Back to Inventories</a>
        <a href="<?php echo BASE_URL; ?>">Back to Home</a>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>