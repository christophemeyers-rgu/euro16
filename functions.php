<?php
/**
 * Created by PhpStorm.
 * User: Christophe
 * Date: 25/05/2016
 * Time: 15:02
 */

//include("dbConnection.php");


function createUser(){

    $db = new MySQLi(
        'ap-cdbr-azure-east-c.cloudapp.net', //server or host address
        'b27f975a706fe7', //username for connecting to database
        '078b0d65', //user's password
        'meyerseuro16bets' //database being connected to
    );

    if($db->connect_errno){		//check if there was a connection error and respond accordingly
        die('Connection failed:'.connect_error);
    }
    else{

        //read input details from index.php
        $email=$_POST['email'];




        //create select statement to using firstname and surname as filters
        $query="SELECT email
				FROM users
				WHERE email ='$email'
			    LIMIT 1";

        //check to see that sql query executes properly, and return any errors
        $output=$db->query($query) or die("Error: ".$query."<br>".$db->error);

        $return=NULL;

        //go through the array of results returned from the query if any
        while($row = $output->fetch_assoc()) {
            $return=$row["email"];//add the email value to the return variable
        }

        //if $return is no longer NULL, then it means user exists already
        if(isset($return)){
            header("Location: createAccount.php?Success=No");
        }
        else{
            //create user in database if they dont exists there already
            $firstname=$_POST['firstname'];
            $surname=$_POST['surname'];
            $password=$_POST['password'];
            $score=0;


            $insert="INSERT INTO users (email, password, firstname, surname, score)
				VALUES('".$email."','".$password."','".$firstname."','".$surname."','".$score."')";

            /*$stmt = $db->prepare($insert);
            $stmt->bind_param("s",$salt);
            $stmt->execute() or die("Error: ".$insert."<br>".$db->error);*/


            $outcome=$db->query($insert) or die("Error: ".$insert."<br>".$db->error);

            header("Location: login.php?Success=Yes");

            emailRegisteredUser();//call the function "emailRegisteredUser()"

            $db->close();
        }
    }
}

