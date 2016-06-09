<?php
/**
 * Created by PhpStorm.
 * User: Christophe
 * Date: 09/06/2016
 * Time: 23:38
 */

include("functions.php");

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

        <h3>List of all matches</h3>

        <table>

            <?php

            $matchesResult = getAllMatches();

            if(mysqli_num_rows($matchesResult)>0){



                while($matchesRow = mysqli_fetch_array($matchesResult)){

                    $nationA = getNation($matchesRow["nationIDA"]);
                    $nationB = getNation($matchesRow["nationIDB"]);

                    ?>

                    <tr>
                        <td>
                            <?php
                            echo $matchesRow["matchTime"];
                            ?>
                        </td>
                        <td>
                            <span style="text-align: right">
                                France
                            </span>

                        </td>
                        <td>
                            <?php
                            getFlag($nationA["nationID"]);
                            ?>
                        </td>
                        <td>
                            <?php
                            getFlag($nationB["nationID"]);
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $nationB["nationName"];
                            ?>
                        </td>

                    </tr>

                    <?php
                }
            }
            ?>

        </table>


    </div>

</main>

</body>
</html>
