<?php
ini_set('display_errors', 1);

$servername = "db-mysql-fra1-44104-do-user-15108968-0.c.db.ondigitalocean.com";
$username = "doadmin";
$password = "AVNS_2Vp9yj6KmNnnAWE3STE";
$dbname = "defaultdb";
$port = "25060";

$options = array(
    PDO::ATTR_PERSISTENT => true,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);

$dsn = 'mysql:host=' . $servername . ';port=' . $port . ';dbname=' . $dbname;

try {
    $dbh = new PDO($dsn, $username, $password, $options);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (isset($_POST["submit"])) {
    // Use $dbh consistently for database connection
    $stmt = $dbh->prepare("SELECT * FROM accounts WHERE username = :user");
    $stmt->bindParam(":user", $_POST["username"]);
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count == 1) {
        $row = $stmt->fetch();
        if (password_verify($_POST["pw"], $row["password"])) {
            session_start();
            $_SESSION["username"] = $row["username"];
            header("Location: geheim.php");
            exit; // Don't forget to exit after header redirection
        } else {
            echo "Der Login ist fehlgeschlagen";
        }
    } else {
        echo "Der Login ist fehlgeschlagen";
    }
}
function getDB() {
    global $dbh; // Verwende die globale PDO-Verbindung

    // Überprüfe, ob die Verbindung vorhanden ist
    if ($dbh instanceof PDO) {
        return $dbh; // Gib die bestehende Verbindung zurück
    } else {
        // Handle den Fall, wenn die Verbindung nicht existiert
        // Hier könntest du eine neue Verbindung aufbauen oder eine Fehlerbehandlung durchführen
        return null;
    }
}
?>
