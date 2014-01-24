<?php 

$vine = new Vine;


$username = 'jillianmyla@aol.com';
$password = 'glennn11';

$key = $vine->vineAuth($username,$password);

$userId = strtok($key,'-');


$records = $vine->vineTimeline($userId,$key);
var_dump($records);
?>