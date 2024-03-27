<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../database.php'; // This should set up $conn using PDO.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are present in $_POST
    $required_fields = ['voornaam', 'achternaam', 'email', 'wachtwoord', 'bevestig-wachtwoord', 'straatnaam', 'woonplaats', 'huisnummer', 'postcode', 'land'];

    foreach ($required_fields as $field) {
        if (!isset($_POST[$field])) {
            // Handle the case when a required field is missing
            $_SESSION['registration_error'] = "Required field '$field' is missing.";
            header('Location: ../views/employee_dashboard.php');
            exit;
        }
    }

    // Now you can safely access the fields
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];
    $bevestig_wachtwoord = $_POST['bevestig-wachtwoord'];
    $rol = 'customer'; // Default role for new registrations

    // Address details
    $postcode = $_POST['postcode'];
    $straatnaam = $_POST['straatnaam'];
    $huisnummer = $_POST['huisnummer'];
    $woonplaats = $_POST['woonplaats'];
    $land = $_POST['land'];

    // Check if passwords match
    if ($wachtwoord !== $bevestig_wachtwoord) {
        $_SESSION['registration_error'] = "Passwords do not match.";
        header('Location: ../views/employee_dashboard.php');
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($wachtwoord, PASSWORD_DEFAULT);

    // Start a transaction
    $conn->beginTransaction();

    try {
        // Insert the new address into the database
        $addressStmt = $conn->prepare("INSERT INTO Adres (postcode, straatnaam, huisnummer, woonplaats, land) VALUES (:postcode, :straatnaam, :huisnummer, :woonplaats, :land)");
        $addressStmt->execute([
            ':postcode' => $postcode,
            ':straatnaam' => $straatnaam,
            ':huisnummer' => $huisnummer,
            ':woonplaats' => $woonplaats,
            ':land' => $land
        ]);
        $adresId = $conn->lastInsertId(); // Get the newly created address ID

        // Prepare SQL statement for inserting the new user with the address ID
        $userStmt = $conn->prepare("INSERT INTO Gebruiker (voornaam, achternaam, rol, email, wachtwoord, adres_id) VALUES (:voornaam, :achternaam, :rol, :email, :wachtwoord, :adresId)");
        $userStmt->execute([
            ':voornaam' => $voornaam,
            ':achternaam' => $achternaam,
            ':rol' => $rol,
            ':email' => $email,
            ':wachtwoord' => $hashed_password,
            ':adresId' => $adresId
        ]);

        // Commit the transaction
        $conn->commit();

        // Redirect naar een succespagina of een andere actie ondernemen
        header('Location: ../views/employee_dashboard.php');
        exit;
    } catch (PDOException $e) {
        // If an error occurs, rollback the transaction
        $conn->rollBack();
        $_SESSION['registration_error'] = 'Error occurred during registration: ' . $e->getMessage();
        // Redirect to the registration page with an error message
        header('Location: ../views/employee_dashboard.php');
        exit;
    }
} else {
    // If the request method is not POST, redirect to the registration page
    header('Location: ../views/employee_dashboard.php');
    exit;
}
