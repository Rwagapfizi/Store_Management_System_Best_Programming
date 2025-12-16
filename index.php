<?php
// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define application paths
define('APP_ROOT', dirname(__FILE__));

// Include configuration
require_once 'config/database.php';
require_once 'config/constants.php';

// Simple class autoloader
spl_autoload_register(function($className) {
    $paths = [
        'controllers/' . $className . '.php',
        'models/' . $className . '.php',
        'helpers/' . $className . '.php'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Get the URL
$url = isset($_GET['url']) ? $_GET['url'] : 'home';

// Clean and sanitize the URL
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);

// If URL is empty, set to home
if (empty($url)) {
    $url = 'home';
}

$urlParts = explode('/', $url);

// Handle singular/plural: 'users' -> 'UserController'
$controllerPart = $urlParts[0];
if (substr($controllerPart, -1) === 's') {
    $controllerPart = rtrim($controllerPart, 's');
}
$controllerName = ucfirst($controllerPart) . 'Controller';
// $controllerName = ucfirst($controllerPart) . 'Controller';

$action = isset($urlParts[1]) ? $urlParts[1] : 'index';
$params = array_slice($urlParts, 2);

// Debug output
if (DEBUG_MODE) {
    echo "<!-- DEBUG: Controller: $controllerName, Action: $action -->\n";
}

// Check if controller file exists
// $controllerFile = 'controllers/' . $controllerName . '.php';
$controllerFile = 'controllers/UserController.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        
        if (method_exists($controller, $action)) {
            call_user_func_array([$controller, $action], $params);
        } else {
            // Action not found
            if (DEBUG_MODE) {
                die("Action '$action' not found in controller '$controllerName'. Available methods: " . 
                    implode(', ', get_class_methods($controller)));
            } else {
                require_once 'views/errors/404.php';
            }
        }
    } else {
        // Controller class not found
        if (DEBUG_MODE) {
            die("Controller class '$controllerName' not found in file '$controllerFile'");
        } else {
            require_once 'views/errors/500.php';
        }
    }
} else {
    // Controller file not found - create a simple fallback
    if ($controllerName === 'UserController' && !file_exists($controllerFile)) {
        // Create a temporary UserController for testing
        class UserController {
            public function index() {
                echo "<h1>Users Management</h1>";
                echo "<p>UserController is working! This is a temporary view.</p>";
                echo "<p><a href='" . BASE_URL . "'>Back to Home</a></p>";
                echo "<p>Next step: Create the real UserController with database functionality.</p>";
            }
            public function create() {
                echo "<h1>Create User</h1>";
                echo "<p>User creation form will go here.</p>";
                echo "<p><a href='" . BASE_URL . "user'>Back to Users</a></p>";
            }
        }
        
        $controller = new UserController();
        if (method_exists($controller, $action)) {
            call_user_func_array([$controller, $action], $params);
        } else {
            require_once 'views/errors/404.php';
        }
    } else {
        if (DEBUG_MODE) {
            die("Controller file not found: $controllerFile. URL was: $url");
        } else {
            require_once 'views/errors/404.php';
        }
    }
}