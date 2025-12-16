<?php
class InventoryModel
{
    private $db;

    public function __construct()
    {
        require_once 'models/Database.php';
        $this->db = Database::getInstance();
    }

    // Get all inventory items with product and user details
    public function getAllInventory()
    {
        $sql = "SELECT inv.inventory_id, inv.quantity, inv.productId, 
                       p.product_Name, p.brand, 
                       u.userId, u.firstName, u.lastName, u.username,
                       inv.added_date
                FROM stk_inventory inv 
                JOIN stk_products p ON inv.productId = p.productId 
                JOIN stk_users u ON inv.userID = u.userId
                ORDER BY inv.inventory_id DESC";

        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Get inventory item by ID
    public function getInventoryById($id)
    {
        $id = $this->db->escape($id);
        $sql = "SELECT inv.*, p.product_Name, p.brand, 
                       u.firstName, u.lastName
                FROM stk_inventory inv 
                JOIN stk_products p ON inv.productId = p.productId 
                JOIN stk_users u ON inv.userID = u.userId
                WHERE inv.inventory_id = '$id'";

        $result = $this->db->query($sql);
        return mysqli_fetch_assoc($result);
    }

    // Add to inventory (with update if exists)
    public function addToInventory($data)
    {
        $productId = $this->db->escape($data['productID']);
        $quantity = $this->db->escape($data['quantity']);
        $userID = $this->db->escape($data['userID']);

        // Check if product already exists in inventory for this user
        $checkSql = "SELECT inventory_id, quantity FROM stk_inventory 
                     WHERE productId = '$productId' AND userId = '$userID'";
        $checkResult = $this->db->query($checkSql);

        if (mysqli_num_rows($checkResult) > 0) {
            // Update existing inventory
            $row = mysqli_fetch_assoc($checkResult);
            $newQuantity = $row['quantity'] + $quantity;
            $inventoryId = $row['inventory_id'];

            $updateSql = "UPDATE stk_inventory SET quantity = '$newQuantity' 
                          WHERE inventory_id = '$inventoryId'";
            return $this->db->query($updateSql);
        } else {
            // Insert new inventory record
            $insertSql = "INSERT INTO stk_inventory (productId, quantity, userId) 
                          VALUES ('$productId', '$quantity', '$userID')";
            return $this->db->query($insertSql);
        }
    }

    // Update inventory
    public function updateInventory($id, $data)
    {
        $id = $this->db->escape($id);
        $productId = $this->db->escape($data['productID']);
        $quantity = $this->db->escape($data['quantity']);
        $userID = $this->db->escape($data['userID']);

        $sql = "UPDATE stk_inventory SET 
                productId = '$productId',
                quantity = '$quantity',
                userId = '$userID'
                WHERE inventory_id = '$id'";

        return $this->db->query($sql);
    }

    // Delete inventory
    public function deleteInventory($id)
    {
        $id = $this->db->escape($id);
        $sql = "DELETE FROM stk_inventory WHERE inventory_id = '$id'";
        return $this->db->query($sql);
    }

    // Get total inventory quantity for a product
    public function getProductInventoryTotal($productId)
    {
        $productId = $this->db->escape($productId);
        $sql = "SELECT SUM(quantity) as total_quantity 
                FROM stk_inventory 
                WHERE productId = '$productId'";

        $result = $this->db->query($sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total_quantity'] ?? 0;
    }

    // Get inventory by product ID
    public function getInventoryByProduct($productId)
    {
        $productId = $this->db->escape($productId);
        $sql = "SELECT inv.*, u.username, u.firstName, u.lastName
                FROM stk_inventory inv 
                JOIN stk_users u ON inv.userID = u.userId
                WHERE inv.productId = '$productId' 
                ORDER BY inv.added_date DESC";

        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Get inventory by user ID
    public function getInventoryByUser($userId)
    {
        $userId = $this->db->escape($userId);
        $sql = "SELECT inv.*, p.product_Name, p.brand
                FROM stk_inventory inv 
                JOIN stk_products p ON inv.productId = p.productId
                WHERE inv.userID = '$userId' 
                ORDER BY inv.added_date DESC";

        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }
}
