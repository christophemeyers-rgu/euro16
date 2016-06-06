<?php
/**
 * Created by PhpStorm.
 * User: Christophe
 * Date: 25/05/2016
 * Time: 15:02
 */

//include("dbConnection.php");




function userRegistered($email,$password) {
    //test to discover if the user is already in the DB
    //to do that, we can find out if the email address already exists in any row

//    include("db_connection.php");
    echo "<script>alert('Test 1');</script>";

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

        echo "<script>alert('Test 2');</script>";


        //select all values from database using the entered values as filter
        $query="SELECT email, password
					FROM users
					WHERE email = ? AND password = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ss",$email,$password);
        $stmt->execute() or die("Error: ".$query."<br>".$db->error);



        if(mysqli_stmt_fetch($stmt)){	//if the sql query returns a value
            echo "<script>alert('Test 3');</script>";

            return TRUE; 	//indicate that a value was returned, and user exists in database

        }
        else{
            echo "<script>alert('Test 4');</script>";

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
