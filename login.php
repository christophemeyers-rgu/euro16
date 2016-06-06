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
    if(userRegistered($email,$password)){	//See function
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


    <form id="login" action="login.php" method="post">
        <input type="text" placeholder="Email Address" name="email">
        <br>
        <input type="password" placeholder="Password" name="password">
        <br>
        <input type="submit" value="Login">
    </form>
    <a href="#">Create Account</a>

    <div class="popup" onclick="myFunction()">Create Account
        <span class="popuptext" id="myPopup">You are already logged in</span>
    </div>

    <script>
        // When the user clicks on div, open the popup
        function myFunction() {
            var session = <?php echo json_encode($_SESSION['email']); ?>;
            if (typeof session !== 'undefined'){
                window.location.assign("http://meyerseuro16bets.azurewebsites.net/createAccount.php")
            }
            else{
                var popup = document.getElementById('myPopup');
                popup.classList.toggle('show');
            }
        }
    </script>


</body>
</html>