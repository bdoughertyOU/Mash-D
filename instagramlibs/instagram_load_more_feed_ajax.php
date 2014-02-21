<?php
session_start();

require 'instagram.class.php';
$instagram = new Instagram(array(
  'apiKey'      => 'af0092092bd347f2948940ef30261dcc',
  'apiSecret'   => '12b2d103aa884b9c9a4bf377ad4cf279',
  'apiCallback' => 'http://localhost/Mashd/Mash-D/social.php' // must point to success.php
));

	$package = $_SESSION['igObject'];
	$comments = $instagram->getMediaComments('658735405901136900_195838440');
	var_dump($comments);
	$result = $instagram->pagination($package, 20);
	$_SESSION['igObject'] = $result; 
	include 'instagram_more_feed_ajax_parse.php';

?>