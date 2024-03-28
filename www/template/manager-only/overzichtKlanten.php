<div id="klantenOverzicht" class="dynamic-content" style="display: none;">
    <h2>Klanten Overzicht</h2>
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
            <?php foreach ($resultKlanten as $row) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['voornaam'] . ' ' . $row['achternaam']) ?></td>
                    <td><?= htmlspecialchars($row['rol']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['postcode']) ?></td>
                    <td><?= htmlspecialchars($row['straatnaam']) ?></td>
                    <td><?= htmlspecialchars($row['huisnummer']) ?></td>
                    <td><?= htmlspecialchars($row['woonplaats']) ?></td>
                    <td><?= htmlspecialchars($row['land']) ?></td>
                    <td class="action-buttons">
                        <a href="EditGebruiker.php?id=<?= $row['gebruiker_id'] ?>" class="btn wijzig-button">Wijzigen</a>
                        <form action="../controllers/delete_gebruiker.php" method="POST" onsubmit="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?');">
                            <input type="hidden" name="gebruiker_id" value="<?= $row['gebruiker_id'] ?>">
                            <button type="submit" class="btn verwijder-button">Verwijderen</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>