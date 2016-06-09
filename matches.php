<?php
/**
 * Created by PhpStorm.
 * User: Christophe
 * Date: 09/06/2016
 * Time: 23:38
 */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="assets/css/unsemantic-grid-responsive-tablet.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">


    <title>Matches</title>
</head>
<body>

<!--    <img src="assets/images/YoungHappyPlatini.jpg" id="leftImage">-->

<header>

    <h1><?php
        getUserName($_SESSION["email"]);
        ?>
    </h1>

    <nav>
        <ul>
            <li> <a href="home.php">Home</a> </li>
            <li> <a href="#">Groups</a> </li>
            <li> <a href="matches.php">Matches</a></li>
            <li> <a href="nations.php">Participating Nations</a> </li>
            <li> <a href="logout.php">Logout</a> </li>
        </ul>
    </nav>
</header>


<main>



    <div class="grid-100 tablet-grid-100 mobile-grid-100">




    </div>

</main>

</body>
</html>
