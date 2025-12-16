<?php
class Helper
{

    // Redirect to a URL
    public static function redirect($url)
    {
        header('Location: ' . BASE_URL . $url);
        exit;
    }

    // Get current URL
    public static function currentUrl()
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        return $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    // Sanitize input
    public static function sanitize($input)
    {
        if (is_array($input)) {
            return array_map('self::sanitize', $input);
        }
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }

    // Validate email
    public static function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    // Set flash message
    public static function setFlash($type, $message)
    {
        $_SESSION[$type] = $message;
    }

    // Get flash message
    public static function getFlash($type)
    {
        if (isset($_SESSION[$type])) {
            $message = $_SESSION[$type];
            unset($_SESSION[$type]);
            return $message;
        }
        return null;
    }

    // Check if user is logged in
    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    // Format date
    public static function formatDate($date, $format = DATE_FORMAT)
    {
        return date($format, strtotime($date));
    }

    // Get user IP address
    public static function getUserIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    // Generate random string
    public static function randomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    // Hash password
    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    // Verify password
    public static function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    // Convert array to options for select dropdown
    public static function arrayToOptions($array, $selected = null)
    {
        $options = '';
        foreach ($array as $value => $label) {
            $selectedAttr = ($selected == $value) ? ' selected' : '';
            $options .= "<option value=\"$value\"$selectedAttr>$label</option>";
        }
        return $options;
    }
}
