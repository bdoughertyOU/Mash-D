<?php 
include 'dbc.php';
page_protect();
include 'facebooklibs/auth.php';
include 'instagramlibs/instagramAuth.php';
include 'twitterlibs/twitterauth.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>My Account</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

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
    <pre><?php print_r($_SESSION); ?><br/>
    <?php print_r($_COOKIE); ?></pre>
<!--##############################################################################-->  
<!--###########################FaceBook Inject####################################--> 
<?php include 'facebook_parse.php';?> 

<!--##############################################################################-->  
<!--###########################Instagram Inject###################################--> 
<?php include 'instagram_parse.php';?>

<!--##############################################################################-->  
<!--###########################Twitter Inject#####################################--> 
<?php 
if (isset ($_SESSION['access_token'])){
$access_token = $_SESSION['access_token'];

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$method = 'statuses/home_timeline';
$the_response = $connection->get($method);
foreach ($the_response as $twitter){
  $id = $twitter->id_str;
    $comments_method = 'expanded/batch/$id?include_entities=true&include_rts=true&count=7';
    $comments = $connection->get($comments_method);
    if (isset($twitter->retweeted_status)){
      $img = $twitter->retweeted_status->user->profile_image_url;
      $retweeter = $twitter->user->name;
      $user_name = $twitter->retweeted_status->user->name;
      $user_profile_name = $twitter->retweeted_status->user->screen_name;
      $tweet = $twitter->retweeted_status->text;
      $match = preg_match('/http:\/\/t.co([^ ]+)/', $tweet);
      if ($match === 1){
        if(!empty($twitter->entities->urls)){
          foreach($twitter->entities->urls as $urlss){
            $the_url = $urlss->url;
            $the_new_url = "<a href='$urlss->expanded_url' >" .  $urlss->display_url . "</a>";
          $tweet = str_replace($the_url, $the_new_url, $tweet);
          }
        }
        if(isset($twitter->entities->media)){
         foreach($twitter->entities->media as $other_urls){
            $the_url = $other_urls->url;
            $the_new_url = "<a href='$other_urls->expanded_url' >" .  $other_urls->display_url . "</a>";
          $tweet = str_replace($the_url, $the_new_url, $tweet);
          }
        }

      }
      echo "Retweeted by " . $retweeter . "<br/>";
      echo "<img src='$img'>";
      echo " " . $user_name;
      echo " @" . $user_profile_name;
      echo "<br/>";
      echo $tweet;
      echo "<br/>";
      if(isset($twitter->entities->media)){
        foreach($twitter->entities->media as $the_media){
          $some_media = $the_media->media_url;
          echo "<img src='$some_media'>";
        } 
      }
    }else{
      $img = $twitter->user->profile_image_url;
      $user_name = $twitter->user->name;
      $user_profile_name = $twitter->user->screen_name;
      $tweet = $twitter->text;
      $match = preg_match('/http:\/\/t.co([^ ]+)/', $tweet);
      if ($match === 1){
        if(!empty($twitter->entities->urls)){
          foreach($twitter->entities->urls as $urlss){
            $the_url = $urlss->url;
            $the_new_url = "<a href='$urlss->expanded_url' >" .  $urlss->display_url . "</a>";
          $tweet = str_replace($the_url, $the_new_url, $tweet);
          }
        }
        if(isset($twitter->entities->media)){
         foreach($twitter->entities->media as $other_urls){
            $the_url = $other_urls->url;
            $the_new_url = "<a href='$other_urls->expanded_url' >" .  $other_urls->display_url . "</a>";
          $tweet = str_replace($the_url, $the_new_url, $tweet);
          }
        }
      }
      echo "<img src='$img'>";
      echo " " . $user_name;
      echo " @" . $user_profile_name;
      echo "<br/>";
      echo $tweet;
      echo "<br/>";
      echo $twitter->media;
      if(isset($twitter->entities->media)){
        foreach($twitter->entities->media as $the_media){
          $some_media = $the_media->media_url;
          echo "<img src='$some_media'>";
        } 
      }
    }
    echo "<br/>";
    print_r($twitter);
    echo "<br/><br/>";
    var_dump($comments);
    echo "<br/><br/>";
  }
}
?>
      </td>
    <td width="196" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3"></td>
  </tr>
</table>

</body>
</html>
