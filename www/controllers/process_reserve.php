<?php
// Start de sessie als deze nog niet is gestart
session_start();

// Controleer of het een POST-verzoek is
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclusief het databasebestand
    require_once('../database.php');

    // Haal de reserveringsgegevens op uit het formulier
    $datum = $_POST['date'];
    $tijd = $_POST['time'];
    $aantalPersonen = $_POST['people'];
    $tafelNummer = $_POST['table']; // Als je een tafelnummer hebt in het formulier, haal het op, anders kun je dit aanpassen

    // Haal de gebruiker ID op uit de sessie
    $gebruikerId = $_SESSION['userId'];

    try {
        // Bereid de SQL-query voor om een nieuwe reservering toe te voegen
        $stmt = $conn->prepare("INSERT INTO Reservering (datum, tijd, aantal_personen, tafel_nummer, gebruiker_id) VALUES (:datum, :tijd, :aantalPersonen, :tafelNummer, :gebruikerId)");
        $stmt->bindParam(':datum', $datum);
        $stmt->bindParam(':tijd', $tijd);
        $stmt->bindParam(':aantalPersonen', $aantalPersonen);
        $stmt->bindParam(':tafelNummer', $tafelNummer);
        $stmt->bindParam(':gebruikerId', $gebruikerId);
        $stmt->execute();

        // Controleer of de reservering succesvol is toegevoegd
        if ($stmt->rowCount() > 0) {
            // Als de reservering met succes is toegevoegd, stuur een succesbericht terug naar de gebruiker
            $_SESSION['message'] = "Reservering succesvol toegevoegd.";
        } else {
            // Als er een fout is opgetreden tijdens het toevoegen van de reservering, stuur een foutbericht terug
            $_SESSION['error'] = "Er is een fout opgetreden tijdens het toevoegen van de reservering. Probeer het opnieuw.";
        }
    } catch (PDOException $e) {
        // Als er een databasefout optreedt, stuur een foutbericht terug
        $_SESSION['error'] = "Databasefout: " . $e->getMessage();
    }

    // Stuur de gebruiker terug naar de pagina waar ze vandaan kwamen
    header("Location: ../views/employee_dashboard.php");
    exit();
} else {
    // Als er geen geldig POST-verzoek is ingediend, stuur de gebruiker terug naar de reserveringspagina
    header("Location: ../views/employee_dashboard.php");
    exit();
}
?>
