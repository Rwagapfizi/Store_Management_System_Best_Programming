<?php
$pageTitle = '500 - Server Error';
// require_once '../views/layouts/header.php';
require_once './views/layouts/header.php'
?>

<div class="container error-container">
    <div class="error-content">
        <h1>500</h1>
        <h2>Internal Server Error</h2>
        <p>Something went wrong on our end. Please try again later or contact support if the problem persists.</p>
        <div class="error-actions">
            <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">Go to Homepage</a>
            <a href="javascript:history.back()" class="btn btn-secondary">Go Back</a>
            <?php if (DEBUG_MODE && isset($error)): ?>
                <div class="error-details">
                    <h3>Error Details:</h3>
                    <pre><?php echo htmlspecialchars($error); ?></pre>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .error-container {
        text-align: center;
        padding: 50px 20px;
        min-height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .error-content h1 {
        font-size: 120px;
        color: #dc3545;
        margin: 0;
        font-weight: bold;
    }

    .error-content h2 {
        font-size: 36px;
        color: orange;
        margin: 10px 0 20px;
    }

    .error-content p {
        font-size: 18px;
        color: #666;
        margin-bottom: 30px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .error-actions {
        margin-top: 30px;
    }

    .error-actions .btn {
        margin: 0 10px;
        padding: 10px 30px;
        font-size: 16px;
    }

    .error-details {
        margin-top: 30px;
        text-align: left;
        background: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
        border-left: 4px solid #dc3545;
    }

    .error-details h3 {
        color: #333;
        margin-bottom: 10px;
    }

    .error-details pre {
        background: #fff;
        padding: 15px;
        border-radius: 4px;
        overflow-x: auto;
        font-size: 14px;
        color: #721c24;
    }
</style>

<?php require_once '../views/layouts/footer.php'; ?>