<?php
// Start the session
if (
    session_status() == PHP_SESSION_NONE
) {
    session_start();
}

// Include necessary files
require('../database.php'); // Make sure the path to your database file is correct

// Check user role and set available roles accordingly
$availableRoles = ['customer' => 'Klant']; // Default role for simplicity
if ($_SESSION['userRole'] == 'manager' || $_SESSION['userRole'] == 'director') {
    $availableRoles += ['employee' => 'Medewerker', 'manager' => 'Manager'];
}

// Fetch the user's ID passed as a query parameter for editing
$userId = isset($_GET['id']) ? $_GET['id'] : null;

if (!$userId) {
    die('Geen gebruiker ID meegegeven.');
}

// Prepare and execute the SQL query
$query = "SELECT Gebruiker.*, Adres.straatnaam, Adres.woonplaats, Adres.huisnummer, Adres.postcode, Adres.land 
          FROM Gebruiker 
          INNER JOIN Adres ON Gebruiker.adres_id = Adres.adres_id 
          WHERE Gebruiker.gebruiker_id = :userId";

$stmt = $conn->prepare($query);
$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmt->execute();

// Fetch the user data
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
    die('Gebruiker niet gevonden.');
}

?>


<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wijzig Gebruiker | Keniaans Restaurant</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include '../partials/header.php'; ?>
    <div class="form-container">
        <h2>Gebruiker Instellingen</h2>
        <form class="form-container" action="../controllers/process-edit-gebruiker.php" method="post">
            <input type="hidden" name="gebruiker_id" value="<?php echo htmlspecialchars($userId); ?>">

            <div class="form-group">
                <label for="voornaam">Voornaam:</label>
                <input type="text" id="voornaam" name="voornaam" required value="<?php echo htmlspecialchars($userData['voornaam']); ?>">
            </div>

            <div class="form-group">
                <label for="achternaam">Achternaam:</label>
                <input type="text" id="achternaam" name="achternaam" required value="<?php echo htmlspecialchars($userData['achternaam']); ?>">
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($userData['email']); ?>">
            </div>

            <div class="form-group">
                <label for="nieuw-wachtwoord">Nieuw Wachtwoord (indien wijziging):</label>
                <input type="password" id="nieuw-wachtwoord" name="nieuw-wachtwoord">
            </div>

            <div class="form-group">
                <label for="bevestig-nieuw-wachtwoord">Bevestig Nieuw Wachtwoord:</label>
                <input type="password" id="bevestig-nieuw-wachtwoord" name="bevestig-nieuw-wachtwoord">
            </div>

            <!-- Role selection dropdown -->
            <div class="form-group">
                <label for="rol">Rol:</label>
                <select id="rol" name="rol" required>
                    <?php foreach ($availableRoles as $roleValue => $roleName) : ?>
                        <option value="<?php echo $roleValue; ?>" <?php echo ($userData['rol'] == $roleValue) ? 'selected' : ''; ?>>
                            <?php echo $roleName; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="postcode">Postcode:</label>
                <input type="text" id="postcode" name="postcode" required value="<?php echo htmlspecialchars($userData['postcode']); ?>">
            </div>

            <div class="form-group">
                <label for="straatnaam">Straatnaam:</label>
                <input type="text" id="straatnaam" name="straatnaam" required value="<?php echo htmlspecialchars($userData['straatnaam']); ?>">
            </div>

            <div class="form-group">
                <label for="huisnummer">Huisnummer:</label>
                <input type="text" id="huisnummer" name="huisnummer" required value="<?php echo htmlspecialchars($userData['huisnummer']); ?>">
            </div>

            <div class="form-group">
                <label for="woonplaats">Woonplaats:</label>
                <input type="text" id="woonplaats" name="woonplaats" required value="<?php echo htmlspecialchars($userData['woonplaats']); ?>">
            </div>

            <div class="form-group">
                <label for="land">Land:</label>
                <input type="text" id="land" name="land" required value="<?php echo htmlspecialchars($userData['land']); ?>">
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn">Wijzigingen Opslaan</button>
        </form>
    </div>
    <?php include '../partials/footer.php'; ?>
</body>

</html>