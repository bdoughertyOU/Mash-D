<?php 
function time_elapsed_string($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1)
    {
        return '0 seconds';
    }

    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60 * 7        =>  'week',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
        }
    }
}
if (isset ($_SESSION['vine_key']) && isset($_SESSION['vine_userid'])){

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
  $video_thumb = $vines['thumbnailUrl'];
$time = strtotime($vines['created']);
$the_time = time_elapsed_string(strtotime($vines['created']));
 #####START TO PRINT STUFF OUT HERE ###### 
          echo "<div timestamp='$time'>";
echo "<div class='vinepost' data='$postId'>";
if(isset($poster_if_revined)){
  echo "<span class='revined'>" . $poster_if_revined . " revined</span>";
   echo "<br/>";
   $time = strtotime($vines['repost']['created']);
}

echo "<img src='$original_poster_avatar' class='vineAvatar' height = 50px width = 50px> ";
echo "<span class='vineUsername'>" . $original_poster_username . "</span>"; 
echo "<span class='vineTime'>" . $the_time . "</span>";
echo "<br/>";
$video = $vines['videoUrl'];
                               
echo "<video style='margin: 1% 0% 1% 0%;' poster='$video_thumb' width='420px' preload='none' height='420' controls loop>
<source src='$video'>
<object data='$video' width='420' height='420'></object>
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
    echo "<button type='button' class='ajaxcommentbutton1' group='$postId' data='2'>Load previous comments</button>";
    echo "<br/>";
    echo "<div class='commentsContainer'>";
    echo "<div class='1'>";
     $vineI=0;
    while($vineI < 6){
      if(isset($vines['comments']['records'][$vineI])){
      $actual_comments = $vines['comments']['records'][$vineI];
      $comment_profile_img = $actual_comments['avatarUrl'];
      $comment_poster_username = $actual_comments['username'];
      $the_comment = $actual_comments['comment'];

      echo "<img src='$comment_profile_img' height = 15px width = 15px>'";
      echo $comment_poster_username;
      echo ' ' . $the_comment . '<br />';
    }
      $vineI++;
    }
    //var_dump($records['data']['records']);

    echo "</div></div></div><hr></div>";
}

}#End If isset
?>