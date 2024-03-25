<?php
// Start the session
session_start();

// Include database connection file
require '../database.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize input values
    $gebruiker_id = filter_input(INPUT_POST, 'gebruiker_id');
    $voornaam = filter_input(INPUT_POST, 'voornaam');
    $achternaam = filter_input(INPUT_POST, 'achternaam');
    $email = filter_input(INPUT_POST, 'email');
    $rol = filter_input(INPUT_POST, 'rol');
    $postcode = filter_input(INPUT_POST, 'postcode');
    $straatnaam = filter_input(INPUT_POST, 'straatnaam');
    $huisnummer = filter_input(INPUT_POST, 'huisnummer');
    $woonplaats = filter_input(INPUT_POST, 'woonplaats');
    $land = filter_input(INPUT_POST, 'land');

    // Optional: Hash the new password if it was provided
    $nieuw_wachtwoord = !empty($_POST['nieuw-wachtwoord']) ? password_hash($_POST['nieuw-wachtwoord'], PASSWORD_DEFAULT) : null;

    try {
        // Begin transaction
        $conn->beginTransaction();

        // Update user and address details using INNER JOIN
        $updateGebruikerSql = "UPDATE Gebruiker 
                               INNER JOIN Adres ON Gebruiker.adres_id = Adres.adres_id
                               SET Gebruiker.voornaam = :voornaam, 
                                   Gebruiker.achternaam = :achternaam, 
                                   Gebruiker.email = :email, 
                                   Gebruiker.rol = :rol, 
                                   Adres.postcode = :postcode, 
                                   Adres.straatnaam = :straatnaam, 
                                   Adres.huisnummer = :huisnummer, 
                                   Adres.woonplaats = :woonplaats, 
                                   Adres.land = :land";
                                   
        // Add conditionally updating the password
        if ($nieuw_wachtwoord) {
            $updateGebruikerSql .= ", Gebruiker.wachtwoord = :nieuw_wachtwoord";
        }
        $updateGebruikerSql .= " WHERE Gebruiker.gebruiker_id = :gebruiker_id";

        $stmt = $conn->prepare($updateGebruikerSql);
        $stmt->bindParam(':voornaam', $voornaam);
        $stmt->bindParam(':achternaam', $achternaam);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':postcode', $postcode);
        $stmt->bindParam(':straatnaam', $straatnaam);
        $stmt->bindParam(':huisnummer', $huisnummer);
        $stmt->bindParam(':woonplaats', $woonplaats);
        $stmt->bindParam(':land', $land);
        $stmt->bindParam(':gebruiker_id', $gebruiker_id);
        if ($nieuw_wachtwoord) {
            $stmt->bindParam(':nieuw_wachtwoord', $nieuw_wachtwoord);
        }
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        if ($_SESSION['userRole'] === 'manager' || $_SESSION['userRole'] === 'director') {
            header("Location: ../views/admin_dashboard.php");
        } else {
            header("Location: ../views/dashboard.php"); // Redirect to the default dashboard
        }
        exit;
     
    } catch (PDOException $e) {
        // Roll back the transaction if something failed
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
        // Handle error
    }
}
?>
