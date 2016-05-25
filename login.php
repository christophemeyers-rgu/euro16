<?php

include("dbConnection.php");
include("functions.php");

session_start();
if(isset($_SESSION['email'])){
    header("Location: home.php");
}



//GET when accessed through URL
if($_SERVER['REQUEST_METHOD']==='GET'){
    //check if session is set
    session_start();
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
        session_start();	//start the session
        $_SESSION["email"]=$email;	//assign the admin email address to the session
        header("Location: home.php");	//send admin to adminhome.php
    }
    else{
        //show_index_page();	//This isn't necessary anymore
        echo "<script>alert('Invalid user details');</script>";
    }
}

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

    <form action="login.php" method="post">
        <input type="text" placeholder="Email Address" name="email">
        <br>
        <input type="password" placeholder="Password" name="password">
        <br>
        <input type="submit" value="Login">
    </form>



</body>
</html>