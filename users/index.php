<!-- Website made with love by keksstudios.dev | Copy paste is not allowed! -->
<?php
$pdo = new mysqli('#CENSORED#');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)

error_reporting(E_ALL);

define('OAUTH2_CLIENT_ID', '#CENSORED#');
define('OAUTH2_CLIENT_SECRET', '#CENSORED#');

$authorizeURL = 'https://discordapp.com/api/oauth2/authorize';
$tokenURL = 'https://discordapp.com/api/oauth2/token';
$apiURLBase = 'https://discordapp.com/api/users/@me';

session_start();

$isLoggedIn = false;

// Start the login process by sending the user to Discord's authorization page
if(get('action') == 'login') {

  $params = array(
    'client_id' => OAUTH2_CLIENT_ID,
    'redirect_uri' => 'https://keksstudios.dev/discordrobots/index.php',
    'response_type' => 'code',
    'scope' => 'identify'
  );

  // Redirect the user to Discord's authorization page
  header('Location: https://discordapp.com/api/oauth2/authorize' . '?' . http_build_query($params));
  die();

}


// When Discord redirects the user back here, there will be a "code" and "state" parameter in the query string
if(get('code')) {

  // Exchange the auth code for a token
  $token = apiRequest($tokenURL, array(
    "grant_type" => "authorization_code",
    'client_id' => OAUTH2_CLIENT_ID,
    'client_secret' => OAUTH2_CLIENT_SECRET,
    'redirect_uri' => 'https://keksstudios.dev/discordrobots/index.php',
    'code' => get('code')
  ));
  $logout_token = $token->access_token;
  $_SESSION['access_token'] = $token->access_token;


  header('Location: ' . $_SERVER['PHP_SELF']);
}

if(session('access_token')) {
  $user = apiRequest($apiURLBase);
if($user->id == "601366418759483393") {
	echo 'Oops, you are banned from our server';
	return;
}
$isLoggedIn = true;


?>
<script>
      var startApp = setTimeout(function() {
        document.getElementById('PlayerIcon').style = "display: flex";
        document.getElementById('NewBot').style = "display: flex";
	  document.getElementById('PlayerIcon').src = "https://cdn.discordapp.com/avatars/<?php echo $user->id ?>/<?php echo $user->avatar ?>.png";
	  document.getElementById('PlayerIcon').alt = '<?php echo $user->username ?>#<?php echo $user->discriminator ?>';
      document.getElementById('PlayerIcon').title = '<?php echo $user->username ?>#<?php echo $user->discriminator ?>';
      document.getElementById('loginButton').innerText = 'LOGOUT';
      document.getElementById('loginHREF').href = '?action=logout';
 }, 0);
startApp;</script>
<?php
}

if(get('action') == 'logout') {
apiRequest($revokeURL, array(
        'token' => session('access_token'),
        'client_id' => OAUTH2_CLIENT_ID,
        'client_secret' => OAUTH2_CLIENT_SECRET,
      ));
    unset($_SESSION['access_token']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    die();
}

function apiRequest($url, $post=FALSE, $headers=array()) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

  $response = curl_exec($ch);


  if($post)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

  $headers[] = 'Accept: application/json';

  if(session('access_token'))
    $headers[] = 'Authorization: Bearer ' . session('access_token');

  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($ch);
  return json_decode($response);
}

function get($key, $default=NULL) {
  return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}

function session($key, $default=NULL) {
  return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
}

