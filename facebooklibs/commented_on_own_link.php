<?php
#commented_on_own_link
$id_of_self_post = preg_replace('/.*_/', '', $data['id']);
$self_post_url = '/' .$id_of_self_post;
$self_origin_post = $facebook->api($self_post_url,'GET');
  echo $data['story'];
  echo "<br/>";
  echo $self_origin_post['message'];
  $picture = $self_origin_post['picture'];
  echo "<br />";
  echo "<img src='$picture'/>";

?>