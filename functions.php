<?php
/**
 * Created by PhpStorm.
 * User: Christophe
 * Date: 25/05/2016
 * Time: 15:02
 */

include("dbConnection.php");


function user_registered($email,$password) {
    //test to discover if the user is already in the DB
    //to do that, we can find out if the email address already exists in any row

    include("db_connection.php");


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