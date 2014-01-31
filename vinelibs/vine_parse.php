<?php 
if (isset ($_SESSION['vine_key']) && isset($_SESSION['vine_userid'])){
$vine = new Vine;
$key = $_SESSION['vine_key'];
$records = $vine->vineTimeline($key);

foreach($records['data']['records'] as $vines){
  if(isset($vines['repost']['username']))
  {
  $poster_if_revined = $vines['repost']['username'];
  }
  $original_poster_avatar = $vines['avatarUrl'];
  $original_poster_username = $vines['username'];
  $description = $vines['description'];
  $likes= $vines['likes']['count'];
  $revines = $vines['reposts']['count'];
  $num_comments = $vines['comments']['count'];
  $postId = $vines['postIdStr'];

 #####START TO PRINT STUFF OUT HERE ###### 
echo "<div id='vinepost' data='$postId'>";
if(isset($poster_if_revined)){
  echo $poster_if_revined . " revined";
}
  echo "<br/>";

echo "<img src='$original_poster_avatar' height = 50px width = 50px> ";
echo $original_poster_username;
echo "<br/>";
$video = $vines['videoUrl'];
                               
echo "<video width='350' height='350' controls loop>
<source src='$video'>
<object data='$video' width='350' height='350'></object>
</video>";
echo "<br/>";
echo $description;
echo "<br/>";
if(!empty($likes)){
      $num_likes = (int)str_replace(' ', '', $likes);
      if($num_likes > 1){
  echo $likes . " Likes ";
  }else{
    echo $likes . 'like';
  }
}
if(!empty($revines)){
  $num_revines = (int)str_replace(' ', '', $revines);
      if($num_revines > 1){
  echo $revines . " Revines ";
  }else{
    echo $revines . ' Revine';
  }
}
if(!empty($num_comments)){
  $num_of_comments = (int)str_replace(' ', '', $num_comments);
  if($num_of_comments > 1){
  echo $num_comments . " Comments ";
  }else{
    echo $num_comments . ' Comment';
  }
}
    echo "<br/>";
    echo "<button type='button' id='ajaxcommentbutton1' class='1' data='1' onclick='loadVineComments()'>Load previous comments</button>";
    echo "<br/>";
    echo "<div id='commentsContainer'></div>";
    foreach($vines['comments']['records'] as $actual_comments){
      $comment_profile_img = $actual_comments['avatarUrl'];
      $comment_poster_username = $actual_comments['username'];
      $the_comment = $actual_comments['comment'];
      echo "<br/>";
      echo "<img src='$comment_profile_img' height = 15px width = 15px>'";
      echo $comment_poster_username;
      echo $the_comment;
    }

    echo "</div><br/>";echo "<br/>";
}

}#End If isset
?>