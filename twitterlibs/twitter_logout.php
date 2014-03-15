<?php  
session_start();
unset($_SESSION['access_token']);
header("Location: http://localhost/mashd/Mash-D/#/social");
?>