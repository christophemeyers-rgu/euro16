<?php


session_start();
if(!isset($_SESSION['email'])){
    header("Location: login.php");
}


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="assets/css/unsemantic-grid-responsive-tablet.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">


    <title>Home</title>
</head>
<body>


<header>

    <h1><?php
        getUserName($_SESSION["email"]);
        ?>
    </h1>
    <nav>
        <ul>
            <li> <a href="index.php">Home</a> </li>
            <li class="dropdown">
                <a href="groups.php" class="dropbtn">Groups</a>
                <div class="dropdown-content">
                    <a href="groups.php">Your Groups</a>
                    <a href="joinGroup.php">Join a Group</a>
                    <a href="createGroup.php">Create a Group</a>
                </div>
            </li>
            <li> <a href="matches.php">Matches</a></li>
            <li> <a href="nations.php">Participating Nations</a> </li>
            <li> <a href="logout.php">Logout</a> </li>
        </ul>
    </nav>
</header>


    <main>


        <div class="grid-100 tablet-grid-100 mobile-grid-100">

            <p>Hello my friend.
                This is how this is going to work:
                blablabla rules blabla.</p>

        </div>

    </main>

</body>
</html>