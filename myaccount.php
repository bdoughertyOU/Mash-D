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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>


$(document).on('click', '.loadmorefeed', function() {
    $.ajax({url:"vinelibs/vineajax.php",success:function(result){
      $("#myDiv").html(result);
      var elem = document.getElementById('ajaxbutton1');
    elem.parentNode.removeChild(elem);
    }});
  });

$(document).on('click', '.loadMoreFeed', function() {
    pageNum = parseFloat($('.myDiv').last().attr('data'));
    newPageNum = pageNum + 1;
    $.ajax({url:"instagramlibs/instagram_load_more_feed_ajax.php",success:function(result){
      $('div.myDiv[data="' + pageNum + '"]').after("<div class='myDiv' data='" + newPageNum + "'>&nbsp</div>");
      $('div.myDiv[data="' + newPageNum + '"]').html(result);
    }});
  });

$(document).on('click', '.instaComments', function() {
    var currentDiv, pageValue, newPage, newPageid;
    currentDiv = $(this).attr('group');
    pageValue = parseFloat($(this).attr('data'));
    newPage = pageValue + 5 ;
    newPageid =  '.' + pageValue;
    $.ajax({url:"instagramlibs/instagramcommentsajax.php",
           type:'POST',              
       dataType:'text',
           data: {id: currentDiv,
                  page: pageValue},
        success:function(result){
          $('div[group="' + currentDiv + '"] .commentsContainer > div:first-child').before("<div class='" + pageValue + "'>&nbsp</div>");
       $('div[group="' + currentDiv + '"] ' + newPageid).html(result);
       $('button[group="' + currentDiv + '"]').attr('data', newPage);
       $('button[group="' + currentDiv + '"]').off();
    }});
});

$(document).on('click', '.ajaxcommentbutton1', function() {
    var currentDiv, pageValue, newPage, newPageid;
    currentDiv = $(this).attr('group');
    pageValue = parseFloat($(this).attr('data'));
    newPage = pageValue + 1;
    newPageid =  '.' + newPage;
    $.ajax({url:"vinelibs/vinecommentsajax.php",
           type:'POST',              
       dataType:'text',
           data: {id: currentDiv,
                  page: newPage},
        success:function(result){
          $('div[data="' + currentDiv + '"] .commentsContainer > div:first-child').before("<div class='" + newPage + "'>&nbsp</div>");
       $('div[data="' + currentDiv + '"] ' + newPageid).html(result);
       $('button[group="' + currentDiv + '"]').attr('data', newPage);
       $('button[group="' + currentDiv + '"]').off();
    }});
});

$(document).on('click', '.twitterComments', function() {
    var currentDiv, pageValue, newPage, newPageid;
    posterScreenName = $(this).attr('data');
    postId = $(this).attr('data-id');
    $.ajax({url:"twitterlibs/twittercommentsajax.php",
           type:'POST',              
       dataType:'text',
           data: {poster: posterScreenName,
                  post: postId},
        success:function(result){
          $('div[data-id="' + postId + '"] .twitterCommentContainer').html(result);
          
    }});
});


</script>
</head>

<body>
<section>
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
      <p>&nbsp;</p>
      </section>
    <section>
      <h3 class="titlehdr">Welcome <?php echo $_SESSION['user_name'];?></h3>  
	  <?php	
      if (isset($_GET['msg'])) {
	  echo "<div class=\"error\">$_GET[msg]</div>";
	  }

	  	  
	  ?>
   <pre><?php #print_r($_SESSION); ?><br/>
    <?php #print_r($_COOKIE); ?></pre>
<div class="myDiv" data="1">
<!--##############################################################################-->  
<!--###########################FaceBook Inject####################################--> 
<?php include 'facebook_parse.php';?> 

<!--##############################################################################-->  
<!--###########################Instagram Inject###################################--> 
<?php #include 'instagram_parse.php';?>

<!--##############################################################################-->  
<!--###########################Twitter Inject#####################################--> 
<?php #include 'twitter_parse.php';?>

<!--##############################################################################-->  
<!--###########################Vine Inject#####################################--> 
<?php #include 'vinelibs/vine_parse.php';  ?>
</div>
  </section>

<button type="button" class="loadMoreFeed">Request data</button>

</body>
</html>