?>
<html lang="en">
<head>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="1074910460731-dgkalatuokgr9a3okjop3nhvvnfk3ppl.apps.googleusercontent.com">
	<script data-ad-client="ca-pub-4609945663829295" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <?php
    $sql_r = "SELECT * FROM r WHERE owner_id='".$_GET["user"]."'";
    $result_r = mysqli_query($pdo, $sql_r);
    if($result_r) {
      $row_r = mysqli_fetch_array($result_r);
      $sql_bot = "SELECT * FROM owner_meta WHERE user_id='".$_GET["user"]."'";
      $result_bot = mysqli_query($pdo, $sql_bot);
      $row_bot = mysqli_fetch_array($result_bot);
      $name = $row_bot["username"];
      $avatar = $row_bot["avatar_url"];
    } else {
      $name = "404 (User not found)";
      $status = "UNKNOWN";
      $avatar = "/assets/images/KeksBotTrans.webp";
    }

    ?>
    <title id="title">DiscordRobots - <?php echo $name ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//keksstudios.dev/assets/bootstrap/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.woff" rel="stylesheet" id="bootstrap-css">-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="An User which has registered Bots on DiscordRobots">
    <meta name="keywords" content="Discord Bot List,  Discord Bots, Discord, kostenlos, free, fun, musicbot">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <meta name="theme-color" content="#ffcc00">
	<link rel="manifest" href="//keksstudios.dev/manifest.json">
    <meta name="twitter:title" content="DiscordRobots - <?php echo $name ?>">
	<meta name="twitter:description" content="An user which has registered Bots on DiscordRobots.">
	<meta property="og:title" content="DiscordRobots - <?php echo $name ?>>
	<meta property="og:type" content="website">
	<meta property="og:image" content="<?php echo $avatar ?>">
	<meta name="twitter:image" content="<?php echo $avatar ?>">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<style>
 /* width */
 ::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 10px;
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: black; 
  border-radius: 10px;
  height: 0px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #414141; 
}
	#the-final-countdown {
		font-size: auto;
		color: white;
	}
        a {
            color:#fff;
        }
        .active {
            color: #7289DA;
        }
		body {
    background-color: #23272A;
}
		.bg-dark {
    background-color: #2C2F33;
}
.bg-dark-2 {
    background-color: #414141;
}

.ad_banner {
    background-color: transparent;
    height: 1px;
    width: 1px;
}

.white {
color: #fff;
}
.bot {
    background: url(https://i.imgur.com/DocRwyB.jpg) repeat;
-webkit-animation: scrollGood 60s linear infinite;
  animation: scrollGood 60s linear infinite;
    position: relative;
    display: -webkit-box;
    display: flex;
    width: 100%;
    min-height: 500px;
    -webkit-box-pack: end;
    justify-content: flex-end;
}
@-webkit-keyframes scrollGood {
 0%{background-position:0 0}to{background-position:-2160px -2160px}}
}
@keyframes scrollGood {
  0%{background-position:0 0}to{background-position:-2160px -2160px}}
}


.height100 {
    height: 100%;
}

.banner_details {
    display: -webkit-box;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    flex-direction: column;
    -webkit-box-align: center;
    align-items: center;
}

.bot_details_more {
    display: -webkit-box;
    display: flex;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: reverse;
    flex-direction: row-reverse;
    -webkit-box-align: center;
    align-items: center;
    height: 100%;
    padding-right: 4rem;
}

.bot_details_avatar {
    -webkit-box-flex: 0;
    flex: 0 0 auto;
    border-radius: 50%;
    background-color: rgba(0,0,0,.5);
    width: 384px;
    height: 384px;
    -webkit-box-shadow: 0 0 16px rgba(0,0,0,0.8);
  box-shadow: 0 0 16px rgba(0,0,0,0.8);
        }

.bot_details_stats {
    margin-right: 2rem;
    display: -webkit-box;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    flex-direction: column;
    -webkit-box-align: end;
    align-items: flex-end;
}

.bot_discrimi {
    vertical-align: super;
    font-size: .5em;
    opacity: .5;
}

.bot_details_row {
    display: -webkit-box;
    display: flex;
    margin-top: .5rem;
}
.bot_info {
    display: -webkit-inline-box;
    display: inline-flex;
    -webkit-box-align: center;
    align-items: center;
    border-radius: 50px;
    background: rgba(0,0,0,.75);
    color: white;
    padding: .5rem 1rem;
    -webkit-box-shadow: 0 0 16px rgba(0,0,0,0.8);
  box-shadow: 0 0 16px rgba(0,0,0,0.8);
    }

.bot_desc {
    padding: 50;
    color: white;
}    


