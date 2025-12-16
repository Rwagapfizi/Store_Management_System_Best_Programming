<?php
$pageTitle = 'Outgoing Products';
require_once 'views/layouts/header.php';
?>

<div class="container table_container">
    <h2>Outgoing Products</h2>

    <?php if (empty($outgoingItems)): ?>
        <p class="no-data">Currently, there are no outgoing products.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Product Id</th>
                <th>Product Name, Brand</th>
                <th>Quantity</th>
                <th>Processed By</th>
                <th>Date</th>
                <th colspan='2'>Actions</th>
            </tr>

            <?php foreach ($outgoingItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['outgoingId']); ?></td>
                    <td><?php echo htmlspecialchars($item['productId']); ?></td>
                    <td><?php echo htmlspecialchars($item['product_Name'] . ', ' . $item['brand']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($item['firstName'] . ' ' . $item['lastName'] . ' (' . $item['username'] . ')'); ?></td>
                    <td><?php echo date('Y-m-d H:i', strtotime($item['added_date'])); ?></td>
                    <td class='action-links'>
                        <a href='<?php echo BASE_URL; ?>outgoing/edit/<?php echo $item['outgoingId']; ?>'>Edit</a>
                    </td>
                    <td class='action-links delete'>
                        <a class='delete'
                            href='<?php echo BASE_URL; ?>outgoing/delete/<?php echo $item['outgoingId']; ?>'
                            onclick="return confirmDelete(<?php echo $item['outgoingId']; ?>, '<?php echo htmlspecialchars(addslashes($item['product_Name'])); ?>')">
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
        <a href='<?php echo BASE_URL; ?>outgoing/create'>Add to Outgoing</a>
        <a href='<?php echo BASE_URL; ?>outgoing/report'>View Report</a>
    </div>
</div>

<script>
    function confirmDelete(outgoingId, productName) {
        return confirm('Are you sure you want to delete outgoing record for ' + productName + '?');
    }
</script>

<?php require_once 'views/layouts/footer.php'; ?>