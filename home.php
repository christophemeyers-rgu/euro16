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
    <title>Home</title>
</head>
<body>

    <nav>
        <ul>
            <li> <a href="#">Home</a> </li>
            <li> <a href="#">Groups</a> </li>
            <li> <a href="#">Matches</a></li>
        </ul>
    </nav>


    Hello my friend.
</body>
</html>