@media screen and (max-width: 1440px) {
    .bot_details_avatar {
    width: 256px;
    height: 256px;
}
}
@media screen and (max-width: 1000px) {
    .bot_content {
    -webkit-box-flex: 1;
    flex: 1 0 auto;
    text-align: center;
    }
    .bot {
    -webkit-box-pack: center;
    justify-content: center;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    flex-direction: column;
    }
    .bot_details {
    display: -webkit-box;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    flex-direction: column;
    -webkit-box-align: center;
    align-items: center;
    }
    .bot_details_more {
        -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    flex-direction: column;
    -webkit-box-pack: center;
    justify-content: center;
    padding: 0 1rem;
    width: 100%;
    }
    .bot_row {
    -webkit-box-flex: 1;
    flex: 1 0 auto;
    }
    .bot_details_avatar {
    width: 200px;
    height: 200px;
}
}
@media screen and (max-width: 500px) {
    .bot_details_avatar {
    width: 100px;
    height: 100px;
}
}
h1 {
    font-size: 80px;
    font-weight: 1000;
    color: white;
    text-shadow: 0 0 32px rgba(0,0,0,0.8);
}
@media screen and (max-width: 700px){
    h1 {
    font-size: 40px;
    font-weight: bolder;
    color: white;
    text-shadow: 0 0 32px rgba(0,0,0,0.8);
}
}

h2 {
    color: white;
}
.box-part{
    background:hsla(0, 0%, 25%,.5);
    border-radius:10px;
    padding:60px 10px;
    margin:30px 0px;
    overflow: hidden;
}

.box-part .title {
    font-size: 50px;
    font-weight: 900;
    text-transform: uppercase;
}

.box-part:hover{
    background:#4183D7;
}

.box-part:hover .fa , 
.box-part:hover .fas , 
.box-part:hover .title , 
.box-part:hover .text ,
.box-part:hover a{
    color:#414141;
    -webkit-transition: all 300ms ease-out;
    -moz-transition: all 300ms ease-out;
    -o-transition: all 300ms ease-out;
    transition: all 300ms ease-out;
}

.text{
    margin:20px 0px;
}
.fa{
     color:#4183D7;
}
.fab{
     color:#4183D7;
}
.fas{
     color:#4183D7;
}


.overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.7);
  transition: opacity 500ms;
  visibility: hidden;
  opacity: 0;
}
.overlay:target {
  visibility: visible;
  opacity: 1;
}

.popup {
  margin: 70px auto;
  padding: 20px;
  background: #414141;
  border-radius: 5px;
  width: 30%;
  position: relative;
  transition: all 5s ease-in-out;
}

.popup h2 {
  margin-top: 0;
  color: #fff;
  font-family: Tahoma, Arial, sans-serif;
}
.popup .close {
  position: absolute;
  top: 20px;
  right: 30px;
  transition: all 200ms;
  font-size: 30px;
  font-weight: bold;
  text-decoration: none;
  color: #fff;
}
.popup .close:hover {
  color: red;
}
.popup .content {
  max-height: 30%;
  overflow: auto;
}

@media screen and (max-width: 700px){
  .box{
    width: 70%;
  }
  .popup{
    width: 70%;
  }
}

.BotIcon {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  -webkit-background-size: 50px;
  -moz-background-size: 50px;
  background-size: 50px;
  background-color: #fff;
  -webkit-box-shadow: 0 0 16px rgba(0,0,0,0.8);
  box-shadow: 0 0 16px rgba(0,0,0,0.8);
}

.topnumber .number {
    width: 60px!important;
    height: 60px!important;
    font-size: 30px;
    list-style: none;
    box-shadow: 0px 0px 8px -2px rgba(0,0,0,0.4);
    position: absolute;
    right: -10px;
    top: 15px;
    pointer-events: none;
    background: white;
    border-style: dashed; 
}
.topnumber img{
    width: 100px!important;
    height: 100px!important;
    box-shadow: 0px 0px 8px -2px rgba(0,0,0,0.4);
    position: absolute;
    right: -20px;
    top: -5px;
    pointer-events: none;
    background: none;
    border-style: none; 
}
ol {
    list-style: none;
   counter-reset: item;
}
.status {

    text-align: center;
    align-items: center;
    justify-content: space-between;
    flex-direction: row;
    flex-wrap: nowrap;
    color: #414141;
    text-transform: uppercase;
    font: 700 12px "Karla", sans-serif;
    position: relative;
    width: 58px;
}
.green {
    color: green;
}
.red {
    color: red;
}
.yellow {
    color: yellow;
}

.navbar {
    display: -webkit-box;
    display: flex;
    top: 0;
    width: 100%;
    background: rgba(0,0,0,.5);
    z-index: 9001;
    -webkit-transition: background-color .1s ease-out;
    transition: background-color .1s ease-out;
}
}


