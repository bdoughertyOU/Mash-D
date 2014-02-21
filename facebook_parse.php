 <p>
  
  <!--/***********************************************facebook stuff*****/-->    
 <?php if ($user){

  $user_id = $facebook->getUser();
if($user_id) {

      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
        $ret_obj = $facebook->api('/me/home?access_token=&limit=20','GET');
        foreach($ret_obj['data'] as $the_post){        
          $data = $the_post;
          $aname = $data['from']['id'];
          $usr_post_pic = $facebook->api('/' . $aname . '?fields=picture','GET');
          $pic = $usr_post_pic['picture']['data']['url'];

###########   Printing USERS PROFILE PICTURE
          echo "<img src='$pic'/>";
############
###########   Printing TITLE OF POST (POSTERS NAME, OR THE "STORY TITLE")
          if (empty($data['story'])){
              echo $data['from']['name'];
            }elseif(preg_match("/commented on a status/",$data['story'])){
              include 'facebooklibs/commented_on_a_status.php';
            }elseif(preg_match("/commented on ... own status/",$data['story'])){
              include 'facebooklibs/commented_on_own_status.php';
            }elseif(preg_match("/commented on ... own link/",$data['story'])){
              include 'facebooklibs/commented_on_own_link.php';##############NOT STARTED just like external link
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

          if (isset($data['to'])){
              echo " to " . $data['to']['data']['0']['name'];
              }     
############
###########  PRINTS THE MESSAGE OF THE POST IF ANY        
          echo "<br/>";
          if (isset($data['message'])){
              echo $data['message'];
              echo "<br/>";
            }
          if(!empty($data['likes'])){
          echo "<br/>";
          $like_count = count($data['likes']['data']);
          echo "Likes: " . $like_count;
          echo "<br/>";
          $y = 0;
          /*$like_count = count($data['likes']['data']);
          while($y < $like_count){
              echo $data['likes']['data'][$y]['name'];
              echo "<br/>";
              $y++;
          }*/
        }
############
###########   EITHER PRINTS THE YOUTUBE VIDEO, OR A DIRECTLY UPLOADED VIDEO, OR PICTURE              ###### ------> WHAT IF USER UPLOADED VIDEO AND PICTURE??
        if ((isset($data['source'])) && (preg_match("/youtube/",$data['source']))){
          $big_youtube2 = preg_replace('/.*?\//', '', $data['source']);
          $med_youtube2 = preg_replace('/\?.*/', '', $big_youtube2);
          $youtube_link2 = 'https://www.youtube.com/v/' . $med_youtube2 . '?version=3&amp;autohide=1&amp;autoplay=1';
          $youtube_embed_link2 = 'https://www.youtube.com/embed/' . $med_youtube2;

          echo "<iframe width='398' height='224' frameborder='0' scrolling='no' src =" . $youtube_embed_link2 . ">
          <!DOCTYPE html>
          <html>
            <head>
              <meta charset='utf-8'>
            </head>
            <body>
              <div>
                <span>
                  <object type='application/x-shockwave-flash' data=" . $youtube_link2 . " height='224' width='398'>
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
            ##this is a post linked to another web page or article
            if(preg_match('/fbexternal/', $data['picture'])){
              $urlOfExternal = preg_replace('/.*url=/', '', $data['picture']);
              $newUrlimg = urldecode($urlOfExternal);
              $urlLink =  $data['link'];

              echo "<a href='$urlLink' target='_blank'><img src='$newUrlimg' width='400px'/></a>";
              echo "<br/>";
              if(isset($data['name']))
              {
                $articleName = $data['name'];
                echo $articleName;
                echo "<br/>";
              }
              if(isset($data['caption']))
              {
                $articleCaption = $data['caption'];
                echo $articleCaption;
                echo "<br/>";
              }
              if(isset($data['description']))
              {
                $articleDescription = $data['description'];
                echo $articleDescription;
              }
            }else{ 
              ###regular post
            $big_num = preg_replace('/\_s..../', '', $data['picture']);
            $med_num = preg_replace('/.*[\/]/', '', $big_num);
            $imglink = 'https://scontent-b-pao.xx.fbcdn.net/hphotos-prn1/' .$med_num. '_n.jpg';
            echo "<img src='$imglink' width='400px'/>";
          }
        }
############
###########   END PRINTS THE YOUTUBE VIDEO, OR A DIRECTLY UPLOADED VIDEO, OR PICTURE   
          echo "<br/>";

          print_r($data);

          echo "<br/>";
         }
          ##figure out how to loop through because if the post has multiple photos i
          ##it will only upload one
          
        }
    
      
}

?>

  <!--/*********************************************** End facebook stuff*****/-->

</p>