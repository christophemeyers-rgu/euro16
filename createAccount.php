<?php
/**
 * Created by PhpStorm.
 * User: Christophe
 * Date: 06/06/2016
 * Time: 02:16
 */

include("functions.php");


session_start();
if(isset($_SESSION['email'])){
    header("Location: index.php");
}


//This check shows the right message if the user was created or existed already
if($_SERVER['REQUEST_METHOD']==='POST'){
    createUser();
}
elseif($_SERVER['REQUEST_METHOD']==='GET'){
    $success = $_GET["Success"];

    if($success=="Yes"){
        echo "<SCRIPT>alert('Account was successfully created!');</SCRIPT>";
    }
    elseif($success=="No"){
        echo "<script>alert('This email address is already registered to an account.');</script>";
    }
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



    <title>Create Account</title>
</head>
<body>


<form id="login" action="createAccount.php" method="post">
    <input type="text" placeholder="Email Address" name="email">
    <br>
    <input type="password" placeholder="Password" name="password">
    <br>
    <input type="text" placeholder="Firstname" name="firstname">
    <br>
    <input type="text" placeholder="Surname" name="surname">
    <br>
    <input type="submit" value="Register">
</form>






</body>
</html>
