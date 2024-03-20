<?php
require "../database.php"; // Assuming this file contains your database connection
include '../partials/header.php';

$sql = "SELECT Menugang.naam AS menugang_naam, Product.naam AS product_naam, Product.beschrijving AS product_beschrijving, Product.verkoopprijs AS product_prijs, Product.afbeelding AS product_afbeelding
        FROM Menugang
        INNER JOIN Product ON Menugang.menugang_id = Product.menugang_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$menugangen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Keniaans Restaurant</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <main class="container menu-page">
        <h1>Het Menu</h1>
        <div class="menu-items">
            <?php foreach ($menugangen as $menugang) : ?>
                <div class="menu-item">
                    <!-- Display the image retrieved from the database -->
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($menugang['product_afbeelding']); ?>" alt="<?php echo $menugang['product_naam']; ?>">
                    <!-- Product naam -->
                    <h3><?php echo $menugang['product_naam']; ?></h3>
                    <!-- Product beschrijving -->
                    <p><?php echo $menugang['product_beschrijving']; ?></p>
                    <!-- Product prijs -->
                    <p>Prijs: €<?php echo $menugang['product_prijs']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <?php include '../partials/footer.php'; ?>
</body>

</html>