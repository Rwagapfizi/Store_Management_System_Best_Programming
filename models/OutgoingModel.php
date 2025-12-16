<?php
class OutgoingModel
{
    private $db;

    public function __construct()
    {
        require_once 'models/Database.php';
        $this->db = Database::getInstance();
    }

    // Get all outgoing items with product and user details
    public function getAllOutgoing()
    {
        $sql = "SELECT o.outgoingId, o.quantity, o.productId, 
                       p.product_Name, p.brand, 
                       u.userId, u.firstName, u.lastName, u.username,
                       o.added_date
                FROM stk_outgoing o 
                JOIN stk_products p ON o.productId = p.productId 
                JOIN stk_users u ON o.userID = u.userId
                ORDER BY o.outgoingId DESC";

        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Get outgoing item by ID
    public function getOutgoingById($id)
    {
        $id = $this->db->escape($id);
        $sql = "SELECT o.*, p.product_Name, p.brand, 
                       u.firstName, u.lastName
                FROM stk_outgoing o 
                JOIN stk_products p ON o.productId = p.productId 
                JOIN stk_users u ON o.userID = u.userId
                WHERE o.outgoingId = '$id'";

        $result = $this->db->query($sql);
        return mysqli_fetch_assoc($result);
    }

    // Add to outgoing
    public function addToOutgoing($data)
    {
        $productId = $this->db->escape($data['productID']);
        $quantity = $this->db->escape($data['quantity']);
        $userID = $this->db->escape($data['userID']);

        $sql = "INSERT INTO stk_outgoing (productId, quantity, userId) 
                VALUES ('$productId', '$quantity', '$userID')";

        return $this->db->query($sql);
    }

    // Update outgoing
    public function updateOutgoing($id, $data)
    {
        $id = $this->db->escape($id);
        $productId = $this->db->escape($data['productID']);
        $quantity = $this->db->escape($data['quantity']);
        $userID = $this->db->escape($data['userID']);

        $sql = "UPDATE stk_outgoing SET 
                productId = '$productId',
                quantity = '$quantity',
                userId = '$userID'
                WHERE outgoingId = '$id'";

        return $this->db->query($sql);
    }

    // Delete outgoing
    public function deleteOutgoing($id)
    {
        $id = $this->db->escape($id);
        $sql = "DELETE FROM stk_outgoing WHERE outgoingId = '$id'";
        return $this->db->query($sql);
    }

    // Deduct from inventory
    public function deductFromInventory($productId, $quantity, $userId)
    {
        $productId = $this->db->escape($productId);
        $quantity = $this->db->escape($quantity);
        $userId = $this->db->escape($userId);

        // Start transaction
        mysqli_begin_transaction($this->db->getConnection());

        try {
            // Get inventory items for this product, ordered by oldest first (FIFO)
            $inventorySql = "SELECT inventory_id, quantity 
                            FROM stk_inventory 
                            WHERE productId = '$productId' 
                            ORDER BY added_date ASC";
            $inventoryResult = $this->db->query($inventorySql);

            $remaining = $quantity;

            while ($row = mysqli_fetch_assoc($inventoryResult) && $remaining > 0) {
                $inventoryId = $row['inventory_id'];
                $available = $row['quantity'];

                if ($available >= $remaining) {
                    // This inventory item has enough quantity
                    $newQuantity = $available - $remaining;

                    if ($newQuantity > 0) {
                        $updateSql = "UPDATE stk_inventory SET quantity = '$newQuantity' 
                                     WHERE inventory_id = '$inventoryId'";
                    } else {
                        $updateSql = "DELETE FROM stk_inventory WHERE inventory_id = '$inventoryId'";
                    }

                    $this->db->query($updateSql);
                    $remaining = 0;
                } else {
                    // Use all from this inventory item
                    $deleteSql = "DELETE FROM stk_inventory WHERE inventory_id = '$inventoryId'";
                    $this->db->query($deleteSql);
                    $remaining -= $available;
                }
            }

            if ($remaining > 0) {
                throw new Exception("Insufficient inventory after deduction attempt");
            }

            mysqli_commit($this->db->getConnection());
            return true;
        } catch (Exception $e) {
            mysqli_rollback($this->db->getConnection());
            error_log("Inventory deduction error: " . $e->getMessage());
            return false;
        }
    }

    // Add to inventory (for restoring stock)
    public function addToInventory($productId, $quantity, $userId)
    {
        $productId = $this->db->escape($productId);
        $quantity = $this->db->escape($quantity);
        $userId = $this->db->escape($userId);

        // Check if product already exists in inventory for this user
        $checkSql = "SELECT inventory_id, quantity FROM stk_inventory 
                     WHERE productId = '$productId' AND userId = '$userId'";
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
                          VALUES ('$productId', '$quantity', '$userId')";
            return $this->db->query($insertSql);
        }
    }

    // Get outgoing report (summary by product)
    public function getOutgoingReport()
    {
        $sql = "SELECT p.productId, p.product_Name, p.brand,
                       SUM(o.quantity) as total_outgoing,
                       COUNT(o.outgoingId) as transaction_count,
                       MAX(o.added_date) as last_outgoing_date
                FROM stk_outgoing o 
                JOIN stk_products p ON o.productId = p.productId 
                GROUP BY p.productId, p.product_Name, p.brand
                ORDER BY total_outgoing DESC";

        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Get outgoing by product
    public function getOutgoingByProduct($productId)
    {
        $productId = $this->db->escape($productId);
        $sql = "SELECT o.*, u.firstName, u.lastName, u.username
                FROM stk_outgoing o 
                JOIN stk_users u ON o.userID = u.userId
                WHERE o.productId = '$productId' 
                ORDER BY o.added_date DESC";

        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Get outgoing by user
    public function getOutgoingByUser($userId)
    {
        $userId = $this->db->escape($userId);
        $sql = "SELECT o.*, p.product_Name, p.brand
                FROM stk_outgoing o 
                JOIN stk_products p ON o.productId = p.productId
                WHERE o.userID = '$userId' 
                ORDER BY o.added_date DESC";

        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Get total outgoing quantity for a product
    public function getProductOutgoingTotal($productId)
    {
        $productId = $this->db->escape($productId);
        $sql = "SELECT SUM(quantity) as total_outgoing 
                FROM stk_outgoing 
                WHERE productId = '$productId'";

        $result = $this->db->query($sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total_outgoing'] ?? 0;
    }

    // Get outgoing between dates
    public function getOutgoingBetweenDates($startDate, $endDate)
    {
        $startDate = $this->db->escape($startDate);
        $endDate = $this->db->escape($endDate);

        $sql = "SELECT o.*, p.product_Name, p.brand, 
                    u.firstName, u.lastName
                FROM stk_outgoing o 
                JOIN stk_products p ON o.productId = p.productId 
                JOIN stk_users u ON o.userID = u.userId
                WHERE DATE(o.added_date) BETWEEN '$startDate' AND '$endDate'
                ORDER BY o.added_date DESC";

        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }
}
