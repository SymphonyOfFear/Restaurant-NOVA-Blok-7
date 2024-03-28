<div id="reserveringenOverzicht" class="content-section" style="display:none;">
    <h2>Reserveringen Overzicht</h2>
    <form class="search-form" method="POST" action="../controllers/search_reservations.php">
        <input autocomplete="off" type="text" name="searchReserveringen" placeholder="Zoek naar reserveringen..." value="<?= isset($_POST['searchReserveringen']) ? htmlspecialchars($_POST['searchReserveringen']) : '' ?>">
        <button type="submit">Zoek</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Reserverings ID</th>
                <th>Naam Klant</th>
                <th>Datum</th>
                <th>Tijd</th>
                <th>Tafelnummer</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($reserveringen) > 0) : ?>
                <?php foreach ($reserveringen as $reservering) : ?>
                    <tr>
                        <td><?= htmlspecialchars($reservering['reservering_id']) ?></td>
                        <td><?= htmlspecialchars($reservering['voornaam'] . ' ' . $reservering['achternaam']) ?></td>
                        <td><?= htmlspecialchars($reservering['datum']) ?></td>
                        <td><?= htmlspecialchars($reservering['tijd']) ?></td>
                        <td><?= htmlspecialchars($reservering['tafel_nummer']) ?></td>
                        <td class="action-buttons">
                            <a href="EditReservation.php?id=<?= $reservering['reservering_id']; ?>" class="wijzig-button">Wijzigen</a>
                            <form action="../controllers/delete_reservation.php" method="POST" onsubmit="return confirm('Weet je zeker dat je deze reservering wilt verwijderen?');">
                                <input type="hidden" name="reservering_id" value="<?= $reservering['reservering_id']; ?>">
                                <button type="submit" class="verwijder-button">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6">Geen reserveringen gevonden.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>