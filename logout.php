<?php

include_once('includes/config.php');

session_start();

$id = $_SESSION['login_user_id'];
$query = "update  `users`  set  `check_activity`=0  WHERE id =  '$id' ";
        $results = mysqli_query($mysqli,$query) or die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
        session_destroy();

header("Location: index.php");

?>