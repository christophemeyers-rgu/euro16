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

    <img src="assets/images/YoungHappyPlatini.jpg" id="leftImage">

    <header>
        <nav>
            <ul>
                <li> <a href="#">Home</a> </li>
                <li> <a href="#">Groups</a> </li>
                <li> <a href="#">Matches</a></li>
                <li> <a href="#">Participating Nations</a> </li>
                <li> <a href="logout.php">Logout</a> </li>
            </ul>
        </nav>
    </header>


    <main>
        <p>Hello my friend.
        This is how this is going to work:
        blablabla rules blabla.</p>
    </main>

</body>
</html>