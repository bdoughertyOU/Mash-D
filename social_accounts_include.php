  <?php 
include 'dbc.php';
include 'facebooklibs/auth.php';
include 'instagramlibs/instagramAuth.php';
include 'twitterlibs/twitterauth.php';
include 'vinelibs/vine.php';

    include 'mashd.class.php'; 

    if(isset($_SESSION['vine_userid'])||isset($_SESSION['access_token'])||isset($_SESSION['instagram'])||isset($user_id))
    {
     include 'vinelibs/vine_parse.php'; 
     include 'facebook_parse.php'; 
     include 'instagram_parse.php';
     include 'twitter_parse.php';
   // echo "<button type='button' class='loadMoreFeed'>Request data</button>";
    echo "<script>$(document).ready(function(){
      $('#pic1').hide();
      $('.brandon').show();
      // get array of elements
      var myArray = $('.brandon > div');
      var count = 0;

      // sort based on timestamp attribute
      myArray.sort(function (a, b) {
          
          // convert to integers from strings
          a = parseInt($(a).attr('timestamp'));
          b = parseInt($(b).attr('timestamp'));
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
      $('.mainContainer').append(myArray);
      });</script>";
  }else{
    echo "<div class='pleaseLogIn'>Please Log into one of your Social accounts!</div>";
   echo "<script>$(document).ready(function(){
      $('#pic1').hide();
      $('.brandon').show();});</script>";
        
  }
  ?>
