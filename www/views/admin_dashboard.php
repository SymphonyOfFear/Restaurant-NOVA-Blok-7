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

$queryReserveringen = "
    SELECT R.*, G.voornaam, G.achternaam 
    FROM Reservering R
    INNER JOIN Gebruiker G ON R.gebruiker_id = G.gebruiker_id";
$resultReserveringen = $conn->query($queryReserveringen);
$searchTerm = '';
if (isset($_POST['searchTerm'])) {
    $searchTerm = trim($_POST['searchTerm']);
}

// Modify your queries to include a WHERE clause that searches for the term
$queryMenuItems = "
    SELECT P.*, C.naam AS categorie_naam, MG.naam AS menugang_naam
    FROM Product P
    INNER JOIN Categorie C ON P.categorie_id = C.categorie_id
    INNER JOIN Menugang MG ON P.menugang_id = MG.menugang_id";

$stmt = $conn->prepare($queryMenuItems);
$stmt->execute();
$menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
$reserveringen = [];
if ($resultReserveringen !== false) {
    $reserveringen = $resultReserveringen->fetchAll(PDO::FETCH_ASSOC);
}


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
                <!-- User Management Dropdown -->
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

                <!-- Menu Management Dropdown -->
                <li>
                    <button class="dropdown-btn" data-dropdown="beheer-menu">Beheer Menu</button>
                    <div id="beheer-menu" class="dropdown-content">
                        <a href="#" class="dynamic-content-button" data-content="menuOverzicht">Menu Overzicht</a>
                        <a href="#" class="dynamic-content-button" data-content="gerechtToevoegen">Product Toevoegen</a>
                        <a href="#" class="dynamic-content-button" data-content="categorieToevoegen">Categorie Toevoegen</a>
                    </div>
                </li>

                <!-- Reservation Management Dropdown -->
                <li>
                    <button class="dropdown-btn" data-dropdown="beheer-reserveringen">Beheer Reserveringen</button>
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

                <?php
                include "../template/director-only/managerOverzicht.php";
                include "../template/manager-only/adminMedewerkerOverzicht.php";
                include "../template/manager-only/overzichtKlanten.php";
                include "../template/addCategorie.php";
                include "../template/addproductform.php";
                include "../template/addreserve.php";
                include "../template/overzichtMenu.php";
                include "../template/overzichtreserveren.php";
                ?>



            </div>
        </main>
    </div>
    <?php include '../partials/footer.php'; ?>
</body>

</html>