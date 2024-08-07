<?php
// Datenbankverbindung herstellen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expanses";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

$sql = "SELECT Value, Category, Date, CreateDate, UserID, Description FROM expanses";
$result = $conn->query($sql);

$expenses = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $expenses[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($expenses);
