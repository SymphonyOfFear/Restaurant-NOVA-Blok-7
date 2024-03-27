 <div id="klantToevoegen" class="content-section" style="display: none;">
     <form class="form-container" action="../controllers/process-klant-toevoegen.php" method="post">
         <h2>Klant Toevoegen</h2>
         <div class="form-group">
             <label for="voornaam">Voornaam:</label>
             <input type="text" id="voornaam" name="voornaam" required>
         </div>
         <div class="form-group">
             <label for="achternaam">Achternaam:</label>
             <input type="text" id="achternaam" name="achternaam" required>
         </div>
         <div class="form-group">
             <label for="email">E-mail:</label>
             <input type="email" id="email" name="email" required>
         </div>
         <div class="form-group">
             <label for="wachtwoord">Wachtwoord:</label>
             <input type="password" id="wachtwoord" name="wachtwoord" required>
         </div>
         <div class="form-group">
             <label for="bevestig-wachtwoord">Bevestig Wachtwoord:</label>
             <input type="password" id="bevestig-wachtwoord" name="bevestig-wachtwoord" required>
         </div>

         <!-- Adresgegevens -->
         <div class="form-group">
             <label for="straatnaam">Straatnaam:</label>
             <input type="text" id="straatnaam" name="straatnaam" required>
         </div>
         <div class="form-group">
             <label for="huisnummer">Huisnummer:</label>
             <input type="text" id="huisnummer" name="huisnummer" required>
         </div>
         <div class="form-group">
             <label for="postcode">Postcode:</label>
             <input type="text" id="postcode" name="postcode" required>
         </div>
         <div class="form-group">
             <label for="woonplaats">Woonplaats:</label>
             <input type="text" id="woonplaats" name="woonplaats" required>
         </div>
         <div class="form-group">
             <label for="land">Land:</label>
             <input type="text" id="land" name="land" required>
         </div>

         <button type="submit" class="btn">Klant Toevoegen</button>
     </form>
 </div>