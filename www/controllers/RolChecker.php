<?php
// Check if headers have already been sent and if not, start a session
if (!headers_sent()) {
    session_start();
}

header('Content-Type: application/json');

// Only proceed if the user is logged in and the userId is set in the session
if (isset($_SESSION['userId'])) {
    // Send the user role in JSON format
    echo json_encode(['rol' => $_SESSION['userRole']]);
} else {
    // Send an error message if not logged in
    echo json_encode(['error' => 'Not logged in.']);
}
