<?php
// Ensure the session is started
session_start();

// Include necessary files...
require_once('../database.php'); // Adjust the path as needed

// Assuming the user's ID is stored in the session, fetch their data
$userId = $_SESSION['userId'];
$userData = []; // Initialize the array to hold user data

// Adjust the query to include an INNER JOIN with the Adres table
$query = "SELECT Gebruiker.*, Adres.straatnaam, Adres.woonplaats, Adres.huisnummer, Adres.postcode, Adres.land 
          FROM Gebruiker 
          INNER JOIN Adres ON Gebruiker.adres_id = Adres.adres_id 
          WHERE gebruiker_id = :userId";

$stmt = $conn->prepare($query);
$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmt->execute();
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the user was found
if (!$userData) {
    die('Gebruiker niet gevonden');
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instellingen | Keniaans Restaurant</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include "../partials/header.php" ?>
    <main>
        <div class="form-container">
            <h1>Instellingen</h1>
            <form action="../controllers/process-change-settings.php" method="post">
                <input type="hidden" name="id" value="<?php echo $userId; ?>">

                <div class="form-group">
                    <label for="voornaam">Voornaam:</label>
                    <input type="text" id="voornaam" name="voornaam" required value="<?php echo htmlspecialchars($userData ['voornaam']); ?>">
                </div>

                <div class="form-group">
                    <label for="achternaam">Achternaam:</label>
                    <input type="text" id="achternaam" name="achternaam" required value="<?php echo htmlspecialchars($userData ['achternaam']); ?>">
                </div>

                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($userData ['email']); ?>">
                </div>

                <div class="form-group">
                    <label for="nieuw-wachtwoord">Nieuw Wachtwoord (optioneel):</label>
                    <input type="password" id="nieuw-wachtwoord" name="nieuw-wachtwoord">
                </div>

                <div class="form-group">
                    <label for="bevestig-nieuw-wachtwoord">Bevestig Nieuw Wachtwoord:</label>
                    <input type="password" id="bevestig-nieuw-wachtwoord" name="bevestig-nieuw-wachtwoord">
                </div>

                <!-- Address details -->
                <div class="form-group">
                    <label for="straatnaam">Straatnaam:</label>
                    <input type="text" id="straatnaam" name="straatnaam" required value="<?php echo htmlspecialchars($userData['straatnaam']); ?>">
                </div>

                <div class="form-group">
                    <label for="woonplaats">Woonplaats:</label>
                    <input type="text" id="woonplaats" name="woonplaats" required value="<?php echo htmlspecialchars($userData['woonplaats']); ?>">
                </div>

                <div class="form-group">
                    <label for="huisnummer">Huisnummer:</label>
                    <input type="text" id="huisnummer" name="huisnummer" required value="<?php echo htmlspecialchars($userData['huisnummer']); ?>">
                </div>

                <div class="form-group">
                    <label for="postcode">Postcode:</label>
                    <input type="text" id="postcode" name="postcode" required value="<?php echo htmlspecialchars($userData['postcode']); ?>">
                </div>

                <div class="form-group">
                    <label for="land">Land:</label>
                    <input type="text" id="land" name="land" required value="<?php echo htmlspecialchars($userData['land']); ?>">
                </div>

                <!-- Voeg een knop toe om wijzigingen op te slaan -->
                <button type="submit" class="btn">Opslaan</button>
            </form>

            <!-- Voeg een sectie toe voor het verwijderen van het account -->
            <div class="delete-account-section">
                <h2>Account verwijderen</h2>
                <p>Weet je zeker dat je je account wilt verwijderen? Dit kan niet ongedaan worden gemaakt.</p>
                <form action="../controllers/process-delete-account.php" method="post">
                    <button type="submit" class="delete-account-btn">Account verwijderen</button>
                </form>
            </div>
        </div>
    </main>
    <?php include '../partials/footer.php'; ?>
</body>

</html>
