<?php
// Ensure the session is started
session_start();

// Include necessary files...
require_once('../database.php'); // Adjust the path as needed

// Check user role and set available roles accordingly
$availableRoles = ['customer' => 'Klant']; // Default role
if ($_SESSION['userRole'] == 'manager') {
    $availableRoles['employee'] = 'Medewerker';
} elseif ($_SESSION['userRole'] == 'director') {
    $availableRoles['employee'] = 'Medewerker';
    $availableRoles['manager'] = 'Manager';
}

// Assuming the user's ID is stored in the session, fetch their data
$userId = $_SESSION['userId'];
$userData = []; // Initialize the array to hold user data

// Prepare the SQL query
$query = "SELECT * FROM Gebruiker WHERE gebruiker_id = :userId";
$stmt = $conn->prepare($query);
$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmt->execute();
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the user was found
if (!$userData) {
    // Handle the case when no user is found
    // Redirect or display an error message
    die('Gebruiker niet gevonden');
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
        <form class="form-container" action="../controllers/process-update-gebruiker.php" method="post">
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
                <label for="wachtwoord">E-mail:</label>
                <input type="password" id="wachtwoord" name="wachtwoord" required value="<?php echo htmlspecialchars($userData['wachtwoord']); ?>">
            </div>
            <div class="form-group">
                <label for="wachtwoord">E-mail:</label>
                <input type="password" id="wachtwoord" name="wachtwoord" required value="<?php echo htmlspecialchars($userData['wachtwoord']); ?>">
            </div>
            <div class="form-group">
                <label for="wachtwoord">E-mail:</label>
                <input type="password" id="wachtwoord" name="wachtwoord" required value="<?php echo htmlspecialchars($userData['wachtwoord']); ?>">
            </div>


            <!-- Role selection dropdown -->
            <div class="form-group">
                <label for="rol">Rol:</label>
                <select id="rol" name="rol" required>
                    <?php foreach ($availableRoles as $roleValue => $roleName) : ?>
                        <option value="<?php echo $roleValue; ?>" <?php echo ($userData['rol'] === $roleValue) ? 'selected' : ''; ?>>
                            <?php echo $roleName; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn">Wijzigingen Opslaan</button>
        </form>
    </div>
    <?php include '../partials/footer.php'; ?>
</body>

</html>