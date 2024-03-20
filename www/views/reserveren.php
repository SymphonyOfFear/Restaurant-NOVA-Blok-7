<?php include '../partials/header.php'; ?>

<main class="container reservation-page">
    <h1>Maak een Reservering</h1>
    <form class="form-container" action="path_to_reservation_processing.php" method="post">
        <!-- Reservation form fields -->
        <label for="voornaam">Voornaam:</label>
        <input type="text" id="voornaam" name="voornaam" required>
        <label for="achternaam">Achternaam:</label>
        <input type="text" id="achternaam" name="achternaam" required>

        <label for="datum">Datum:</label>
        <input type="date" id="datum" name="datum" required>
        <label for="time">Tijd:</label>
        <input type="time" id="time" name="time" required>

        <label for="guests">Aantal personen:</label>
        <input type="number" id="guests" name="guests" required>

        <label for="opmerkingen">Opmerkingen:</label>
        <textarea id="opmerkingen" name="opmerkingen"></textarea>

        <button type="submit" class="btn">Reserveer Nu</button>
    </form>

</main>
<?php include '../partials/footer.php'; ?>