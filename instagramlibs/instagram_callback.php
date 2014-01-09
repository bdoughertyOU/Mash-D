<?php
include 'Instagram.php';





/**
 * Configuration params, make sure to write exactly the ones
 * instagram provide you at http://instagr.am/developer/
 */
$config = array(
        'client_id' => 'af0092092bd347f2948940ef30261dcc',
        'client_secret' => '12b2d103aa884b9c9a4bf377ad4cf279',
        'grant_type' => 'authorization_code',
        'redirect_uri' => 'http://localhost/Mashd/Mash-D/instagramlibs/instagram_callback.php',
     );

// Instantiate the API handler object
$instagram = new Instagram($config);
$accessToken = $instagram->getAccessToken();
$_SESSION['InstagramAccessToken'] = $accessToken;
var_dump($accessToken);
$instagram->setAccessToken($_SESSION['InstagramAccessToken']);


?>
<html>
<head></head>
<body><?php print_r($_SESSION); ?>
</body>
</html>


