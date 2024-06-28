<?php

require 'config.php';
class usermodel{

    $this->connectionSettings = new Config();
    // $this->userModelObj = new 

    public function addUser($name, $surname){
        $sqlAddUser = "INSERT INTO users (name, surname) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sqlAddUser);
        $stmt->bind_param("ss", $name, $surname);
        return $stmt->execute();
    }

    public function selectUsers(){
        $sqlSelectUsers = "SELECT name, surname FROM users";
        $result = $this->conn->query($sqlSelectUsers);
        
        $users = array();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $users[]= $row;
            }
        }
        return $users;
    }
}
?>