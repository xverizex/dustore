<?php
// 08.03.2025 (c) Alexander Livanov

// 26.04.2025
class Database {
    private $host = 'localhost';
    private $db_name = 'dustore';
    private $username = 'root';
    private $password = '';
    private $conn;

    // DB Connect (PDO)
    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }

    // Execute Statement
    private function executeStatement($statement = "", $parameters = [])
    {
        try {
            $stmt = $this->connect()->prepare($statement);
            $stmt->execute($parameters);
            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    // Insert Row/Rows To Database - INSERT (Create)
    public function Insert($statement = "", $parameters = [])
    {
        try {
            $this->executeStatement($statement, $parameters);
            return $this->connect()->lastInsertId();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    // Select Row/Rows From Database - SELECT (Read)
    public function Select($statement = "", $parameters = [])
    {
        try {
            $stmt = $this->executeStatement($statement, $parameters);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    // Update Row/Rows From Database - UPDATE
    public function Update($statement = "", $parameters = [])
    {
        try {
            $this->executeStatement($statement, $parameters);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    // Delete Row/Rows From Database - DELETE  
    public function Remove($statement = "", $parameters = [])
    {
        try {
            $this->executeStatement($statement, $parameters);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}

class Time {
    public function getServerTime()
    {
        return date('d.m.Y H:i', time());
    }
}