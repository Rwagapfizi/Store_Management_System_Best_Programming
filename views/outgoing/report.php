<?php
$pageTitle = 'Outgoing Report';
require_once 'views/layouts/header.php';
?>

<div class="container table_container">
    <h2>Outgoing Report</h2>

    <?php if (empty($outgoingReport)): ?>
        <p class="no-data">No outgoing records found.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Product</th>
                <th>Brand</th>
                <th>Total Outgoing</th>
                <th>Transactions</th>
                <th>Last Outgoing</th>
                <th>Details</th>
            </tr>

            <?php foreach ($outgoingReport as $report): ?>
                <tr>
                    <td><?php echo htmlspecialchars($report['product_Name']); ?></td>
                    <td><?php echo htmlspecialchars($report['brand']); ?></td>
                    <td><?php echo htmlspecialchars($report['total_outgoing']); ?></td>
                    <td><?php echo htmlspecialchars($report['transaction_count']); ?></td>
                    <td><?php echo date('Y-m-d', strtotime($report['last_outgoing_date'])); ?></td>
                    <td>
                        <a href="<?php echo BASE_URL; ?>outgoing/productReport/<?php echo $report['productId']; ?>" class="btn btn-small">
                            View Details
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="summary">
            <h3>Summary</h3>
            <p>Total Products: <?php echo count($outgoingReport); ?></p>
            <p>Total Transactions: <?php echo array_sum(array_column($outgoingReport, 'transaction_count')); ?></p>
            <p>Total Quantity Outgoing: <?php echo array_sum(array_column($outgoingReport, 'total_outgoing')); ?></p>
        </div>
    <?php endif; ?>

    <br>
    <div class="action-links">
        <a href="<?php echo BASE_URL; ?>outgoing" class="btn">Back to Outgoing</a>
        <a href="<?php echo BASE_URL; ?>" class="btn">Back to Home</a>
    </div>
</div>

<style>
    .summary {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin: 20px 0;
        border-left: 4px solid purple;
    }

    .summary h3 {
        margin-top: 0;
        color: purple;
    }

    .btn-small {
        padding: 5px 10px;
        font-size: 14px;
    }
</style>

<?php require_once 'views/layouts/footer.php'; ?>