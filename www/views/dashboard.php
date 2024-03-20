<?php
// Zorg dat de code voor sessie start bovenaan staat
session_start();
// Redirect als niet ingelogd
if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn']) {
    header('Location: inloggen.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Keniaans Restaurant</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include '../partials/header.php'; ?>

    <div class="dashboard-container">
        <aside class="sidebar">
            <ul>
                <!-- Voeg hier de links toe die relevant zijn voor de gebruiker -->
                <li><a href="beheer-reserveringen.php">Reserveringen Overzicht</a></li>
                <!-- Andere links... -->
            </ul>
        </aside>
        <main class="dashboard-main">
            <h1>Welkom bij Jouw Dashboard</h1>
            <p>Hier kun je menu-items, reserveringen en meer beheren.</p>
            <!-- Content voor de gebruiker -->
        </main>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>

</html>