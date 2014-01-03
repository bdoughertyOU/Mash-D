<?php 
include 'dbc.php';
include 'facebooklibs/auth.php';
page_protect();




?>
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
  <a href="myaccount.php">My Account</a><br>
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
      
      <p>
        <h3>PHP Session</h3>
    <pre><?php print_r($_SESSION); ?></pre>
  
  <!--/***********************************************facebook stuff*****/-->    

<?php if (empty($user)): ?>
 
<!--auth user////////////////////////////
  //could possibly have the sync links on the home page if the user does not have any accounts linked

  //this is just a fb login redirect
   //$dialog_url = 'https://www.facebook.com/dialog/oauth?client_id=' 
    //. $app_id . '&redirect_uri=' . urlencode($my_url) ;
    
    // echo("<script>top.location.href='" . $dialog_url . "'</script>"); -->
  <p>please sync your accounts, go to the "Social Accounts" tab.</p>

 <?php endif ?>
 <?php if ($user){

  $config = array(
  'appId'  => '464235817026185',
  'secret' => 'cc0dfb735ef12d40c59dc83fa7493efd',
  'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
  );

  $facebook = new Facebook($config);
  $user_id = $facebook->getUser();
if($user_id) {

      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.

  /////////////////////////////
  /////////////////////
  ///////////////////////// calling api call for users feed, printing out to mashd ui
        $ret_obj = $facebook->api('/me/home', 'GET');
        echo count($ret_obj['data']); // this is uneccesary just for testing
        
        $i=0;
        
        $count = count($ret_obj['data']);
        while($i < $count){
          
          $data = $ret_obj['data'][$i];

          echo "<br/> -----------<span class=\"fbname\">" . 
          $data[from][name] . 
          "</span> at " . 
          $data[place][name] . #need conditional for placing the "at" in for location.
          "<br/>" . 
          $data[message] . 
          "<br/>" . 
          $data[picture] . ##look into how to upload photos
          "<br/>";
         
          $i++;
        }
        
      
}
}
?>

  <!--/*********************************************** End facebook stuff*****/-->

</p>


	 
      </td>
    <td width="196" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3"></td>
  </tr>
</table>

</body>
</html>
