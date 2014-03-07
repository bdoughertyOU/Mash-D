  <!--/***********************************************facebook stuff*****/-->    
 <?php 
if(isset($user_id)) {

      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
        foreach($ret_obj['data'] as $the_post){ 
          $fbCreated = strtotime($the_post['created_time']); 
          echo "<div timestamp='$fbCreated'>";
          echo "<div class='fbPost' >";
          $data = $the_post;
          $aname = $data['from']['id'];
          $usr_post_pic = $facebook->api('/' . $aname . '?fields=picture','GET');
          $pic = $usr_post_pic['picture']['data']['url'];

###########   Printing USERS PROFILE PICTURE
          echo "<img src='$pic'/>";
############
###########   Printing TITLE OF POST (POSTERS NAME, OR THE "STORY TITLE")
          if (empty($data['story'])){
              include 'facebooklibs/normal_fb_post.php';
            }elseif(preg_match("/commented on a status/",$data['story'])){
              include 'facebooklibs/commented_on_a_status.php';
            }elseif(preg_match("/commented on ... own status/",$data['story'])){
              include 'facebooklibs/commented_on_own_status.php';
            }elseif(preg_match("/commented on ... own link/",$data['story'])){
              include 'facebooklibs/commented_on_own_link.php';
            }elseif(preg_match("/commented on a video/",$data['story'])){
              include 'facebooklibs/commented_on_a_video.php';
            }elseif(preg_match("/likes a link/",$data['story'])){
              include 'facebooklibs/likes_a_link.php';##############NOT STARTED
            }elseif(preg_match("/shared a link/",$data['story'])){
              include 'facebooklibs/shared_a_link.php';##############NOT STARTED
            }elseif(preg_match("/was tagged in a link/",$data['story'])){
              include 'facebooklibs/was_tagged_in_a_link.php';##############NOT STARTED
            }elseif(preg_match("/added/",$data['story']) && preg_match("/photo/",$data['story'])){
              include 'facebooklibs/added_x_photos.php';##############NOT STARTED
            }else{ 
              echo $data['story'];
            

        }
        
############
###########   END PRINTS THE YOUTUBE VIDEO, OR A DIRECTLY UPLOADED VIDEO, OR PICTURE   
          echo "<br/>";

          print_r($data);
          echo "</div>";
          echo "<hr>";
          echo "</div>";

         }
          ##figure out how to loop through because if the post has multiple photos i
          ##it will only upload one
        }
    

?>
