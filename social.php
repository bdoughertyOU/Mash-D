<?php
include 'dbc.php';
page_protect();
include 'facebooklibs/auth.php';
include 'instagramlibs/instagramAuth.php';
include 'twitterlibs/twitterauth.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Social logins</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
</head>
  <body>
    <a href="myaccount.php">My Account</a>
    <pre><?php print_r($_SESSION); ?><br/>
    <?php print_r($_COOKIE); ?></pre>
    <!--facebook stuff -->
    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        <!--Login using OAuth 2.0 handled by the PHP SDK:-->
        <a href="<?php echo $loginUrl; ?>">Facebook Login</a>
        <strong><em>You are not Connected.</em></strong>
      </div>
    <?php endif ?>

    <?php if ($user): ?>
      <h3>You are using facebook with Mash'D</h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">
    <?php endif ?>
    <!--End facebook stuff -->

    <!--Instagram stuff -->
    <?php if (isset($_SESSION['instagram'])):?>
      <h3>You are using Instagram with Mash'D</h3>
    <?php else: ?>
      <div>
       <a href="<?php echo $instagram_loginUrl; ?>">Instagram Login</a>
        <strong><em>You are not Connected.</em></strong>
      </div>
    <?php endif ?>

    <!--End Instagram stuff  -->

    <!--Twitter stuff  -->  
    <?php if (isset($_SESSION['access_token'])):?>
      <h3>You are using Twitter with Mash'D</h3>
    <?php else: ?>
    <p>
      <?php print_r($content); ?>
      <strong><em>You are not Connected.</em></strong>
   </p>
   <?php endif ?>
    <!--End Twitter stuff  -->
    <p><a href="#">Vine Login</a></p>
    <p><a href="#">Reddit Login</a></p>

  </body>
</html>
