<?php
// Start the session and include the database configuration
session_start();
require_once 'includes/config.php';

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $contactId = isset($_POST['contact_id']) ? intval($_POST['contact_id']) : 0;
    $name = sanitizeInput($_POST['name']);
    $company = sanitizeInput($_POST['company']);
    $phone = sanitizeInput($_POST['phone']);
    $email = sanitizeInput($_POST['email']);

    // Prepare the SQL query to update the contact
    $sql = "UPDATE contacts SET name = ?, company = ?, phone = ?, email = ? WHERE contact_id = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param('ssssi', $name, $company, $phone, $email, $contactId);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Contact updated successfully!";
    } else {
        $_SESSION['error'] = "Update failed. Please try again.";
    }

    $stmt->close();
    $conn->close();
    
    // Redirect to a confirmation page or back to the contacts list
    header("Location: contact.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: contact.php");
    exit();
}
?>
