<?php
class InventoryController
{
    private $inventoryModel;
    private $productModel;
    private $userModel;

    public function __construct()
    {
        require_once 'models/InventoryModel.php';
        require_once 'models/ProductModel.php';
        require_once 'models/UserModel.php';

        $this->inventoryModel = new InventoryModel();
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $inventoryItems = $this->inventoryModel->getAllInventory();
        $pageTitle = 'Products in Inventory';
        require_once 'views/inventory/index.php';
    }

    public function create()
    {
        // Get products and users for dropdowns
        $products = $this->productModel->getProductsForDropdown();
        $users = $this->userModel->getAllUsers();

        $pageTitle = 'Add to Inventory';
        require_once 'views/inventory/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate required fields
            if (empty($_POST['productID']) || empty($_POST['quantity']) || empty($_POST['userID'])) {
                $_SESSION['error'] = "Product, quantity, and user are required";
                header('Location: ' . BASE_URL . 'inventory/create');
                exit;
            }

            // Check if quantity is positive
            if ($_POST['quantity'] <= 0) {
                $_SESSION['error'] = "Quantity must be greater than 0";
                header('Location: ' . BASE_URL . 'inventory/create');
                exit;
            }

            $success = $this->inventoryModel->addToInventory($_POST);

            if ($success) {
                $_SESSION['success'] = "Product added to inventory successfully";
                header('Location: ' . BASE_URL . 'inventory');
            } else {
                $_SESSION['error'] = "Failed to add product to inventory";
                header('Location: ' . BASE_URL . 'inventory/create');
            }
        } else {
            header('Location: ' . BASE_URL . 'inventory/create');
        }
    }

    public function edit($id)
    {
        $inventoryItem = $this->inventoryModel->getInventoryById($id);

        if ($inventoryItem) {
            // Get products and users for dropdowns
            $products = $this->productModel->getProductsForDropdown();
            $users = $this->userModel->getAllUsers();

            $pageTitle = 'Edit Product in Inventory';
            require_once 'views/inventory/edit.php';
        } else {
            require_once 'views/errors/404.php';
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate required fields
            if (empty($_POST['productID']) || empty($_POST['quantity']) || empty($_POST['userID'])) {
                $_SESSION['error'] = "Product, quantity, and user are required";
                header('Location: ' . BASE_URL . 'inventory/edit/' . $id);
                exit;
            }

            // Check if quantity is positive
            if ($_POST['quantity'] <= 0) {
                $_SESSION['error'] = "Quantity must be greater than 0";
                header('Location: ' . BASE_URL . 'inventory/edit/' . $id);
                exit;
            }

            $success = $this->inventoryModel->updateInventory($id, $_POST);

            if ($success) {
                $_SESSION['success'] = "Inventory updated successfully";
                header('Location: ' . BASE_URL . 'inventory');
            } else {
                $_SESSION['error'] = "Failed to update inventory";
                header('Location: ' . BASE_URL . 'inventory/edit/' . $id);
            }
        } else {
            header('Location: ' . BASE_URL . 'inventory/edit/' . $id);
        }
    }

    public function delete($id)
    {
        $inventoryItem = $this->inventoryModel->getInventoryById($id);

        if (!$inventoryItem) {
            $_SESSION['error'] = "Inventory item not found";
            header('Location: ' . BASE_URL . 'inventory');
            exit;
        }

        // Show confirmation
        $pageTitle = 'Confirm Deletion';
        require_once 'views/inventory/confirm_delete.php';
    }

    public function destroy($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
            $success = $this->inventoryModel->deleteInventory($id);

            if ($success) {
                $_SESSION['success'] = "Inventory item deleted successfully";
            } else {
                $_SESSION['error'] = "Failed to delete inventory item";
            }
        } else {
            $_SESSION['error'] = "Deletion cancelled";
        }

        header('Location: ' . BASE_URL . 'inventory');
    }
}
