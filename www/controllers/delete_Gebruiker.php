<?php
require '../database.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Controleer of het een POST-verzoek is en of de gebruiker_id is ingesteld
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['gebruiker_id'])) {
    $gebruiker_id = $_POST['gebruiker_id'];

    // Extra beveiligingscontroles kunnen hier worden toegevoegd (bijv. rolcontrole)

    try {
        $stmt = $conn->prepare("DELETE Gebruiker, Adres FROM Gebruiker INNER JOIN Adres ON Gebruiker.adres_id = Adres.adres_id WHERE Gebruiker.gebruiker_id = :gebruiker_id");
        $stmt->bindParam(':gebruiker_id', $gebruiker_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['message'] = "Gebruiker verwijderd.";
        } else {
            $_SESSION['error'] = "Kan gebruiker niet verwijderen.";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Fout bij het verwijderen: " . $e->getMessage();
    }

    // Redirect naar het admin-dashboard na de verwijderingsactie
    header("Location: ../views/admin_dashboard.php");
    exit();
} else {
    // Als de gebruiker rechtstreeks toegang probeert te krijgen tot dit bestand zonder POST-gegevens
    $_SESSION['error'] = "Ongeldige aanvraag.";
    header("Location: ../views/admin_dashboard.php");
    exit();
}
