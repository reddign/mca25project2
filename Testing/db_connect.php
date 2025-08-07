<?php
$servername = "195.35.59.14";
$username = "u121755072_chess";
$password = "Mu4[XM@[D6&d";
$dbname = "u121755072_chessdb";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit(); // Exit if connection fails
}
?>