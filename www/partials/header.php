<?php
session_start(); // Start the session.
$loggedIn = isset($_SESSION['isLoggedIn']) ? $_SESSION['isLoggedIn'] : false;
$userRole = isset($_SESSION['userRole']) ? $_SESSION['userRole'] : 'guest'; // Default to 'guest' if not set.
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keniaanse Restaurant</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
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
                <li class="dropdown">
    <a href="javascript:void(0);" class="dropbtn">Account</a>
    <div class="dropdown-content">
                        <?php if ($loggedIn): ?>
                            <a href="../views/settings.php">Instellingen</a>
                            <a href="../controllers/logout.php">Uitloggen</a>
                            <?php if (in_array($userRole, ['manager', 'director'])): ?>
                                <a href="../views/admin_dashboard.php">Admin Dashboard</a>
                                <?php elseif(in_array($userRole, ['employee'])):?>
                                 <a href="../views/dashboard.php">Admin Dashboard</a>
                            <?php endif; ?>
                        <?php else: ?>
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
