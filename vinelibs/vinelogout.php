<?php  
session_start();
unset($_SESSION['vine_key']);
unset($_SESSION['vine_userid']);
header("Location: http://localhost/mashd/Mash-D/social.php");
?>