/* Solid class attached on scroll past first section */
.navbar.solid {
  background-color: #7289DA;
  -webkit-transition: background-color 1s ease 0s;
  transition: background-color 1s ease 0s;
  box-shadow: 0 0 4px grey;
}
.navbar.solid .navbar-brand {
  color: #414141;
  -webkit-transition: color 1s ease 0s;
  transition: color 1s ease 0s;
}
.navbar.solid .navbar-nav > li > a {
  color: #414141;
  -webkit-transition: color 1s ease 0s;
  transition: color 1s ease 0s;
}

.about {
  background-color: #C57ED3;
  color: #490D40;
  height: 600px;
  text-align: center;
  margin-top: -20px;
}
.about h2 {
  padding-top: 220px;
}
.about p {
  padding: 20px 80px;
}
.navbar-brand {
    font-size: 40px; 
    font-weight: 900
}
@media screen and (max-width: 620px) {
    .navbar-brand {
    font-size: 20px; 
    font-weight: 400
}
}
.playerIcon {
  display: none;
    position: relative;
    border-radius: 50%;
    height: 32px;
    width: 32px;
}
.playerIcon img {
    border-radius: 50%;
    color: white;
    background-color: black;
}

.playerIcon_text {
position: absolute;
    display: block;
    background: #000;
    top: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    opacity: 0;
    -webkit-transition: opacity .2s ease-out;
    transition: opacity .2s ease-out;
    }
  .textArea {
    resize: vertical;
    min-height: 5rem;
    max-height: 500px;
  }
  .desc {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border: 2px solid hsla(214, 65%, 55%, .25);
    border-radius: 4px;
    outline: none;
    background: transparent;
    color: #fff;
    font-family: inherit;
    font-size: inherit;
    padding: 1rem;
    margin: 0;
    -webkit-transition: border-color .2s ease-out;
    transition: border-color .2s ease-out;
    width: 90%;
  }
  .input {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border: 2px solid hsla(214, 65%, 55%, .25);
    border-radius: 4px;
    outline: none;
    background: transparent;
    color: #fff;
    font-family: inherit;
    font-size: inherit;
    padding: 1rem;
    margin: 0;
    -webkit-transition: border-color .2s ease-out;
    transition: border-color .2s ease-out;
  }
  .infoLabel ,
  .boxHelp {
    color: white;
  }
  a:hover, .bot_details_avatar:hover, h1:hover, p:hover {
opacity: 0.5
}
</style>
</head>
<body>
<script>
$(document).ready(function() {
        // Transition effect for navbar 
        $(window).scroll(function() {
          // checks if window is scrolled more than 500px, adds/removes solid class
          if($(this).scrollTop() > 500) { 
              $('.navbar').addClass('solid');
          } else {
              $('.navbar').removeClass('solid');
          }
        });
});
</script>

<nav class="navbar navbar-expand-lg navbar-light bg-dark " style="list-style: none;">
<div class="container">
    <a href="//keksstudios.dev"><img src="../assets/images/KeksBotTrans.webp" width="50" height="50" class="d-inline-block align-top" alt="" loading="lazy"></a>
    <a class="navbar-brand" style="color: white;">DISCORDROBOTS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"/>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <h4 class="nav-link"><a class="nav-link white"  style="color: white " href="../index.php">HOME</a></h4>
                </a>
            </li>
		    <li>
                <h4 class="nav-link"><a class="nav-link white"  style="color: white" href="../bot/search">ALL BOTS</a></h4>
            </li>
        </ul>
		</div>
        <a class=""  href="../users/?user=<?php echo $user->id ?>"><img id="PlayerIcon" src="../assets/images/question_mark.svg" class="playerIcon" /></a> 
        <a class="" href="../bot/new"><img id="NewBot" src="../assets/images/plus.png" class="playerIcon" /></a>
        <li>
            <h4 class="nav-link white" style="color: white"><a class="nav-link white" style="color: white" href="?action=login" id="loginHREF"><button id="loginButton" class="btn btn-primary">LOGIN</button></a></h4>
        </li> 
        </div>
</nav>
  <div id="name"></div>
 	
        <?php

