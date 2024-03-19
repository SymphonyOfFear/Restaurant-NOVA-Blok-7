<?php include '../partials/header.php'; ?>

<main class="container reservation-page">
    <h1>Maak een Reservering</h1>
    <form class="form-container" action="path_to_reservation_processing.php" method="post">
        <!-- Reservation form fields -->
        <label for="name">Naam:</label>
        <input type="text" id="name" name="name" required>

        <label for="date">Datum:</label>
        <input type="date" id="date" name="date" required>    
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