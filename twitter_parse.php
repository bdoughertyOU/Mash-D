<?php 
if (isset ($_SESSION['access_token'])){
$access_token = $_SESSION['access_token'];

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$method = 'statuses/home_timeline';
$the_response = $connection->get($method);
foreach ($the_response as $twitter){
  $poster_id = $twitter->user->screen_name;
  $post_id = $twitter->id_str;
  $method =$poster_id . '/status/' . $post_id;
$the_comments = $connection->get($method);
 echo "<div class='twitterPost' data-id='$post_id'>";
    if (isset($twitter->retweeted_status)){
      $img = $twitter->retweeted_status->user->profile_image_url;
      $retweeter = $twitter->user->name;
      $user_name = $twitter->retweeted_status->user->name;
      $user_profile_name = $twitter->retweeted_status->user->screen_name;
      $tweet = $twitter->retweeted_status->text;
      $match = preg_match('/http:\/\/t.co([^ ]+)/', $tweet);
      if ($match === 1){
        if(!empty($twitter->entities->urls)){
          foreach($twitter->entities->urls as $urlss){
            $the_url = $urlss->url;
            $the_new_url = "<a href='$urlss->expanded_url' >" .  $urlss->display_url . "</a>";
          $tweet = str_replace($the_url, $the_new_url, $tweet);
          }
        }
        if(isset($twitter->entities->media)){
         foreach($twitter->entities->media as $other_urls){
            $the_url = $other_urls->url;
            $the_new_url = "<a href='$other_urls->expanded_url' >" .  $other_urls->display_url . "</a>";
          $tweet = str_replace($the_url, $the_new_url, $tweet);
          }
        }

      }
      echo "Retweeted by " . $retweeter . "<br/>";
      echo "<img src='$img'>";
      echo " " . $user_name;
      echo " @" . $user_profile_name;
      echo "<br/>";
      echo $tweet;
      echo "<br/>";
      if(isset($twitter->entities->media)){
        foreach($twitter->entities->media as $the_media){
          $some_media = $the_media->media_url;
          echo "<img src='$some_media'><br/>";
        } 
      }
    }else{
      $img = $twitter->user->profile_image_url;
      $user_name = $twitter->user->name;
      $user_profile_name = $twitter->user->screen_name;
      $tweet = $twitter->text;
      $match = preg_match('/http:\/\/t.co([^ ]+)/', $tweet);
      if ($match === 1){
        if(!empty($twitter->entities->urls)){
          foreach($twitter->entities->urls as $urlss){
            $the_url = $urlss->url;
            $the_new_url = "<a href='$urlss->expanded_url' >" .  $urlss->display_url . "</a>";
          $tweet = str_replace($the_url, $the_new_url, $tweet);
          }
        }
        if(isset($twitter->entities->media)){
         foreach($twitter->entities->media as $other_urls){
            $the_url = $other_urls->url;
            $the_new_url = "<a href='$other_urls->expanded_url' >" .  $other_urls->display_url . "</a>";
          $tweet = str_replace($the_url, $the_new_url, $tweet);
          }
        }
      }
      echo "<img src='$img'>";
      echo " " . $user_name;
      echo " @" . $user_profile_name;
      echo "<br/>";
      echo $tweet;
      echo "<br/>";
      if(isset($twitter->entities->media)){
        foreach($twitter->entities->media as $the_media){
          $some_media = $the_media->media_url;
          echo "<img src='$some_media'><br/>";
        } 
      }
    }
    $num_retweets = $twitter->retweet_count;
    $num_favorites = $twitter->favorite_count;
    echo "Retweets " . $num_retweets . " Favorites " . $num_favorites;
    echo "<br/><div class='twitterCommentContainer'></div><br/>";
    echo "<button class='twitterComments' data='$poster_id' data-id='$post_id'>Expand Comments</button>";
    echo "<br/><br/>";
    echo "</div>";
  }
}
?>