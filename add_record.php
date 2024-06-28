<?php
// Erhalte den Rohinhalt der POST-Anfrage
$rawData = file_get_contents("php://input");

// Dekodiere die JSON-Daten
$data = json_decode($rawData, true);

if (is_array($data) && isset($data['firstname']) && isset($data['lastname'])) {
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];

    // Datenbankverbindung herstellen
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "expanses";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Verbindung fehlgeschlagen: " . $conn->connect_error);
    }

    // SQL-Befehl zum Einfügen der Daten
    $sql = "INSERT INTO users (name, surname) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $firstname, $lastname);

    if ($stmt->execute()) {
        echo "Datensatz erfolgreich hinzugefügt!";
    } else {
        echo "Fehler beim Hinzufügen des Datensatzes: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Fehlende Daten: Vorname oder Nachname nicht gefunden.";
}
?>

