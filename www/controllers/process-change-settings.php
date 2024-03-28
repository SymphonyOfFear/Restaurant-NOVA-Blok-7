<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../database.php'; // Adjust as necessary to point to your database connection script

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['userId'])) {
        exit('User is not logged in.');
    }

    // Extract submitted form data
    $userId = $_POST['id'];
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];
    $straatnaam = $_POST['straatnaam'];
    $woonplaats = $_POST['woonplaats'];
    $huisnummer = $_POST['huisnummer'];
    $postcode = $_POST['postcode'];
    $land = $_POST['land'];
    $nieuw_wachtwoord = $_POST['nieuw-wachtwoord'];
    $bevestig_nieuw_wachtwoord = $_POST['bevestig-nieuw-wachtwoord'];

    // Check if new password is provided and matches
    if ($nieuw_wachtwoord && $nieuw_wachtwoord === $bevestig_nieuw_wachtwoord) {
        // Hash the new password
        $hashed_password = password_hash($nieuw_wachtwoord, PASSWORD_DEFAULT);

        // Update password
        $updatePasswordQuery = "UPDATE Gebruiker SET wachtwoord = :wachtwoord WHERE gebruiker_id = :userId";
        $stmt = $conn->prepare($updatePasswordQuery);
        $stmt->execute([':wachtwoord' => $hashed_password, ':userId' => $userId]);
    } elseif ($nieuw_wachtwoord && $nieuw_wachtwoord !== $bevestig_nieuw_wachtwoord) {
        // Handle password mismatch
        $_SESSION['error'] = 'Passwords do not match.';
        header('Location: ../views/instellingen.php');
        exit;
    }

    // Update user data
    $updateQuery = "UPDATE Gebruiker SET voornaam = :voornaam, achternaam = :achternaam, email = :email, straatnaam = :straatnaam, woonplaats = :woonplaats, huisnummer = :huisnummer, postcode = :postcode, land = :land WHERE gebruiker_id = :userId";
    $stmt = $conn->prepare($updateQuery);
    $stmt->execute([
        ':voornaam' => $voornaam,
        ':achternaam' => $achternaam,
        ':email' => $email,
        ':straatnaam' => $straatnaam,
        ':woonplaats' => $woonplaats,
        ':huisnummer' => $huisnummer,
        ':postcode' => $postcode,
        ':land' => $land,
        ':userId' => $userId
    ]);

    // Check if update was successful
    if ($stmt->rowCount() > 0) {
        // Success
        $_SESSION['success'] = 'Your settings have been updated.';
    } else {
        // No changes made
        $_SESSION['error'] = 'No changes were made.';
    }

    // Redirect back to the settings page
    header('Location: ../views/instellingen.php');
} else {
    // Redirect to the settings form if the script was not accessed via POST
    header('Location: ../views/instellingen.php');
    exit;
}
