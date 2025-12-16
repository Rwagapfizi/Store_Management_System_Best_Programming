<?php
$pageTitle = 'Edit Outgoing Product';
require_once 'views/layouts/header.php';
?>

<div class="container">
    <h2>EDIT OUTGOING PRODUCT</h2>

    <form action="<?php echo BASE_URL; ?>outgoing/update/<?php echo isset($outgoingItem['outgoingId']) ? $outgoingItem['outgoingId'] : ''; ?>" method="POST">
        <div class="row">
            <label for="productID">Product: </label>
            <select name="productID" id="productID" required>
                <option value="">Select Product</option>
                <?php foreach ($products as $product):
                    $selected = (isset($outgoingItem['productId']) && $outgoingItem['productId'] == $product['productId']) ? "selected" : "";
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
                value="<?php echo isset($outgoingItem['quantity']) ? htmlspecialchars($outgoingItem['quantity']) : ''; ?>" />
        </div>

        <div class="row">
            <label for="userID">Processed By: </label>
            <select name="userID" id="userID" required>
                <option value="">Select User</option>
                <?php foreach ($users as $user):
                    $selected = (isset($outgoingItem['userID']) && $outgoingItem['userID'] == $user['userId']) ? "selected" : "";
                ?>
                    <option value="<?php echo htmlspecialchars($user['userId']); ?>" <?php echo $selected; ?>>
                        <?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="submit" value="Update Outgoing" name="Register" />
    </form>

    <div class="action-links">
        <a href="<?php echo BASE_URL; ?>outgoing">Back to Outgoing</a>
        <a href="<?php echo BASE_URL; ?>">Back to Home</a>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>