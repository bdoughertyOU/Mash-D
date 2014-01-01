<?php
include 'facebooklibs/auth.php';
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
    
    <!--facebook stuff -->
    <h1>php-sdk</h1>
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

      <h3>Your User Object (/me)</h3>
      <pre><?php print_r($user_profile); ?></pre>
    <?php endif ?>
    <!--End facebook stuff -->

    <p><a href="#">Twitter Login</a></p>
    <p><a href="#">Instagram Login</a></p>
    <p><a href="#">Vine Login</a></p>
    <p><a href="#">Reddit Login</a></p>

    <h3>PHP Session</h3>
    <pre><?php print_r($_SESSION); ?></pre>

  </body>
</html>
