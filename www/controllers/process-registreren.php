<?php
session_start();
require_once '../app/config/database.php';

// Use a more comprehensive check for HTTP method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Use the built-in function for setting the response code
    include '405.php'; // Ensure this file provides meaningful information about the error
    exit;
}

// Initialize variables and perform basic validation
$voornaam = filter_input(INPUT_POST, 'voornaam', FILTER_SANITIZE_STRING);
$achternaam = filter_input(INPUT_POST, 'achternaam', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$wachtwoord = $_POST['wachtwoord'] ?? '';
$postcode = filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_STRING);
$adres = filter_input(INPUT_POST, 'straatnaam', FILTER_SANITIZE_STRING);
$huisnummer = filter_input(INPUT_POST, 'huisnummer', FILTER_SANITIZE_STRING);
$woonplaats = filter_input(INPUT_POST, 'woonplaats', FILTER_SANITIZE_STRING);
$land = filter_input(INPUT_POST, 'land', FILTER_SANITIZE_STRING);

if (empty($email) || empty($wachtwoord) || empty($voornaam) || empty($achternaam) || empty($postcode) || empty($adres) || empty($huisnummer) || empty($woonplaats) || empty($land)) {
    $_SESSION['message'] = 'Alle velden zijn vereist.';
    header("Location: ../views/registreren.php");
    exit;
}

try {
    // Start transaction
    $conn->beginTransaction();

    // Insert address details
    $stmtAdres = $conn->prepare("INSERT INTO Adres (postcode, straatnaam, huisnummer, woonplaats, land) VALUES (?, ?, ?, ?, ?)");
    $stmtAdres->execute([$postcode, $adres, $huisnummer, $woonplaats, $land]);

    // Get the last inserted address ID
    $adresId = $conn->lastInsertId();

    // Hash password
    $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

    // Insert user details with the address ID
    $stmtGebruiker = $conn->prepare("INSERT INTO Gebruiker (voornaam, achternaam, email, wachtwoord, adres_id) VALUES (?, ?, ?, ?, ?)");
    $stmtGebruiker->execute([$voornaam, $achternaam, $email, $hashedPassword, $adresId]);

    // Commit transaction
    $conn->commit();

    // Set success message and redirect
    $_SESSION['message'] = 'Registratie succesvol. U kunt nu inloggen.';
    header("Location: ../views/inloggen.php");
    exit;
} catch (PDOException $e) {
    // Rollback transaction if any error occurs
    $conn->rollback();
    error_log("Registration error: " . $e->getMessage()); // Consider logging this error
    $_SESSION['message'] = 'Er is een probleem opgetreden bij de registratie. Probeer het later opnieuw.';
    header("Location: ../views/registreren.php");
    exit;
}
