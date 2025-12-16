<?php
$pageTitle = 'Products in Inventory';
require_once 'views/layouts/header.php';
?>

<div class="container table_container">
    <h2>Products in Inventory</h2>

    <?php if (empty($inventoryItems)): ?>
        <p class="no-data">Currently, there are no products in the inventory.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>No</th>
                <th>Product Id</th>
                <th>Product Name, Brand</th>
                <th>Quantity</th>
                <th>Registered User</th>
                <th>Added Date</th>
                <th colspan='2'>Actions</th>
            </tr>

            <?php foreach ($inventoryItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['inventory_id']); ?></td>
                    <td><?php echo htmlspecialchars($item['productId']); ?></td>
                    <td><?php echo htmlspecialchars($item['product_Name'] . ', ' . $item['brand']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($item['firstName'] . ' ' . $item['lastName'] . ' (' . $item['username'] . ')'); ?></td>
                    <td><?php echo date('Y-m-d H:i', strtotime($item['added_date'])); ?></td>
                    <td class='action-links'>
                        <a href='<?php echo BASE_URL; ?>inventory/edit/<?php echo $item['inventory_id']; ?>'>Edit</a>
                    </td>
                    <td class='action-links delete'>
                        <!-- <a class='delete'
                            href='<?php echo BASE_URL; ?>inventory/delete/<?php echo $item['inventory_id']; ?>'
                            onclick="return confirmDelete(<?php echo $item['inventory_id']; ?>, '<?php echo htmlspecialchars(addslashes($item['product_Name'])); ?>')">
                            Delete
                        </a> -->
                        <a class='delete'
                            href='<?php echo BASE_URL; ?>inventory/delete/<?php echo $item['inventory_id']; ?>'>
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <br>
    <div class="action-links">
        <a href='<?php echo BASE_URL; ?>'>Back to Home</a>
        <a href='<?php echo BASE_URL; ?>inventory/create'>Add a product into Inventory</a>
    </div>
</div>

<script>
    function confirmDelete(inventoryId, productName) {
        return confirm('Are you sure you want to delete ' + productName + ' from inventory?');
    }
</script>

<?php require_once 'views/layouts/footer.php'; ?>