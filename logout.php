<?php
/**
 * Created by PhpStorm.
 * User: Christophe
 * Date: 26/05/2016
 * Time: 15:39
 */


session_start();
if(session_destroy()){
    header("Location: login.php");
}

?>