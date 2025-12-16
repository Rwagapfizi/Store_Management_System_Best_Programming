<?php
class ProductModel
{
    private $db;

    public function __construct()
    {
        require_once 'models/Database.php';
        $this->db = Database::getInstance();
    }

    // Get all products
    public function getAllProducts()
    {
        $sql = "SELECT p.*, u.username as added_by 
                FROM stk_products p 
                LEFT JOIN stk_users u ON p.userID = u.userId 
                ORDER BY p.productId DESC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Get product by ID
    public function getProductById($id)
    {
        $id = $this->db->escape($id);
        $sql = "SELECT p.*, u.username as added_by 
                FROM stk_products p 
                LEFT JOIN stk_users u ON p.userID = u.userId 
                WHERE p.productId = '$id'";
        $result = $this->db->query($sql);
        return mysqli_fetch_assoc($result);
    }

    // Create product
    public function createProduct($data)
    {
        $productName = $this->db->escape($data['product_Name']);
        $brand = $this->db->escape($data['brand']);
        $supplierPhone = isset($data['supplier_phone']) ? $this->db->escape($data['supplier_phone']) : '';
        $supplier = $this->db->escape($data['supplier']);
        $userID = isset($data['userID']) ? $this->db->escape($data['userID']) : 1;

        $sql = "INSERT INTO stk_products 
                (product_Name, brand, supplier_phone, supplier, userID) 
                VALUES 
                ('$productName', '$brand', '$supplierPhone', '$supplier', '$userID')";

        return $this->db->query($sql);
    }

    // Update product
    public function updateProduct($id, $data)
    {
        $id = $this->db->escape($id);
        $productName = $this->db->escape($data['product_Name']);
        $brand = $this->db->escape($data['brand']);
        $supplierPhone = isset($data['supplier_phone']) ? $this->db->escape($data['supplier_phone']) : '';
        $supplier = $this->db->escape($data['supplier']);

        $sql = "UPDATE stk_products SET 
                product_Name = '$productName',
                brand = '$brand',
                supplier_phone = '$supplierPhone',
                supplier = '$supplier'
                WHERE productId = '$id'";

        return $this->db->query($sql);
    }

    // Delete product (basic - no cascade)
    public function deleteProduct($id)
    {
        $id = $this->db->escape($id);
        $sql = "DELETE FROM stk_products WHERE productId = '$id'";
        return $this->db->query($sql);
    }

    // Delete product with cascade (deletes related inventory and outgoing)
    public function deleteProductWithCascade($id)
    {
        $id = $this->db->escape($id);

        // Start transaction
        mysqli_begin_transaction($this->db->getConnection());

        try {
            // Delete related records first
            $deleteInventory = "DELETE FROM stk_inventory WHERE productId = '$id'";
            $deleteOutgoing = "DELETE FROM stk_outgoing WHERE productId = '$id'";
            $deleteProduct = "DELETE FROM stk_products WHERE productId = '$id'";

            // Execute in order
            if (!$this->db->query($deleteInventory)) {
                throw new Exception("Failed to delete inventory records");
            }

            if (!$this->db->query($deleteOutgoing)) {
                throw new Exception("Failed to delete outgoing records");
            }

            if (!$this->db->query($deleteProduct)) {
                throw new Exception("Failed to delete product");
            }

            // Commit transaction
            mysqli_commit($this->db->getConnection());
            return true;
        } catch (Exception $e) {
            // Rollback on error
            mysqli_rollback($this->db->getConnection());
            error_log("Cascade delete error: " . $e->getMessage());
            return false;
        }
    }

    // Get product with relation counts
    public function getProductWithRelations($id)
    {
        $id = $this->db->escape($id);

        // Get product info
        $product = $this->getProductById($id);
        if (!$product) {
            return null;
        }

        // Get counts of related records
        $product['inventory_count'] = $this->countProductInventory($id);
        $product['outgoing_count'] = $this->countProductOutgoing($id);

        return $product;
    }

    private function countProductInventory($id)
    {
        $sql = "SELECT COUNT(*) as count FROM stk_inventory WHERE productId = '$id'";
        $result = $this->db->query($sql);
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }

    private function countProductOutgoing($id)
    {
        $sql = "SELECT COUNT(*) as count FROM stk_outgoing WHERE productId = '$id'";
        $result = $this->db->query($sql);
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }

    // Get products for dropdown
    public function getProductsForDropdown()
    {
        $sql = "SELECT productId, product_Name, brand FROM stk_products ORDER BY product_Name";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Search products
    public function searchProducts($searchTerm)
    {
        $searchTerm = $this->db->escape($searchTerm);
        $sql = "SELECT p.*, u.username as added_by 
                FROM stk_products p 
                LEFT JOIN stk_users u ON p.userID = u.userId 
                WHERE p.product_Name LIKE '%$searchTerm%' 
                OR p.brand LIKE '%$searchTerm%' 
                OR p.supplier LIKE '%$searchTerm%' 
                ORDER BY p.productId DESC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Add this method to ProductModel.php
    public function getProductNameById($productId)
    {
        $productId = $this->db->escape($productId);
        $sql = "SELECT product_Name, brand FROM stk_products WHERE productId = '$productId'";
        $result = $this->db->query($sql);
        $product = mysqli_fetch_assoc($result);

        if ($product) {
            return $product['product_Name'] . ' (' . $product['brand'] . ')';
        }

        return 'Unknown Product';
    }
}
