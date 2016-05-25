<?php


session_start();
if(!isset($_SESSION['ad_email'])){
    header("Location: index.php");
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
    Hello my friend.
</body>
</html>