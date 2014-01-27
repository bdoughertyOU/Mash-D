<?php 
include 'dbc.php';
page_protect();
include 'facebooklibs/auth.php';
include 'instagramlibs/instagramAuth.php';
include 'twitterlibs/twitterauth.php';
include 'vinelibs/vine.php';

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
<?php #include 'facebook_parse.php';?> 

<!--##############################################################################-->  
<!--###########################Instagram Inject###################################--> 
<?php #include 'instagram_parse.php';?>

<!--##############################################################################-->  
<!--###########################Twitter Inject#####################################--> 
<?php #include 'twitter_parse.php';?>

<!--##############################################################################-->  
<!--###########################Vine Inject#####################################--> 
<?php 

$vine = new Vine;


$username = 'jillianmyla@aol.com';
$password = 'glennn11';

$key = $vine->vineAuth($username,$password);

$userId = strtok($key,'-');


$records = $vine->vineTimeline($userId,$key);


foreach($records['data']['records'] as $vines){
  $poster_if_revined = $vines['repost']['username'];
  $original_poster_avatar = $vines['avatarUrl'];
  $original_poster_username = $vines['username'];
  $description = $vines['description'];
  $likes= $vines['likes']['count'];
  $revines = $vines['reposts']['count'];
  $num_comments = $vines['comments']['count'];
if(isset($poster_if_revined)){
  echo $poster_if_revined . " revined";
}
  echo "<br/>";

echo "<img src='$original_poster_avatar' height = 50px width = 50px> ";
echo $original_poster_username;
echo "<br/>";
$video = $vines['videoUrl'];
                               
echo "<video width='350' height='350' controls>
<source src='$video'>
<object data='$video' width='350' height='350'></object>
</video>";
echo "<br/>";
echo $description;
echo "<br/>";
if(!empty($likes)){
      $num_likes = (int)str_replace(' ', '', $likes);
      if($num_likes > 1){
  echo $likes . " Likes ";
  }else{
    echo $likes . 'like';
  }
}
if(!empty($revines)){
  $num_revines = (int)str_replace(' ', '', $revines);
      if($num_revines > 1){
  echo $revines . " Revines ";
  }else{
    echo $revines . ' Revine';
  }
}
if(!empty($num_comments)){
  $num_of_comments = (int)str_replace(' ', '', $num_comments);
  if($num_of_comments > 1){
  echo $num_comments . " Comments ";
  }else{
    echo $num_comments . ' Comment';
  }
}

    echo "<br/><br/>";
}?>
      </td>
    <td width="196" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3"></td>
  </tr>
</table>

</body>
</html>
