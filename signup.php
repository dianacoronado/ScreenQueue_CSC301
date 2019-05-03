<?php

// Create and include a configuration file with the database connection
include_once('config.php');

// Include functions for application
include('functions.php');

// If form submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get info from from the form as variables
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    //Create new user and save to database
    $user = new User($database);
    $user
        ->set('firstName',$firstname)
        ->set('lastName',$lastname)
        ->set('username',$username)
        ->set('password', $password)
        ->save();
}   

?>

<?php include('includes/navbar.php') ?>
<div class="container">
    <h1 class="display-4">Sign Up</h1>
    <hr>
    <div class="col">
        <form method="POST">
            <div class="form-group">
                <div class="col">
                    <input type="text" class="form-control" name="firstname" placeholder="First Name" />
                </div>
            </div>
            <div class="form-group">
                <div class="col">
                    <input type="text" class="form-control" name="lastname" placeholder="Last Name" />
                </div>
            </div>
            <div class="form-group">
                <div class="col">
                    <input type="text" class="form-control" name="username" placeholder="Username" />
                </div>
            </div>
            <div class="form-group">
                <div class="col">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
                </div>
            </div>
            <div class="form-group">
                <div class="col">
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" />
                </div>
                <div class="invalid-feedback">
                    Passwords do not match
                </div>
            </div>
            <div class="form-group">
                <div class="col">
                    <input type="submit" id="submitButton" class="btn btn-primary" value="Sign Up" />
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col">
            <br/>
            <a href="login.php">Already have an account? Login in</a>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>

<script>
    //validate password
    $('#confirmPassword').on('keyup', function (){
        console.log("validating");
        if($("#password").val()!== ($("#confirmPassword").val()))
        {
            $("#confirmPassword").addClass("is-invalid");
            $("#submitButton").attr("disabled", true);
        }
        else
        {;
         $('#confirmPassword').removeClass("is-invalid");
         $("#submitButton").attr("disabled", false);
        }

    });
</script>
