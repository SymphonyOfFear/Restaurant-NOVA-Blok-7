<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['isLoggedIn']) {
    switch ($_SESSION['userRole']) {
        case 'director':
            header('Location: ../views/admin_dashboard.php');
            break;
        case 'manager':
            header('Location: ../views/admin_dashboard.php');
            break;
        case 'employee':
            header('Location: ../views/employee_dashboard.php');
            break;
        case 'customer':
            header('Location: ../views/dashboard.php');
            break;
        default:
            header('Location: ../index.php');
            break;
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<?php require "../partials/header.php"; ?>



<div class="form-container">
    <h2>Inloggen</h2>
    <form action="../controllers/process-inloggen.php" method="post">
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="wachtwoord">Wachtwoord:</label>
            <input type="password" id="wachtwoord" name="wachtwoord" required>
        </div>
        <button type="submit" class="btn">Inloggen</button>
    </form>
</div>



<?php require "../partials/footer.php"; ?>