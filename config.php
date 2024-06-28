<?php

//Create database connection
class config {

    protected $host;
    protected $username;
    protected $password;
    protected $database;

    public function __construct(){
        $this->host = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->database = "expanses";
    }

    public function getHost() {
        return $this->host;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getDatabase() {
        return $this->database;
    }

}

?>