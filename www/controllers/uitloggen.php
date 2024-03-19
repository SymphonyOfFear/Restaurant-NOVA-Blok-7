<?php
session_start();

$_SESSION['isIngelogd'] = false;
session_unset();

// Vernietig de sessie
session_destroy();

// Doorverwijzen naar de inlogpagina of een andere gewenste pagina
header("Location: ../views/inloggen.php");
exit;
