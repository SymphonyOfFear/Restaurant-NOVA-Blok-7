<?php
// Start the session
session_start();

// Include necessary files
require('../database.php'); // Make sure the path to your database file is correct

// Check if the product ID is passed as a query parameter for editing
$productId = isset($_GET['id']) ? $_GET['id'] : null;

if (!$productId) {
    die('Geen product ID meegegeven.');
}

// Prepare and execute the SQL query to fetch product details
$queryProduct = "
    SELECT P.*, C.naam AS categorie_naam, MG.naam AS menugang_naam
    FROM Product P
    INNER JOIN Categorie C ON P.categorie_id = C.categorie_id
    INNER JOIN Menugang MG ON P.menugang_id = MG.menugang_id
    WHERE P.product_id = :productId";

$stmt = $conn->prepare($queryProduct);
$stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
$stmt->execute();

// Fetch the product data
$productData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$productData) {
    die('Product niet gevonden.');
}

// Get categories and menugang options for the dropdowns
$categories = $conn->query("SELECT * FROM Categorie")->fetchAll(PDO::FETCH_ASSOC);
$menuGangs = $conn->query("SELECT * FROM Menugang")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wijzig Gerecht | Keniaans Restaurant</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include '../partials/header.php'; ?>

    <div class="form-container">
        <h2>Gerecht Wijzigen</h2>
        <form class="form-container" action="../controllers/process-wijzig-product.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($productId) ?>">

            <div class="form-group">
                <label for="gerechtNaam">Naam:</label>
                <input type="text" id="gerechtNaam" name="gerechtNaam" required value="<?= htmlspecialchars($productData['naam']) ?>">
            </div>

            <div class="form-group">
                <label for="gerechtBeschrijving">Beschrijving:</label>
                <textarea id="gerechtBeschrijving" name="gerechtBeschrijving" required><?= htmlspecialchars($productData['beschrijving']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="gerechtInkoopprijs">Inkoopprijs:</label>
                <input type="text" id="gerechtInkoopprijs" name="gerechtInkoopprijs" required value="<?= htmlspecialchars($productData['inkoopprijs']) ?>">
            </div>

            <div class="form-group">
                <label for="gerechtVerkoopprijs">Verkoopprijs:</label>
                <input type="text" id="gerechtVerkoopprijs" name="gerechtVerkoopprijs" required value="<?= htmlspecialchars($productData['verkoopprijs']) ?>">
            </div>

            <div class="form-group">
                <label for="gerechtAfbeelding">Huidige Afbeelding:</label>
                <!-- Show current image here -->
                <img src="../assets/images/<?= htmlspecialchars($productData['afbeelding']) ?>" alt="<?= htmlspecialchars($productData['naam']) ?>">
                <label for="gerechtAfbeelding">Afbeelding Wijzigen:</label>
                <input type="file" id="gerechtAfbeelding" name="gerechtAfbeelding" accept="image/*">
            </div>

            <div class="form-group">
                <label for="gerechtIsVega">Is Vega:</label>
                <select id="gerechtIsVega" name="gerechtIsVega" required>
                    <option value="0" <?= $productData['is_vega'] == 0 ? 'selected' : '' ?>>Nee</option>
                    <option value="1" <?= $productData['is_vega'] == 1 ? 'selected' : '' ?>>Ja</option>
                </select>
            </div>

            <div class="form-group">
                <label for="gerechtCategorie">Categorie:</label>
                <select id="gerechtCategorie" name="gerechtCategorie" required>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['categorie_id'] ?>" <?= $productData['categorie_id'] == $category['categorie_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['naam']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="gerechtMenugang">Menugang:</label>
                <select id="gerechtMenugang" name="gerechtMenugang" required>
                    <?php foreach ($menuGangs as $menuGang) : ?>
                        <option value="<?= $menuGang['menugang_id'] ?>" <?= $productData['menugang_id'] == $menuGang['menugang_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($menuGang['naam']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="gerechtVoorraad">Voorraad:</label>
                <input type="number" id="gerechtVoorraad" name="gerechtVoorraad" required value="<?= htmlspecialchars($productData['voorraad']) ?>">
            </div>

            <button type="submit" class="btn">Wijzigingen Opslaan</button>
        </form>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>

</html>