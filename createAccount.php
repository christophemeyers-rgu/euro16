<?php
/**
 * Created by PhpStorm.
 * User: Christophe
 * Date: 06/06/2016
 * Time: 02:16
 */


session_start();
if(isset($_SESSION['email'])){
    header("Location: home.php");
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

    <script src="assets/javascript/functions.js" type="text/javascript"></script>


    <title>Create Account</title>
</head>
<body>


<form id="login" action="login.php" method="post">
    <input type="text" placeholder="Email Address" name="email">
    <br>
    <input type="password" placeholder="Password" name="password">
    <br>
    <input type="submit" value="Login">
</form>

<div class="popup" onclick="myFunction()">Create Account
    <span class="popuptext" id="myPopup">You are already logged in</span>
</div>




</body>
</html>
