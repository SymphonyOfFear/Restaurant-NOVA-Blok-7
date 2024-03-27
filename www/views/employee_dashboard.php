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

$reserveringen = [];
if ($resultReserveringen !== false) {
    $reserveringen = $resultReserveringen->fetchAll(PDO::FETCH_ASSOC);
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


                <?php
                include "../template/addCategorie.php";
                include "../template/addcustomer.php";
                include "../template/addproductform.php";
                include "../template/addreserve.php";
                include "../template/overzichtmedewerkers.php";
                include "../template/overzichtMenu.php";
                include "../template/overzichtreserveren.php";
                ?>



            </div>
        </main>
    </div>
    <?php include '../partials/footer.php'; ?>
</body>

</html>