<?php
class UserController
{
    private $userModel;

    public function __construct()
    {
        // Include and instantiate the model
        require_once 'models/UserModel.php';
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Get all users from the model
        $users = $this->userModel->getAllUsers();

        // Set page title
        $pageTitle = 'Registered Users';

        // Load the view
        require_once 'views/users/index.php';
    }

    public function create()
    {
        $pageTitle = 'Create User';
        require_once 'views/users/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate passwords match
            if ($_POST['password'] !== $_POST['cpassword']) {
                $_SESSION['error'] = "Passwords do not match";
                header('Location: ' . BASE_URL . 'user/create');
                exit;
            }

            // Create user
            $success = $this->userModel->createUser($_POST);

            if ($success) {
                $_SESSION['success'] = "User created successfully";
                header('Location: ' . BASE_URL . 'user');
            } else {
                $_SESSION['error'] = "Failed to create user";
                header('Location: ' . BASE_URL . 'user/create');
            }
        } else {
            // If not POST, redirect to create form
            header('Location: ' . BASE_URL . 'user/create');
        }
    }

    public function edit($id)
    {
        $user = $this->userModel->getUserById($id);
        if ($user) {
            $pageTitle = 'Edit User';
            $countries = ['Rwanda', 'Kenya', 'Burundi', 'Uganda', 'Tanzania', 'DRC', 'Russia', 'Italy', 'other'];
            require_once 'views/users/edit.php';
        } else {
            require_once 'views/errors/404.php';
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate passwords match
            if ($_POST['password'] !== $_POST['cpassword']) {
                $_SESSION['error'] = "Passwords do not match";
                header('Location: ' . BASE_URL . 'user/edit/' . $id);
                exit;
            }

            $success = $this->userModel->updateUser($id, $_POST);

            if ($success) {
                $_SESSION['success'] = "User updated successfully";
                header('Location: ' . BASE_URL . 'user');
            } else {
                $_SESSION['error'] = "Failed to update user";
                header('Location: ' . BASE_URL . 'user/edit/' . $id);
            }
        } else {
            // If not POST, redirect to edit form
            header('Location: ' . BASE_URL . 'user/edit/' . $id);
        }
    }

    public function delete($id)
    {
        $success = $this->userModel->deleteUser($id);

        if ($success) {
            $_SESSION['success'] = "User deleted successfully";
        } else {
            $_SESSION['error'] = "Failed to delete user";
        }

        header('Location: ' . BASE_URL . 'user');
    }

    public function search()
    {
        $pageTitle = 'Search Users';
        require_once 'views/users/search.php';
    }

    public function searchResults()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $searchTerm = $_POST['search'];
            $users = $this->userModel->searchUsers($searchTerm);
            $pageTitle = 'Search Results';
            require_once 'views/users/search_results.php';
        } else {
            // If not POST, redirect to search form
            header('Location: ' . BASE_URL . 'user/search');
        }
    }
}
