<?php if (isset($ig_username)): ?> 
 <img src="instagramlibs/example/assets/instagram.png" alt="Instagram logo">
        <h1><span><?php echo $ig_username->data->username ?></span>'s Instagram feed</h1>
      </header>
      <div class="main"><?php #print_r($result->data);?>
        <ul class="grid">
        <?php
          // display all user likes
          foreach ($result->data as $media) {
            $content = "<li>";
            $profilepic = $media->user->profile_picture;
            $igposter = $media->user->username;
            $created_time = $media->created_time;
            $diff = (time() - ($created_time));
            #echo $created_time;
            #echo $diff;
            echo strftime("%r", $diff);

            #echo strftime('%t', ($created_time));
            echo "<span><img src ='$profilepic' width='55' height='55'/><p>$igposter</p></span><br/>";
            // output media
            if ($media->type === 'video') {
              // video
              $poster = $media->images->low_resolution->url;
              $source = $media->videos->standard_resolution->url;
              $content .= "<video  width=\"250\" height=\"250\" controls>
                             <source src=\"{$source}\" type=\"video/mp4\" />
                             <object data=\"{$source}\" width=\"250\" height=\"250\"></object>
                           </video>";
            } else {
              // image
              $image = $media->images->standard_resolution->url;
              $content .= "<img class=\"media\" src=\"{$image}\"/>";
            }
            
            // create meta section
            
            if(!empty($media->caption->text)){
            $content .= "<div class=\"content\">
                           <div class=\"comment\">{$media->caption->text}</div>
                         </div>";
            }
            // output media
            echo $content . "</li>";
          }
        ?>
        <?php endif ?>