<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../database.php'; // Pas het pad aan indien nodig
$searchTerm = isset($_POST['searchTerm']) ? trim($_POST['searchTerm']) : '';
if (!empty($searchTerm)) {
    // Voer de zoekopdracht uit
    $stmt = $conn->prepare("SELECT P.*, C.naam AS categorie_naam, MG.naam AS menugang_naam 
                            FROM Product P 
                            INNER JOIN Categorie C ON P.categorie_id = C.categorie_id 
                            INNER JOIN Menugang MG ON P.menugang_id = MG.menugang_id 
                            WHERE P.naam LIKE :searchTerm");
    $searchWithWildcard = '%' . $searchTerm . '%';
    $stmt->bindParam(':searchTerm', $searchWithWildcard, PDO::PARAM_STR);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoek Producten | Keniaans Restaurant</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include '../partials/header.php'; ?>
    <main class="dashboard-main">
        <h1>Zoek Producten</h1>
        <form class="search-form" method="POST">
            <input autocomplete="off" type="text" name="searchTerm" placeholder="Zoek naar producten..." value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit">Zoek</button>
        </form>

        <!-- Zoekresultaten sectie -->
        <?php if (!empty($searchTerm)) : ?>
            <div class="search-results">
                <?php if (!empty($products)) : ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Naam</th>
                                <th>Beschrijving</th>
                                <th>Verkoopprijs</th>
                                <th>Categorie</th>
                                <th>Menugang</th>
                                <th>Voorraad</th>
                                <th>Foto</th>
                                < <th>Actie</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['naam']); ?></td>
                                    <td><?php echo htmlspecialchars($product['beschrijving']); ?></td>
                                    <td>€<?php echo htmlspecialchars($product['verkoopprijs']); ?></td>
                                    <td><?php echo htmlspecialchars($product['categorie_naam']); ?></td>
                                    <td><?php echo htmlspecialchars($product['menugang_naam']); ?></td>
                                    <td><?php echo htmlspecialchars($product['voorraad']); ?></td>
                                    <td><img src="../assets/images/<?php echo htmlspecialchars($product['afbeelding']); ?>" alt="<?php echo htmlspecialchars($product['naam']); ?>"></td>

                                    <td class="action-buttons">
                                        <a href="EditProduct.php?id=<?php echo $product['product_id']; ?>" class="wijzig-button">Wijzigen</a>
                                        <form action="../controllers/delete_product.php" method="POST" onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">
                                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                            <button type="submit" class="verwijder-button">Verwijderen</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>Geen producten gevonden.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>
    <?php include '../partials/footer.php'; ?>
</body>

</html>