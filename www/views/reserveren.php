<?php include 'partials/header.php'; ?>

<main class="main-content">
    <h1>Reserveren</h1>
    <form action="/controllers/process-reserveren.php" method="post">
        <input type="text" name="naam" placeholder="Volledige naam" required>
        <input type="email" name="email" placeholder="E-mailadres" required>
        <input type="date" name="datum" required>
        <input type="time" name="tijd" required>
        <input type="number" name="aantal_personen" placeholder="Aantal personen" required>
        <input type="text" name="opmerkingen" placeholder="Opmerkingen">
        <button type="submit">Reserveren</button>
    </form>
</main>

<?php include 'partials/footer.php'; ?>