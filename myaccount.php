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
      
      <p>
  
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
  function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}
############
###########   Printing stuff out HEREEEEE
###########
        $ret_obj = $facebook->api('/me/home?access_token=&limit=30&untill=','GET');
        
        echo count($ret_obj['data']); // this is uneccesary just for testing
        $i=0;
        
        $count = count($ret_obj['data']);
        while($i < $count){
          
          $data = $ret_obj['data'][$i];
          $aname = $data['from']['id'];
          $usr_post_pic = $facebook->api('/' . $aname . '?fields=picture','GET');
          $pic = $usr_post_pic['picture']['data']['url'];
############
###########   if the post is from instagram, dont show it , in order to remove duplicate posts      #######----> WHAT IF YOU ARENT FOLLOWING THE USER ON INSTAGRAM,
                                                                                                    #############THUS YOU WOULDNT SEE THIS POST AT ALL
          if (isset($data['application']['name']) && $data['application']['name'] == 'Instagram'){}
            
          else{
        ############
###########   Printing USERS PROFILE PICTURE
          echo "<img src='$pic'/>";
############
###########   Printing TITLE OF POST (POSTERS NAME, OR THE "STORY TITLE")
          if (empty($data['story'])){
              echo $data['from']['name'];
            }elseif(preg_match("/commented on a status/",$data['story'])){
              $id_of_origin_post = preg_replace('/.*_/', '', $data['id']);
              $post_url = '/' .$id_of_origin_post;
              $origin_post = $facebook->api($post_url,'GET');
                #the original posters user profile picture
                $origin_aname = $origin_post['from']['id'];
                $origin_usr_post_pic = $facebook->api('/' . $origin_aname . '?fields=picture','GET');
                $origin_pic = $origin_usr_post_pic['picture']['data']['url'];
                  echo $data['story'];
                  echo "<br/>";
                  echo "-------------------><img src='$origin_pic'/>";
                  echo "<br/>";
                               if (isset($origin_post['to'])){
                                   echo " to " . $origin_post['to']['data']['0']['name'];
                                }     
                      ############
                      ###########  PRINTS THE MESSAGE OF THE POST IF ANY        
                                echo "<br/>";
                                if (isset($origin_post['message'])){
                                    echo $origin_post['message'];
                                  }
                                echo "<br/>";
                                echo "Likes:";
                                echo "<br/>";
                                $z = 0;
                                $likes_count = count($origin_post['likes']['data']);
                                while($z <= $likes_count){
                                    echo $origin_post['likes']['data'][$z]['name'];
                                    echo "<br/>";
                                    $z++;
                                }
                      ############
                      ###########   EITHER PRINTS THE YOUTUBE VIDEO, OR A DIRECTLY UPLOADED VIDEO, OR PICTURE              ###### ------> WHAT IF USER UPLOADED VIDEO AND PICTURE??
                              if ((isset($origin_post['source'])) && (preg_match("/youtube/",$origin_post['source']))){
                                echo "<iframe width='398' height='224' frameborder='0' scrolling='no' src = 'https://www.youtube.com/embed/vVVNN2pzaHw'>
                                <!DOCTYPE html>
                                <html>
                                  <head>
                                    <meta charset='utf-8'>
                                  </head>
                                  <body>
                                    <div>
                                      <span>
                                        <object type='application/x-shockwave-flash' data='https://www.youtube.com/v/vVVNN2pzaHw?version=3&amp;autohide=1&amp;autoplay=1' height='224' width='398'>
                                        </object>
                                      </span>
                                    </div>
                                  </body>
                                </html>
                                </iframe>";

                              }elseif ((isset($origin_post['source'])) && (preg_match("/\.3g2|\.3gp|\.gpp|\.asf|\.avi|\.dat|\.divx|\.dv|\.f4v|\.flv|\.m2ts|\.m4v|\.mkv|\.mod|\.mov|\.mp4|\.mpe|\.mpeg|\.mpeg4|\.mpg|\.mts|\.nsv|\.ogm|\.ogv|\.qt|\.tod|\.ts|\.vob|\.wmv/",$origin_post['source']))){
                                $video_up1 = $origin_post['source'];
                                echo "<video width='320' height='240' controls >
                                  <source src='$video_up1' type='video/mp4'/>
                                  <object data='$video_up1' width='320' height='240'></object>
                                </video>";

                              }elseif (isset($data['picture'])){
                                  ##working on this regex #################
                                  $big_num1= preg_replace('/\_s..../', '', $origin_post['picture']);
                                  $med_num1 = preg_replace('/.*[\/]/', '', $big_num1);
                                  $imglink1 = 'https://scontent-b-pao.xx.fbcdn.net/hphotos-prn1/' .$med_num1. '_n.jpg';
                                  echo "<img src='$imglink1'/>";
                                }
                      ############
                      ###########   END PRINTS THE YOUTUBE VIDEO, OR A DIRECTLY UPLOADED VIDEO, OR PICTURE   
                        echo "<br/>";
              print_r($origin_post);
#######################   END comment on other users post   #######################   END comment on other users post   ############
###########   END comment on other users post   #######################   END comment on other users post   ############
###########   END comment on other users post   #######################   END comment on other users post   #######################   END comment on other users post   ############

            }elseif(preg_match("/commented on ... own status/",$data['story'])){
              $id_of_self_post = preg_replace('/.*_/', '', $data['id']);
              $self_post_url = '/' .$id_of_self_post;
              $self_origin_post = $facebook->api($self_post_url,'GET');
                  echo $data['story'];
                  echo "<br/>";
                               if (isset($self_origin_post['to'])){
                                   echo " to " . $self_origin_post['to']['data']['0']['name'];
                                }     
                      ############
                      ###########  PRINTS THE MESSAGE OF THE POST IF ANY        
                                echo "<br/>";
                                if (isset($self_origin_post['message'])){
                                    echo $self_origin_post['message'];
                                  }
                                echo "<br/>";
                                echo "Likes:";
                                echo "<br/>";
                                $x=0;
                                $likes_count1 = count($self_origin_post['likes']['data']);
                                while($x <= $likes_count1){
                                    echo $self_origin_post['likes']['data'][$x]['name'];
                                    echo "<br/>";
                                    $x++;
                                }
                      ############
                      ###########   EITHER PRINTS THE YOUTUBE VIDEO, OR A DIRECTLY UPLOADED VIDEO, OR PICTURE              ###### ------> WHAT IF USER UPLOADED VIDEO AND PICTURE??
                              if ((isset($self_origin_post['source'])) && (preg_match("/youtube/",$self_origin_post['source']))){
                                echo "<iframe width='398' height='224' frameborder='0' scrolling='no' src = 'https://www.youtube.com/embed/vVVNN2pzaHw'>
                                <!DOCTYPE html>
                                <html>
                                  <head>
                                    <meta charset='utf-8'>
                                  </head>
                                  <body>
                                    <div>
                                      <span>
                                        <object type='application/x-shockwave-flash' data='https://www.youtube.com/v/vVVNN2pzaHw?version=3&amp;autohide=1&amp;autoplay=1' height='224' width='398'>
                                        </object>
                                      </span>
                                    </div>
                                  </body>
                                </html>
                                </iframe>";

                              }elseif ((isset($self_origin_post['source'])) && (preg_match("/\.3g2|\.3gp|\.gpp|\.asf|\.avi|\.dat|\.divx|\.dv|\.f4v|\.flv|\.m2ts|\.m4v|\.mkv|\.mod|\.mov|\.mp4|\.mpe|\.mpeg|\.mpeg4|\.mpg|\.mts|\.nsv|\.ogm|\.ogv|\.qt|\.tod|\.ts|\.vob|\.wmv/",$origin_post['source']))){
                                $video_up2 = $self_origin_post['source'];
                                echo "<video width='320' height='240' controls >
                                  <source src='$video_up2' type='video/mp4'/>
                                  <object data='$video_up2' width='320' height='240'></object>
                                </video>";

                              }elseif (isset($data['picture'])){
                                  ##working on this regex #################
                                  $big_num2 = preg_replace('/\_s..../', '', $self_origin_post['picture']);
                                  $med_num2 = preg_replace('/.*[\/]/', '', $big_num2);
                                  $imglink2 = 'https://scontent-b-pao.xx.fbcdn.net/hphotos-prn1/' .$med_num2. '_n.jpg';
                                  echo "<img src='$imglink2'/>";
                                }
                      ############
                      ###########   END PRINTS THE YOUTUBE VIDEO, OR A DIRECTLY UPLOADED VIDEO, OR PICTURE   
                        echo "<br/>";
              print_r($self_origin_post);
            }else{
              echo $data['story'];
            }

          if (isset($data['to'])){
              echo " to " . $data['to']['data']['0']['name'];
              }     
############
###########  PRINTS THE MESSAGE OF THE POST IF ANY        
          echo "<br/>";
          if (isset($data['message'])){
              echo $data['message'];
            }
          echo "<br/>";
          echo "Likes:";
          echo "<br/>";
          $y = 0;
          $like_count = count($data['likes']['data']);
          while($y <= $like_count){
              echo $data['likes']['data'][$y]['name'];
              echo "<br/>";
              $y++;
          }
############
###########   EITHER PRINTS THE YOUTUBE VIDEO, OR A DIRECTLY UPLOADED VIDEO, OR PICTURE              ###### ------> WHAT IF USER UPLOADED VIDEO AND PICTURE??
        if ((isset($data['source'])) && (preg_match("/youtube/",$data['source']))){
          echo "<iframe width='398' height='224' frameborder='0' scrolling='no' src = 'https://www.youtube.com/embed/vVVNN2pzaHw'>
          <!DOCTYPE html>
          <html>
            <head>
              <meta charset='utf-8'>
            </head>
            <body>
              <div>
                <span>
                  <object type='application/x-shockwave-flash' data='https://www.youtube.com/v/vVVNN2pzaHw?version=3&amp;autohide=1&amp;autoplay=1' height='224' width='398'>
                  </object>
                </span>
              </div>
            </body>
          </html>
          </iframe>";

        }elseif ((isset($data['source'])) && (preg_match("/\.3g2|\.3gp|\.gpp|\.asf|\.avi|\.dat|\.divx|\.dv|\.f4v|\.flv|\.m2ts|\.m4v|\.mkv|\.mod|\.mov|\.mp4|\.mpe|\.mpeg|\.mpeg4|\.mpg|\.mts|\.nsv|\.ogm|\.ogv|\.qt|\.tod|\.ts|\.vob|\.wmv/",$data['source']))){
          $video_up = $data['source'];
          echo "<video width='320' height='240' controls >
            <source src='$video_up' type='video/mp4'/>
            <object data='$video_up' width='320' height='240'></object>
          </video>";

        }elseif (isset($data['picture'])){
            ##working on this regex #################
            $big_num = preg_replace('/\_s..../', '', $data['picture']);
            $med_num = preg_replace('/.*[\/]/', '', $big_num);
            $imglink = 'https://scontent-b-pao.xx.fbcdn.net/hphotos-prn1/' .$med_num. '_n.jpg';
            echo "<img src='$imglink'/>";
          }
############
###########   END PRINTS THE YOUTUBE VIDEO, OR A DIRECTLY UPLOADED VIDEO, OR PICTURE   
          echo "<br/>";

          print_r($data);

          echo "<br/>";
         }
          ##figure out how to loop through because if the post has multiple photos i
          ##it will only upload one
          
         
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
