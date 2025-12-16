<?php
$pageTitle = 'Confirm Deletion';
require_once 'views/layouts/header.php';
?>

<div class="container">
    <h2>Confirm Outgoing Deletion</h2>

    <?php if (isset($outgoingItem)): ?>
        <div class="warning-box">
            <h3>⚠️ Delete Outgoing Record</h3>

            <p>Are you sure you want to delete this outgoing record?</p>
            <p><strong>Note:</strong> Deleting this record will restore the quantity to inventory.</p>

            <div class="item-details">
                <p><strong>Product:</strong> <?php echo htmlspecialchars($outgoingItem['product_Name'] . ' (' . $outgoingItem['brand'] . ')'); ?></p>
                <p><strong>Quantity:</strong> <?php echo htmlspecialchars($outgoingItem['quantity']); ?></p>
                <p><strong>Processed by:</strong> <?php echo htmlspecialchars($outgoingItem['firstName'] . ' ' . $outgoingItem['lastName']); ?></p>
                <p><strong>Date:</strong> <?php echo date('Y-m-d H:i', strtotime($outgoingItem['added_date'])); ?></p>
            </div>

            <form action="<?php echo BASE_URL; ?>outgoing/destroy/<?php echo $outgoingItem['outgoingId']; ?>" method="POST">
                <div class="confirmation-options">
                    <label>
                        <input type="radio" name="confirm" value="yes" required>
                        Yes, delete this outgoing record and restore inventory
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="confirm" value="no" checked>
                        No, keep the outgoing record
                    </label>
                </div>

                <div class="form-actions">
                    <input type="submit" value="Confirm Deletion" class="btn btn-danger">
                    <a href="<?php echo BASE_URL; ?>outgoing" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="error-box">
            <p>Outgoing item not found.</p>
            <a href="<?php echo BASE_URL; ?>outgoing" class="btn">Back to Outgoing</a>
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