<?php
class OutgoingController
{
    private $outgoingModel;
    private $productModel;
    private $userModel;
    private $inventoryModel;

    public function __construct()
    {
        require_once 'models/OutgoingModel.php';
        require_once 'models/ProductModel.php';
        require_once 'models/UserModel.php';
        require_once 'models/InventoryModel.php';

        $this->outgoingModel = new OutgoingModel();
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
        $this->inventoryModel = new InventoryModel();
    }

    public function index()
    {
        $outgoingItems = $this->outgoingModel->getAllOutgoing();
        $pageTitle = 'Outgoing Products';
        require_once 'views/outgoing/index.php';
    }

    public function create()
    {
        // Get products with available inventory
        $products = $this->productModel->getProductsForDropdown();
        $productsWithStock = [];

        foreach ($products as $product) {
            $totalStock = $this->inventoryModel->getProductInventoryTotal($product['productId']);
            if ($totalStock > 0) {
                $product['available_stock'] = $totalStock;
                $productsWithStock[] = $product;
            }
        }

        $users = $this->userModel->getAllUsers();

        $pageTitle = 'Add to Outgoing';
        require_once 'views/outgoing/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate required fields
            if (empty($_POST['productID']) || empty($_POST['quantity']) || empty($_POST['userID'])) {
                $_SESSION['error'] = "Product, quantity, and user are required";
                header('Location: ' . BASE_URL . 'outgoing/create');
                exit;
            }

            // Check if quantity is positive
            if ($_POST['quantity'] <= 0) {
                $_SESSION['error'] = "Quantity must be greater than 0";
                header('Location: ' . BASE_URL . 'outgoing/create');
                exit;
            }

            // Check if enough stock is available
            $productId = $_POST['productID'];
            $quantity = $_POST['quantity'];
            $totalStock = $this->inventoryModel->getProductInventoryTotal($productId);

            if ($quantity > $totalStock) {
                $_SESSION['error'] = "Insufficient stock. Available: $totalStock, Requested: $quantity";
                header('Location: ' . BASE_URL . 'outgoing/create');
                exit;
            }

            $success = $this->outgoingModel->addToOutgoing($_POST);

            if ($success) {
                // Deduct from inventory
                $deductSuccess = $this->outgoingModel->deductFromInventory($productId, $quantity, $_POST['userID']);

                if ($deductSuccess) {
                    $_SESSION['success'] = "Product added to outgoing and inventory updated successfully";
                } else {
                    $_SESSION['warning'] = "Product added to outgoing but inventory update failed";
                }

                header('Location: ' . BASE_URL . 'outgoing');
            } else {
                $_SESSION['error'] = "Failed to add product to outgoing";
                header('Location: ' . BASE_URL . 'outgoing/create');
            }
        } else {
            header('Location: ' . BASE_URL . 'outgoing/create');
        }
    }

    public function edit($id)
    {
        $outgoingItem = $this->outgoingModel->getOutgoingById($id);

        if ($outgoingItem) {
            // Get products and users for dropdowns
            $products = $this->productModel->getProductsForDropdown();
            $users = $this->userModel->getAllUsers();

            $pageTitle = 'Edit Outgoing Product';
            require_once 'views/outgoing/edit.php';
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
                header('Location: ' . BASE_URL . 'outgoing/edit/' . $id);
                exit;
            }

            // Check if quantity is positive
            if ($_POST['quantity'] <= 0) {
                $_SESSION['error'] = "Quantity must be greater than 0";
                header('Location: ' . BASE_URL . 'outgoing/edit/' . $id);
                exit;
            }

            // Get current outgoing item to check quantity change
            $currentItem = $this->outgoingModel->getOutgoingById($id);

            if ($currentItem) {
                $quantityChange = $_POST['quantity'] - $currentItem['quantity'];

                // If increasing quantity, check stock availability
                if ($quantityChange > 0) {
                    $totalStock = $this->inventoryModel->getProductInventoryTotal($_POST['productID']);

                    if ($quantityChange > $totalStock) {
                        $_SESSION['error'] = "Insufficient stock for quantity increase. Available: $totalStock";
                        header('Location: ' . BASE_URL . 'outgoing/edit/' . $id);
                        exit;
                    }
                }
            }

            $success = $this->outgoingModel->updateOutgoing($id, $_POST);

            if ($success && isset($quantityChange) && $quantityChange != 0) {
                // Update inventory based on quantity change
                if ($quantityChange > 0) {
                    // Deduct additional quantity from inventory
                    $this->outgoingModel->deductFromInventory($_POST['productID'], $quantityChange, $_POST['userID']);
                } else {
                    // Add back reduced quantity to inventory
                    $this->outgoingModel->addToInventory($_POST['productID'], abs($quantityChange), $_POST['userID']);
                }

                $_SESSION['success'] = "Outgoing updated and inventory adjusted successfully";
            } elseif ($success) {
                $_SESSION['success'] = "Outgoing updated successfully";
            } else {
                $_SESSION['error'] = "Failed to update outgoing";
            }

            header('Location: ' . BASE_URL . 'outgoing');
        } else {
            header('Location: ' . BASE_URL . 'outgoing/edit/' . $id);
        }
    }

    public function delete($id)
    {
        $outgoingItem = $this->outgoingModel->getOutgoingById($id);

        if (!$outgoingItem) {
            $_SESSION['error'] = "Outgoing item not found";
            header('Location: ' . BASE_URL . 'outgoing');
            exit;
        }

        // Show confirmation
        $pageTitle = 'Confirm Deletion';
        require_once 'views/outgoing/confirm_delete.php';
    }

    public function destroy($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
            // Get outgoing item before deletion to restore inventory
            $outgoingItem = $this->outgoingModel->getOutgoingById($id);

            if ($outgoingItem) {
                // Restore inventory
                $restoreSuccess = $this->outgoingModel->addToInventory(
                    $outgoingItem['productId'],
                    $outgoingItem['quantity'],
                    $outgoingItem['userID']
                );

                // Delete outgoing record
                $deleteSuccess = $this->outgoingModel->deleteOutgoing($id);

                if ($deleteSuccess) {
                    if ($restoreSuccess) {
                        $_SESSION['success'] = "Outgoing deleted and inventory restored successfully";
                    } else {
                        $_SESSION['warning'] = "Outgoing deleted but inventory restoration failed";
                    }
                } else {
                    $_SESSION['error'] = "Failed to delete outgoing item";
                }
            } else {
                $_SESSION['error'] = "Outgoing item not found";
            }
        } else {
            $_SESSION['error'] = "Deletion cancelled";
        }

        header('Location: ' . BASE_URL . 'outgoing');
    }

    // Report methods
    public function report()
    {
        $outgoingReport = $this->outgoingModel->getOutgoingReport();
        $pageTitle = 'Outgoing Report';
        require_once 'views/outgoing/report.php';
    }

    public function productReport($productId = null)
    {
        if ($productId) {
            $productOutgoing = $this->outgoingModel->getOutgoingByProduct($productId);
            $product = $this->productModel->getProductById($productId);
            $pageTitle = 'Product Outgoing Report: ' . ($product['product_Name'] ?? 'Unknown');
            require_once 'views/outgoing/product_report.php';
        } else {
            header('Location: ' . BASE_URL . 'outgoing/report');
        }
    }
}
