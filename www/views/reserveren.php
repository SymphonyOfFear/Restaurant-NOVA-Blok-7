<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserveer Pagina</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<?php include '../partials/header.php'; ?>

<div class="form-container">
    <h2>Maak een Reservering</h2>
    <form action="../controllers/process_reserve.php" method="post">
        <div class="form-group">
            <label for="date">Datum:</label>
            <input type="date" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="time">Tijd:</label>
            <input type="time" id="time" name="time" required>
        </div>
        <div class="form-group">
            <label for="people">Aantal personen:</label>
            <input type="number" id="people" name="people" required>
        </div>
        <div class="form-group">
            <label for="table">Tafelnummer:</label>
            <input type="text" id="table" name="table">
        </div>
        <button type="submit" class="btn">Reserveer</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>