//email to volunteer function
function emailRegisteredUser(){

    //setting some variables with form values
    $firstname = $_POST["firstname"];
    $surname = $_POST["surname"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $name = $firstname . " " . $surname;

    //email subject
    $subject = "Meyers' Euro16 Bets - Registration Confirmation";


    //email body in html
    //ATTENTION, THE LINK MAY POINT TO THE MASTER DOMAIN, RATHER THAN YOUR OWN VOLUNTEERLOGIN.PHP
    $txt = "Dear $name,
					<br><br>
					This is to confirm your registration for the Meyers' Euro16 Bets system.
					<br><br>
                    This is the explanation of the rules.
					<br><br>
					Best of luck,
					<br><br>
					Meyers' Euro16 Bets Team
					<br>
					Chris Meyers";


    //take in the necessary swiftmailer code
    require_once 'swiftmailer/lib/swift_required.php';

    //this is all swiftmailer magic, using the gmail smtp server of my account...
    $transporter = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
        ->setUsername('christophe.meyers.312@gmail.com')
        ->setPassword('AnnachengAddress');

    //Creates an instance of the mailer
    $mailer = Swift_Mailer::newInstance($transporter);

    //the message supplies some more detailed info
    $message = Swift_Message::newInstance("Meyers' Euro16 Bets - Registration Confirmation")
        ->setFrom(array('christophe.meyers.312@gmail.com' => 'Chris Meyers'))	//shows my name when email arrives
        ->setTo(array($email => $name))	//shows volunteer name as linked to their email address
        ->setBody($txt, "text/html");	//tells swiftmailer that we're using html text

    //Finally the mail is sent
    $result = $mailer->send($message);


}

function userRegistered($email,$password) {
    //test to discover if the user is already in the DB
    //to do that, we can find out if the email address already exists in any row

//    include("db_connection.php");

    $db = new MySQLi(
        'ap-cdbr-azure-east-c.cloudapp.net', //server or host address
        'b27f975a706fe7', //username for connecting to database
        '078b0d65', //user's password
        'meyerseuro16bets' //database being connected to
    );

    if($db->connect_errno){		//check if there was a connection error and respond accordingly
        die('Connection failed:'.connect_error);
    }
    else{

        //select all values from database using the entered values as filter
        $query="SELECT email, password
					FROM users
					WHERE email = ? AND password = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ss",$email,$password);
        $stmt->execute() or die("Error: ".$query."<br>".$db->error);



        if(mysqli_stmt_fetch($stmt)){	//if the sql query returns a value
            return TRUE; 	//indicate that a value was returned, and user exists in database
        }
        else{
            return FALSE; //indicate a value wasn't returned, and user doesn't exist in database
        }
        $db->close(); // Closing Connection
    }

}

function getUserName($email){

//    include("db_connection.php");   //connect to database

    $db = new MySQLi(
        'ap-cdbr-azure-east-c.cloudapp.net', //server or host address
        'b27f975a706fe7', //username for connecting to database
        '078b0d65', //user's password
        'meyerseuro16bets' //database being connected to
    );

    if($db->connect_errno){
        die('Connectfailed['.$db->connect_error.']');   //if connection fails, return error
    }

    $namequery = "SELECT firstname, surname
                  FROM users
                  WHERE email='$email'";  //query for getting name

    $result = $db->query($namequery);

    $row = $result->fetch_array();

    $firstname = $row['firstname'];
    $surname = $row['surname'];

    $db->close();

    echo "{$firstname} {$surname}";   //the function prints the name
}

function getAllNations(){

    $db = new MySQLi(
        'ap-cdbr-azure-east-c.cloudapp.net', //server or host address
        'b27f975a706fe7', //username for connecting to database
        '078b0d65', //user's password
        'meyerseuro16bets' //database being connected to
    );

    if($db->connect_errno){
        die('Connectfailed['.$db->connect_error.']');   //if connection fails, return error
    }

    $nationquery = "SELECT *
                    FROM nations";

    $result = $db->query($nationquery) or die("Error: ".$nationquery."<br>".$db->error);

    $db->close();

    return $result;
}

function getAllMatches(){

    $db = new MySQLi(
        'ap-cdbr-azure-east-c.cloudapp.net', //server or host address
        'b27f975a706fe7', //username for connecting to database
        '078b0d65', //user's password
        'meyerseuro16bets' //database being connected to
    );

    if($db->connect_errno){
        die('Connectfailed['.$db->connect_error.']');   //if connection fails, return error
    }

    $matchquery = "SELECT *
                   FROM matches";

    $result = $db->query($matchquery) or die("Error: ".$matchquery."<br>".$db->error);

    $db->close();

    return $result;
}

function getNation($id){

    $db = new MySQLi(
        'ap-cdbr-azure-east-c.cloudapp.net', //server or host address
        'b27f975a706fe7', //username for connecting to database
        '078b0d65', //user's password
        'meyerseuro16bets' //database being connected to
    );

    if($db->connect_errno){
        die('Connectfailed['.$db->connect_error.']');   //if connection fails, return error
    }

    $nationquery = "SELECT *
                    FROM nations
                    WHERE nationID = $id";

    $result = $db->query($nationquery) or die("Error: ".$nationquery."<br>".$db->error);

    $db->close();

    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_array($result)){
            return $row;
        }
    }
}

function getResult($id){

    $db = new MySQLi(
        'ap-cdbr-azure-east-c.cloudapp.net', //server or host address
        'b27f975a706fe7', //username for connecting to database
        '078b0d65', //user's password
        'meyerseuro16bets' //database being connected to
    );

    if($db->connect_errno){
        die('Connectfailed['.$db->connect_error.']');   //if connection fails, return error
    }

    $resultQuery = "SELECT *
                    FROM results
                    WHERE matchID=$id";

    $result = $db->query($resultQuery) or die("Error: ".$resultQuery."<br>".$db->error);

    $db->close();

    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_array($result)){
            return $row;
        }
    }
    else{
        return NULL;
    }

}

function getBets($matchID,$userEmail){

    $db = new MySQLi(
        'ap-cdbr-azure-east-c.cloudapp.net', //server or host address
        'b27f975a706fe7', //username for connecting to database
        '078b0d65', //user's password
        'meyerseuro16bets' //database being connected to
    );

    if($db->connect_errno){
        die('Connectfailed['.$db->connect_error.']');   //if connection fails, return error
    }



    $betQuery = "SELECT *
                 FROM bets
                 WHERE matchID=$matchID
                 AND userID= (SELECT userID
                              FROM users
                              WHERE email = '$userEmail')";

    $result = $db->query($betQuery) or die("Error: ".$betQuery."<br>".$db->error);

    $db->close();

    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_array($result)){
            return $row;
        }
    }
    else{
        return NULL;
    }
}

