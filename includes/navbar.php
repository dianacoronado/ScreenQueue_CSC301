<?php
include_once('config.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <?php if(isset($title)): ?>
        <title><?php echo $title ?> - Screen Queue</title>
        <?php else: ?>
        <title>Screen Queue</title>
        <?php endif; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/authy-form-helpers/2.3/form.authy.min.js" data-turbolinks-track="reload"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <style>
            body
            {
                background-color: white;
            }
            h1,h2,h3,h4,p,small{
                color: black;
            }
        </style>
    </head>

    <body>
        <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-transparent">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <?php if($current_url=='index.php'):?>
                    <li class="nav-item active">
                        <a class="nav-link" href="upcoming.php">Upcoming <span class="sr-only"></span></a>
                    </li>                    
                    <?php endif;?>
                </ul>
                <div class="form-inline my-2 my-lg-0">
                    <?php if(!isset($user) && $current_url!='login.php'):?>
                    <a class="nav-link" href="login.php">Login <span class="sr-only"></span></a>
                    <?php elseif(isset($user) &&  $current_url!='profile.php'):?>
                    <a class="nav-link" href="profile.php"><?php echo $user->get('firstName') ?><span class="sr-only"></span></a>
                    <a class="nav-link" href="logout.php">Log out<span class="sr-only"></span></a>
                    <?php elseif(isset($user) &&  $current_url=='profile.php'):?>
                    <a class="nav-link" href="logout.php">Log out<span class="sr-only"></span></a>
                    <?php endif; ?>
                    <input class="form-control" id="searchText" type="search" placeholder="Search Movie Titles" aria-label="Search">
                    <button class="btn btn-outline-success" id="searchButton" type="submit">Search</button>
                </div>
            </div>
        </nav>



        <script>


            $("#searchText").on("keydown",function search(e) {
                if(e.keyCode === 13) {
                    $("#searchButton").click();
                }
            });
            $('#searchButton').click(function()
                                     {
                var url = 'search.php?q='+$('#searchText').val();
                window.location.href=url;
            });

            $( document ).ready(function() {
                var date = new Date().getFullYear();
                $('#copyright').text(date);
            });

        </script>