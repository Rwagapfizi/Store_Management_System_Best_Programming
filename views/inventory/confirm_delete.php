<?php
$pageTitle = 'Confirm Deletion';
require_once 'views/layouts/header.php';
?>

<div class="container">
    <h2>Confirm Inventory Deletion</h2>

    <?php if (isset($inventoryItem)): ?>
        <div class="warning-box">
            <h3>⚠️ Delete Inventory Item</h3>

            <p>Are you sure you want to delete this inventory item?</p>

            <div class="item-details">
                <p><strong>Product:</strong> <?php echo htmlspecialchars($inventoryItem['product_Name'] . ' (' . $inventoryItem['brand'] . ')'); ?></p>
                <p><strong>Quantity:</strong> <?php echo htmlspecialchars($inventoryItem['quantity']); ?></p>
                <p><strong>Added by:</strong> <?php echo htmlspecialchars($inventoryItem['firstName'] . ' ' . $inventoryItem['lastName']); ?></p>
            </div>

            <form action="<?php echo BASE_URL; ?>inventory/destroy/<?php echo $inventoryItem['inventory_id']; ?>" method="POST">
                <div class="confirmation-options">
                    <label>
                        <input type="radio" name="confirm" value="yes" required>
                        Yes, delete this inventory item
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="confirm" value="no" checked>
                        No, keep the inventory item
                    </label>
                </div>

                <div class="form-actions">
                    <input type="submit" value="Confirm Deletion" class="btn btn-danger">
                    <a href="<?php echo BASE_URL; ?>inventory" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="error-box">
            <p>Inventory item not found.</p>
            <a href="<?php echo BASE_URL; ?>inventory" class="btn">Back to Inventory</a>
        </div>
    <?php endif; ?>
</div>

<style>
    .warning-box {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 5px;
        padding: 20px;
        margin: 20px 0;
    }

    .warning-box h3 {
        color: #856404;
        margin-top: 0;
    }

    .item-details {
        background: white;
        padding: 15px;
        border-radius: 4px;
        margin: 15px 0;
    }

    .confirmation-options {
        margin: 20px 0;
    }

    .confirmation-options label {
        display: block;
        margin: 10px 0;
        font-size: 16px;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .error-box {
        background: #f8d7da;
        color: #721c24;
        padding: 20px;
        border-radius: 5px;
        text-align: center;
    }
</style>

<?php require_once 'views/layouts/footer.php'; ?>