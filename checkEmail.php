<?php
// Include the database connection file
require_once 'includes/config.php';

// Get the email from the request
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

// Prepare the query to check if the email exists
$sql = "SELECT COUNT(*) FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
$conn->close();

// Return the result as JSON
echo json_encode(['exists' => $count > 0]);
?>
