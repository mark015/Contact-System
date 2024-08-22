<?php
    include("includes/auth.php");

    include("includes/head.php");
    include("includes/navbar.php");
?>

<div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="row w-100">
        <div class="col-md-6 mx-auto">
            <div class="d-flex flex-column gap-3">
                <h2 class="text-center">Add New User</h2>
                <form action="addContactProcess.php" method="post">
                    <div class="d-flex flex-row align-items-center m-3">
                        <label for="name" class="mr-3" style="width: 150px;">Name:</label>
                        <input type="text" id="name" class="form-control flex-grow-1" name="name" required>
                    </div>

                    <div class="d-flex flex-row align-items-center m-3">
                        <label for="company" class="mr-3" style="width: 150px;">Company:</label>
                        <input type="text" id="company" class="form-control flex-grow-1" name="company">
                    </div>

                    <div class="d-flex flex-row align-items-center m-3">
                        <label for="phone" class="mr-3" style="width: 150px;">Phone:</label>
                        <input type="text" id="phone" class="form-control flex-grow-1" name="phone">
                    </div>

                    <div class="d-flex flex-row align-items-center m-3">
                        <label for="email" class="mr-3" style="width: 150px;">Email:</label>
                        <input type="email" id="email" class="form-control flex-grow-1" name="email">
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
    include("includes/bottom.php");
?>
