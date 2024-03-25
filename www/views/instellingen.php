<?php
// Ensure the session is started
session_start();

// Include necessary files...
require_once('../database.php'); // Adjust the path as needed

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
    <title>Instellingen | Keniaans Restaurant</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include "../partials/header.php" ?>
    <main>
        <h1>Instellingen</h1>
        <form class="form-container" action="../controllers/process-edit-gebruiker.php" method="POST">


            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Wachtwoord</label>
                <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($userData['wachtwoord']); ?>">
            </div>



            <!-- Add any additional fields that may be necessary for the user to update their settings -->

            <button type="submit" class="btn">Opslaan</button>
        </form>
    </main>
    <?php include '../partials/footer.php'; ?>
</body>

</html>