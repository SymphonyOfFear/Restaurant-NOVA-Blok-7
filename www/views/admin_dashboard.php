<?php
require '../database.php';
// Start the session if it has not already been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$queryMedewerkers = "SELECT Gebruiker.*, Adres.postcode, Adres.straatnaam, Adres.huisnummer, Adres.woonplaats, Adres.land FROM Gebruiker INNER JOIN Adres ON Gebruiker.adres_id = Adres.adres_id WHERE Gebruiker.rol IN ('employee', 'manager')";
$stmtMedewerkers = $conn->prepare($queryMedewerkers);
$stmtMedewerkers->execute();
$resultMedewerkers = $stmtMedewerkers->fetchAll(PDO::FETCH_ASSOC);

$queryKlanten = "SELECT Gebruiker.*, Adres.postcode, Adres.straatnaam, Adres.huisnummer, Adres.woonplaats, Adres.land FROM Gebruiker INNER JOIN Adres ON Gebruiker.adres_id = Adres.adres_id WHERE Gebruiker.rol = 'customer'";
$stmtKlanten = $conn->prepare($queryKlanten);
$stmtKlanten->execute();
$resultKlanten = $stmtKlanten->fetchAll(PDO::FETCH_ASSOC);

$queryManagers = "SELECT Gebruiker.*, Adres.postcode, Adres.straatnaam, Adres.huisnummer, Adres.woonplaats, Adres.land FROM Gebruiker INNER JOIN Adres ON Gebruiker.adres_id = Adres.adres_id WHERE Gebruiker.rol = 'manager'";
$stmtManagers = $conn->prepare($queryManagers);
$stmtManagers->execute();
$resultManagers = $stmtManagers->fetchAll(PDO::FETCH_ASSOC);

$queryReserveringen = "SELECT * FROM Reservering";
$stmtReserveringen = $conn->prepare($queryReserveringen);
$stmtReserveringen->execute();
$resultReserveringen = $stmtReserveringen->fetchAll(PDO::FETCH_ASSOC);

