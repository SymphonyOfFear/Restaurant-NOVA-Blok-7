<?php
session_start();
require '../database.php'; // Make sure this path is correct.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];

    // SQL to fetch the user by email.
    $sql = "SELECT gebruiker_id, voornaam, wachtwoord, rol FROM gebruiker WHERE email = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id, $voornaam, $hashed_wachtwoord, $rol);

                if ($stmt->fetch()) {
                    if (password_verify($wachtwoord, $hashed_wachtwoord)) {
                        // Password is correct, set session variables
                        $_SESSION['isLoggedIn'] = true;
                        $_SESSION['userId'] = $id;
                        $_SESSION['userName'] = $voornaam;
                        $_SESSION['userRole'] = $rol;

                        // Redirect based on role
                        if ($rol === 'employee' || $rol === 'manager' || $rol === 'director') {
                            header("Location: ../views/admin_dashboard.php"); // Path to the admin dashboard
                        } else {
                            header("Location: dashboard.php"); // Path to the standard user dashboard
                        }
                        exit();
                    } else {
                        // Password is not valid
                        echo "Het opgegeven wachtwoord is onjuist.";
                    }
                }
            } else {
                // Email not found
                echo "Er bestaat geen account met dit e-mailadres.";
            }
        } else {
            echo "Er is een fout opgetreden. Probeer het later opnieuw.";
        }
        $stmt->close();
    }
    $conn->close();
} else {
    echo "Formulier is niet correct ingediend.";
}
?>
