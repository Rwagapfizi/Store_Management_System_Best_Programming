<?php
$pageTitle = 'Register Product';
require_once 'views/layouts/header.php';
?>

<div class="container form_container">
    <h2>REGISTER PRODUCT</h2>

    <form action="<?php echo BASE_URL; ?>product/store" method="POST">
        <div class="row">
            <label for="product_Name">Product Name: </label>
            <input
                type="text"
                name="product_Name"
                id="product_Name"
                placeholder="Product Name"
                required="required" />
        </div>

        <div class="row">
            <label for="brand">Brand: </label>
            <input
                type="text"
                name="brand"
                id="brand"
                placeholder="Brand"
                required="required" />
        </div>

        <div class="row">
            <label for="supplier">Supplier: </label>
            <input
                type="text"
                name="supplier"
                id="supplier"
                placeholder="Supplier"
                required="required" />
        </div>

        <div class="row">
            <label for="supplier_phone">Supplier Phone: </label>
            <input
                type="tel"
                name="supplier_phone"
                id="supplier_phone"
                placeholder="Supplier Phone" />
        </div>

        <input type="submit" value="Register Product" name="Register" />
    </form>

    <div class="action-links">
        <a href="<?php echo BASE_URL; ?>product">Back to Products List</a>
        <a href="<?php echo BASE_URL; ?>">Back to Home</a>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>