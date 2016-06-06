<?php
/**
 * Created by PhpStorm.
 * User: Christophe
 * Date: 06/06/2016
 * Time: 02:16
 */


session_start();
if(isset($_SESSION['email'])){
    header("Location: home.php");
}

?>




