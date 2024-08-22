<?php
    include("includes/head.php");
?>

<div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="row w-100">
        <div class="col-md-6 mx-auto">
            <div class="d-flex flex-column gap-3">
                <form action="registerProcess.php" method="post">
                    <h2 class="text-center">Register</h2>
                    
                    <div class="d-flex flex-row  m-3">
                        <label for="name" class="me-3" style="width: 150px;">Name:</label>
                        <input type="text" id="name" class="form-control" name="name">
                    </div>
                    <span id="messageName" class="align-items-center" style="color:red; text-align:center" ></span>
                    
                    <div class="d-flex flex-row align-items-center m-3">
                        <label for="email" class="me-3" style="width: 150px;">Email:</label>
                        <input type="email" id="email" class="form-control flex-grow-1" name="email" required>
                    </div>
                    <span id="messageEmail" style="color:red;"></span>
                    
                    <div class="d-flex flex-row align-items-center m-3">
                        <label for="password" class="me-3" style="width: 150px;">Password:</label>
                        <input type="password" id="password" class="form-control flex-grow-1" name="password" required>
                    </div>
                    <span id="messagePassword" style="color:red;"></span>
                    
                    <div class="d-flex flex-row align-items-center m-3">
                        <label for="confirm-password" class="me-3" style="width: 150px;">Confirm Password:</label>
                        <input type="password" id="confirm-password" class="form-control flex-grow-1" name="confirm-password" required>
                    </div>
                    <span id="messageConfirmPassword" style="color:red;"></span>
                    
                    <div class="d-flex justify-content-center">
                        <button type="submit" id="submit" class="btn btn-success">Submit</button>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="login.php" class="btn btn-danger mt-3">Back to login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
<script>
    $(document).on('input', '#email', function() {
        var email = $(this).val();
        
        // Clear previous messages
        $('#messageEmail').text('');

        // Check if the email is already taken
        if(email.trim() !== '') {
            $.ajax({
                url: 'checkEmail.php',
                type: 'POST',
                data: { email: email },
                dataType: 'json',
                success: function(response) {
                    if(response.exists) {
                        $('#messageEmail').text('This email is already taken!');
                    }
                }
            });
        }
    });

    $(document).on('click', '#submit', function(event){
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var confirmPassword = $('#confirm-password').val();
        
        // Clear previous messages
        $('#messageName').text('');
        $('#messageEmail').text('');
        $('#messagePassword').text('');
        $('#messageConfirmPassword').text('');

        var isValid = true;

        // Check if the name field is empty
        if(name.trim() === ''){
            $('#messageName').text('Please fill out this field!');
            isValid = false;
        }
        
        // Check if the email field is empty
        if(email.trim() === ''){
            $('#messageEmail').text('Please fill out this field!');
            isValid = false;
        }
        
        // Check if the password field is empty
        if(password.trim() === ''){
            $('#messagePassword').text('Please fill out this field!');
            isValid = false;
        }

        // Check if the confirm password field is empty or does not match password
        if(confirmPassword.trim() === ''){
            $('#messageConfirmPassword').text('Please fill out this field!');
            isValid = false;
        } else if(confirmPassword !== password) {
            $('#messageConfirmPassword').text('Passwords do not match!');
            isValid = false;
        }

        // Prevent form submission if validation fails
        if(!isValid) {
            event.preventDefault();
        }
    });
</script>

<?php
    include("includes/bottom.php");
?>
