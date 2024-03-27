 <!-- Gerecht Toevoegen -->
 <div id="gerechtToevoegen" class="content-section" style="display: none;">

     <form class="form-container" action="../controllers/process-nieuw-product.php" method="POST" enctype="multipart/form-data">
         <h2>Product Toevoegen</h2>
         <label for="gerechtNaam">Naam:</label>
         <input type="text" id="gerechtNaam" name="gerechtNaam" required>

         <label for="gerechtBeschrijving">Beschrijving:</label>
         <textarea id="gerechtBeschrijving" name="gerechtBeschrijving" required></textarea>

         <label for="gerechtInkoopprijs">Inkoopprijs:</label>
         <input type="text" id="gerechtInkoopprijs" name="gerechtInkoopprijs" required>

         <label for="gerechtVerkoopprijs">Verkoopprijs:</label>
         <input type="text" id="gerechtVerkoopprijs" name="gerechtVerkoopprijs" required>

         <label for="gerechtAfbeelding">Afbeelding uploaden:</label>
         <input type="file" id="gerechtAfbeelding" name="gerechtAfbeelding" accept="image/*" required>

         <label for="gerechtIsVega">Is Vega:</label>
         <select id="gerechtIsVega" name="gerechtIsVega" required>
             <option value="0">Nee</option>
             <option value="1">Ja</option>
         </select>

         <label for="gerechtCategorie">Categorie:</label>
         <select id="gerechtCategorie" name="gerechtCategorie" required>
             <option value="">Kies een categorie...</option>
             <?php foreach ($categories as $category) : ?>
                 <option value="<?= $category['categorie_id'] ?>"><?= $category['naam'] ?></option>
             <?php endforeach; ?>
         </select>
         <label for="gerechtMenugang">Menugang:</label>
         <select id="gerechtMenugang" name="gerechtMenugang" required>
             <option value="">Kies een menugang...</option>
             <?php foreach ($menuGangs as $menuGang) : ?>
                 <option value="<?= $menuGang['menugang_id'] ?>"><?= $menuGang['naam'] ?></option>
             <?php endforeach; ?>
         </select>
         <label for="gerechtVoorraad">Voorraad:</label>
         <input type="number" id="gerechtVoorraad" name="gerechtVoorraad" required>
         <button type="submit">Toevoegen</button>
     </form>
 </div>