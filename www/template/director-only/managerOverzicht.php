  <div id="managersOverzicht" class="dynamic-content" style="display: none;">
      <h2>Managers Overzicht</h2>
      <table>
          <thead>
              <tr>
                  <th>Naam</th>
                  <th>Rol</th>
                  <th>Email</th>
                  <th>Postcode</th>
                  <th>Straatnaam</th>
                  <th>Huisnummer</th>
                  <th>Woonplaats</th>
                  <th>Land</th>
                  <th>Acties</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($resultManagers as $row) { ?>
                  <tr>
                      <td><?php echo htmlspecialchars($row['voornaam'] . " " . $row['achternaam']); ?></td>
                      <td><?php echo htmlspecialchars($row['rol']); ?></td>
                      <td><?php echo htmlspecialchars($row['email']); ?></td>
                      <td><?php echo htmlspecialchars($row['postcode']); ?></td>
                      <td><?php echo htmlspecialchars($row['straatnaam']); ?></td>
                      <td><?php echo htmlspecialchars($row['huisnummer']); ?></td>
                      <td><?php echo htmlspecialchars($row['woonplaats']); ?></td>
                      <td><?php echo htmlspecialchars($row['land']); ?></td>
                      <td>
                          <a href="EditGebruiker.php?id=<?php echo $row['gebruiker_id']; ?>" class="wijzig-button">Wijzigen</a>
                          <form action="../controllers/delete_gebruiker.php" method="POST" onsubmit="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?');">
                              <input type="hidden" name="gebruiker_id" value="<?php echo $row['gebruiker_id']; ?>">
                              <button type="submit" class="verwijder-button">Verwijderen</button>
                          </form>
                      </td>
                  </tr>
              <?php } ?>
          </tbody>
      </table>
  </div>