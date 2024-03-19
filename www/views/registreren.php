<?php include '../partials/header.php'; ?>

<!-- registreren.php -->
<div class="form-container">
    <h2>Register</h2>
    <form action="../controllers/process-registreren.php" method="post">
    <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm_password" required>
        </div>
        
        <!-- Address details -->
        <div class="form-group">
            <label for="street">Street:</label>
            <input type="text" id="street" name="street" required>
        </div>
        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>
        </div>
        <div class="form-group">
            <label for="postcode">Postcode:</label>
            <input type="text" id="postcode" name="postcode" required>
        </div>
        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" id="country" name="country" required>
        </div>

        <button type="submit" class="btn">Register</button>
    </form>
</div>


<?php include '../partials/footer.php'; ?>