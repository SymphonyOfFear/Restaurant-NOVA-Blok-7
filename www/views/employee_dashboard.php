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

// Query om alle categorieën op te halen
$queryCategories = "SELECT * FROM Categorie";
$resultCategories = $conn->query($queryCategories);
$categories = $resultCategories->fetchAll(PDO::FETCH_ASSOC);

// Query om alle menugangen op te halen
$queryMenuGangs = "SELECT * FROM Menugang";
$resultMenuGangs = $conn->query($queryMenuGangs);
$menuGangs = $resultMenuGangs->fetchAll(PDO::FETCH_ASSOC);
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
                        <label for="gerechtNaam">Naam:</label>
                        <input type="text" id="gerechtNaam" name="gerechtNaam" required>

                        <label for="gerechtBeschrijving">Beschrijving:</label>
                        <textarea id="gerechtBeschrijving" name="gerechtBeschrijving" required></textarea>

                        <label for="gerechtInkoopprijs">Inkoopprijs:</label>
                        <input type="text" id="gerechtInkoopprijs" name="gerechtInkoopprijs" required>

                        <label for="gerechtVerkoopprijs">Verkoopprijs:</label>
                        <input type="text" id="gerechtVerkoopprijs" name="gerechtVerkoopprijs" required>

                        <label for="gerechtAfbeelding">Afbeelding uploaden:</label>
                        <input type="file" id="gerechtAfbeelding" name="gerechtAfbeelding" accept="image/*" required>

                        <label for="gerechtIsVega">Is Vega:</label>
                        <select id="gerechtIsVega" name="gerechtIsVega" required>
                            <option value="0">Nee</option>
                            <option value="1">Ja</option>
                        </select>

                        <label for="gerechtCategorie">Categorie:</label>
                        <select id="gerechtCategorie" name="gerechtCategorie" required>
                            <option value="">Kies een categorie...</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category['categorie_id'] ?>"><?= $category['naam'] ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label for="gerechtMenugang">Menugang:</label>
                        <select id="gerechtMenugang" name="gerechtMenugang" required>
                            <option value="">Kies een menugang...</option>
                            <?php foreach ($menuGangs as $menuGang) : ?>
                                <option value="<?= $menuGang['menugang_id'] ?>"><?= $menuGang['naam'] ?></option>
                            <?php endforeach; ?>
                        </select>

                        <button type="submit">Toevoegen</button>
                    </form>
                </div>

                <!-- Reservering Toevoegen -->
                <div id="reserveringToevoegen" class="content-section" style="display: none;">
                    <div class="form-container">
                        <h1>Reservering Toevoegen</h2>
                            <form action="../controllers/process_reserve.php" method="post">
                                <div class="form-group">
                                    <label for="date">Datum:</label>
                                    <input type="date" id="date" name="date" required>
                                </div>
                                <div class="form-group">
                                    <label for="time">Tijd:</label>
                                    <input type="time" id="time" name="time" required>
                                </div>
                                <div class="form-group">
                                    <label for="people">Aantal personen:</label>
                                    <input type="number" id="people" name="people" required>
                                </div>
                                <div class="form-group">
                                    <label for="table">Tafelnummer:</label>
                                    <input type="text" id="table" name="table">
                                </div>
                                <button type="submit" class="btn">Reserveer</button>
                            </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php include '../partials/footer.php'; ?>
</body>

</html>