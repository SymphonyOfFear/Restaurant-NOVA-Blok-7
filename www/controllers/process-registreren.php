<?php
session_start();
require '../database.php'; // Adjust the path as necessary.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password']; // This should be hashed with a salt before storing

    // Protect against SQL injection
    $email = mysqli_real_escape_string($db, $email);
    $password = mysqli_real_escape_string($db, $password);

    // Insert the new user into the database
    $query = "INSERT INTO users (email, password) VALUES ('$email', SHA1('$password'))";
    $result = mysqli_query($db, $query);

    if ($result) {
        // Registration successful
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['userId'] = mysqli_insert_id($db);
        $_SESSION['userRole'] = 'customer'; // Default role

        header('Location: /dashboard.php');
        exit;
    } else {
        // Error occurred
        $_SESSION['registration_error'] = 'Error occurred during registration';
        header('Location: /register.php');
        exit;
    }
}
?>