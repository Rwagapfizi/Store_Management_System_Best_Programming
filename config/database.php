<?php
// Database configuration
class DatabaseConfig
{
    const HOST = 'localhost';
    const USER = 'root';
    const PASSWORD = '12345';
    const DATABASE = 'wd_final_exam';
    const CHARSET = 'utf8mb4';
    
    public static function getConnection()
    {
        $conn = mysqli_connect(
            self::HOST,
            self::USER,
            self::PASSWORD,
            self::DATABASE
        );
        
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        mysqli_set_charset($conn, self::CHARSET);
        return $conn;
    }
}