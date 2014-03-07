<?php if (isset($ig_username)): ?> 
<!-- <img src="instagramlibs/example/assets/instagram.png" alt="Instagram logo">
        <h1><span><?php echo $ig_username->data->username ?></span>'s Instagram feed</h1>-->
      <?php #print_r($result);?>
        <?php
          foreach ($result->data as $media) {
            $postId = $media->id;
            $igCreated = $media->created_time;
            echo "<div timestamp='$igCreated'>";
            echo "<div class='instagramPost' group='$postId'>";
            $profilepic = $media->user->profile_picture;
            $igposter = $media->user->username;
            $created_time = $media->created_time;
            $diff = (time() - ($created_time));
            if(isset($media->location) && isset($media->location->name)){
              $location = $media->location->name;
            }
            #echo $created_time;
            #echo $diff;
            echo strftime("%r", $diff);

            #echo strftime('%t', ($created_time));
            echo "<div class='igAvatar'><img src ='$profilepic' width='55' height='55'/>";
            echo $igposter . "</div>";
            echo "<div class='iglogo'><img src='images/instagramlogo.gif' height='60px' width='140'/></div>";
            echo "<br/>";
            if(isset($media->location->name)){
              $location = $media->location->name;
              echo $location;
              echo "<br/>";
            }
            // output media
            if ($media->type === 'video') {
              // video
              $poster = $media->images->low_resolution->url;
              $source = $media->videos->standard_resolution->url;
              echo "<video  width=\"250\" height=\"250\" controls>
                             <source src=\"{$source}\" type=\"video/mp4\" />
                             <object data=\"{$source}\" width=\"250\" height=\"250\"></object>
                           </video><br/>";
            } else {
              // image
              $image = $media->images->standard_resolution->url;
              echo "<img class=\"media\" src=\"{$image}\"/><br/>";
            }
            
            // create meta section
            
            if(!empty($media->caption->text)){
           echo "<div class=\"content\">
                           <div class=\"comment\">{$media->caption->text}</div>
                         </div>";
            }
            $likes = $media->likes->count;
            echo "Likes " . $likes;
            echo "<br/>";
            if(!empty($media->comments->data)){
              echo "<div class='commentsContainer'>";
              echo "<div class='1'>";
                $i=0;
                while($i < 5){
                  if(isset($media->comments->data[$i])){
                    $comments = $media->comments->data[$i];
                    $comment_img = $comments->from->profile_picture;
                    $comment_name = $comments->from->username;
                    $comment_text = $comments->text;
                    echo "<img src='$comment_img' width='30px' height='30px'/> ";
                    echo $comment_name . ' - ';
                    echo $comment_text . "<br/>";
                  }
                  $i++;
                }
                echo "</div>";
                if($media->comments->count > 5){
                  echo "<button class='instaComments radius' group='$postId' data='9'>Load comments</button>";
                }
                echo "</div>";
              }

            echo "</div><hr></div>";
            //print_r($media);
            //echo "<br/><br/>";
          }
        ?>
        <?php endif ?>