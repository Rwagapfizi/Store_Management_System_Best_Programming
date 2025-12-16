<?php
$pageTitle = 'Confirm Product Deletion';
require_once 'views/layouts/header.php';

// Get product with relations
$productWithRelations = $this->productModel->getProductWithRelations($id);
?>

<div class="container">
    <h2>Confirm Product Deletion</h2>

    <?php if ($productWithRelations): ?>
        <div class="warning-box">
            <h3>⚠️ Delete Product: <?php echo htmlspecialchars($productWithRelations['product_Name']); ?></h3>

            <p>Product ID: <strong><?php echo htmlspecialchars($productWithRelations['productId']); ?></strong></p>
            <p>Brand: <strong><?php echo htmlspecialchars($productWithRelations['brand']); ?></strong></p>
            <p>Supplier: <strong><?php echo htmlspecialchars($productWithRelations['supplier']); ?></strong></p>

            <?php if ($productWithRelations['inventory_count'] > 0 || $productWithRelations['outgoing_count'] > 0): ?>
                <div class="danger-box">
                    <h4>⚠️ WARNING: Product has related records!</h4>

                    <ul>
                        <?php if ($productWithRelations['inventory_count'] > 0): ?>
                            <li>Inventory entries: <?php echo $productWithRelations['inventory_count']; ?></li>
                        <?php endif; ?>

                        <?php if ($productWithRelations['outgoing_count'] > 0): ?>
                            <li>Outgoing records: <?php echo $productWithRelations['outgoing_count']; ?></li>
                        <?php endif; ?>
                    </ul>

                    <p>Deleting this product will also delete all related records.</p>

                    <div class="cascade-option">
                        <label>
                            <input type="checkbox" name="cascade" value="yes" required>
                            I understand that all related inventory and outgoing records will be deleted
                        </label>
                    </div>
                </div>
            <?php else: ?>
                <p>This product has no related inventory or outgoing records.</p>
            <?php endif; ?>

            <form action="<?php echo BASE_URL; ?>product/destroy/<?php echo $productWithRelations['productId']; ?>" method="POST">
                <div class="confirmation-options">
                    <label>
                        <input type="radio" name="confirm" value="yes" required>
                        Yes, delete this product<?php echo ($productWithRelations['inventory_count'] > 0 || $productWithRelations['outgoing_count'] > 0) ? ' and all related records' : ''; ?>
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="confirm" value="no" checked>
                        No, keep the product
                    </label>
                </div>

                <?php if ($productWithRelations['inventory_count'] > 0 || $productWithRelations['outgoing_count'] > 0): ?>
                    <input type="hidden" name="cascade" value="yes">
                <?php endif; ?>

                <div class="form-actions">
                    <input type="submit" value="Confirm Deletion" class="btn btn-danger">
                    <a href="<?php echo BASE_URL; ?>product" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="error-box">
            <p>Product not found.</p>
            <a href="<?php echo BASE_URL; ?>product" class="btn">Back to Products</a>
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

    .danger-box {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        padding: 15px;
        margin: 15px 0;
    }

    .danger-box h4 {
        color: #721c24;
        margin-top: 0;
    }

    .warning-box h3 {
        color: #856404;
        margin-top: 0;
    }

    .cascade-option {
        width: 100%;
        background: white;
        padding: 10px;
        border-radius: 4px;
        margin: 10px 0;
    }

    .cascade-option label {
        display: flex;
        width: 100%;
        align-items: center;
        font-weight: bold;
    }

    .cascade-option input[type="checkbox"] {
        margin-right: 10px;
    }

    .confirmation-options {
        margin: 20px 0;
        width: 100%;
    }

    .confirmation-options label {
        display: block;
        width: 100%;
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