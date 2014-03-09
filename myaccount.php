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

<!--<link href="styles.css" rel="stylesheet" type="text/css">-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link href="css/foundation.min.css" rel="stylesheet" type="text/css">
<link href="css/normalize.css" rel="stylesheet" type="text/css">
<script src="js/foundation.min.js"></script>
<script src="js/foundation.tooltip.js"></script>
<script src="js/modernizr.js"></script>
<link rel="stylesheet" href="css/main.css" />
<script>
  $(function(){
    $(document).foundation();    
  })
</script>
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
<ul class="left options">
  <a href="#" data-dropdown="drop2" class="small radius button dropdown">Account</a><br>
  <ul id="drop2" class="f-dropdown" data-dropdown-content>
  <li><a href="mysettings.php">Settings</a></li>
  <li><a href="social.php">Social Accounts</a></li>
  </ul> 
</ul>
<ul class="right logout">
  <a href="logout.php" data-tooltip class="has-tip tip-bottom small radius button " title='See ya!'>Logout</a>
</ul>

     <h3 id="mashdUser">Mash'D</h3>
 

<!--<?php 
if (isset($_SESSION['user_id'])){

/*********************** MYACCOUNT MENU ****************************
This code shows my account menu only to logged in users. 
Copy this code till END and place it in a new html or php where
you want to show myaccount options. This is only visible to logged in users
*******************************************************************/
$mashdUser = $_SESSION['user_name'];
  }
  # echo "Welcome $mashdUser";
?>
   <pre><?php #print_r($_SESSION); ?><br/>
    <?php #print_r($_COOKIE); ?></pre>-->
<div class="row myDiv" data="1">
  <div class="large-8 large-centered columns mainContainer">
  
  <div id="pic1"></div>
    <div class="brandon">
  <?php 
    include 'mashd.class.php'; 

    if(isset($_SESSION['vine_userid'])||isset($_SESSION['access_token'])||isset($_SESSION['instagram'])||isset($user_id))
    {
  ##############################################################################-->  
    ###########################Vine Inject#####################################--> 
     include 'vinelibs/vine_parse.php';  
    ##############################################################################-->  
    ###########################FaceBook Inject####################################--> 
    include 'facebook_parse.php'; 
    ##############################################################################-->  
    ###########################Instagram Inject###################################--> 
    include 'instagram_parse.php';

    ##############################################################################-->  
    ###########################Twitter Inject#####################################--> 
    #include 'twitter_parse.php';
    #echo "<button type='button' class='loadMoreFeed'>Request data</button>";
  }else{
    echo "<div class='pleaseLogIn'>Please Log into one of your Social accounts!</div>";
  }
  ?>

    
    </div>
  </div>
</div>
  </section>
<script>
$(window).load(function(){
//alert("(window).load was called - window is loaded!");
$('#pic1').hide();
$('.brandon').show();
// get array of elements
var myArray = $(".brandon > div");
var count = 0;

// sort based on timestamp attribute
myArray.sort(function (a, b) {
    
    // convert to integers from strings
    a = parseInt($(a).attr("timestamp"));
    b = parseInt($(b).attr("timestamp"));
    count += 2;
    // compare
    if(a < b) {
        return 1;
    } else if(a > b) {
        return -1;
    } else {
        return 0;
    }
});
// put sorted results back on page
$(".mainContainer").append(myArray);
});</script>
<div class="button-bar secondNav fixed">

    <ul class="button-group radius">
      <li><a href="#" class="tiny small large button">Facebook</a></li>
      <li><a href="#" class="tiny small large button">Twitter</a></li>
      <li><a href="#" class="tiny small large button">Instagram</a></li>
      <li><a href="#" class="tiny small large button">Vine</a></li>
    </ul>
  </div>
</body>
</html>
