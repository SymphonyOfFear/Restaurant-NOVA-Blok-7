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

// Hier zou je PHP code toevoegen om gegevens op te halen uit de database, zoals menu-items, reserveringen, etc.
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medewerker Dashboard | Keniaans Restaurant</title>
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>
    <?php include '../partials/header.php'; ?>
    <div class="dashboard-wrapper">
        <aside class="sidebar">
            <ul>
                <li>
                    <button class="dropdown-btn" data-dropdown="beheer-menu">Menu Beheren</button>
                    <div id="beheer-menu" class="dropdown-content">
                        <a href="#" class="dynamic-content-button" data-content="menuOverzicht">Menu Overzicht</a>
                        <a href="#" class="dynamic-content-button" data-content="gerechtToevoegen">Gerecht Toevoegen</a>
                    </div>
                </li>
                <li>
                    <button class="dropdown-btn" data-dropdown="beheer-reserveringen">Reserveringen Beheren</button>
                    <div id="beheer-reserveringen" class="dropdown-content">
                        <a href="#" class="dynamic-content-button" data-content="reserveringenOverzicht">Reserveringen Overzicht</a>
                        <a href="#" class="dynamic-content-button" data-content="reserveringToevoegen">Reservering Toevoegen</a>
                    </div>
                </li>
                <!-- Voeg hier meer dropdowns toe zoals vereist voor andere functionaliteiten -->
            </ul>
        </aside>

        <main class="dashboard-main">
            <h1>Welkom, <?php echo htmlspecialchars($_SESSION['userName']); ?></h1>
            <div id="dashboardContent">
                <!-- Menu Overzicht -->
                <div id="menuOverzicht" class="content-section" style="display: none;">
                    <h2>Menu Overzicht</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Gerecht</th>
                                <th>Prijs</th>
                                <th>Categorie</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($menuItems as $menuItem) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($menuItem['Gerecht']) ?></td>
                                    <td><?= htmlspecialchars($menuItem['Prijs']) ?></td>
                                    <td><?= htmlspecialchars($menuItem['Categorie']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Reserveringen Overzicht -->
                <div id="reserveringenOverzicht" class="content-section" style="display: none;">
                    <h2>Reserveringen Overzicht</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Naam</th>
                                <th>Datum & Tijd</th>
                                <th>Aantal Personen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reserveringen as $reservering) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($reservering['Naam']) ?></td>
                                    <td><?= htmlspecialchars($reservering['Datum & Tijd']) ?></td>
                                    <td><?= htmlspecialchars($reservering['Aantal Personen']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Categorie Toevoegen -->
                <div id="categorieToevoegen" class="content-section" style="display: none;">
                    <h2>Categorie Toevoegen</h2>
                    <form class="form-container" action="../controllers/process-nieuwe-categorie.php" method="POST">
                        <label for="categorieNaam">Categorie Naam:</label>
                        <input type="text" id="categorieNaam" name="categorieNaam" required>
                        <button type="submit">Toevoegen</button>
                    </form>
                </div>
                <!-- Gerecht Toevoegen -->
                <div id="gerechtToevoegen" class="content-section" style="display: none;">
                    <h2>Gerecht Toevoegen</h2>
                    <form class="form-container" action="../controllers/process-nieuw-product.php" method="POST">
                        <label for="gerechtNaam">Gerecht Naam:</label>
                        <input type="text" id="gerechtNaam" name="gerechtNaam" required>

                        <label for="gerechtPrijs">Prijs:</label>
                        <input type="text" id="gerechtPrijs" name="gerechtPrijs" required>

                        <label for="gerechtCategorie">Categorie:</label>
                        <select id="gerechtCategorie" name="gerechtCategorie" required>
                            <option value="">Kies een categorie...</option>
                            <option value="voorgerecht">Voorgerecht</option>
                            <option value="hoofdgerecht">Hoofdgerecht</option>
                            <option value="nagerecht">Nagerecht</option>
                        </select>

                        <button type="submit">Toevoegen</button>
                    </form>
                </div>

                <!-- Reservering Toevoegen -->
                <div id="reserveringToevoegen" class="content-section" style="display: none;">
                    <h2>Reservering Toevoegen</h2>
                    <form class="form-container" action="verwerk_reservering_toevoegen.php" method="POST">
                        <label for="reserveringVoornaam">Voornaam:</label>
                        <input type="text" id="reserveringVoornaam" name="reserveringVoornaam" required>
                        <label for="reserveringAchternaam">Achternaam:</label>
                        <input type="text" id="reserveringAchternaam" name="reserveringAchternaam" required>

                        <label for="reserveringDatumTijd">Datum & Tijd:</label>
                        <input type="datetime-local" id="reserveringDatumTijd" name="reserveringDatumTijd" required>

                        <label for="reserveringAantalPersonen">Aantal Personen:</label>
                        <input type="number" id="reserveringAantalPersonen" name="reserveringAantalPersonen" required>

                        <button type="submit">Toevoegen</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <?php include '../partials/footer.php'; ?>
</body>



</html>