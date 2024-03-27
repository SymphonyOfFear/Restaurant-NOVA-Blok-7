  <!-- Reservering Toevoegen -->
  <div id="reserveringToevoegen" class="content-section" style="display: none;">
      <div class="form-container">
          <h1>Reservering Toevoegen</h1>
          <form action="../controllers/process_reserve.php" method="post">
              <div class="form-group">
                  <label for="clientSearch">Zoek Klant:</label>
                  <input type="text" id="clientSearch" onkeyup="searchClients(this.value)" placeholder="Search for clients...">
                  <div id="clientSearchResults" style="display: none;"></div>
              </div>
              <input type="hidden" id="selectedClientId" name="gebruiker_id" value="">
              <div class="form-group">
                  <label for="date">Datum:</label>
                  <input type="date" id="date" name="date" required>
              </div>
              <div class="form-group">
                  <label for="time">Tijd:</label>
                  <input type="time" id="time" name="time" required>
              </div>
              <div class="form-group">
                  <label for="people">Aantal personen:</label>
                  <input type="number" id="people" name="people" required>
              </div>
              <div class="form-group">
                  <label for="table">Tafelnummer:</label>
                  <input type="text" id="table" name="table">
              </div>
              <button type="submit" class="btn">Reserveer</button>
          </form>
      </div>
  </div>