<?php
namespace Shibaji\Core;

use PDO;
use PDOException;

class Database
{
    private $host = 'localhost';
    private $db_name = 'your_database_name';
    private $username = 'your_username';
    private $password = 'your_password';
    private $conn;

    public function __construct()
    {
        // Load config file
        $config = require 'config.php';
        $this->host = $config['database']['host'];
        $this->db_name = $config['database']['name'];
        $this->username = $config['database']['username'];
        $this->password = $config['database']['password'];
    }

    // Get the database connection
    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}