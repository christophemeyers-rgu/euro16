<?php
/**
 * Created by PhpStorm.
 * User: Christophe
 * Date: 30/05/2016
 * Time: 18:48
 */

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

    <title>Home</title>
</head>
<body>

<!--    <img src="assets/images/YoungHappyPlatini.jpg" id="leftImage">-->

<header>

    <!--<h1><?php
    /*                getUserName($_SESSION["email"]);
                */?>
        </h1>-->

    <nav>
        <ul>
            <li> <a href="home.php">Home</a> </li>
            <li> <a href="#">Groups</a> </li>
            <li> <a href="#">Matches</a></li>
            <li> <a href="nations.php">Participating Nations</a> </li>
            <li> <a href="logout.php">Logout</a> </li>
        </ul>
    </nav>
</header>


<main>

    <h3>List of all nations</h3>

    <table>

    <?php

    $result = getAllNations();

    if(mysqli_fetch_array($result)>0){

        $counter = 0;

        while($row = mysqli_fetch_row($result)){

            $counter++;

            ?>

            <tr>

                <td>
                    <?php
                        echo $counter.".";
                    ?>
                </td>

                <td>
                    <?php
                    echo '<img src="assets/images/flags/'.$row['nationName'].'.jpg" class="Flag">';
                    ?>
                </td>

                <td>
                    <?php
                    echo $row['nationName'];
                    ?>
                </td>



            </tr>

            <?php
        }
    }
    ?>

    </table>


    <img src="assets/images/flags/Albania.jpg" class="Flag">
    <img src="assets/images/flags/Northern_Ireland.jpg" class="Flag">
</main>

</body>
</html>