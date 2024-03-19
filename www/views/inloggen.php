<?php include '../partials/header.php'; ?>

<main class="main-content">
    <h1>Inloggen</h1>
    <form action="../controllers/process-login.php" method="post">
        <label for="email">E-mail:</label>
        <input type="password" name="password" placeholder="Wachtwoord" required>
        <button type="submit">Inloggen</button>
    </form>
</main>

<?php include '../partials/footer.php'; ?>