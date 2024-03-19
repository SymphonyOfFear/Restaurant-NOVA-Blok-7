<?php include 'partials/header.php'; ?>

<main class="main-content register-page">
    <div class="container">
        <h1>Registreren</h1>
        <form action="../controllers/process-registreren.php" method="post">

            <input type="text" name="voornaam" placeholder="Voornaam" required>
            <input type="text" name="achternaam" placeholder="Achternaam" required>
            <input type="email" name="email" placeholder="E-Mail" required>
            <input type="password" name="wachtwoord" placeholder="Wachtwoord" required>

            <input type="text" name="postcode" placeholder="Postcode" required>
            <input type="text" name="straatnaam" placeholder="straatnaam" required>
            <input type="text" name="huisnummer" placeholder="Huisnummer" required>
            <input type="text" name="woonplaats" placeholder="Woonplaats" required>
            <input type="text" name="land" placeholder="Land" required>

            <button type="submit">Registreren</button>
        </form>
    </div>
</main>

<?php include 'partials/footer.php'; ?>