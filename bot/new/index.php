<!-- Website made with love by keksstudios.dev | Copy paste is not allowed! -->
<?php
$pdo = new mysqli('#CENSORED#');
if($pdo->$connect_error) {
    die($connect_error);
}
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
    'redirect_uri' => 'https://keksstudios.dev/discordrobots/bot/new',
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
    'redirect_uri' => 'https://keksstudios.dev/discordrobots/bot/new',
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
	  document.getElementById('PlayerIcon').src = "https://cdn.discordapp.com/avatars/<?php echo $user->id ?>/<?php echo $user->avatar ?>.png";
	  document.getElementById('PlayerIcon').alt = '<?php echo $user->username ?>#<?php echo $user->discriminator ?>';
      document.getElementById('PlayerIcon').title = '<?php echo $user->username ?>#<?php echo $user->discriminator ?>';
      document.getElementById('loginButton').innerText = 'LOGOUT';
      document.getElementById('loginHREF').href = '?action=logout';
 }, 100);
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
    $_SESSION["logged_in"] = 'false';
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
if($isLoggedIn) {
?>
<html lang="en">
<head>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<link href="assets/emoji-picker/lib/css/style5.css" rel="stylesheet">
<meta name="google-signin-client_id" content="1074910460731-dgkalatuokgr9a3okjop3nhvvnfk3ppl.apps.googleusercontent.com">
	<script data-ad-client="ca-pub-4609945663829295" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <script src="https://www.webrtc-experiment.com/RecordRTC.js"></script>
    <script src="https://www.webrtc-experiment.com/gif-recorder.js"></script>
    <script src="https://www.webrtc-experiment.com/getScreenId.js"></script>
    <script src="https://www.webrtc-experiment.com/DetectRTC.js"> </script>
    <title id="title">DiscordRobots - Add a new Bot</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//keksstudios.dev/assets/bootstrap/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.woff" rel="stylesheet" id="bootstrap-css">-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="DiscordRobots - Add your cool Bot to our cool DiscordBotList.">
    <meta name="keywords" content="Discord Bot List,  Discord Bots, Discord, kostenlos, free, fun, musicbot">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <meta name="theme-color" content="#ffcc00">
	<link rel="manifest" href="//keksstudios.dev/manifest.json">
    <meta name="twitter:title" content="DiscordRobots - Add a new Bot">
	<meta name="twitter:description" content="DiscordRobots - Add your cool Bot to our cool DiscordBotList.">
	<meta property="og:description" content="DiscordRobots - Add your cool Bot to our cool DiscordBotList.">
	<meta property="og:title" content="DiscordRobots - Add a new Bot">
	<meta property="og:type" content="website">
	<meta property="og:image" content="//keksstudios.dev/new/assets/images/ks-logo-192x192.jpg">
	<meta name="twitter:image" content="//keksstudios.dev/new/assets/images/ks-logo-192x192.jpg">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Change language Script by KeksStudios.dev | START -->

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
.banner {
background: url(assets/images/test_banner.png) repeat;
    -webkit-animation: scrolling-background 120s linear infinite;
    animation: scrolling-background 120s linear infinite;
    position: relative;
    display: -webkit-box;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    flex-direction: column;
    width: 100%;
    height: 100vh;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
    overflow: hidden;
}


.height100 {
    height: 100%;
}

.banner_content {
    display: -webkit-box;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    flex-direction: column;
    -webkit-box-align: center;
    align-items: center;
}

.banner_content_searchbar {
    display: -webkit-box;
    display: flex;
    width: 100%;
    margin-bottom: 1rem;
}

.banner_content input {
    -webkit-box-flex: 2;
    flex: 2 1 auto;
    margin-right: 1rem;
}

.banner_content button {
    -webkit-box-flex: 1;
    flex: 1 1 25%;
}

.banner_content_button {
    color: #fff;
    border-radius: 4px;
    background: hsla(227, 58%, 65%,.5);
    -webkit-transition: background-color .2s ease-out;
    transition: background-color .2s ease-out;
    outline: none;
    border: none;
    font-size: 20px;
}

.banner_search {
    width: 100%;
    background: hsla(0, 0%, 25%,.5);
    border: none;
    outline: none;
    font-size: 20px;
    color: #fff;
    padding: 1rem;
    font-family: inherit;
    border-radius: 8px;
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
    width: 300%;
  }
  @media screen and (max-width: 1440px) {
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
  a {
text-decoration: none;
color: black;
}
a:hover {
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
    <a href="//keksstudios.dev"><img src="../../assets/images/KeksBotTrans.webp" width="50" height="50" class="d-inline-block align-top" alt="" loading="lazy"></a>
    <a class="navbar-brand" style="color: white;">DISCORDROBOTS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"/>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <h4 class="nav-link"><a class="nav-link white"  style="color: white " href="../../index.php">HOME</a></h4>
                </a>
            </li>
		    <li>
                <h4 class="nav-link"><a class="nav-link white"  style="color: white" href="../../bot/search">ALL BOTS</a></h4>
            </li>
        </ul>
		</div>
        <a class=""  href="../../users/?user=<?php echo $user->id ?>"><img class="playerIcon" id="PlayerIcon" src="../../assets/images/question_mark.svg" width="32px" height="32px" /></a> 
        <a class="" href="../../bot/new"><img id="PlayerIcon" src="../../assets/images/plus.png" width="32px" height="32px" /></a>
        <li>
            <h4 class="nav-link white" style="color: white"><a class="nav-link white" style="color: white" href="?action=login" id="loginHREF"><button id="loginButton" class="btn btn-primary">LOGIN</button></a></h4>
        </li> 
        </div>
</nav>


  
					<!-- LOG IN SCRIPT BY GOOGLE AN KEKSSTUDIOS | END -->
                    <center><button class="btn btn-warning"><a href="https://discord.gg/66Kau86" style="color: white;">JOIN OUR SERVER FIRST THEN SUBMIT YOUR BOT OVER THIS FORM</a></button></center>



<?php 

$setID = false;
$setDesc = false;
$setInvite = false;
$setSupport = false;
$setPrefix = false;
$setLib = false;
$setShortDesc = false;
$setWebsite = false;
$setGithub = false;
$setOtherOwner = false;

if(isset($_POST["submit"])) {

    try {
    $pdo = new PDO('mysql:host=localhost;dbname=discordrobots', 'keks', 'KEKSsql2020#!');
    } catch(Exception $e) {
        die('<body style="background-color: #414141; text-align: center; color: white; font-family: Arial"><div style="padding: 50, 50, 50, 50; background-color: #212529; box-shadow: 0 0 10px rgba(0,0,0,0.2); border-style: solid; border-color: red;"><h1 style="color: white; text-align: center">Our service is temporary unavailable OwO</h1></div><br/><br/><br/><div style="padding: 50, 50, 50, 50; background-color: #212529; box-shadow: 0 0 10px rgba(0,0,0,0.2); border-style: solid; border-color: red;"><h2>Error-Log which you can send to our support:</h2><p><strong>Error-Title:</strong> <br/>The Database is offline. <br/> <strong>Error-Desc:</strong> <br/> By trying to reach the database an unexcepted error occupied. <br/>'.$e.'</p></div></body>');

    }
    
    $botID = trim($_POST["bot_id"]);
    $short_description = trim($_POST["short_description"]);
    $description = trim($_POST["description"]);
    $inviteLink = trim($_POST["invite"]);
    $supportcode = trim($_POST["supportcode"]);
    $prefix = trim($_POST["prefix"]);
    $library = trim($_POST["lib"]);
    $website = trim($_POST["website"]);
    $github = trim($_POST["github"]);
    $other_owner = trim($_POST["other_owner"]);
    $tag = $_POST["tags"];

    if(!$botID == "") {
        $setID = true;
    } else {
        die('<body style="background-color: #414141; text-align: center; color: white; font-family: Arial"><div style="padding: 50, 50, 50, 50; background-color: #212529; box-shadow: 0 0 10px rgba(0,0,0,0.2); border-style: solid; border-color: red;"><h1 style="color: white; text-align: center">You did something wrong OwO</h1></div><br/><br/><br/><div style="padding: 50, 50, 50, 50; background-color: #212529; box-shadow: 0 0 10px rgba(0,0,0,0.2); border-style: solid; border-color: red;"><h2>Error-Log which you can send to our support:</h2><p><strong>Error-Title:</strong> <br/>The BotID cannot be fetched<br/> <strong>Error-Desc:</strong> <br/> The BotID cannot be fetched from the form -> Nothing is entered there -> Please resubmit with a BotID</p></div></body>');
    }

    if(!$description == "") {
        $setDesc = true;
    } else {
        die('<body style="background-color: #414141; text-align: center; color: white; font-family: Arial"><div style="padding: 50, 50, 50, 50; background-color: #212529; box-shadow: 0 0 10px rgba(0,0,0,0.2); border-style: solid; border-color: red;"><h1 style="color: white; text-align: center">You did something wrong OwO</h1></div><br/><br/><br/><div style="padding: 50, 50, 50, 50; background-color: #212529; box-shadow: 0 0 10px rgba(0,0,0,0.2); border-style: solid; border-color: red;"><h2>Error-Log which you can send to our support:</h2><p><strong>Error-Title:</strong> <br/>The Description cannot be fetched<br/> <strong>Error-Desc:</strong> <br/> The Description cannot be fetched from the form -> Nothing is entered there -> Please resubmit with a Description</p></div></body>');
    }

    if(!$short_description == "") {
        $setShortDesc = true;
    } else {
        die('<body style="background-color: #414141; text-align: center; color: white; font-family: Arial"><div style="padding: 50, 50, 50, 50; background-color: #212529; box-shadow: 0 0 10px rgba(0,0,0,0.2); border-style: solid; border-color: red;"><h1 style="color: white; text-align: center">You did something wrong OwO</h1></div><br/><br/><br/><div style="padding: 50, 50, 50, 50; background-color: #212529; box-shadow: 0 0 10px rgba(0,0,0,0.2); border-style: solid; border-color: red;"><h2>Error-Log which you can send to our support:</h2><p><strong>Error-Title:</strong> <br/>The Short Description cannot be fetched<br/> <strong>Error-Desc:</strong> <br/> The Short Description cannot be fetched from the form -> Nothing is entered there -> Please resubmit with a Short Description</p></div></body>');
    }

    if(!$library == "") {
        $setLib = true;
    } else {
        die('<body style="background-color: #414141; text-align: center; color: white; font-family: Arial"><div style="padding: 50, 50, 50, 50; background-color: #212529; box-shadow: 0 0 10px rgba(0,0,0,0.2); border-style: solid; border-color: red;"><h1 style="color: white; text-align: center">You did something wrong OwO</h1></div><br/><br/><br/><div style="padding: 50, 50, 50, 50; background-color: #212529; box-shadow: 0 0 10px rgba(0,0,0,0.2); border-style: solid; border-color: red;"><h2>Error-Log which you can send to our support:</h2><p><strong>Error-Title:</strong> <br/>The Library cannot be fetched<br/> <strong>Error-Desc:</strong> <br/> The Library cannot be fetched from the form -> Nothing is entered there -> Please resubmit with a Library</p></div></body>');
    }

    if(!$prefix == "") {
        $setPrefix = true;
    } else {
        die('<body style="background-color: #414141; text-align: center; color: white; font-family: Arial"><div style="padding: 50, 50, 50, 50; background-color: #212529; box-shadow: 0 0 10px rgba(0,0,0,0.2); border-style: solid; border-color: red;"><h1 style="color: white; text-align: center">You did something wrong OwO</h1></div><br/><br/><br/><div style="padding: 50, 50, 50, 50; background-color: #212529; box-shadow: 0 0 10px rgba(0,0,0,0.2); border-style: solid; border-color: red;"><h2>Error-Log which you can send to our support:</h2><p><strong>Error-Title:</strong> <br/>The Prefix cannot be fetched<br/> <strong>Error-Desc:</strong> <br/> The Prefix cannot be fetched from the form -> Nothing is entered there -> Please resubmit with a Prefix</p></div></body>');
    }

    if(!$supportcode == "") {
        $setSupport = true;
    } else {
        $setSupport = true;
        $supportcode = 'none';
    }

    if(!$inviteLink == "") {
        $setInvite = true;
    }

    if(!$website == "") {
        $setWebsite = true;
      } else {
        $website = null;
        $setWebsite = true;
      }
  
      if(!$github == "") {
        $setGithub = true;
      } else {
        $github = null;
        $setGithub = true;
      }

      if(!$other_owner == "") {
        $setOtherOwner = true;
      } else {
        $other_owner = null;
        $setOtherOwner = true;
      }
      
      if($tag == "") {
        $tag = null;
      }


    if($setDesc == true && $setPrefix == true && $setID == true && $setLib == true && $setShortDesc == true) {
        if($inviteLink == "") {
            $inviteLink = "https://discordapp.com/api/oauth2/authorize?client_id=".$botID.'&permissions=0&scope=bot';
        }
        $tags = implode(', ', $tag);
        $sql = "INSERT INTO q(bot_id, owner_id, supportcode, library, description, short_description, invite, prefix, github_repo, website_url, other_owner, tags) VALUES (:bot_id, :owner_id, :supportcode, :library, :description, :short_description, :invite, :prefix, :github_repo, :website_url, :other_owner, :tags)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['bot_id' => $botID, 'owner_id' => $user->id, 'supportcode' => $supportcode, 'library' => $library, 'description' => $description, 'short_description' => $short_description, 'invite' => $inviteLink, 'prefix' => $prefix, 'github_repo' => $github, 'website_url' => $website, 'other_owner' => $other_owner, 'tags' => $tags]);
        ?>
		
			<meta http-equiv="refresh" content="0; URL=https://keksstudios.dev/discordrobots/bot/new/success/">
		
		<?php

    } else {
      die();
    }

}


?>

<div> 
<center>
<div class="container">
        <!-- Page Title -->
        <h1 style="padding-top: 50px;">Submit your Bot</h1>


    <!-- Start of Bot-Information Form -->
    <form id="botinfo" method="post">



    <div class="row">
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

        <!-- Start of a InfoField -->
        <div class="infoField">

            <!-- Start of Meta-Datas for the InfoField -->
            <label class="infoLabel"><h2>Bot ID*</h2></label>
            <p class="boxHelp">Read <a href="../../docs/useful/how-get-a-id/" target="_blank">this Docs</a>, to find out how you get the ID</p>
            <!-- End of Meta-Datas for the InfoField -->

            <!-- Start of Inputs -->
            <div class="inputBox">
                <input name="bot_id" autocomplete="off" class="textArea input" style="width:240px" type="text" placeholder="693956903998455949"  maxlength="18" value="<?php 
                    if($setID == true) {
                        echo $botID;
                    }
                ?>">
            </div>
            <!-- End of Inputs -->

        </div>
        <!-- End of a InfoField -->

        
        <!-- Start of a InfoField -->
        <div class="infoField">

            <!-- Start of Meta-Datas for the InfoField -->
            <label class="infoLabel"><h2>Short Description*</h2></label>
            <p class="boxHelp">Max 100 Letters</p>
            <!-- End of Meta-Datas for the InfoField -->

            <!-- Start of Inputs -->
            <div class="inputBox">
                <input name="short_description" autocomplete="off" class="textArea input" style="width:240px" type="text" placeholder="Cool DiscordBot on the best BotList ;)"  maxlength="100" value="<?php
                    if($setShortDesc == true) {
                        echo $short_description;
                    }
                ?>">
            </div>
            <!-- End of Inputs -->

        </div>
        <!-- End of a InfoField -->

        <!-- Start of a InfoField -->
        <div class="infoField">
        
            <!-- Start of Meta-Datas for the InfoField -->
            <label class="infoLabel"><h2>Library*</h2></label>
            <!-- End of Meta-Datas for the InfoField -->

            <!-- Start of Inputs -->
            <div class="inputBox">
                <select name="lib">
                    <option value="">Choose one...</option>
                    <option value="JDA" <?php if($setLib == true){if($library=="JDA"){echo 'selected="selected"';}} ?>>JDA</option>
                    <option value="discord.js" <?php if($setLib == true){if($library=="discord.js"){echo 'selected="selected"';}} ?>>discord.js</option>
                    <option value="DiscordGo" <?php if($setLib == true){if($library=="DiscordGo"){echo 'selected="selected"';}} ?>>DiscordGo</option>
                    <option value="Eris" <?php if($setLib == true){if($library=="Eris"){echo 'selected="selected"';}} ?>>Eris</option>
                    <option value="Javacord" <?php if($setLib == true){if($library=="Javacord"){echo 'selected="selected"';}} ?>>Javacord</option>
                    <option value="discord.py" <?php if($setLib == true){if($library=="discord.py"){echo 'selected="selected"';}} ?>>discord.py</option>
                    <option value="SwiftDiscord" <?php if($setLib == true){if($library=="SwiftDiscord"){echo 'selected="selected"';}} ?>>SwiftDiscord</option>
                    <option value="Sword" <?php if($setLib == true){if($library=="Sword"){echo 'selected="selected"';}} ?>>Sword</option>
                    <option value="Other" <?php if($setLib == true){if($library=="Other"){echo 'selected="selected"';}} ?>>Other</option>
                </select>
            </div>
            <!-- End of Inputs -->

        </div>
        <!-- End of a InfoField -->

        <!-- Start of a InfoField -->
        <div class="infoField">
        
            <!-- Start of Meta-Datas for the InfoField -->
            <label class="infoLabel">Prefix*</label>
            <!-- End of Meta-Datas for the InfoField -->

            <!-- Start of Inputs -->
            <div class="inputBox">
                <input name="prefix" autocomplete="off" class="input" maxlength="10" type="text" placeholder="+" value="<?php
                    if($setPrefix == true) {
                        echo $prefix;
                    }
                ?>">
            </div>
            <!-- End of Inputs -->

        </div>
        <!-- End of a InfoField -->


        <!-- Start of a InfoField -->
        <div class="infoField" style="margin-top: 10px;">
        
            <!-- Start of Meta-Datas for the InfoField -->
            <label class="infoLabel">Support-Server Invite [optional]</span></label>
            <!-- End of Meta-Datas for the InfoField -->

            <!-- Start of Inputs -->
            <div class="inputBox">
                <p style="background-color: #414141; ">https://discord.gg/<input name="supportcode" maxlength="7" autocomplete="off" value="" class="" style="background-color: #414141; border: none; outline: none; color: white" type="text" placeholder="Gg2wUeS" value="">
            </div>
            <!-- End of Inputs -->

        </div>
        <!-- End of a InfoField -->


        <!-- Start of a InfoField -->
        <div class="infoField" style="margin-top: 10px;">
        
            <!-- Start of Meta-Datas for the InfoField -->
            <label class="infoLabel">Custom Invite[optional]</label>
            <p class="boxHelp">You can add a custom invite-link for extra permissions.</p>
            <!-- End of Meta-Datas for the InfoField -->

            <!-- Start of Inputs -->
            <div class="inputBox">
                <input name="invite" autocomplete="off" class="input" maxlength="100" type="text" value="">
            </div>
            <!-- End of Inputs -->

        </div>
        <!-- End of a InfoField -->

                <!-- Start of a InfoField -->
                <div class="infoField" style="margin-top: 10px;">
        
        <!-- Start of Meta-Datas for the InfoField -->
        <label class="infoLabel">Tags [optinal]</label>
        <p class="boxHelp">You can add  tags.</p>
        <!-- End of Meta-Datas for the InfoField -->

        <!-- Start of Inputs -->
        <div class="inputBox" style="color: white">
              <input type="checkbox" name="tags[]" value="music" >Music</input>
              <input type="checkbox" name="tags[]" value="mod">Moderation</input>
              <input type="checkbox" name="tags[]" value="web" >Web-Dashboard</input>
              <input type="checkbox" name="tags[]" value="level">Level System</input>
              <input type="checkbox" name="tags[]" value="fun" >Fun</input>
              <input type="checkbox" name="tags[]" value="eco" >Economy</input>
              <input type="checkbox" name="tags[]" value="sound" >Soundboard</input>
        </div>
        <!-- End of Inputs -->

    </div>
    <!-- End of a InfoField -->

           <!-- Start of a InfoField -->
           <div class="infoField" style="margin-top: 10px;">
          
          <!-- Start of Meta-Datas for the InfoField -->
          <label class="infoLabel">Website[optional]</label>
          <!-- End of Meta-Datas for the InfoField -->

          <!-- Start of Inputs -->
          <div class="inputBox">
              <input name="website" autocomplete="off" class="input" maxlength="100" type="text" value="">
          </div>
          <!-- End of Inputs -->
</div>
           <!-- Start of a InfoField -->
           <div class="infoField" style="margin-top: 10px;">
          
          <!-- Start of Meta-Datas for the InfoField -->
          <label class="infoLabel">Github Respository[optional]</label>
          <!-- End of Meta-Datas for the InfoField -->

          <div class="inputBox">
                <p style="background-color: #414141; ">https://github.com/<input name="github" maxlength="50" autocomplete="off" value="" class="" style="background-color: #414141; border: none; outline: none; color: white" type="text" placeholder="superSebi/Keksbot" value="">
            </div>

      </div>
      <!-- End of a InfoField -->

                 <!-- Start of a InfoField -->
                 <div class="infoField" style="margin-top: 10px;">
          
          <!-- Start of Meta-Datas for the InfoField -->
          <label class="infoLabel">Other Owner Id[optional]</label>
          <p class="boxHelp">Maximum is one ID atm.</p>
          <!-- End of Meta-Datas for the InfoField -->

          <div class="inputBox">
                <input name="other_owner" autocomplete="off" class="input" maxlength="18" type="text" value="">
            </div>

      </div>
      <!-- End of a InfoField -->
        </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" >

        <!-- Start of a InfoField -->
        <div class="infoField">
        
            <!-- Start of Meta-Datas for the InfoField -->
            <h2>Description*</h2>
            <p class="boxHelp">Describe your bot. You can use HTML/CSS/JS and customize your banner and more, read <a href="../../docs/useful/website/styles">here</a> how.</p>
            <!-- End of Meta-Datas for the InfoField -->

            <!-- Start of Inputs -->
            <div class="inputBox">
            
                <textarea name="description" style="margin-top: 0px;
    margin-bottom: 0px;
    height: 120%;" autocomplete="off" class="textarea desc textArea" id="description"  maxlength="5000" placeholder="This is a Bot which can be online" rows="10"><?php if($setDesc == true){echo $description;}?></textarea>
            </div>
            <!-- End of Inputs -->

        </div>

        <!-- End of a InfoField -->
        <button class="btn btn-primary btn-large" type="submit" name="submit" value="Submit">
            Submit
        </button>
        </div>
        </div>
    

    </form>
    <!-- End of Bot-Information Form -->

</div> 
</div>


</div>

<?php 
} else {
header('Location: ?action=login');
}
?>

</body>

</html>