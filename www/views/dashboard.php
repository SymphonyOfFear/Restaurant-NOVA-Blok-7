<?php
session_start();
// Ensure the customer is logged in
if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn']) {
    header('Location: inloggen.php');
    exit();
}
$userRole = $_SESSION['userRole'] ?? '';
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

    <main class="main-content">
        <div class="container">
            <h1 class="text-center">Welkom bij Jouw Klanten Dashboard</h1>
            <div class="dashboard-actions">
                <!-- Display actions as buttons or links -->
                <a href="menu.php" class="btn">Bekijk Menu</a>
                <a href="reserveren.php" class="btn">Maak Reservering</a>
                <a href="profiel_bewerken.php" class="btn">Bewerk Profiel</a>
                <a href="bestelgeschiedenis.php" class="btn">Bestelgeschiedenis</a>
            </div>
        </div>
    </main>

    <?php include '../partials/footer.php'; ?>
</body>

</html>