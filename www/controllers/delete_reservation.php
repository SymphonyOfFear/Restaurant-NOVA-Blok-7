<?php
// Start de sessie als deze nog niet is gestart
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Controleer of het een POST-verzoek is
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclusief het databasebestand
    require_once('../database.php');

    // Haal de reserverings-ID op uit het formulier
    $reserveringId = $_POST['reservering_id'];

    try {
        // Bereid de SQL-query voor om een reservering te verwijderen
        $stmt = $conn->prepare("DELETE FROM Reservering WHERE reservering_id = :reserveringId");
        $stmt->bindParam(':reserveringId', $reserveringId);
        $stmt->execute();

        // Controleer of de reservering succesvol is verwijderd
        if ($stmt->rowCount() > 0) {
            // Als de reservering met succes is verwijderd, stuur een succesbericht terug naar de gebruiker
            $_SESSION['message'] = "Reservering succesvol verwijderd.";
        } else {
            // Als er geen reservering met het opgegeven ID is gevonden, stuur een foutbericht terug
            $_SESSION['error'] = "Geen reservering gevonden met het opgegeven ID.";
        }
    } catch (PDOException $e) {
        // Als er een databasefout optreedt, stuur een foutbericht terug
        $_SESSION['error'] = "Databasefout: " . $e->getMessage();
    }

    // Stuur de gebruiker terug naar de pagina waar ze vandaan kwamen
    switch ($_SESSION['userRole']) {
        case 'director':
            header('Location: ../views/admin_dashboard.php');
            break;
        case 'manager':
            header('Location: ../views/admin_dashboard.php');
            break;
        case 'employee':
            header('Location: ../views/employee_dashboard.php');
            break;
        case 'customer':
            header('Location: ../views/dashboard.php');
            break;
        default:
            header('Location: ../index.php');
            break;
    }
    exit();
} else {
    // Als er geen geldig POST-verzoek is ingediend, stuur de gebruiker terug naar de reserveringspagina
    switch ($_SESSION['userRole']) {
        case 'director':
            header('Location: ../views/admin_dashboard.php');
            break;
        case 'manager':
            header('Location: ../views/admin_dashboard.php');
            break;
        case 'employee':
            header('Location: ../views/employee_dashboard.php');
            break;
        case 'customer':
            header('Location: ../views/dashboard.php');
            break;
        default:
            header('Location: ../index.php');
            break;
    }
    exit();
}
