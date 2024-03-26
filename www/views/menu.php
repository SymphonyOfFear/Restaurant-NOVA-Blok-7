<?php
require "../database.php"; // Assuming this file contains your database connection
include '../partials/header.php';

$sql = "SELECT Product.product_id, Product.naam AS product_naam, Product.afbeelding AS product_afbeelding
        FROM Product";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu | Keniaans Restaurant</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <main class="container menu-page">
        <div class="menu-items">
            <?php foreach ($products as $product) : ?>
                <div class="menu-item">
                    <a href="product_detail.php?id=<?php echo $product['product_id']; ?>">
                        <div class="menu-item-content">
                            <img src="../assets/images/<?php echo htmlspecialchars($product['product_afbeelding']); ?>" alt="<?php echo htmlspecialchars($product['product_naam']); ?>">
                            <h3><?php echo htmlspecialchars($product['product_naam']); ?></h3>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <?php include '../partials/footer.php'; ?>
</body>

</html>