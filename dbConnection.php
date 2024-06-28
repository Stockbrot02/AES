<?php

require_once 'config.php';

class dbConnection{

    private $conn;

    public function  __construct(){
        $config = new Config();
        $this->conn = new mysqli(
            $config->getHost(),
            $config->getUsername(),
            $config->getPassword(),
            $config->getDatabase()
        );
        
        if($this->conn->connect_error){
            die("Verbindung zur Datenbank fehlgeschlagen: " . $this->conn->connect_error);
        }
    }

    public function getConnection(){
        return $this->conn;
    }
}

//Create database instance and get connction

$dbConnection = new dbConnection();
$conn = $dbConnection->getConnection();


?>