// Ensure only managers and directors can access this page
if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn'] || !($_SESSION['userRole'] == 'manager' || $_SESSION['userRole'] == 'director')) {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Keniaans Restaurant</title>
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>
    <?php include '../partials/header.php'; ?>
    <div class="dashboard-wrapper">
        <aside class="sidebar">
            <ul>
                <li>
                    <button class="dropdown-btn" data-dropdown="beheer-gebruikers">Beheer Gebruikers</button>
                    <div id="beheer-gebruikers" class="dropdown-content">
                        <a href="#" class="dynamic-content-button" data-content="medewerkersOverzicht">Medewerkers Overzicht</a>
                        <a href="#" class="dynamic-content-button" data-content="klantenOverzicht">Klanten Overzicht</a>
                        <?php if ($_SESSION['userRole'] == 'director') : ?>
                            <a href="#" class="dynamic-content-button" data-content="managersOverzicht">Managers Overzicht</a>
                        <?php endif; ?>
                    </div>
                </li>
                <li>
                    <button class="dropdown-btn" data-dropdown="beheer-menu">Beheer Menu</button>
                    <div id="beheer-menu" class="dropdown-content">
                        <a href="#" class="dynamic-content-button" data-content="menuOverzicht">Menu Overzicht</a>
                        <a href="#" class="dynamic-content-button" data-content="categorieToevoegen">Categorie Toevoegen</a>
                    </div>
                </li>
                <li>
                    <button class="dropdown-btn" data-dropdown="beheer-reserveringen">Beheer Reserveringen</button>
                    <div id="beheer-reserveringen" class="dropdown-content">
                        <a href="#" class="dynamic-content-button" data-content="reserveringenOverzicht">Reserveringen Overzicht</a>
                    </div>
                </li>

            </ul>
        </aside>

        <main class="dashboard-main">
            <h1>Welkom, <?php echo htmlspecialchars($_SESSION['userName']); ?></h1>
            <div id="dashboardContent">
                <!-- Placeholder for dynamic content, ensure IDs match 'data-content' attributes -->
                <div id="medewerkersOverzicht" class="dynamic-content" style="display: none;">
                    <h2>Medewerkers Overzicht</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Naam</th>
                                <th>Rol</th>
                                <th>Email</th>
                                <th>Postcode</th>
                                <th>Straatnaam</th>
                                <th>Huisnummer</th>
                                <th>Woonplaats</th>
                                <th>Land</th>
                                <th>Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($resultMedewerkers as $row) {
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['voornaam'] . " " . $row['achternaam']); ?></td>
                                    <td><?php echo htmlspecialchars($row['rol']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['postcode']); ?></td>
                                    <td><?php echo htmlspecialchars($row['straatnaam']); ?></td>
                                    <td><?php echo htmlspecialchars($row['huisnummer']); ?></td>
                                    <td><?php echo htmlspecialchars($row['woonplaats']); ?></td>
                                    <td><?php echo htmlspecialchars($row['land']); ?></td>
                                    <td><button class="verwijder-button">Verwijderen</button><button class="wijzig-button">Wijzigen</button></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div id="menuOverzicht" class="dynamic-content" style="display: none;">
                    <h2>Menu Overzicht</h2>

                </div>
                <div id="reserveringenOverzicht" class="dynamic-content" style="display: none;">
                    <h2>Reserveringen Overzicht</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Reserverings ID</th>
                                <th>Naam Klant</th>
                                <th>Datum</th>
                                <th>Tijd</th>
                                <!-- Voeg hier andere relevante kolommen toe -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultReserveringen as $reservering) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($reservering['reservering_id']); ?></td>
                                    <td><?php echo htmlspecialchars($reservering['naam_klant']); ?></td>
                                    <td><?php echo htmlspecialchars($reservering['datum']); ?></td>
                                    <td><?php echo htmlspecialchars($reservering['tijd']); ?></td>
                                    <!-- Voeg hier andere relevante kolommen toe -->
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>


                <div id="categorieToevoegen" class="dynamic-content" style="display: none;">
                    <h2>Categorie Toevoegen</h2>
                    <form class="form-container" action="../controllers/process-nieuwe-categorie.php" method="POST">
                        <label for="categorieNaam">Categorie Naam:</label>
                        <input type="text" id="categorieNaam" name="categorieNaam" required>
                        <button type="submit">Toevoegen</button>
                    </form>
                </div>

                <div id="klantenOverzicht" class="dynamic-content" style="display: none;">
                    <h2>Klanten Overzicht</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Naam</th>
                                <th>Rol</th>
                                <th>Email</th>
                                <th>Postcode</th>
                                <th>Straatnaam</th>
                                <th>Huisnummer</th>
                                <th>Woonplaats</th>
                                <th>Land</th>
                                <th>Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($resultKlanten as $row) {
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['voornaam'] . ' ' . $row['achternaam']); ?></td>
                                    <td><?php echo htmlspecialchars($row['rol']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['postcode']); ?></td>
                                    <td><?php echo htmlspecialchars($row['straatnaam']); ?></td>
                                    <td><?php echo htmlspecialchars($row['huisnummer']); ?></td>
                                    <td><?php echo htmlspecialchars($row['woonplaats']); ?></td>
                                    <td><?php echo htmlspecialchars($row['land']); ?></td>
                                    <td><button class="verwijder-button">Verwijderen</button><button class="wijzig-button">Wijzigen</button></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div id="managersOverzicht" class="dynamic-content" style="display: none;">
                    <h2>Managers Overzicht</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Naam</th>
                                <th>Rol</th>
                                <th>Email</th>
                                <th>Postcode</th>
                                <th>Straatnaam</th>
                                <th>Huisnummer</th>
                                <th>Woonplaats</th>
                                <th>Land</th>
                                <th>Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultManagers as $row) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['voornaam'] . " " . $row['achternaam']); ?></td>
                                    <td><?php echo htmlspecialchars($row['rol']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['postcode']); ?></td>
                                    <td><?php echo htmlspecialchars($row['straatnaam']); ?></td>
                                    <td><?php echo htmlspecialchars($row['huisnummer']); ?></td>
                                    <td><?php echo htmlspecialchars($row['woonplaats']); ?></td>
                                    <td><?php echo htmlspecialchars($row['land']); ?></td>
                                    <td><button class="verwijder-button">Verwijderen</button><button class="wijzig-button">Wijzigen</button></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <?php include '../partials/footer.php'; ?>
</body>

</html>