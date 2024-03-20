<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


?>

<body>
    <header>
        <div class="logo">
            <img src="../assets/images/logo.png" alt="Keniaanse Restaurant Logo" />
        </div>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../views/menu.php">Menu</a></li>
                <li><a href="../views/reserveren.php">Reserveren</a></li>
                <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION($userRole['userRole'] == "manager") || $_SESSION($userRole['userRole'] == 'director')) : ?>
                    <a href="../views/admin_dashboard.php">Admin Dashboard</a>
                <?php elseif (isset($_SESSION['isLoggedIn']) && $_SESSION($userRole['userRole'] == "employee")) : ?>
                    <a href="../views/employee-dashboard.php">Medewerker Dashboard</a>
                <?php elseif (isset($_SESSION['isLoggedIn']) && $_SESSION($userRole['userRole'] == "customer")) : ?>
                    <a href="../views/dashboard.php">Dashboard</a>
                <?php endif; ?>

                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropbtn">Account</a>
                    <div class="dropdown-content">
                        <?php if ($loggedIn) : ?>
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

</body>

</html>