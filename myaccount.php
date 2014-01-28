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
<script>
<?php 
$vine = new Vine;
$key = $_SESSION['vine_key'];
$userId = $_SESSION['vine_userid'];
$records = $vine->vineTimeline($userId,$key);
$page = $records['data']['nextPage'];
$anchor = $records['data']['anchorStr'];
?>
function loadXMLDoc()
{
var xmlhttp,vineKey,link;
vineKey = "<?php echo $_SESSION['vine_key']; ?>";
page = "<?php echo $page?>";
timelineId = "<?php echo $anchor?>";

link ="https://api.vineapp.com/timelines/graph?page=" + page + "&anchor=" + timelineId;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET",link,true);
xmlhttp.setRequestHeader("vine-session-id",'Origin:vine.co, Accept: application/json, text/javascript, */*; q=0.01,x-vine-client: vinewww/1.0, vine-session-id: ' + vineKey + ', X-Requested-With: XMLHttpRequest');
xmlhttp.send();
}
</script>
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
<?php include 'vine_parse.php';  ?>
<button type="button" onclick="loadXMLDoc()">Request data</button>
<div id="myDiv"></div>
      </td>
    <td width="196" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3"></td>
  </tr>
</table>

</body>
</html>
