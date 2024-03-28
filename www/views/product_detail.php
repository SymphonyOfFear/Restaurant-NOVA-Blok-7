<?php
require '../database.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the 'id' GET parameter is set
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Prepare SQL to fetch product details
    $stmt = $conn->prepare("SELECT Product.*, Categorie.naam AS categorie_naam, Menugang.naam AS menugang_naam FROM Product
                            INNER JOIN Categorie ON Product.categorie_id = Categorie.categorie_id
                            INNER JOIN Menugang ON Product.menugang_id = Menugang.menugang_id
                            WHERE Product.product_id = ?");
    $stmt->bindParam(1, $productId, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the product
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the product exists
    if (!$product) {
        die('Product niet gevonden.');
    }
} else {
    die('Product ID niet opgegeven.');
}

?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Product Details | Keniaans Restaurant</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include '../partials/header.php'; ?>

    <div class="product-detail-container">
        <h1><?= htmlspecialchars($product['naam']) ?></h1>
        <img class="img-size" src="../assets//images/<?= htmlspecialchars($product['afbeelding']) ?>" alt="<?= htmlspecialchars($product['naam']) ?>" />
        <p><?= nl2br(htmlspecialchars($product['beschrijving'])) ?></p>
        <p>€ <?= htmlspecialchars($product['verkoopprijs']) ?></p>
        <p>Categorie: <?= htmlspecialchars($product['categorie_naam']) ?></p>
        <p>Menugang: <?= htmlspecialchars($product['menugang_naam']) ?></p>
        <p>Vegatarisch: <?= $product['is_vega'] ? 'Ja' : 'Nee' ?></p>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>

</html>