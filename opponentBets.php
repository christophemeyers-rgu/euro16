<?php
/**
 * Created by PhpStorm.
 * User: Christophe
 * Date: 13/06/2016
 * Time: 01:15
 */
include("functions.php");

session_start();
if(!isset($_SESSION['email'])){
    header("Location: login.php");
}

if($_SERVER['REQUEST_METHOD']==='GET'){

    $opponentID = $_GET["Opponent"];
    $opponentEmail = getUserEmail($opponentID);

    $userID = getUserID($_SESSION["email"]);
    $userGroupsResult = getMyGroups($userID);

    $joinedInGroup = 0;

    if(mysqli_num_rows($userGroupsResult)>0){

        while($userGroupsRow = mysqli_fetch_array($userGroupsResult)){

            if(partOfSameGroup($userGroupsRow["groupID"], $opponentID)){
                $joinedInGroup = 1;
            }
        }
    }
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


        <?php
        if($joinedInGroup==0){
            ?>
            <p>
                This isn't the page you're looking for.
            </p>
            <?php
        }
        elseif($joinedInGroup==1){
            ?>
            <h3>
                <?php
                getUserName($opponentEmail);
                ?>'s bets:
            </h3>

            <p>
                <?php
                $score = countPoints($opponentEmail);
                echo "Their current score is: ".$score;
                ?>
            </p>
            <p>
                Note: All times are in Central European Time.
            </p>
            <form>
                <table>

                    <?php

                    $matchesResult = getAllMatches();

                    if(mysqli_num_rows($matchesResult)>0){

                        while($matchesRow = mysqli_fetch_array($matchesResult)){

                            if($matchesRow["matchID"]!=171 && $matchesRow["unlockedForBetting"] == FALSE){

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

                                $bets = getBets($matchesRow["matchID"],$opponentEmail);


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
                                            <input class="bet" type="number"  value="<?php echo $betA; ?>" disabled >
                                            <?php
                                        }
                                        else{
                                            ?>
                                            <input class="bet" type="number" disabled >
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
                                            <input class="bet" type="number" value="<?php echo $betB; ?>" disabled >
                                            <?php
                                        }
                                        else{
                                            ?>
                                            <input class="bet" type="number" disabled >
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
                    }
                    ?>
                </table>
            </form>

            <?php
        }
        else{
            ?>
            <p>
                Well this shouldn't happen...
            </p>
            <?php
        }
        ?>






    </div>

</main>

</body>
</html>