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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    // Extract and sanitize input
    $productId = $_POST['product_id'];
    $naam = filter_input(INPUT_POST, "gerechtNaam");
    $beschrijving = filter_input(INPUT_POST, "gerechtBeschrijving");
    $inkoopprijs = filter_input(INPUT_POST, "gerechtInkoopprijs");
    $verkoopprijs = filter_input(INPUT_POST, "gerechtVerkoopprijs");
    $is_vega = isset($_POST["gerechtIsVega"]) && $_POST["gerechtIsVega"] == '1' ? 1 : 0;
    $voorraad = filter_input(INPUT_POST, "gerechtVoorraad");
    $categorieId = filter_input(INPUT_POST, "gerechtCategorie");
    $menugangId = filter_input(INPUT_POST, "gerechtMenugang");

    // Handle file upload
    if (isset($_FILES['gerechtAfbeelding']) && $_FILES['gerechtAfbeelding']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../assets/images/";
        $imageFileType = strtolower(pathinfo($_FILES['gerechtAfbeelding']['name'], PATHINFO_EXTENSION));
        $afbeeldingNaam = uniqid('img_') . '.' . $imageFileType;
        $targetFilePath = $targetDir . $afbeeldingNaam;

        if (move_uploaded_file($_FILES['gerechtAfbeelding']['tmp_name'], $targetFilePath)) {
            // File is successfully uploaded, now prepare to update database
        } else {
            echo "Error uploading the file.";
            exit;
        }
    } else {
        // No file uploaded or an error occurred, use existing image name from database
        // You'd typically fetch this from the database first. For now, we'll use an empty string
        $afbeeldingNaam = "";
    }

    // Update the product in the database
    $sql = "UPDATE Product SET naam=?, beschrijving=?, inkoopprijs=?, verkoopprijs=?, afbeelding=?, is_vega=?, categorie_id=?, menugang_id=?, voorraad=? WHERE product_id=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt->execute([$naam, $beschrijving, $inkoopprijs, $verkoopprijs, $afbeeldingNaam, $is_vega, $categorieId, $menugangId, $voorraad, $productId])) {
        echo "Error updating product in database.";
        exit;
    }

    header('Location: ../views/employee_dashboard.php');
    exit;
} else {
    // Redirect back if not submitted via POST or if the product ID is not set
    header('Location: ../views/employee_dashboard.php');
    exit();
}