function makeBets(){

    $db = new MySQLi(
        'ap-cdbr-azure-east-c.cloudapp.net', //server or host address
        'b27f975a706fe7', //username for connecting to database
        '078b0d65', //user's password
        'meyerseuro16bets' //database being connected to
    );

    if($db->connect_errno){		//check if there was a connection error and respond accordingly
        die('Connection failed:'.connect_error);
    }
    else{
        $email = $_SESSION["email"];

        $idQuery = "SELECT userID
                    FROM users
                    WHERE email='$email'";

        $idResult = $db->query($idQuery) or die("Error: ".$idQuery."<br>".$db->error);

        $idRow = $idResult->fetch_assoc(); //get the row out of the table

        $userID = $idRow['userID'];  //There we have it

        $deleteQuery = "DELETE FROM bets
                        WHERE userID = $userID";

        $deleteResult = $db->query($deleteQuery) or die("Error: ".$deleteQuery."<br>".$db->error);

        foreach($_POST["input"] as $input){
            //process invite
            echo "{$input['betA']} - {$input['betB']} was bet for match of id {$input['matchID']}. <br />";

            $betA = $input["betA"];
            $betB = $input["betB"];
            $matchID = $input["matchID"];

            if($betA != NULL){
                if($betB != NULL){
                    $insert = "INSERT INTO bets (userID, matchID, teamABet, teamBBet)
                           VALUES ('".$userID."', '".$matchID."', '".$betA."', '".$betB."')";

                    $outcome = $db->query($insert) or die("Error: ".$insert."<br>".$db->error);
                }
            }


            $betA = NULL;
            $betB = NULL;
        }
    }

    header("Location: matches.php?Success=Yes");

    $db->close();

}

function unlockedForBetting(){

    $db = new MySQLi(
        'ap-cdbr-azure-east-c.cloudapp.net', //server or host address
        'b27f975a706fe7', //username for connecting to database
        '078b0d65', //user's password
        'meyerseuro16bets' //database being connected to
    );

    if($db->connect_errno){		//check if there was a connection error and respond accordingly
        die('Connection failed:'.connect_error);
    }
    else{

        $query = "SELECT matchID
                  FROM matches
                  WHERE (HOUR(TIMEDIFF(NOW(), matchTime)) <= 1)";

        $result = $db->query($query) or die("Error: ".$query."<br>".$db->error);

        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_array($result)){

                $id = $row["matchID"];

                $update = "UPDATE matches
                           SET unlockedForBetting = 0
                           WHERE matchID = $id";

                $res = $db->query($update) or die("Error: ".$update."<br>".$db->error);
            }
        }


    }

    $db->close();

}

function countPoints($email){

    $points = 0;

    $db = new MySQLi(
        'ap-cdbr-azure-east-c.cloudapp.net', //server or host address
        'b27f975a706fe7', //username for connecting to database
        '078b0d65', //user's password
        'meyerseuro16bets' //database being connected to
    );

    if($db->connect_errno){		//check if there was a connection error and respond accordingly
        die('Connection failed:'.connect_error);
    }
    else{
        echo "<SCRIPT>alert('Works 1!');</SCRIPT>";

        $scoreQuery = "SELECT *
                       FROM results";

        $scoreResult = $db->query($scoreQuery) or die("Error: ".$scoreQuery."<br>".$db->error);

        if(mysqli_num_rows($scoreResult)>0){
            echo "<SCRIPT>alert('Works 2!');</SCRIPT>";

            while($scoreRow=mysqli_fetch_array($scoreResult)){
                echo "<SCRIPT>alert('Works in while loop!');</SCRIPT>";


                $scoreDiff = $scoreRow["teamAGoals"] - $scoreRow["teamBGoals"];

                $id = $scoreRow["matchID"];

                echo "<SCRIPT>alert('Works after getting difference of score as {$scoreDiff}!');</SCRIPT>";

                $betsQuery = "SELECT *
                              FROM bets
                              WHERE matchID = $id
                              AND userID= (SELECT userID
                                           FROM users
                                           WHERE email = '$email')";

                $betsResult = $db->query($betsQuery) or die("Error: ".$betsQuery."<br>".$db->error);

                $betsRow = $betsResult->fetch_assoc(); //get the row out of the table

                $betsDiff = $betsRow["teamABets"] - $betsRow["teamBBets"];

                echo "<SCRIPT>alert('Works after getting difference of bets as {$betsDiff}!');</SCRIPT>";

                if($betsDiff==$scoreDiff){
                    echo "<SCRIPT>alert('Works with right difference!');</SCRIPT>";

                    if($betsRow["teamABets"]==$scoreRow["teamAGoals"]) {
                        echo "<SCRIPT>alert('Works with exact score!');</SCRIPT>";

                        $points += 3;

                    }
                    else {
                        $points += 2;
                    }
                }
                elseif(sign($betsDiff)==sign($scoreDiff)){
                    echo "<SCRIPT>alert('Works with right sign!');</SCRIPT>";

                    $points += 1;
                }

                echo "<SCRIPT>alert('Works with this many {$points}!');</SCRIPT>";


            }
        }

    }

    $db->close();

    return $points;
}

