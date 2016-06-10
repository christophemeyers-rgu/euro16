<?php
/**
 * Created by PhpStorm.
 * User: Christophe
 * Date: 10/06/2016
 * Time: 17:04
 */

include("functions.php");

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


    <title>Create Group</title>
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


        <h3>
            Placing bets:
        </h3>

        <p>
            Under "Matches", you can change your bets for each of the known matches as many times as you want.
            <br>
            Bets close for each match separately 1 hour before kickoff.
        </p>

        <h3>
            Points system:
        </h3>

        <p>
            Once the match score is updated, you will be rewarded points for each bet you made:
            <br>
            <br>
            3 points: You guessed the exact score!
            <br>
            2 points: You correctly guessed the goal difference.
            <br>
            1 point: You correctly picked the winner of the match.
            <br>
            0 points: You got it all wrong or did not even bother to bet.
        </p>

        <h3>
            Groups:
        </h3>

        <p>
            You can join multiple groups to compare points with your friends.
        </p>

        <h3>
            Bugs or questions:
        </h3>

        <p>
            Please talk to me, I will look to fix things as quickly as convenient.
        </p>



    </div>

</main>

</body>
</html>