<?php
// Start the session and include the database configuration
session_start();
require_once 'includes/config.php';

// Check if the delete request is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $contactId = isset($_POST['contact_id']) ? intval($_POST['contact_id']) : 0;

    // Prepare the SQL query to delete the contact
    $sql = "DELETE FROM contacts WHERE contact_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $_SESSION['error'] = "Database error: " . $conn->error;
        header("Location: contacts.php");
        exit();
    }

    $stmt->bind_param('i', $contactId);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Contact deleted successfully!";
    } else {
        $_SESSION['error'] = "Deletion failed. Please try again.";
    }

    $stmt->close();
    $conn->close();
    
    // Redirect to the contacts list
    header("Location: contact.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: contact.php");
    exit();
}
?>
