<?php
session_start();
// Ensure the user is logged in
if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn']) {
    header('Location: inloggen.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Keniaanse Restaurant</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include '../partials/header.php'; ?>

    <div class="dashboard-container">
        <aside class="sidebar">
            <ul>
                <li><a href="dashboard.php">Dashboard Home</a></li>
                <li><a href="manage-menu.php">Manage Menu</a></li>
                <li><a href="manage-reservations.php">Reservations</a></li>
                <li><a href="manage-orders.php">Orders</a></li>
                <!-- Additional links as needed -->
            </ul>
        </aside>

        <main class="dashboard-main">
            <h1>Welcome to Your Dashboard</h1>
            <p>Here you can manage menu items, reservations, and more.</p>
            <!-- Further dashboard content goes here -->
        </main>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>
</html>
