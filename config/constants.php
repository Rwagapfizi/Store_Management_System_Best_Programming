<?php
// Only define constants if they're not already defined
if (!defined('BASE_URL')) {
    // Base URL for your application
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $script = dirname($_SERVER['SCRIPT_NAME']);
    define('BASE_URL', $protocol . $host . $script . '/');
}

if (!defined('SITE_NAME')) {
    define('SITE_NAME', 'Store Management System');
}

if (!defined('DEBUG_MODE')) {
    define('DEBUG_MODE', true);
}

// Error Reporting
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Set timezone if not set
if (!date_default_timezone_get()) {
    date_default_timezone_set('Africa/Kigali');
}