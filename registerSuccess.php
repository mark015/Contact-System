<?php
session_start();
?>

<?php
    include('includes/head.php');
?>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="text-center">
            <h2>Thank you for registering</h2>

            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success mt-3">
                    <a href="contact.php" class="btn btn-success">Go to contacts</a>
                </div>
            <?php endif;?>
        </div>
    </div>
<?php
    include('includes/bottom.php');
?>
