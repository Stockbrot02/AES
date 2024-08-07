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

$sql = "SELECT Category AS Kategorie, SUM(Value) AS Summe FROM expanses GROUP BY Category ORDER BY Value DESC";
$result = $conn->query($sql);

$totalExpenses = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $totalExpenses[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($totalExpenses);
