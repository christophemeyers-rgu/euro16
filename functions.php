<?php
/**
 * Created by PhpStorm.
 * User: Christophe
 * Date: 25/05/2016
 * Time: 15:02
 */

//include("dbConnection.php");


function add_to_database(){

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


            $insert="INSERT INTO volunteers (email, password, firstname, surname, score)
				VALUES('".$email."','".$password."','".$firstname."','".$surname."','".$score."')";

            /*$stmt = $db->prepare($insert);
            $stmt->bind_param("s",$salt);
            $stmt->execute() or die("Error: ".$insert."<br>".$db->error);*/


            $outcome=$db->query($insert) or die("Error: ".$insert."<br>".$db->error);

            header("Location: createAccount.php?Success=Yes");

            emailRegisteredUser();//call the function "emailRegisteredUser()"
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