if(!isset($_GET["user"])) {
    
	?>
	<meta http-equiv="refresh" content="0; URL=https://keksstudios.dev/discordrobots/bot/search">
	<?php
	
} else {

    $foundRQ1 = false;
    $foundR1 = false;
	$canGetMetaBot = false;
    $canGetMetaUser = false;
    ?>
<div class="bot">
<div class="bot_details">
<div class="bot_details_more">
<?php
$sql = "SELECT * FROM r WHERE owner_id = ".$_GET["user"];
$result = mysqli_query($pdo, $sql);
$sql_user = "SELECT * FROM r WHERE owner_id = ".$_GET["user"];
$result_user = mysqli_query($pdo, $sql_user);
$row_user = mysqli_fetch_array($result_user);
if($row_user == null) {
  echo '<img id="bot-img" class="bot_details_avatar" src="../assets/images/question_mark.svg" alt=""><div class="bot_details_stats">';
  echo '<h1 id="bot">User not found<span class="bot_discrimi">#0000</h1>';
  echo '<div class="bot_details_row">';
  echo '<a href="../bot/new"><button class="btn btn-primary" style="border-radius: 50px; box-shadow: 0 0 16px rgba(0,0,0,0.8);"><i class="fa fa-plus" style="color: white; padding-right: 10px"></i>Add your Bot now</button></a>';
  echo '</div>';
  die();
}
$sql3_user = "SELECT * FROM owner_meta WHERE user_id = ".$row_user["owner_id"];
$result3_user = mysqli_query($pdo, $sql3_user);
$row3_user = mysqli_fetch_array($result3_user);

echo '<img id="bot-img" class="bot_details_avatar" src="'.$row3_user["avatar_url"].'?size=1024" alt=""><div class="bot_details_stats">';
echo '<h1 id="bot">'.$row3_user["username"].'<span class="bot_discrimi">#'.$row3_user["discriminator"].'</h1>';
echo '</div></div></div></div></div></div>';
echo '<div class="container">
<h2>Bots:</h2>
<div class="row">';

while($row = mysqli_fetch_array($result)) {
    $sql2 = "SELECT * FROM bot_meta WHERE bot_id = ".$row["bot_id"];
    $result2 = mysqli_query($pdo, $sql2);

    while($row1 = mysqli_fetch_array($result2)) {
		
		$canGetMetaBot = true;

        $sql3 = "SELECT * FROM owner_meta WHERE user_id = ".$row["owner_id"];
        $result3 = mysqli_query($pdo, $sql3);

        while($row2 = mysqli_fetch_array($result3)) {
			
			$canGetMetaUser = true;
			

			
			

            if(!isset($_GET["type"])) {
				


                ?>


			 
			    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
               									 
					<div class="box-part text-center">
					  <img src="<?php echo $row1["avatar_url"]?>?size=1024" class="BotIcon" />
					  <br/><br/>
					<div class="title white">
							<h3 class="title"><?php echo $row1["username"] ?></h3>
                            <span class="status green"><ul style="display:inline-table"><li>ONLINE</li></ul></span>
						</div>
                        
						<div class="text white">
							<h4><?php echo $row["short_description"] ?></h4>
						</div>
						
						<a class="btn btn-primary" href="//keksstudios.dev/discordrobots/bot/result?bot=<?php echo $row1["bot_id"] ?>">To the botpage</a>
                        </div>
					 </div> 

                <?php
     
						}
            } 
}

                        }
                    }
                
                    echo '</div></div>';
						
		
	
                    if($canGetMetaBot == false) {

                      require_once('../errors/abcdefg404abcdefg.php');
                      
                      } else  {
                        if($canGetMetaUser == false) {
                          require_once('../errors/abcdefg404abcdefg.php');
                        }
                      }
                      
?>
<footer style="background-color: #2C2F33">
<div class="container" style="padding-top: 20px; padding-bottom: 20px">
<center><h4 style="color: white">Made with ❤ by KeksStudios by using <img src="https://snippetsofcode.files.wordpress.com/2011/08/php.png" width="30px" height="30px"><img src="https://icons-for-free.com/iconfiles/png/512/award+badge+html+html5+reward+trophy+icon-1320184828635374270.png" width="30px" height="30px"><img src="https://cdn.iconscout.com/icon/free/png-512/css-118-569410.png" width="37px" height="37px"> and <img src="https://cdn2.iconfinder.com/data/icons/nodejs-1/512/nodejs-512.png" width="37px" height="37px"></h4></center>
</div>
</footer>
<script src="//keksstudios.dev/assets/jquery/jquery.min.js"></script>
  <script src="//keksstudios.dev/assets/jquery/jquery-migrate.min.js"></script>
  <script src="//keksstudios.dev/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>