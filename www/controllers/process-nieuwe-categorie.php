<?php
// Start de sessie als deze nog niet is gestart
session_start();

// Controleer of het een POST-verzoek is en of de categorieNaam is ingestuurd
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["categorieNaam"])) {
    // Inclusief het databasebestand
    require_once('../database.php');

    // Haal de categorieNaam op uit het formulier
    $categorieNaam = $_POST["categorieNaam"];

    try {
        // Bereid de SQL-query voor om een nieuwe categorie toe te voegen
        $stmt = $conn->prepare("INSERT INTO Categorie (naam) VALUES (:categorieNaam)");
        $stmt->bindParam(':categorieNaam', $categorieNaam, PDO::PARAM_STR);
        $stmt->execute();

        // Controleer of de categorie succesvol is toegevoegd
        if ($stmt->rowCount() > 0) {
            // Als de categorie met succes is toegevoegd, stuur een succesbericht terug naar de gebruiker
            $_SESSION['message'] = "Categorie succesvol toegevoegd.";
        } else {
            // Als er een fout is opgetreden tijdens het toevoegen van de categorie, stuur een foutbericht terug
            $_SESSION['error'] = "Er is een fout opgetreden tijdens het toevoegen van de categorie. Probeer het opnieuw.";
        }
    } catch (PDOException $e) {
        // Als er een databasefout optreedt, stuur een foutbericht terug
        $_SESSION['error'] = "Databasefout: " . $e->getMessage();
    }

    // Stuur de gebruiker terug naar de pagina waar ze vandaan kwamen
    header("Location: ../views/admin_dashboard.php");
    exit();
} else {
    // Als er geen geldig POST-verzoek is ingediend, stuur de gebruiker terug naar het dashboard
    header("Location: ../views/admin_dashboard.php");
    exit();
}
?>
