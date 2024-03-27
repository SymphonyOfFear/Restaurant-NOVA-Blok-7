   <div id="medewerkerOverzicht" class="dynamic-content" style="display: none;">
       <h2>Medewerkers Overzicht</h2>
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
               </tr>
           </thead>
           <tbody>
               <?php foreach ($medewerkers as $row) : ?>
                   <tr>
                       <td><?php echo htmlspecialchars($row['voornaam'] . " " . $row['achternaam']); ?></td>
                       <td><?php echo htmlspecialchars($row['rol']); ?></td>
                       <td><?php echo htmlspecialchars($row['email']); ?></td>
                       <td><?php echo htmlspecialchars($row['postcode']); ?></td>
                       <td><?php echo htmlspecialchars($row['straatnaam']); ?></td>
                       <td><?php echo htmlspecialchars($row['huisnummer']); ?></td>
                       <td><?php echo htmlspecialchars($row['woonplaats']); ?></td>
                       <td><?php echo htmlspecialchars($row['land']); ?></td>
                   </tr>
               <?php endforeach; ?>
           </tbody>
       </table>
   </div>