<?php
// Start the session
session_start();

// Include the database connection file
require_once 'includes/config.php';

// Handle login submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hashedPassword = md5($password);
    // Prepare the query to fetch the user
    $sql = "SELECT user_id, password FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        // Check if the user exists
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($userId, $pass);
            $stmt->fetch();
            
            // Verify the password
            if ($hashedPassword === $pass) {
                // Start the session for the user
                $_SESSION['user_id'] = $userId;
                $_SESSION['success'] = "Login successful!";
                header("Location: contact.php");
                exit();
            } else {
                $_SESSION['error'] = "Invalid email or password."  ;
            }
        } else {
            $_SESSION['error'] = "Invalid email or password.";
        }
        
        $stmt->close();
    } else {
        $_SESSION['error'] = "Database error: " . $conn->error;
    }
    
    $conn->close();
}
?>

<?php
    include("includes/head.php");
?>

<div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="row w-100">
        <div class="col-md-6 mx-auto">
            
        <span id="messageEmail" style="color:red;"><?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?></span>
            <div class="d-flex flex-column gap-3">
                <form action="login.php" method="post">
                    <h2 class="text-center">Login</h2>
                    
                    <div class="d-flex flex-row align-items-center m-3">
                        <label for="email" class="me-3" style="width: 150px;">Email:</label>
                        <input type="email" id="email" class="form-control flex-grow-1" name="email" required>
                    </div>
                    
                    <div class="d-flex flex-row align-items-center m-3">
                        <label for="password" class="me-3" style="width: 150px;">Password:</label>
                        <input type="password" id="password" class="form-control flex-grow-1" name="password" required>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        <button type="submit" id="submit" class="btn btn-success">Login</button>
                      
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="register.php" class="ml-10">Register</a>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    include("includes/bottom.php");
?>
