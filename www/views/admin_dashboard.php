<?php

// Start the session if it has not already been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
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
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropbtn">Beheer Gebruikers</a>
                    <div class="dropdown-content">
                        <a href="#">Medewerkers Overzicht</a>
                        <a href="#">Klanten Overzicht</a>
                        <?php if ($_SESSION['userRole'] == 'director') : ?>
                            <a href="#">Managers Overzicht</a>
                        <?php endif; ?>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropbtn">Beheer Menu</a>
                    <div class="dropdown-content">
                        <a href="#">Menu Overzicht</a>
                        <a href="#">Categorie Toevoegen</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropbtn">Beheer Reserveringen</a>
                    <div class="dropdown-content">
                        <a href="#">Reserveringen Overzicht</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropbtn">Beheer Rapportages</a>
                    <div class="dropdown-content">
                        <a href="rapportages.php">Rapportages Overzicht</a>
                    </div>
                </li>
            </ul>
        </aside>
        <main class="dashboard-main">
            <h1>Welkom, <?php echo htmlspecialchars($_SESSION['userName']); ?></h1>
            <!-- Additional dashboard content here -->
        </main>
    </div>
    <?php include '../partials/footer.php'; ?>
</body>

</html>