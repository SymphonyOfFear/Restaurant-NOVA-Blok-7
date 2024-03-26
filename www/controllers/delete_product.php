<?php
require '../database.php';

// Check for POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);

    if ($productId) {
        // Prepare DELETE statement
        $stmt = $conn->prepare("DELETE FROM Product WHERE product_id = ?");
        $stmt->execute([$productId]);

        // Check if the product was successfully deleted
        if ($stmt->rowCount() > 0) {
            header("Location: ../views/employee_dashboard.php");
        } else {
            echo "<script>alert('Fout bij het verwijderen van product.'); window.location.href='../views/employee_dashboard.php';</script>";
        }
    }
} else {
    // Redirect to dashboard if not a POST request
    header("Location: ../views/employee_dashboard.php");
    exit();
}
