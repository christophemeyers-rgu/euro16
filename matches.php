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

        <form action="matches.php" method="post">
            <table>

                <?php

                $matchesResult = getAllMatches();

                if(mysqli_num_rows($matchesResult)>0){

                    $counter = 0;


                    while($matchesRow = mysqli_fetch_array($matchesResult)){

                        $counter++;

                        $nationA = getNation($matchesRow["nationIDA"]);
                        $nationB = getNation($matchesRow["nationIDB"]);

                        $results = getResult($matchesRow["matchID"]);
                        if(isset($results)){
                            $goalsA = $results["teamAGoals"];
                            $goalsB = $results["teamBGoals"];
                        }
                        else{
                            $goalsA = "-";
                            $goalsB = "-";
                        }


                        ?>

                        <tr>
                            <td>
                                <?php
                                echo $matchesRow["matchTime"];
                                ?>
                            </td>
                            <td style="float: right">
                                <?php
                                echo $nationA["nationName"];
                                ?>
                            </td>
                            <td style="text-align: right">
                                <?php
                                getFlag($nationA["nationID"]);
                                ?>
                            </td>
                            <td>
                                <input class="bet" type="number" name="betA[<?php echo $counter; ?>]">
                            </td>
                            <td>
                                <?php
                                echo $goalsA.":".$goalsB;
                                ?>
                            </td>
                            <td>
                                <input class="bet" type="number" name="betB[<?php echo $counter; ?>]">
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
            <input type="submit" value="Submit Bets">
        </form>



    </div>

</main>

</body>
</html>
