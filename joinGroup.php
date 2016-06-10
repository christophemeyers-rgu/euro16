<?php
/**
 * Created by PhpStorm.
 * User: Christophe
 * Date: 10/06/2016
 * Time: 14:23
 */

include("functions.php");

session_start();
if(!isset($_SESSION['email'])){
    header("Location: login.php");
}

if($_SERVER['REQUEST_METHOD']==='GET'){

    $success = $_GET["Joined"];
    if($success=="No"){
        echo "<SCRIPT>alert('The entered Name-Password combination matches no groups.');</SCRIPT>";
    }
}
elseif($_SERVER['REQUEST_METHOD']==='POST'){	//Post is used when the form is submitted

    joinGroup();

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

    <!--<h1><?php
    /*                getUserName($_SESSION["email"]);
                */?>
        </h1>-->

    <nav>
        <ul>
            <li> <a href="home.php">Home</a> </li>
            <li class="dropdown">
                <a href="groups.php" class="dropbtn">Groups</a>
                <div class="dropdown-content">
                    <a href="#">Your Groups</a>
                    <a href="joinGroup.php">Join a Group</a>
                    <a href="#">Create a Group</a>
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

        <form action="joinGroup.php" method="post">
            <table>
                <tr>
                    <td>
                        <label for="groupName">Group Name:</label>
                    </td>
                    <td>
                        <input type="text" name="groupName">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="groupPassword">Group Password:</label>
                    </td>
                    <td>
                        <input type="password" name="groupPassword">
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input type="submit" value="Join Group">
                    </td>
                </tr>
            </table>
        </form>

    </div>

</main>

</body>
</html>