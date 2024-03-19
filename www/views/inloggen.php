<?php include '../partials/header.php'; ?>

<div class="form-container">
    <h2>Login</h2>
    <form action="../controllers/process-inloggen.php" method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn">Login</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>