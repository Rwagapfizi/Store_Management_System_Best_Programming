<?php
class HomeController {
    
    public function index() {
        // Set page title
        $pageTitle = 'Dashboard';
        
        // Include the view
        require_once 'views/home/index.php';
    }
}