<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();
// Datenbankverbindung herstellen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expanses";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = $_POST['value'];
    $category = $_POST['category'];
    $date = $_POST['date'];
    $_userid = $_SESSION["UserID"];
    $description = $_POST["description"];

    // Formatting the input for MySQL database ',' to '.'
    $value = str_replace(",", ".", $value);

    $sqlAddExpense = $conn->prepare("INSERT INTO expanses (Value, Category, Date, UserID, Description) VALUES (?, ?, ?, ?, ?)");
    $sqlAddExpense->bind_param("sssis", $value, $category, $date, $_userid, $description);

    if ($sqlAddExpense->execute()) {
        echo json_encode(["message" => "Eintrag erfolgreich hinzugefügt"]);
        // http_response_code(201); // Expense added
    } else {
        echo json_encode(["message" => "Fehler beim Hinzufügen"]);
        // http_response_code(500); // Failure
    }

    $sqlAddExpense->close();
    $conn->close();
} 
else {
    echo json_encode(["message" => "Ungültige Anforderung"]);
    // http_response_code(400); // Bad Request
}
