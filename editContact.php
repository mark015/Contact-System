<?php
include("includes/auth.php");
include("includes/navbar.php");
require_once 'includes/config.php';

// Get the contact ID from the query parameter
$contactId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the contact details from the database
$sql = "SELECT contact_id, name, company, phone, email FROM contacts WHERE contact_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $contactId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Contact not found.";
    exit();
}

$contact = $result->fetch_assoc();
$stmt->close();
?>

<?php
    include('includes/head.php');
?>

<div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="row w-100">
        <div class="col-md-6 mx-auto">
            <div class="d-flex flex-column gap-3">
                <h2 class="text-center">Edit Contact</h2>
                <form action="updateProcess.php" method="post">
                    <input type="hidden" name="contact_id" value="<?php echo htmlspecialchars($contact['contact_id']); ?>">
                    
                    <div class="d-flex flex-row align-items-center m-3">
                        <label for="name"  style="width: 150px;">Name:</label>
                        <input type="text" id="name" class="form-control flex-grow-1" name="name" value="<?php echo htmlspecialchars($contact['name']); ?>" required>
                    </div>

                    <div class="d-flex flex-row align-items-center m-3">
                        <label for="company" class="form-label" style="width: 150px;">Company:</label>
                        <input type="text" id="company" class="form-control flex-grow-1" name="company" value="<?php echo htmlspecialchars($contact['company']); ?>" required>
                    </div>

                    <div class="d-flex flex-row align-items-center m-3">
                        <label for="phone" class="form-label" style="width: 150px;">Phone:</label>
                        <input type="text" id="phone" class="form-control flex-grow-1" name="phone" value="<?php echo htmlspecialchars($contact['phone']); ?>" required>
                    </div>

                    <div class="d-flex flex-row align-items-center m-3">
                        <label for="email" class="form-label" style="width: 150px;">Email:</label>
                        <input type="email" id="email" class="form-control flex-grow-1" name="email" value="<?php echo htmlspecialchars($contact['email']); ?>" required>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    include('includes/bottom.php');
?>
