<?php

include("functions.php");

session_start();
if(isset($_SESSION['email'])){
    header("Location: home.php");
}



//GET when accessed through URL
if($_SERVER['REQUEST_METHOD']==='GET'){
    //check if session is set
//    session_start();
    if(isset($_SESSION["email"])){
        //send user to adminhome.php
        header("Location: home.php");
    }
}
else if($_SERVER['REQUEST_METHOD']==='POST'){	//Post is used when the form is submitted

    //read input details from index.php
    $email=$_POST['email'];
    $password=$_POST['password'];
    if(user_registered($email,$password)){	//See function
//        session_start();	//start the session
        $_SESSION["email"]=$email;	//assign the admin email address to the session
        header("Location: home.php");	//send admin to adminhome.php
    }
    else{
        echo "<script>alert('Invalid user details');</script>";
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



    <title>Login</title>
</head>
<body>

    <img src="assets/images/YoungHappyPlatini.jpg" id="leftImage">

    <form id="login" action="login.php" method="post">
        <input type="text" placeholder="Email Address" name="email">
        <br>
        <input type="password" placeholder="Password" name="password">
        <br>
        <input type="submit" value="Login">
    </form>



</body>
</html>