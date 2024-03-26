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

$queryReserveringen = "
    SELECT R.*, G.voornaam, G.achternaam 
    FROM Reservering R
    INNER JOIN Gebruiker G ON R.gebruiker_id = G.gebruiker_id";
$resultReserveringen = $conn->query($queryReserveringen);

if ($resultReserveringen !== false) {
    $reserveringen = $resultReserveringen->fetchAll(PDO::FETCH_ASSOC);
} else {
    $reserveringen = [];
}

// Query om alle categorieën op te halen
$queryCategories = "SELECT * FROM Categorie";
$resultCategories = $conn->query($queryCategories);
$categories = $resultCategories->fetchAll(PDO::FETCH_ASSOC);

// Query om alle menugangen op te halen
$queryMenuGangs = "SELECT * FROM Menugang";
$resultMenuGangs = $conn->query($queryMenuGangs);
$menuGangs = $resultMenuGangs->fetchAll(PDO::FETCH_ASSOC);

$searchTerm = '';
if (isset($_POST['searchTerm'])) {
    $searchTerm = trim($_POST['searchTerm']);
}

// Modify your queries to include a WHERE clause that searches for the term
$queryMenuItems = "
    SELECT P.*, C.naam AS categorie_naam, MG.naam AS menugang_naam
    FROM Product P
    INNER JOIN Categorie C ON P.categorie_id = C.categorie_id
    INNER JOIN Menugang MG ON P.menugang_id = MG.menugang_id
    WHERE P.naam LIKE :searchTerm OR P.beschrijving LIKE :searchTerm";
$stmt = $conn->prepare($queryMenuItems);
$searchWithWildcard = '%' . $searchTerm . '%';
$stmt->bindParam(':searchTerm', $searchWithWildcard);
$stmt->execute();
$menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Query om alle medewerkers op te halen
$queryMedewerkers = "
    SELECT G.*, A.postcode, A.straatnaam, A.huisnummer, A.woonplaats, A.land
    FROM Gebruiker G
    INNER JOIN Adres A ON G.adres_id = A.adres_id
    WHERE G.rol = 'employee'";
