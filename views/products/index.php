<?php
$pageTitle = 'All Products';
require_once 'views/layouts/header.php';
?>

<div class="container table_container">
    <h2>All Products</h2>

    <?php if (empty($products)): ?>
        <p class="no-data">Currently, there are no products in the database.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Brand</th>
                <th>Supplier</th>
                <th>Supplier Phone</th>
                <th>Added By</th>
                <th>Added Date</th>
                <th colspan='2'>Actions</th>
            </tr>

            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['productId']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_Name']); ?></td>
                    <td><?php echo htmlspecialchars($product['brand']); ?></td>
                    <td><?php echo htmlspecialchars($product['supplier']); ?></td>
                    <td><?php echo htmlspecialchars($product['supplier_phone']); ?></td>
                    <td><?php echo htmlspecialchars($product['added_by'] ?? 'N/A'); ?></td>
                    <td><?php echo date('Y-m-d H:i', strtotime($product['added_date'])); ?></td>
                    <td class='action-links'>
                        <a href='<?php echo BASE_URL; ?>product/edit/<?php echo $product['productId']; ?>'>Edit</a>
                    </td>
                    <td class='action-links delete'>
                        <a class='delete'
                            href='<?php echo BASE_URL; ?>product/delete/<?php echo $product['productId']; ?>'
                            onclick="return confirmDelete(<?php echo $product['productId']; ?>, '<?php echo htmlspecialchars($product['product_Name']); ?>')">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <br>
    <div class="action-links">
        <a href='<?php echo BASE_URL; ?>product/create'>Add New Product</a>
        <a href='<?php echo BASE_URL; ?>'>Back to Home</a>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>