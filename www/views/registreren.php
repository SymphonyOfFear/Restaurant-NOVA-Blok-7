<?php include '../partials/header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreer Pagina</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<!-- registreren.php -->
<div class="form-container">
    <h2>Registreren</h2>
    <form action="../controllers/process-registreren.php" method="post">
        <div class="form-group">
            <label for="voornaam">Voornaam:</label>
            <input type="text" id="voornaam" name="voornaam" required>
        </div>
        <div class="form-group">
            <label for="achternaam">Achternaam:</label>
            <input type="text" id="achternaam" name="achternaam" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Wachtwoord:</label>
            <input type="password" id="wachtwoord" name="wachtwoord" required>
        </div>
        <div class="form-group">
            <label for="bevestig-wachtwoord">Bevestig Wachtwoord:</label>
            <input type="password" id="bevestig-wachtwoord" name="bevestig-wachtwoord" required>
        </div>

        <!-- Address details -->
        <div class="form-group">
            <label for="straatnaam">Straatnaam:</label>
            <input type="text" id="straatnaam" name="straatnaam" required>
        </div>
        <div class="form-group">
            <label for="woonplaats">Woonplaats:</label>
            <input type="text" id="woonplaats" name="woonplaats" required>
        </div>
        <div class="form-group">
            <label for="huisnummer">Huisnummer:</label>
            <input type="text" id="huisnummer" name="huisnummer" required>
        </div>
        <div class="form-group">
            <label for="postcode">Postcode:</label>
            <input type="text" id="postcode" name="postcode" required>
        </div>
        <div class="form-group">
            <label for="country">Land:</label>
            <input type="text" id="land" name="land" required>
        </div>

        <button type="submit" class="btn">Registreren</button>
    </form>
</div>


<?php include '../partials/footer.php'; ?>