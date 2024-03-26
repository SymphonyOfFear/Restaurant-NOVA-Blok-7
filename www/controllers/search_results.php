<?php
require '../database.php';
session_start();

// Ensure only specific roles can access this page
if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn'] || !($_SESSION['userRole'] == 'employee' || $_SESSION['userRole'] == 'manager')) {
    header('Location: ../index.php');
    exit();
}

$searchTerm = '';
if (isset($_POST['searchTerm'])) {
    $searchTerm = trim($_POST['searchTerm']);
}

// Query to search for menu items with the search term
$queryMenuItems = "
    SELECT P.*, C.naam AS categorie_naam, MG.naam AS menugang_naam
    FROM Product P
    INNER JOIN Categorie C ON P.categorie_id = C.categorie_id
    INNER JOIN Menugang MG ON P.menugang_id = MG.menugang_id
    WHERE P.naam LIKE :searchTerm OR P.beschrijving LIKE :searchTerm";
$stmt = $conn->prepare($queryMenuItems);
$searchWithWildcard = '%' . $searchTerm . '%';
$stmt->bindParam(':searchTerm', $searchWithWildcard);
$stmt->execute();
$menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoekresultaten | Keniaans Restaurant</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include '../partials/header.php'; ?>
    <main class="dashboard-main">
        <h1>Zoekresultaten</h1>
        <table>
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Beschrijving</th>
                    <th>Inkoopprijs</th>
                    <th>Verkoopprijs</th>
                    <th>Afbeelding</th>
                    <th>Is Vega</th>
                    <th>Categorie</th>
                    <th>Menugang</th>
                    <th>Voorraad</th>
                    <th>Actie</th> <!-- Added missing table header for actions -->
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($menuItems)) : ?>
                    <?php foreach ($menuItems as $menuItem) : ?>
                        <tr>
                            <td><?= htmlspecialchars($menuItem['naam']) ?></td>
                            <td><?= htmlspecialchars($menuItem['beschrijving']) ?></td>
                            <td><?= htmlspecialchars($menuItem['inkoopprijs']) ?></td>
                            <td><?= htmlspecialchars($menuItem['verkoopprijs']) ?></td>
                            <td><img src="../assets/images/<?= htmlspecialchars($menuItem['afbeelding']) ?>" alt="Afbeelding"></td>
                            <td><?= ($menuItem['is_vega'] == 1) ? 'Ja' : 'Nee' ?></td>
                            <td><?= htmlspecialchars($menuItem['categorie_naam']) ?></td>
                            <td><?= htmlspecialchars($menuItem['menugang_naam']) ?></td>
                            <td><?= htmlspecialchars($menuItem['voorraad']) ?></td>
                            <td> <!-- Added missing closing tag for table cell -->
                                <a href="EditProduct.php?id=<?= $menuItem['product_id']; ?>" class="wijzig-button">Wijzigen</a>
                                <form action="../controllers/delete_product.php" method="POST" onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">
                                    <input type="hidden" name="product_id" value="<?= $menuItem['product_id']; ?>">
                                    <button type="submit" class="verwijder-button">Verwijderen</button>
                                </form>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="10">Geen zoekresultaten gevonden.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table> <!-- Added missing closing tag for table -->
    </main>
    <?php include '../partials/footer.php'; ?>
</body>

</html>