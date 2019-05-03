<?php

// Create and include a configuration file with the database connection
include_once('config.php');

// Include functions for application
include_once('functions.php');

// If form submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get username and password from the form as variables
    $username = $_POST['username'];
    $password = $_POST['password'];

    //Login
    $user = new User($database);
    $user->login($username,$password);
}

?>

<?php include('includes/navbar.php') ?>
<div class="container">
    <h1 class="display-4">Login</h1>
    <form method="POST">
        <div class="row">
            <div class="col">
                <input type="text" class="form-control" name="username" placeholder="Username" />
            </div>
            <div class="col">
                <input type="password" class="form-control" name="password" placeholder="Password" />
            </div>
            <div class="col">
                <input type="submit" class="btn btn-primary" value="Log In" />
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col">
            <br/>
            <a href="signup.php">Sign Up</a>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>
