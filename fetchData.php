<?php
require_once 'includes/config.php';
session_start();
$userId = $_SESSION['userId'];
// Sanitize input
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$limit = 10; // Number of records per page
$offset = ($page - 1) * $limit;

// Prepare the query
$sql = "SELECT contact_id, user_id, name, company, phone, email FROM contacts 
        WHERE (name LIKE ? OR company LIKE ? OR phone LIKE ? OR email LIKE ?) AND user_id = ?
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
    exit();
}

$searchTerm = "%$search%";
$stmt->bind_param('sssssii', $searchTerm, $searchTerm, $searchTerm, $searchTerm, $userId, $limit, $offset);

// Execute and fetch results
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo json_encode(['error' => 'Execute failed: ' . $stmt->error]);
    exit();
}

// Generate table rows
$tableRows = '';
while ($row = $result->fetch_assoc()) {
    $tableRows .= '<tr>';
    $tableRows .= '<td>' . htmlspecialchars($row['name']) . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($row['company']) . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($row['phone']) . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($row['email']) . '</td>';
    $tableRows .= '<td>
                        <a href="editContact.php?id=' . $row['contact_id'] . '" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-danger btn-sm delete-btn" id="deleteContactBtn" data-id="' . $row['contact_id'] . '">Delete</button>
                    </td>';
    $tableRows .= '</tr>';
}

// Get total records for pagination
$sqlCount = "SELECT COUNT(*) FROM contacts 
             WHERE name LIKE ? OR company LIKE ? OR phone LIKE ? OR email LIKE ?";
$stmtCount = $conn->prepare($sqlCount);

if (!$stmtCount) {
    echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
    exit();
}

$stmtCount->bind_param('ssss', $searchTerm, $searchTerm, $searchTerm, $searchTerm);
$stmtCount->execute();
$resultCount = $stmtCount->get_result();

if (!$resultCount) {
    echo json_encode(['error' => 'Execute failed: ' . $stmtCount->error]);
    exit();
}

$totalRecords = $resultCount->fetch_row()[0];
$totalPages = ceil($totalRecords / $limit);

// Generate pagination links
$paginationLinks = '';
for ($i = 1; $i <= $totalPages; $i++) {
    $active = $i == $page ? 'active' : '';
    $paginationLinks .= '<li class="page-item ' . $active . '"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
}

// Close the database connection
$stmt->close();
$stmtCount->close();
$conn->close();

// Return the table and pagination links as JSON
echo json_encode([
    'table' => $tableRows,
    'pagination' => $paginationLinks
]);
?>
