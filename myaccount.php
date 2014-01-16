<?php 
include 'dbc.php';
page_protect();
include 'facebooklibs/auth.php';

/*
 * Instagram PHP API
 * 
 * @link https://github.com/cosenary/Instagram-PHP-API
 * @author Christian Metz
 * @since 01.10.2013
 */

require_once 'instagramlibs/instagram.class.php';

// initialize class
$instagram = new Instagram(array(
  'apiKey'      => 'af0092092bd347f2948940ef30261dcc',
  'apiSecret'   => '12b2d103aa884b9c9a4bf377ad4cf279',
  'apiCallback' => 'http://localhost/Mashd/Mash-D/myaccount.php' // must point to success.php
));


// check whether the user has granted access
if (isset($_COOKIE['instagram'])) {

  // receive OAuth token object
    // store user access token
  $data = $instagram->setAccessToken($_COOKIE['instagram']);
$ig_username = $instagram-> getUser();

  // now you have access to all authenticated user methods
  $result = $instagram->getUserFeed(15);

}elseif (isset($_GET['code'])) {

  // receive OAuth token object
  $data = $instagram->getOAuthToken($_GET['code']);
  $username = $instagram-> getUser();
 
  // store user access token
  $ig_instagram->setAccessToken($data);

  // now you have access to all authenticated user methods
  $result = $instagram->getUserFeed(15);

} else {

  // check whether an error occurred
  if (isset($_GET['error'])) {
    echo 'An error occurred: ' . $_GET['error_description'];
  }

}







?>
<!DOCTYPE html>
<html>
<head>
<title>My Account</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="main">
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td width="160" valign="top">
<?php 
/*********************** MYACCOUNT MENU ****************************
This code shows my account menu only to logged in users. 
Copy this code till END and place it in a new html or php where
you want to show myaccount options. This is only visible to logged in users
*******************************************************************/
if (isset($_SESSION['user_id'])) {?>
<div class="myaccount">
  <p><strong>My Account</strong></p>
  <a href="####">#####</a><br>
  <a href="mysettings.php">Settings</a><br>
    <a href="logout.php">Logout </a><br>
     <a href="social.php">Social Accounts</a>
	
  <p>You can add more links here for users</p></div>
<?php }
if (checkAdmin()) {
/*******************************END**************************/
?>
      <p> <a href="account/admin.php">Admin CP </a></p>
	  <?php } ?>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    <td width="732" valign="top"><p>&nbsp;</p>
      <h3 class="titlehdr">Welcome <?php echo $_SESSION['user_name'];?></h3>  
	  <?php	
      if (isset($_GET['msg'])) {
	  echo "<div class=\"error\">$_GET[msg]</div>";
	  }
	  	  
	  ?>
<!--#############################################################################-->  
<!--###########################FaceBook Inject###################################--> 
<?php #include 'facebook_parse.php';?> 

<!--#############################################################################-->  
<!--###########################Instagram Inject###################################--> 
<?php if (empty($ig_username)): ?>
  <pre><?php print_r($_SESSION); ?></pre>
<?php print_r($_COOKIE); ?>
  <?php endif ?>
 <?php if (isset($ig_username)): ?> 
<pre><?php print_r($_SESSION); ?></pre>
<?php print_r($_COOKIE); ?>
 <img src="instagramlibs/example/assets/instagram.png" alt="Instagram logo">
        <h1><span><?php echo $ig_username->data->username ?></span>'s Instagram feed</h1>
      </header>
      <div class="main"><?php print_r($result->data);?>
        <ul class="grid">
        <?php
          // display all user likes
          foreach ($result->data as $media) {
            $content = "<li>";
            $profilepic = $media->user->profile_picture;
            $igposter = $media->user->username;
            echo "<span><img src ='$profilepic' width='55' height='55'/><p>$igposter</p></span><br/>";
            // output media
            if ($media->type === 'video') {
              // video
              $poster = $media->images->low_resolution->url;
              $source = $media->videos->standard_resolution->url;
              $content .= "<video  width=\"250\" height=\"250\" controls>
                             <source src=\"{$source}\" type=\"video/mp4\" />
                             <object data=\"{$source}\" width=\"250\" height=\"250\"></object>
                           </video>";
            } else {
              // image
              $image = $media->images->standard_resolution->url;
              $content .= "<img class=\"media\" src=\"{$image}\"/>";
            }
            
            // create meta section
            $username = $media->user->username;
            
            if(!empty($media->caption->text)){
            $content .= "<div class=\"content\">
                           <div class=\"comment\">{$media->caption->text}</div>
                         </div>";
            }
            // output media
            echo $content . "</li>";
          }
        ?>
        <?php endif ?>
	 
      </td>
    <td width="196" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3"></td>
  </tr>
</table>

</body>
</html>