function getFlag($id){

    if($id==1){
        echo "<img src='assets/images/flags/Albania.jpg' class='Flag'>";
    }
    elseif($id==2){
        echo "<img src='assets/images/flags/Austria.jpg' class='Flag'>";
    }
    elseif($id==3){
        echo "<img src='assets/images/flags/Belgium.jpg' class='Flag'>";
    }
    elseif($id==4){
        echo "<img src='assets/images/flags/Croatia.jpg' class='Flag'>";
    }
    elseif($id==5){
        echo "<img src='assets/images/flags/Czech_Republic.jpg' class='Flag'>";
    }
    elseif($id==6){
        echo "<img src='assets/images/flags/England.jpg' class='Flag'>";
    }
    elseif($id==7){
        echo "<img src='assets/images/flags/France.jpg' class='Flag'>";
    }
    elseif($id==8){
        echo "<img src='assets/images/flags/Germany.jpg' class='Flag'>";
    }
    elseif($id==9){
        echo "<img src='assets/images/flags/Hungary.jpg' class='Flag'>";
    }
    elseif($id==10){
        echo "<img src='assets/images/flags/Iceland.jpg' class='Flag'>";
    }
    elseif($id==11){
        echo "<img src='assets/images/flags/Italy.jpg' class='Flag'>";
    }
    elseif($id==12){
        echo "<img src='assets/images/flags/Northern_Ireland.jpg' class='Flag'>";
    }
    elseif($id==13){
        echo "<img src='assets/images/flags/Poland.jpg' class='Flag'>";
    }
    elseif($id==14){
        echo "<img src='assets/images/flags/Portugal.jpg' class='Flag'>";
    }
    elseif($id==15){
        echo "<img src='assets/images/flags/Republic_of_Ireland.jpg' class='Flag'>";
    }
    elseif($id==16){
        echo "<img src='assets/images/flags/Romania.jpg' class='Flag'>";
    }
    elseif($id==17){
        echo "<img src='assets/images/flags/Russia.jpg' class='Flag'>";
    }
    elseif($id==18){
        echo "<img src='assets/images/flags/Slovakia.jpg' class='Flag'>";
    }
    elseif($id==19){
        echo "<img src='assets/images/flags/Spain.jpg' class='Flag'>";
    }
    elseif($id==20){
        echo "<img src='assets/images/flags/Sweden.jpg' class='Flag'>";
    }
    elseif($id==21){
        echo "<img src='assets/images/flags/Switzerland.jpg' class='Flag'>";
    }
    elseif($id==22){
        echo "<img src='assets/images/flags/Turkey.jpg' class='Flag'>";
    }
    elseif($id==23){
        echo "<img src='assets/images/flags/Ukraine.jpg' class='Flag'>";
    }
    elseif($id==24){
        echo "<img src='assets/images/flags/Wales.jpg' class='Flag'>";
    }



}



function sign( $number ) {
    return ( $number > 0 ) ? 1 : ( ( $number < 0 ) ? -1 : 0 );
}


?>

<script>
    // When the user clicks on div, open the popup or redirect to createAccount.php
function myFunction() {
    var session = <?php echo json_encode($_SESSION['email']); ?>;
if (typeof session !== 'undefined'){
window.location.assign("http://meyerseuro16bets.azurewebsites.net/createAccount.php")
}
else{
var popup = document.getElementById('myPopup');
popup.classList.toggle('show');
}
}
</script>
