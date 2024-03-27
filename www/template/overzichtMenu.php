 <div id="menuOverzicht" class="content-section" style="display: none;">
     <h2>Menu Overzicht</h2>
     <form class="search-form" method="POST" action="../controllers/search_menu_items.php">
         <input type="text" id="searchMenu" name="searchTerm" placeholder="Zoeken..." value="<?= htmlspecialchars($searchTerm) ?>">
         <button type="submit">Zoek</button>
     </form>

     <div class="table-container">
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
                 <?php if (!empty($menuItems)) : ?>
                     <?php foreach ($menuItems as $menuItem) : ?>
                         <tr>
                             <td><?= htmlspecialchars($menuItem['naam']) ?></td>
                             <td><?= htmlspecialchars($menuItem['beschrijving']) ?></td>
                             <td><?= htmlspecialchars($menuItem['inkoopprijs']) ?></td>
                             <td><?= htmlspecialchars($menuItem['verkoopprijs']) ?></td>
                             <td><img src="../assets/images/<?= htmlspecialchars($menuItem['afbeelding']) ?>" alt="Afbeelding" style="width: 100px; height: auto;"></td>
                             <td><?= ($menuItem['is_vega'] == 1) ? 'Ja' : 'Nee' ?></td>
                             <td><?= htmlspecialchars($menuItem['categorie_naam']) ?></td>
                             <td><?= htmlspecialchars($menuItem['menugang_naam']) ?></td>
                             <td><?= htmlspecialchars($menuItem['voorraad']) ?></td>
                             <td class="action-buttons">
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
                         <td colspan="10">Geen producten gevonden.</td>
                     </tr>
                 <?php endif; ?>
             </tbody>
         </table>
     </div>
 </div>