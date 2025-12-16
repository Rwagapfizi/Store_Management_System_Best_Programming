<?php
class ProductController
{
    private $productModel;

    public function __construct()
    {
        require_once 'models/ProductModel.php';
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $products = $this->productModel->getAllProducts();
        $pageTitle = 'All Products';
        require_once 'views/products/index.php';
    }

    public function create()
    {
        $pageTitle = 'Register Product';
        require_once 'views/products/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate required fields
            if (empty($_POST['product_Name']) || empty($_POST['brand']) || empty($_POST['supplier'])) {
                $_SESSION['error'] = "Product name, brand, and supplier are required";
                header('Location: ' . BASE_URL . 'product/create');
                exit;
            }

            // Get current user ID from session
            $userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;

            // Add userID to POST data
            $_POST['userID'] = $userID;

            $success = $this->productModel->createProduct($_POST);

            if ($success) {
                $_SESSION['success'] = "Product created successfully";
                header('Location: ' . BASE_URL . 'product');
            } else {
                $_SESSION['error'] = "Failed to create product";
                header('Location: ' . BASE_URL . 'product/create');
            }
        } else {
            header('Location: ' . BASE_URL . 'product/create');
        }
    }

    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            $pageTitle = 'Edit Product';
            require_once 'views/products/edit.php';
        } else {
            require_once 'views/errors/404.php';
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate required fields
            if (empty($_POST['product_Name']) || empty($_POST['brand']) || empty($_POST['supplier'])) {
                $_SESSION['error'] = "Product name, brand, and supplier are required";
                header('Location: ' . BASE_URL . 'product/edit/' . $id);
                exit;
            }

            $success = $this->productModel->updateProduct($id, $_POST);

            if ($success) {
                $_SESSION['success'] = "Product updated successfully";
                header('Location: ' . BASE_URL . 'product');
            } else {
                $_SESSION['error'] = "Failed to update product";
                header('Location: ' . BASE_URL . 'product/edit/' . $id);
            }
        } else {
            header('Location: ' . BASE_URL . 'product/edit/' . $id);
        }
    }

    public function delete($id)
    {
        // Check if product exists
        $product = $this->productModel->getProductById($id);

        if (!$product) {
            $_SESSION['error'] = "Product not found";
            header('Location: ' . BASE_URL . 'product');
            exit;
        }

        // Show confirmation page
        $pageTitle = 'Confirm Product Deletion';
        require_once 'views/products/confirm_delete.php';
    }

    public function destroy($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {

            // Check if product has related records
            $productWithRelations = $this->productModel->getProductWithRelations($id);

            if ($productWithRelations['inventory_count'] > 0 || $productWithRelations['outgoing_count'] > 0) {
                // Ask for cascade deletion confirmation
                if (isset($_POST['cascade']) && $_POST['cascade'] === 'yes') {
                    // Delete with cascade
                    $success = $this->productModel->deleteProductWithCascade($id);

                    if ($success) {
                        $_SESSION['success'] = "Product and all related inventory/outgoing records deleted successfully";
                    } else {
                        $_SESSION['error'] = "Failed to delete product with related records";
                    }
                } else {
                    $_SESSION['error'] = "Product has inventory or outgoing records. Please confirm cascade deletion.";
                    header('Location: ' . BASE_URL . 'product/delete/' . $id);
                    exit;
                }
            } else {
                // No related records, delete normally
                $success = $this->productModel->deleteProduct($id);

                if ($success) {
                    $_SESSION['success'] = "Product deleted successfully";
                } else {
                    $_SESSION['error'] = "Failed to delete product";
                }
            }
        } else {
            $_SESSION['error'] = "Deletion cancelled";
        }

        header('Location: ' . BASE_URL . 'product');
    }
}
