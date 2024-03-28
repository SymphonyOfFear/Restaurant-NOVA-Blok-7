<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require "../database.php";

// Check if the reservation ID is provided in the URL
if (isset($_GET['id'])) {
    $reserveringId = $_GET['id'];

    // Prepare and execute SQL query to fetch reservation data along with user's name
    $queryReservation = "
        SELECT R.*, CONCAT(G.voornaam, ' ', G.achternaam) AS gebruiker_naam
        FROM Reservering R
        INNER JOIN Gebruiker G ON R.gebruiker_id = G.gebruiker_id
        WHERE R.reservering_id = :reserveringId";

    $stmt = $conn->prepare($queryReservation);
    $stmt->bindParam(':reserveringId', $reserveringId, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch reservation data along with user's name
    $reservationData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reservationData) {
        die('Reservering niet gevonden.');
    }
} else {
    // Redirect or show an error message if the reservation ID is not provided
    die('Reservering ID niet opgegeven.');
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservering Wijzigen | Restaurant</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include '../partials/header.php'; ?>

    <div class="form-container">
        <h2>Reservering Wijzigen</h2>
        <form class="form-container" action="../controllers/edit_reservation_process.php" method="POST">
            <input type="hidden" name="reservering_id" value="<?= htmlspecialchars($reserveringId) ?>">

            <div class="form-group">
                <label for="clientSearch">Zoek Klant:</label>
                <input autocomplete="off" type="text" id="clientSearch" onkeyup="searchClients(this.value)" placeholder="Search for clients...">
                <div id="clientSearchResults"></div>
            </div>
            <input type="hidden" id="selectedClientId" name="gebruiker_id" value="<?= htmlspecialchars($reservationData['gebruiker_id']) ?>">

            <div class="form-group">
                <label for="name">Naam:</label>
                <input readonly type="text" id="name" name="name" required value="<?= htmlspecialchars($reservationData['gebruiker_naam']) ?>">
            </div>

            <div class="form-group">
                <label for="date">Datum:</label>
                <input type="date" id="date" name="date" required value="<?= htmlspecialchars($reservationData['datum']) ?>">
            </div>

            <div class="form-group">
                <label for="time">Tijd:</label>
                <input type="time" id="time" name="time" required value="<?= htmlspecialchars($reservationData['tijd']) ?>">
            </div>

            <div class="form-group">
                <label for="people">Aantal Personen:</label>
                <input type="number" id="people" name="people" required value="<?= htmlspecialchars($reservationData['aantal_personen']) ?>">
            </div>

            <div class="form-group">
                <label for="table">Tafel Nummer:</label>
                <input type="text" id="table" name="table" required value="<?= htmlspecialchars($reservationData['tafel_nummer']) ?>">
            </div>

            <!-- Voeg hier eventueel meer velden toe voor andere reserveringsgegevens -->

            <button type="submit" class="btn">Wijzigingen Opslaan</button>
        </form>
    </div>
    <?php include '../partials/footer.php'; ?>


</body>

</html>