<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Members Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">

</script>
<link href="css/foundation.min.css" rel="stylesheet" type="text/css">
<link href="css/normalize.css" rel="stylesheet" type="text/css">
<script src="js/foundation.min.js"></script>
<script src="js/foundation.tooltip.js"></script>
<script src="js/modernizr.js"></script>
<link rel="stylesheet" href="css/main.css" />


</head>

<body>
   <script>
  $(function(){
    $(document).foundation();    
  });
</script>
<div class="row">
<div class="large-12 columns" style="height:30px;"></div>
</div>
    <div class="row">
      <div class="large-5 large-centered columns">
        <h1 id ="mashd"><span data-tooltip class="has-tip tip-left radius" title="<span style='font-size:1.2em;'><b>facebook</span>" >M</span><span data-tooltip class="has-tip tip-top radius" title="<span style='font-size:1.2em;color:#2daddc;'><b>Twitter</span>" >a</span><span data-tooltip class="has-tip radius" title="<span style='font-size:1.3em;'><b><span style='color:#DA1421;'>I</span><span style='color:#DFB405;'>n</span><span style='color:#6BB47D;'>s</span><span style='color:#407EE5;'>t</span><span style='color:#D9AB73;'>a</span>gram</span>">s</span><span data-tooltip class="has-tip tip-top radius" title="<span style='font-size:1.3em;color:#00bf8f;'><b>Vine</span>">h</span><span data-tooltip class="has-tip tip-right radius" title="<span style='font-size:1.3em;'><b>Whats Next?</span>">'D</span>
        </h1>
      </div>  
    </div>
        <div class="row">
          <div class="large-3 large-centered columns">
            <!--<form action="login.php" method="post" name="logForm" id="logForm" >-->
            <input name="usr_email" type="text" placeholder="username" class="required" id="usr_email" size="25">
          </div>
        </div>
        <div class="row">
          <div class="large-3 large-centered columns">
            <input name="pwd" type="password" placeholder="password" class="required password" id="password" size="25">
          </div>
        </div>
        <div class="row">
          <div class="large-3 large-centered columns">
            <button class="round button expand" name="doLogin" value="Login"type="submit" id="doLogin3">Login</button>
            <!--</form>-->
          </div>
        </div>
        <div class="row">
          <div class="large-3 large-centered columns">
          <a href="register.php">Register-</a>
          <a href="forgot.php">Forgot Password</a> 
        </div>
       </div>
       <div class="result"></div>
       <script>
 $(document).on('click', '#doLogin3', function(){
    var uid = $('#usr_email').val();
    var pwd = $('#password').val();

     $.ajax({url:"http://localhost/mashd/Mash-D/login.php",
           type:'POST',              
       dataType:'text',
           data: {usr_email : uid,
                  pwd : pwd},
        success:function(result){
                if(result == "1" || result == true){
                      document.location = 'http://localhost/mashd/mash-d/myaccount.php';
                } else {
                    $('#logForm').html("Login failed, username and/or password don't match");
                }

          }});
    }); 
    
</script>
</body>
</html>

