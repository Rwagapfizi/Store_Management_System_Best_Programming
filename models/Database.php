<?php
// Base Database Model
class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        // Include database config
        require_once 'config/database.php';
        $this->connection = DatabaseConfig::getConnection();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function query($sql)
    {
        return mysqli_query($this->connection, $sql);
    }

    public function escape($value)
    {
        return mysqli_real_escape_string($this->connection, $value);
    }

    public function fetchAll($result)
    {
        $rows = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public function getLastInsertId()
    {
        return mysqli_insert_id($this->connection);
    }
}
