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
                    <td><?= htmlspecialchars($row['voornaam'] . " " . $row['achternaam']); ?></td>
                    <td><?= htmlspecialchars($row['rol']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['postcode']); ?></td>
                    <td><?= htmlspecialchars($row['straatnaam']); ?></td>
                    <td><?= htmlspecialchars($row['huisnummer']); ?></td>
                    <td><?= htmlspecialchars($row['woonplaats']); ?></td>
                    <td><?= htmlspecialchars($row['land']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>