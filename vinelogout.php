<?php  
session_start();
unset($_SESSION['vine_key']);
unset($_SESSION['vine_userid']);
header("Location: social.php");
?>