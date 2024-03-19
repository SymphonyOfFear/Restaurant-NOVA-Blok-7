<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Restaurant</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <header>
        <div class="logo">

            <img src="/assets/images/logo.png" alt="My Restaurant Logo">
        </div>
        <nav>
            <ul>
                <li><a href="../views/index.php">Home</a></li>
                <li><a href="../views/menu.php">Menu</a></li>
                <li><a href="../views/reserveren.php">Reserveren</a></li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn" onclick="toggleDropdown('accountDropdown')">Account</a>
                    <div class="dropdown-content" id="accountDropdown">
                        <?php if (!isset($_SESSION['isIngelogd']) && $_SESSION['isIngelogd']) : ?>
                            <a href="/views/inloggen.php">Inloggen</a>
                            <a href="../views/registreren.php">Registreren</a>
                        <?php else : ?>
                            <a href="/..views/inloggen.php">Instellingen</a>
                            <a href="../views/registreren.php">Uitloggen</a>
                        <?php endif ?>
                    </div>
                </li>
                <li><a href="/views/contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>