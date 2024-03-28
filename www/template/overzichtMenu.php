<div id="menuOverzicht" class="content-section" style="display: none;">
    <h2>Menu Overzicht</h2>
    <form class="search-form" method="POST" action="../controllers/search_menu_items.php">
        <input autocomplete="off" type="text" id="searchMenu" name="searchTerm" placeholder="Zoeken..." value="<?= htmlspecialchars($searchTerm) ?>">
        <button type="submit" class="btn">Zoek</button>
    </form>
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
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menuItems as $menuItem) : ?>
                <tr>
                    <td><?= htmlspecialchars($menuItem['naam']) ?></td>
                    <td><?= htmlspecialchars($menuItem['beschrijving']) ?></td>
                    <td>€ <?= htmlspecialchars(number_format($menuItem['inkoopprijs'], 2, ',', '.')) ?></td>
                    <td>€ <?= htmlspecialchars(number_format($menuItem['verkoopprijs'], 2, ',', '.')) ?></td>
                    <td><img src="../assets/images/<?= htmlspecialchars($menuItem['afbeelding']) ?>" alt="<?= htmlspecialchars($menuItem['naam']) ?>" class="img-size"></td>
                    <td><?= $menuItem['is_vega'] ? 'Ja' : 'Nee' ?></td>
                    <td><?= htmlspecialchars($menuItem['categorie_naam']) ?></td>
                    <td><?= htmlspecialchars($menuItem['menugang_naam']) ?></td>
                    <td><?= htmlspecialchars($menuItem['voorraad']) ?></td>
                    <td class="action-buttons">
                        <a href="EditProduct.php?id=<?= $menuItem['product_id']; ?>" class="btn wijzig-button">Wijzigen</a>
                        <form action="../controllers/delete_product.php" method="POST" onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">
                            <input type="hidden" name="product_id" value="<?= $menuItem['product_id']; ?>">
                            <button type="submit" class="btn verwijder-button">Verwijderen</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>