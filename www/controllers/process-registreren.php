<?php
session_start();
require '../database.php'; // Adjust the path as necessary.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture and sanitize user inputs
    $email = mysqli_real_escape_string($db, $_POST['email']);
    // Hash the password for security
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Address details
    $street = mysqli_real_escape_string($db, $_POST['street']);
    $city = mysqli_real_escape_string($db, $_POST['city']);
    $postcode = mysqli_real_escape_string($db, $_POST['postcode']);
    $country = mysqli_real_escape_string($db, $_POST['country']);

    // Insert the new user into the database
    $query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    if (mysqli_query($db, $query)) {
        $userId = mysqli_insert_id($db); // Get the newly created user ID
        
        // Now insert the address for the new user
        $addressQuery = "INSERT INTO addresses (user_id, street, city, postcode, country) VALUES ('$userId', '$street', '$city', '$postcode', '$country')";
        
        if (mysqli_query($db, $addressQuery)) {
            // Registration successful
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['userId'] = $userId;
            $_SESSION['userRole'] = 'customer'; // Default role

            header('Location: /dashboard.php');
            exit;
        } else {
            // Handle error for address insertion
            $_SESSION['registration_error'] = 'Error occurred during address registration';
            header('Location: /register.php');
            exit;
        }
    } else {
        // Handle error for user insertion
        $_SESSION['registration_error'] = 'Error occurred during user registration';
        header('Location: /register.php');
        exit;
    }
}
?>
