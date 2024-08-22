<?php

//Load expenses based on UserID
session_start();
$_userid = $_SESSION["UserID"];

require 'config.php';

$config = new config();

$conn = new mysqli($config->getHost(), $config->getUsername(), $config->getPassword(), $config->getDatabase());


if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

$sql = "SELECT Value, Category, Date, CreateDate, UserID, Description FROM expanses WHERE UserID = $_userid";
$result = $conn->query($sql);

$expenses = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $expenses[] = $row;
    }
}

$conn->close();

// inform client that the content is in JSON format
header('Content-Type: application/json');
// converting array into JSON
echo json_encode($expenses);
