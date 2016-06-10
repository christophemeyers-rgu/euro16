<?php
/**
 * Created by PhpStorm.
 * User: Christophe
 * Date: 09/06/2016
 * Time: 23:38
 */

include("functions.php");

session_start();
if(!isset($_SESSION['email'])){
    header("Location: login.php");
}

if($_SERVER['REQUEST_METHOD']==='POST'){	//Post is used when the form is submitted

    $i = 0;
    foreach($_POST["betA"] as $a){
        //process invite
        $i++;
        echo "{$a} was bet {$i} for team A. <br />";
    }
    $j = 0;
    foreach($_POST["betB"] as $b){
        $j++;
        echo "{$b} was bet {$j} for team B. <br />";
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

                        $bets = getBets($matchesRow["matchID"],$_SESSION["email"]);

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
                                <?php
                                if(isset($bets)){
                                    $betA = $bets["teamABet"];
                                    ?>
                                    <input class="bet" type="number" name="betA[<?php echo $matchesRow["matchID"]; ?>]" value="<?php echo $betA; ?>">
                                    <?php
                                }
                                else{
                                    ?>
                                    <input class="bet" type="number" name="betA[<?php echo $matchesRow["matchID"]; ?>]">
                                    <?php
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $goalsA.":".$goalsB;
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($bets)){
                                    $betB = $bets["teamBBet"];
                                    ?>
                                    <input class="bet" type="number" name="betB[<?php echo $counter; ?>]" value="<?php echo $betB; ?>">
                                    <?php
                                }
                                else{
                                    ?>
                                    <input class="bet" type="number" name="betB[<?php echo $counter; ?>]">
                                    <?php
                                }
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
            <input type="submit" value="Submit Bets">
        </form>



    </div>

</main>

</body>
</html>
