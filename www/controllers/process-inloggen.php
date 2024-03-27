<?php
session_start();
require '../database.php'; // Make sure this path is correct.
// Checken op Post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];

    // SQL Query
    $sql = "SELECT gebruiker_id, voornaam, wachtwoord, rol FROM Gebruiker WHERE email = :email";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

    if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($wachtwoord, $user['wachtwoord'])) {
                // Als wachtwoord correct is zet de variabelen vanuit de database
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['userId'] = $user['gebruiker_id'];
                $_SESSION['userName'] = $user['voornaam'];
                $_SESSION['userRole'] = $user['rol'];

                // Gebruiker met de juiste rol naar de correcte pagina sturen
                if ($user['rol'] === 'manager' || $user['rol'] === 'director') {
                    header("Location: ../views/admin_dashboard.php");
                } elseif ($user['rol'] === 'employee') {
                    header("Location: ../views/employee_dashboard.php");
                } else {
                    header("Location: ../index.php");
                }
                exit;
            } else {
                // Onjuist wachtwoord functie
                $_SESSION['login_error'] = "Het opgegeven wachtwoord is onjuist.";
                header("Location: ../views/inloggen.php");
                exit;
            }
        } else {
            // Geen E-mail adres  in de database gevonden
            $_SESSION['login_error'] = "Er bestaat geen account met dit e-mailadres.";
            header("Location: ../views/inloggen.php");
            exit;
        }
    } else {
        // SQL Errors
        $_SESSION['login_error'] = "Er is een fout opgetreden. Probeer het later opnieuw.";
        header("Location: ../views/inloggen.php");
        exit;
    }
} else {
    // Geen POST request
    header("Location: ../views/inloggen.php");
    exit;
}
