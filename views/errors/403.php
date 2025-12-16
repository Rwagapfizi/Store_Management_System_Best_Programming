<?php
$pageTitle = '403 - Access Denied';
require_once '../views/layouts/header.php';
?>

<div class="container error-container">
    <div class="error-content">
        <h1>403</h1>
        <h2>Access Denied</h2>
        <p>You don't have permission to access this page. If you believe this is an error, please contact the administrator.</p>
        <div class="error-actions">
            <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">Go to Homepage</a>
            <a href="javascript:history.back()" class="btn btn-secondary">Go Back</a>
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
        color: #ff9800;
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
</style>

<?php require_once '../views/layouts/footer.php'; ?>