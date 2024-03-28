<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['isLoggedIn'] = false;
session_unset();

// Vernietig de sessie
session_destroy();

// Doorverwijzen naar de inlogpagina of een andere gewenste pagina
header("Location: ../views/inloggen.php");
exit;
