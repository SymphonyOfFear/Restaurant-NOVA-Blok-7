<?php
require '../database.php';

// Start de sessie als deze nog niet is gestart
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Zorg ervoor dat alleen medewerkers en managers deze pagina kunnen openen
if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn'] || !($_SESSION['userRole'] == 'employee' || $_SESSION['userRole'] == 'manager')) {
    header('Location: ../index.php');
    exit();
}

// Controleer of het formulier is verzonden
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ontvang en controleer de ingediende gegevens
    $naam = $_POST["gerechtNaam"];
    $beschrijving = $_POST["gerechtBeschrijving"];
    $inkoopprijs = $_POST["gerechtInkoopprijs"];
    $verkoopprijs = $_POST["gerechtVerkoopprijs"];
    $afbeeldingNaam = ""; // Dit wordt ingesteld nadat de afbeelding is geüpload
    $is_vega = isset($_POST["gerechtIsVega"]) ? 1 : 0; // Controleer of het gerecht vegetarisch is
    $voorraad = $_POST["gerechtVoorraad"]; // Ontvang de voorraad van het gerecht

    // Controleer of er een afbeelding is geüpload
    if (isset($_FILES['gerechtAfbeelding']) && $_FILES['gerechtAfbeelding']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../assets/images/"; // Map waar de afbeeldingen worden opgeslagen
        $targetFile = $targetDir . basename($_FILES["gerechtAfbeelding"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Controleer of het bestand een afbeelding is
        $check = getimagesize($_FILES["gerechtAfbeelding"]["tmp_name"]);
        if ($check !== false) {
            // Controleer of de bestandsnaam al bestaat, zo ja, voeg een willekeurig nummer toe om duplicaten te voorkomen
            $count = 1;
            while (file_exists($targetFile)) {
                $targetFile = $targetDir . pathinfo($_FILES["gerechtAfbeelding"]["name"], PATHINFO_FILENAME) . "_" . $count . "." . $imageFileType;
                $count++;
            }
            // Verplaats het geüploade bestand naar de juiste map op de server
            if (move_uploaded_file($_FILES["gerechtAfbeelding"]["tmp_name"], $targetFile)) {
                // Sla alleen de bestandsnaam op in de database
                $afbeeldingNaam = basename($targetFile);
            } else {
                echo "Sorry, er was een probleem bij het uploaden van je bestand.";
                exit();
            }
        } else {
            echo "Het geüploade bestand is geen afbeelding.";
            exit();
        }
    } else {
        echo "Er is geen afbeelding geüpload of er is een fout opgetreden tijdens het uploaden.";
        exit();
    }

    // Haal de categorie-id op basis van de geselecteerde categorie-naam
    $categorieNaam = $_POST['gerechtCategorie'];
    $stmt = $pdo->prepare("SELECT categorie_id FROM Categorie WHERE naam = ?");
    $stmt->execute([$categorieNaam]);
    $categorieId = $stmt->fetchColumn();

    // Voeg het nieuwe gerecht toe aan de database
    $stmt = $pdo->prepare("INSERT INTO Product (naam, beschrijving, inkoopprijs, verkoopprijs, afbeelding, is_vega, categorie_id, menugang_id, voorraad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$naam, $beschrijving, $inkoopprijs, $verkoopprijs, $afbeeldingNaam, $is_vega, $categorieId, $_POST['gerechtMenugang'], $voorraad]);

    // Stuur de gebruiker terug naar het dashboard
    header('Location: ../views/employee_dashboard.php');
    exit();
} else {
    // Als het formulier niet is verzonden, stuur de gebruiker terug naar het toevoegformulier
    header('Location: ../views/employee_dashboard.php');
    exit();
}
?>
