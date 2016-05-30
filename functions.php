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

    $result = $db->query($nationquery);

    $db->close();

    return $result;
}

function getFlag($name){



}