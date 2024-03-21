<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<header>
    <div class="logo">
        <img src="../assets/images/logo.png" alt="Keniaans Restaurant Logo" />
    </div>
    <nav>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="../views/menu.php">Menu</a></li>
            <li><a href="../views/reserveren.php">Reserveren</a></li>
            <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) : ?>
                <?php if ($_SESSION['userRole'] == "manager" || $_SESSION['userRole'] == 'director') : ?>
                    <li><a href="../views/admin_dashboard.php">Admin Dashboard</a></li>
                <?php elseif ($_SESSION['userRole'] == "employee") : ?>
                    <li><a href="../views/employee_dashboard.php">Medewerker Dashboard</a></li>
                <?php elseif ($_SESSION['userRole'] == "customer") : ?>
                    <li><a href="../views/dashboard.php">Dashboard</a></li>
                <?php endif; ?>
            <?php endif; ?>

            <li id="navdrop" class="dropdown">
                <a href="javascript:void(0);" class="dropbtn">Account</a>
                <div class="dropdown-content">
                    <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) : ?>
                        <a href="../views/instellingen.php">Instellingen</a>
                        <a href="../controllers/uitloggen.php">Uitloggen</a>
                    <?php else : ?>
                        <a href="../views/inloggen.php">Inloggen</a>
                        <a href="../views/registreren.php">Registreren</a>
                    <?php endif; ?>
                </div>
            </li>
        </ul>
    </nav>
</header>