$resultMedewerkers = $conn->query($queryMedewerkers);
$medewerkers = $resultMedewerkers->fetchAll(PDO::FETCH_ASSOC);

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
                        <a href="#" class="dynamic-content-button" data-content="gerechtToevoegen">Product Toevoegen</a>
                        <a href="#" class="dynamic-content-button" data-content="categorieToevoegen">Categorie Toevoegen</a>
                    </div>
                </li>
                <li>
                    <button class="dropdown-btn" data-dropdown="beheer-reserveringen">Reserveringen Beheren</button>
                    <div id="beheer-reserveringen" class="dropdown-content">
                        <a href="#" class="dynamic-content-button" data-content="reserveringenOverzicht">Reserveringen Overzicht</a>
                        <a href="#" class="dynamic-content-button" data-content="reserveringToevoegen">Reservering Toevoegen</a>
                    </div>
                </li>
                <li>
                    <button class="dropdown-btn" data-dropdown="beheer-klanten">Beheer Klanten</button>
                    <div id="beheer-klanten" class="dropdown-content">
                        <a href="#" class="dynamic-content-button" data-content="klantToevoegen">Klant Toevoegen</a>
                    </div>
                </li>
                <li>
                    <button class="dropdown-btn" data-dropdown="beheer-medewerkers">Beheer Medewerkers</button>
                    <div id="beheer-medewerkers" class="dropdown-content">
                        <a href="#" class="dynamic-content-button" data-content="medewerkerOverzicht">Medewerkers Overzicht</a>
                    </div>
                </li>
            </ul>
        </aside>

        <main class="dashboard-main">
            <h1>Welkom, <?php echo htmlspecialchars($_SESSION['userName']); ?></h1>
            <div id="dashboardContent">

                <div id="medewerkerOverzicht" class="dynamic-content" style="display: none;">
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($medewerkers as $row) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['voornaam'] . " " . $row['achternaam']); ?></td>
                                    <td><?php echo htmlspecialchars($row['rol']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['postcode']); ?></td>
                                    <td><?php echo htmlspecialchars($row['straatnaam']); ?></td>
                                    <td><?php echo htmlspecialchars($row['huisnummer']); ?></td>
                                    <td><?php echo htmlspecialchars($row['woonplaats']); ?></td>
                                    <td><?php echo htmlspecialchars($row['land']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div id="menuOverzicht" class="content-section" style="display: none;">
                    <h2>Menu Overzicht</h2>
                    <form class="search-form" method="POST" action="../controllers/search_results.php">
                        <input type="text" id="searchMenu" name="searchTerm" placeholder="Zoeken..." value="<?= htmlspecialchars($searchTerm) ?>">
                        <button type="submit">Zoek</button>
                    </form>

                    <table>
                        <thead>
                            <tr>
                                <th>Naam</th>
                                <th>Beschrijving</th>
                                <th>Inkoopprijs</th>
                                <th>Verkoopprijs</th>
                                <th>Afbeelding</th>
                                <th>Is Vega</th>
                                <th>Categorie</th>
                                <th>Menugang</th>
                                <th>Voorraad</th>
                                <th>Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($menuItems as $menuItem) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($menuItem['naam']) ?></td>
                                    <td><?= htmlspecialchars($menuItem['beschrijving']) ?></td>
                                    <td><?= htmlspecialchars($menuItem['inkoopprijs']) ?></td>
                                    <td><?= htmlspecialchars($menuItem['verkoopprijs']) ?></td>
                                    <td><img src="../assets/images/<?= htmlspecialchars($menuItem['afbeelding']) ?>" alt="Afbeelding" style="width: 100px; height: auto;"></td>
                                    <td><?= ($menuItem['is_vega'] == 1) ? 'Ja' : 'Nee' ?></td>
                                    <td><?= htmlspecialchars($menuItem['categorie_naam']) ?></td>
                                    <td><?= htmlspecialchars($menuItem['menugang_naam']) ?></td>
                                    <td><?= htmlspecialchars($menuItem['voorraad']) ?></td>
                                    <td>
                                        <a href="EditProduct.php?id=<?php echo $menuItem['product_id']; ?>" class="wijzig-button">Wijzigen</a>
                                        <form action="../controllers/delete_product.php" method="POST" onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">
                                            <input type="hidden" name="product_id" value="<?= $menuItem['product_id']; ?>">
                                            <button type="submit" class="verwijder-button">Verwijderen</button>
                                        </form>
                                    </td>
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
                                    <td><?= htmlspecialchars($reservering['voornaam'] . ' ' . $reservering['achternaam']) ?></td>
                                    <td><?= htmlspecialchars($reservering['Datum & Tijd']) ?></td>
                                    <td><?= htmlspecialchars($reservering['Aantal Personen']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Categorie Toevoegen -->
                <div id="categorieToevoegen" class="content-section" style="display: none;">
                    <form class="form-container" action="../controllers/process-nieuwe-categorie.php" method="POST">
                        <h2>Categorie Toevoegen</h2>
                        <label for="categorieNaam">Categorie Naam:</label>
                        <input type="text" id="categorieNaam" name="categorieNaam" required>
                        <button type="submit">Toevoegen</button>
                    </form>
                </div>
                <!-- Gerecht Toevoegen -->
                <div id="gerechtToevoegen" class="content-section" style="display: none;">

                    <form class="form-container" action="../controllers/process-nieuw-product.php" method="POST" enctype="multipart/form-data">
                        <h2>Product Toevoegen</h2>
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
                        <label for="gerechtVoorraad">Voorraad:</label>
                        <input type="number" id="gerechtVoorraad" name="gerechtVoorraad" required>
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
                <div id="klantToevoegen" class="content-section" style="display: none;">
                    <h2>Klant Toevoegen</h2>
                    <form class="form-container" action="../controllers/process-klant-toevoegen.php" method="post">
                        <div class="form-group">
                            <label for="voornaam">Voornaam:</label>
                            <input type="text" id="voornaam" name="voornaam" required>
                        </div>
                        <div class="form-group">
                            <label for="achternaam">Achternaam:</label>
                            <input type="text" id="achternaam" name="achternaam" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="wachtwoord">Wachtwoord:</label>
                            <input type="password" id="wachtwoord" name="wachtwoord" required>
                        </div>
                        <div class="form-group">
                            <label for="bevestig-wachtwoord">Bevestig Wachtwoord:</label>
                            <input type="password" id="bevestig-wachtwoord" name="bevestig-wachtwoord" required>
                        </div>

                        <!-- Adresgegevens -->
                        <div class="form-group">
                            <label for="straatnaam">Straatnaam:</label>
                            <input type="text" id="straatnaam" name="straatnaam" required>
                        </div>
                        <div class="form-group">
                            <label for="huisnummer">Huisnummer:</label>
                            <input type="text" id="huisnummer" name="huisnummer" required>
                        </div>
                        <div class="form-group">
                            <label for="postcode">Postcode:</label>
                            <input type="text" id="postcode" name="postcode" required>
                        </div>
                        <div class="form-group">
                            <label for="woonplaats">Woonplaats:</label>
                            <input type="text" id="woonplaats" name="woonplaats" required>
                        </div>
                        <div class="form-group">
                            <label for="land">Land:</label>
                            <input type="text" id="land" name="land" required>
                        </div>

                        <button type="submit" class="btn">Klant Toevoegen</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <?php include '../partials/footer.php'; ?>
</body>

</html>