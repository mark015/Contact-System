<?php
// Start the session to store user messages
session_start();

// Include the database connection file
require_once 'includes/config.php';

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize it
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    $confirmPassword = sanitizeInput($_POST['confirm-password']);

    // Hash the password
    $hashedPassword = md5($password);

    // Prepare the SQL query to insert the user into the database
    $sql = "INSERT INTO users ( `name`, `email`, `password`) VALUES ( ?, ?, ?)";

    // Prepare and execute the statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            $userId = $conn->insert_id;
            $_SESSION['userId'] = $userId;
            $_SESSION['success'] = "Registration successful!";
            header("Location: registerSuccess.php");
        } else {
            $_SESSION['error'] = "Registration failed. Please try again.";
            header("Location: register.php");
        }

        // Close the statement
        $stmt->close();
    } else {
        $_SESSION['error'] = "Database error: " . $conn->error;
        header("Location: register.php");
    }

    // Close the database connection
    $conn->close();
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: register.php");
}
