<?php
$pageTitle = 'Add to Outgoing';
require_once 'views/layouts/header.php';
?>

<div class="container">
    <h2>ADD TO OUTGOING</h2>

    <form action="<?php echo BASE_URL; ?>outgoing/store" method="POST">
        <div class="row">
            <label for="productID">Product: </label>
            <select name="productID" id="productID" required onchange="updateStockInfo()">
                <option value="">Select Product</option>
                <?php foreach ($productsWithStock as $product): ?>
                    <option value="<?php echo htmlspecialchars($product['productId']); ?>"
                        data-stock="<?php echo htmlspecialchars($product['available_stock']); ?>">
                        <?php echo htmlspecialchars($product['product_Name'] . ', ' . $product['brand']); ?>
                        (Stock: <?php echo htmlspecialchars($product['available_stock']); ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <div id="stock-info" style="display: none; margin-top: 5px; font-size: 14px; color: #666;">
                Available stock: <span id="available-stock">0</span>
            </div>
        </div>

        <div class="row">
            <label for="quantity">Quantity: </label>
            <input
                type="number"
                name="quantity"
                id="quantity"
                placeholder="Quantity"
                min="1"
                required="required"
                oninput="validateQuantity()" />
            <div id="quantity-error" style="color: #dc3545; font-size: 14px; display: none;">
                Quantity exceeds available stock!
            </div>
        </div>

        <div class="row">
            <label for="userID">Processed By: </label>
            <select name="userID" id="userID" required>
                <option value="">Select User</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo htmlspecialchars($user['userId']); ?>">
                        <?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="submit" value="Add to Outgoing" name="Register" id="submit-btn" />
    </form>

    <div class="action-links">
        <a href="<?php echo BASE_URL; ?>outgoing">Back to Outgoing</a>
        <a href="<?php echo BASE_URL; ?>">Back to Home</a>
    </div>
</div>

<script>
    let maxStock = 0;

    function updateStockInfo() {
        const productSelect = document.getElementById('productID');
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const stockInfo = document.getElementById('stock-info');
        const availableStockSpan = document.getElementById('available-stock');

        if (selectedOption.value) {
            maxStock = parseInt(selectedOption.getAttribute('data-stock'));
            availableStockSpan.textContent = maxStock;
            stockInfo.style.display = 'block';
        } else {
            stockInfo.style.display = 'none';
            maxStock = 0;
        }

        validateQuantity();
    }

    function validateQuantity() {
        const quantityInput = document.getElementById('quantity');
        const quantityError = document.getElementById('quantity-error');
        const submitBtn = document.getElementById('submit-btn');
        const quantity = parseInt(quantityInput.value) || 0;

        if (maxStock > 0 && quantity > maxStock) {
            quantityError.style.display = 'block';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
            submitBtn.style.cursor = 'not-allowed';
        } else {
            quantityError.style.display = 'none';
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateStockInfo();
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?>