<?php

$servername = "mariadb";
$username = "root";
$password = "password";
$dbname = "restaurant_nova";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn; // Make the connection available outside
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
