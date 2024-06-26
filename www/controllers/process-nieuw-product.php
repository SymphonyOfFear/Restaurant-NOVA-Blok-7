<?php
require '../database.php';

// Ensure the session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ensure only specific roles can access this page
if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn'] || !($_SESSION['userRole'] == 'employee' || $_SESSION['userRole'] == 'manager')) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize input
    $naam = filter_input(INPUT_POST, "gerechtNaam");
    $beschrijving = filter_input(INPUT_POST, "gerechtBeschrijving");
    $inkoopprijs = filter_input(INPUT_POST, "gerechtInkoopprijs");
    $verkoopprijs = filter_input(INPUT_POST, "gerechtVerkoopprijs");
    $is_vega = isset($_POST["gerechtIsVega"]) && $_POST["gerechtIsVega"] == '1' ? 1 : 0;
    $voorraad = filter_input(INPUT_POST, "gerechtVoorraad");
    $categorieId = filter_input(INPUT_POST, "gerechtCategorie");
    $menugangId = filter_input(INPUT_POST, "gerechtMenugang");

    // Default image name
    $afbeeldingNaam = "default.jpg";

    if (isset($_FILES['gerechtAfbeelding']) && $_FILES['gerechtAfbeelding']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../assets/images/"; // Ensure this path is correct and writable
        $imageFileType = strtolower(pathinfo($_FILES['gerechtAfbeelding']['name'], PATHINFO_EXTENSION));
        $afbeeldingNaam = uniqid('img_') . '.' . $imageFileType;
        $targetFilePath = $targetDir . $afbeeldingNaam;

        if (move_uploaded_file($_FILES['gerechtAfbeelding']['tmp_name'], $targetFilePath)) {
            // File is successfully uploaded
        } else {
            echo "Error uploading the file.";
            exit;
        }
    }

    // Insert into database
    $sql = "INSERT INTO Product (naam, beschrijving, inkoopprijs, verkoopprijs, afbeelding, is_vega, categorie_id, menugang_id, voorraad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt->execute([$naam, $beschrijving, $inkoopprijs, $verkoopprijs, $afbeeldingNaam, $is_vega, $categorieId, $menugangId, $voorraad])) {
        echo "Error saving product to database.";
        exit;
    }

    header('Location: ../views/employee_dashboard.php');
    exit;
} else {
    // Redirect back if not submitted via POST
    header('Location: ../views/employee_dashboard.php');
    exit();
}
