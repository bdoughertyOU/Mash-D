<?php
	include 'src/facebook.php';
	
	$facebook = new Facebook(array(
  'appId'  => '464235817026185',
  'secret' => 'cc0dfb735ef12d40c59dc83fa7493efd',
));

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $statusUrl = $facebook->getLoginStatusUrl();
  $loginUrl = $facebook->getLoginUrl(array(
  	'scope' => 'read_stream,read_friendlists'
  ));
}

// This call will always work since we are fetching public data.
//$naitik = $facebook->api('/naitik');

?>