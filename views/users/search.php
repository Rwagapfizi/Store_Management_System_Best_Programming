<?php
$pageTitle = 'Search Users';
require_once 'views/layouts/header.php';
?>

<div class="search_container">
    <h2>SEARCH BY USERNAME</h2>
    
    <form action="<?php echo BASE_URL; ?>user/searchResults" method="POST">
        <div class="row">
            <label for="search">Search</label>
            <input
                type="text"
                name="search"
                id="search"
                placeholder="Search"
                required="required" />
        </div>
        <input type="submit" value="Search" name="Search" />
    </form>
    
    <div class="action-links">
        <a href="<?php echo BASE_URL; ?>">Back to Home</a>
        <a href="<?php echo BASE_URL; ?>user">Back to Users List</a>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>