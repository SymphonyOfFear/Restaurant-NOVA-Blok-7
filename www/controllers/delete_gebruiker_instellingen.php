<?php
session_start();
require_once('../database.php'); // Adjust the path as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect user ID from form
    $userId = $_POST['gebruiker_id'] ?? null;

    // Ensure the user ID is not null and is the same as the logged-in user
    if ($userId && $userId == $_SESSION['userId']) {
        // Prepare the DELETE query
        $query = "DELETE FROM Gebruiker WHERE gebruiker_id = :userId";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            // Unset all session variables and destroy the session to log out the user
            $_SESSION = array();
            session_destroy();

            // Redirect to the homepage or login page
            header('Location: ../index.php');
            exit();
        } else {
            // Handle the error here - perhaps redirect back to the settings page with an error message
            $_SESSION['error'] = 'Er is een fout opgetreden bij het verwijderen van uw account.';
            header('Location: ../views/instellingen.php');
            exit();
        }
    } else {
        // If the user ID doesn't match or is null, handle the error
        $_SESSION['error'] = 'Ongeldige gebruikers-ID.';
        header('Location: ../views/instellingen.php');
        exit();
    }
}
