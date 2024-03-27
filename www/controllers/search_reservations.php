<?php
// Start the session
session_start();

// Ensure only specific roles can access this page
if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn'] || !($_SESSION['userRole'] == 'employee' || $_SESSION['userRole'] == 'manager')) {
    header('Location: ../index.php');
    exit();
}

// Include your database connection details here
require_once '../database.php'; // Adjust the path as needed

// Initialiseren van de variabele om de waarschuwing te voorkomen als de POST variabele niet is ingesteld
$searchTermReservations = '';

// Controleer of de POST-variabele 'searchTermReservations' is ingesteld voordat we deze gebruiken
if (isset($_POST['searchTermReservations'])) {
    $searchTermReservations = trim($_POST['searchTermReservations']);
}

// Bereid een SQL-query voor om naar reserveringen te zoeken
if (!empty($searchTermReservations)) {
    $stmt = $conn->prepare("SELECT R.*, G.voornaam, G.achternaam FROM Reservering R INNER JOIN Gebruiker G ON R.gebruiker_id = G.gebruiker_id WHERE G.voornaam LIKE :searchTermReservations OR G.achternaam LIKE :searchTermReservations OR R.datum LIKE :searchTermReservations");
    $searchWithWildcard = '%' . $searchTermReservations . '%';
    $stmt->bindParam(':searchTermReservations', $searchWithWildcard, PDO::PARAM_STR); // Voeg het parameter type toe
    $stmt->execute();
    $reserveringen = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Als de zoekterm leeg is, haal alle reserveringen op
    $stmt = $conn->query("SELECT R.*, G.voornaam, G.achternaam FROM Reservering R INNER JOIN Gebruiker G ON R.gebruiker_id = G.gebruiker_id");
    $reserveringen = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoek Reserveringen | Keniaans Restaurant</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include '../partials/header.php'; ?>
    <main class="dashboard-main">
        <h1>Zoek Reserveringen</h1>
        <form class="search-form" method="POST">
            <input type="text" name="searchTermReservations" placeholder="Zoek naar reserveringen..." value="<?php echo htmlspecialchars($searchTermReservations); ?>">
            <button type="submit">Zoek</button>
        </form>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Klant</th>
                        <th>Datum</th>
                        <th>Tijd</th>
                        <th>Aantal Personen</th>
                        <th>Tafelnummer</th>
                        <th>Actie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reserveringen as $reservation) : ?>
                        <tr>
                            <td><?= htmlspecialchars($reservation['voornaam'] . ' ' . $reservation['achternaam']) ?></td>
                            <td><?= htmlspecialchars($reservation['datum']) ?></td>
                            <td><?= htmlspecialchars($reservation['tijd']) ?></td>
                            <td><?= htmlspecialchars($reservation['aantal_personen']) ?></td>
                            <td><?= htmlspecialchars($reservation['tafel_nummer']) ?></td>
                            <td class="action buttons">
                                <a href="../views/EditReservation.php?id=<?= $reservation['reservering_id']; ?>" class="wijzig-button">Wijzigen</a>
                                <form action="../controllers/delete_reservation.php" method="POST" onsubmit="return confirm('Weet je zeker dat je deze reservering wilt verwijderen?');">
                                    <input type="hidden" name="reservering_id" value="<?= $reservation['reservering_id']; ?>">
                                    <button type="submit" class="verwijder-button">Verwijderen</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($reserveringen)) : ?>
                        <tr>
                            <td colspan="6">Geen reserveringen gevonden.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
    <?php include '../partials/footer.php'; ?>
</body>

</html>