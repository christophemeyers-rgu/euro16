<?php
/**
 * Created by PhpStorm.
 * User: Christophe
 * Date: 05/06/2016
 * Time: 19:58
 */

include("functions.php");

session_start();
if(!isset($_SESSION['email'])){
    header("Location: login.php");
}

if($_SERVER['REQUEST_METHOD']==='GET'){

    $success = $_GET["Joined"];
    if($success=="Yes"){
        echo "<SCRIPT>alert('You have successfully joined a group!');</SCRIPT>";
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


    <title>My Groups</title>
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

            $userID = getUserID($_SESSION["email"]);
            $groupsResult = getMyGroups($userID);

            if(mysqli_num_rows($groupsResult)>0){



                while($groupsRow = mysqli_fetch_array($groupsResult)){

                    $groupID = $groupsRow["groupID"];

                    $groupName = getGroupName($groupID);

                    ?>

                    <h3>
                        <?php
                        echo $groupName;
                        ?>
                    </h3>

                    <table>
                        <tr>
                            <th>
                                Name
                            </th>
                            <th>
                                Points
                            </th>
                        </tr>
                        <?php

                        $membersResult = getGroupMembers($groupID);

                        if(mysqli_num_rows($membersResult)>0){

                            $counter = 0;

                            while($membersRow = mysqli_fetch_array($membersResult)){

                                $counter++;

                                $membersArray[] = array('ID' => $membersRow["userID"], 'score' => countPoints(getUserEmail($membersRow["userID"])));

                            }

                            foreach($membersArray as $key => $row){
                                $ID[$key] = $row['ID'];
                                $score[$key] = $row['score'];
                            }

                            array_multisort($score, SORT_DESC, $membersArray);

                            for($i=0; $i<$counter; $i++){
                                ?>
                                <tr>
                                    <td>
                                        <a href="opponentBets.php?Opponent=<?php echo $membersRow["userID"];?>">
                                            <?php
                                            getUserName(getUserEmail($membersArray[$i][0]));
                                            ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php
                                        echo $membersArray[$i][1];
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>

                    <?php

                }
            }
            ?>




    </div>

</main>

</body>
</html>

