<?php
$pageTitle = 'Edit Product';
require_once 'views/layouts/header.php';
?>

<div class="container form_container">
    <h2>UPDATE PRODUCT <?php echo isset($product['productId']) ? $product['productId'] : ''; ?></h2>

    <form action="<?php echo BASE_URL; ?>product/update/<?php echo isset($product['productId']) ? $product['productId'] : ''; ?>" method="POST">
        <div class="row">
            <label for="product_Name">Product Name: </label>
            <input
                type="text"
                name="product_Name"
                id="product_Name"
                placeholder="Product Name"
                required="required"
                value="<?php echo isset($product['product_Name']) ? htmlspecialchars($product['product_Name']) : ''; ?>" />
        </div>

        <div class="row">
            <label for="brand">Brand: </label>
            <input
                type="text"
                name="brand"
                id="brand"
                placeholder="Brand"
                required="required"
                value="<?php echo isset($product['brand']) ? htmlspecialchars($product['brand']) : ''; ?>" />
        </div>

        <div class="row">
            <label for="supplier">Supplier: </label>
            <input
                type="text"
                name="supplier"
                id="supplier"
                placeholder="Supplier"
                required="required"
                value="<?php echo isset($product['supplier']) ? htmlspecialchars($product['supplier']) : ''; ?>" />
        </div>

        <div class="row">
            <label for="supplier_phone">Supplier Phone: </label>
            <input
                type="tel"
                name="supplier_phone"
                id="supplier_phone"
                placeholder="Supplier Phone"
                value="<?php echo isset($product['supplier_phone']) ? htmlspecialchars($product['supplier_phone']) : ''; ?>" />
        </div>

        <input type="submit" value="Update Product" name="Update" />
    </form>

    <div class="action-links">
        <a href="<?php echo BASE_URL; ?>product">Back to Products</a>
        <a href="<?php echo BASE_URL; ?>">Back to Home</a>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>