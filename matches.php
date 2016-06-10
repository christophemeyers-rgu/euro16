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

//GET when accessed through URL
if($_SERVER['REQUEST_METHOD']==='GET'){

    $success = $_GET["Success"];
    if($success=="Yes"){
        echo "<SCRIPT>alert('Bets were successfully updated!');</SCRIPT>";
    }
    elseif($success=="No"){
        echo "<script>alert('Why would you just enter *No* into the url?');</script>";
    }
}
elseif($_SERVER['REQUEST_METHOD']==='POST'){	//Post is used when the form is submitted

    /*foreach($_POST["input"] as $input){
        //process invite
        echo "{$input['betA']} - {$input['betB']} was bet for match of id {$input['matchID']}. <br />";


    }*/

    makeBets();

}

unlockedForBetting();

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

                        if($matchesRow["unlockedForBetting"]){
                            $disabled = 'disabled';
                        }
                        else{
                            $disabled = '';
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
                                <?php
                                if(isset($bets)){
                                    $betA = $bets["teamABet"];
                                    ?>
                                    <input class="bet" type="number" name="input[<?php echo $counter; ?>][betA]" value="<?php echo $betA; ?>" <?php echo $disabled; ?>>
                                    <?php
                                }
                                else{
                                    ?>
                                    <input class="bet" type="number" name="input[<?php echo $counter; ?>][betA]" <?php echo $disabled; ?>>
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
                                    <input class="bet" type="number" name="input[<?php echo $counter; ?>][betB]" value="<?php echo $betB; ?>" <?php echo $disabled; ?>>
                                    <?php
                                }
                                else{
                                    ?>
                                    <input class="bet" type="number" name="input[<?php echo $counter; ?>][betB]" <?php echo $disabled; ?>>
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
                        <input hidden type="number" value="<?php echo $matchesRow["matchID"]; ?>" name="input[<?php echo $counter; ?>][matchID]">
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
