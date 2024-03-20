<?php
session_start();
require '../database.php'; // Make sure this path is correct.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];

    // SQL to fetch the user by email.
    $sql = "SELECT gebruiker_id, voornaam, wachtwoord, rol FROM gebruiker WHERE email = :email";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

    if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($wachtwoord, $user['wachtwoord'])) {
                // Password is correct, set session variables
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['userId'] = $user['gebruiker_id'];
                $_SESSION['userName'] = $user['voornaam'];
                $_SESSION['userRole'] = $user['rol'];

                // Redirect based on role
                if ($user['rol'] === 'manager' || $user['rol'] === 'director') {
                    header("Location: ../views/admin_dashboard.php"); // Path to the admin dashboard
                } elseif ($user['rol'] === 'employee') {
                    header("Location: ../views/employee_dashboard.php"); // Path to the standard user dashboard
                } else {
                    header("Location: ../views/dashboard.php");
                }
                exit;
            } else {
                // Password is not valid
                echo "Het opgegeven wachtwoord is onjuist.";
            }
        } else {
            // Email not found
            echo "Er bestaat geen account met dit e-mailadres.";
        }
    } else {
        echo "Er is een fout opgetreden. Probeer het later opnieuw.";
    }
    // No need to close the statement or connection when using PDO, as they are closed automatically when they go out of scope.
} else {
    echo "Formulier is niet correct ingediend.";
}
