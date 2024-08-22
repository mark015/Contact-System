<?php
session_start();

// Include the database connection file
require_once 'includes/config.php';

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}
$userId = $_SESSION['userId'];
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $name = sanitizeInput($_POST['name']);
    $company = sanitizeInput($_POST['company']);
    $phone = sanitizeInput($_POST['phone']);
    $email = sanitizeInput($_POST['email']);

    // Prepare the SQL query to insert the user into the database
    $sql = "INSERT INTO contacts (user_id, name, company, phone, email) VALUES (?, ?, ?, ?, ?)";

    // Prepare and execute the statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $userId, $name, $company, $phone, $email);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Contacts added successfully!';
        } else {
            $_SESSION['error'] = 'Database error: ' . $conn->error;
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = 'Database error: ' . $conn->error;
    }

    // Close the database connection
    $conn->close();

    // Redirect to the form page with success or error message
    header("Location: contact.php");
    exit();
} else {
    $_SESSION['error'] = 'Invalid request method.';
    header("Location: addUserForm.php");
    exit();
}
