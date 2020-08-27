<!-- Website made with love by keksstudios.dev | Copy paste is not allowed! -->
<?php
$pdo = new mysqli('#INSERT MYSQL DATABASE IP HERE#', '#INSERT MYSQL USER HERE#', '#INSERT MYSQL PW HERE#', '#INSERT MYSQL DATABASE NAME HERE#');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)

error_reporting(E_ALL);

define('OAUTH2_CLIENT_ID', '#INSERT OAUTH2_CLIENT_ID HERE#');
define('OAUTH2_CLIENT_SECRET', '#INSERT OAUTH2_CLIENT_SECRET HERE#');

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
      document.getElementById('PlayerIcon').href = 'users/user?=<?php echo $user->id ?>';
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
<link href="assets/emoji-picker/lib/css/style5.css" rel="stylesheet">
<meta name="google-signin-client_id" content="1074910460731-dgkalatuokgr9a3okjop3nhvvnfk3ppl.apps.googleusercontent.com">
	<script data-ad-client="ca-pub-4609945663829295" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <script src="https://www.webrtc-experiment.com/RecordRTC.js"></script>
    <script src="https://www.webrtc-experiment.com/gif-recorder.js"></script>
    <script src="https://www.webrtc-experiment.com/getScreenId.js"></script>
    <script src="https://www.webrtc-experiment.com/DetectRTC.js"> </script>
    <title id="title">DiscordRobots - Your DiscordBot List with the best bots</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.woff" rel="stylesheet" id="bootstrap-css">-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="DiscordRobots is your BotList with the best bots on Discord. You just search for an cool Bot or want that your bot get more servers? Then here is the perfect page for you.">
    <meta name="keywords" content="Discord Bot List,  Discord Bots, Discord, kostenlos, free, fun, musicbot">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <meta name="theme-color" content="#ffcc00">
	<link rel="manifest" href="//keksstudios.dev/manifest.json">
    <meta name="twitter:title" content="DiscordRobots - Your DiscordBot List with the best bots">
	<meta name="twitter:description" content="DiscordRobots is your BotList with the best bots on Discord. You just search for an cool Bot or want that your bot get more servers? Then here is the perfect page for you.">
	<meta property="og:description" content="DiscordRobots is your BotList with the best bots on Discord. You just search for an cool Bot or want that your bot get more servers? Then here is the perfect page for you.">
	<meta property="og:title" content="DiscordRobots - Your DiscordBot List with the best bots">
	<meta property="og:type" content="website">
	<meta property="og:image" content="//keksstudios.dev/assets/images/ks-logo-192x192.jpg">
	<meta name="twitter:image" content="//keksstudios.dev/assets/images/ks-logo-192x192.jpg">
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
  background: url(https://i.imgur.com/DocRwyB.jpg) repeat;epeat;
-webkit-animation: scrollGood 60s linear infinite;
  animation: scrollGood 60s linear infinite;
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
@-webkit-keyframes scrollGood {
 0%{background-position:0 0}to{background-position:-2160px -2160px}}
}
@keyframes scrollGood {
  0%{background-position:0 0}to{background-position:-2160px -2160px}}
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
    padding:60px 20px;
    margin:30px 0px;
    overflow: hidden;
}

.box-part .title {
    font-size: 30px;
    font-weight: 900;
    text-transform: uppercase;
}

.box-part:hover{
    background:#4183D7;
    -webkit-transition: all 300ms ease-out;
    -moz-transition: all 300ms ease-out;
    -o-transition: all 300ms ease-out;
    transition: all 300ms ease-out;
}

.box-part:hover .green {
  color: #90ee90;
  -webkit-transition: all 300ms ease-out;
    -moz-transition: all 300ms ease-out;
    -o-transition: all 300ms ease-out;
    transition: all 300ms ease-out;
}

.box-part:hover .fa , 
.box-part:hover .fas , 
.box-part:hover .title , 
.box-part:hover .text ,
.box-part:hover a{
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
  -webkit-transition: all 300ms ease-out;
    -moz-transition: all 300ms ease-out;
    -o-transition: all 300ms ease-out;
    transition: all 300ms ease-out;
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
    a:hover, .bot_info:hover, button:hover {
opacity: 0.5;
-webkit-transition: all 300ms ease-out;
    -moz-transition: all 300ms ease-out;
    -o-transition: all 300ms ease-out;
    transition: all 300ms ease-out;
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

<div class="height100">
<nav class="navbar navbar-expand-lg navbar-light bg-dark " style="list-style: none;">
<div class="container">
    <a href="//keksstudios.dev"><img src="assets/images/KeksBotTrans.webp" width="50" height="50" class="d-inline-block align-top" alt="" loading="lazy"></a>
    <a class="navbar-brand" style="color: white;">DISCORDROBOTS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"/>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <h4 class="nav-link"><a class="nav-link active"  style="color: #7289DA " href="index.php">HOME</a></h4>
                </a>
            </li>
		    <li>
                <h4 class="nav-link"><a class="nav-link white"  style="color: white" href="bot/search">ALL BOTS</a></h4>
            </li>
        </ul>
		</div>
    <a class=""  href="users/?user=<?php echo $user->id ?>"><img class="playerIcon" id="PlayerIcon" src="assets/images/question_mark.svg" width="32px" height="32px" /></a> 
        <a class="" href="bot/new"><img id="NewBot" class="playerIcon" src="assets/images/plus.png" /></a>
        <li>
            <h4 class="nav-link white" style="color: white"><a class="nav-link white" style="color: white" href="?action=login" id="loginHREF"><button id="loginButton" class="btn btn-primary">LOGIN</button></a></h4>
        </li> 
        </div>
</nav>

<div>
<section class="banner">
<section class="banner_content"><h1>DiscordRobots</h1><h2 class="bot_info">Your free DiscordBot List for your Server/Bot</h2>
<section class="banner_content_searchbar">
<form method="post" style="display: contents;
    margin-top: 0;
    margin-block-end: 0;"> 
<input type="text" placeholder="Search for an bot" name="search" class="banner_search" />
<button class="btn btn-primary button banner_content_button" type="submit" onclick="scrollToResult()" name="submit" value="Submit">Lets-a-go</button>
</form>

<?php 
if(isset($_POST["submit"])) {
  $found_search_result = false;
  $search = trim($_POST["search"]);
  $sql_search = "SELECT * FROM bot_meta WHERE username='".str_replace("'", "", $search)."'";
  $result_search = mysqli_query($pdo, $sql_search);
  echo '</div><div class="container">
  <h1 id="search_result">Search Result</h1>
  <div class="row">';
  while($row_search = mysqli_fetch_array($result_search)) {
    $found_search_result = true;
    ?>

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
               									 
                                  <div class="box-part text-center">
                                    <img src="<?php echo $row_search['avatar_url'] ?>" class="BotIcon" />
                                    <br/><br/>
                                  <div class="title white">
                                      <h3 class="title"><?php echo $row_search['username'] ?></h3>
                                                    <span class="status yellow"><ul style="display:inline-table"><li>unknown</li></ul></span>
                                    </div>
                                                
                                    <div class="text white">
                                      <h4>Desc not found</h4>
                                    </div>
                                    
                                    <a class="btn btn-primary" href="bot/result?bot=<?php echo $row_search['bot_id'] ?>">To the botpage</a>
                                   </div>
                                </div>	 
    <?php
  }
if($found_search_result == false) {
  ?>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
               									 
                                  <div class="box-part text-center">
                                    <img src="assets/images/question_mark.svg" class="BotIcon" />
                                    <br/><br/>
                                  <div class="title white">
                                      <h3 class="title">YOUR BOT?</h3>
                                                    <span class="status yellow"><ul style="display:inline-table"><li>Unkown</li></ul></span>
                                    </div>
                                                
                                    <div class="text white">
                                      <h4>Here stands your description</h4>
                                    </div>
                                    
                                    <a class="btn btn-primary" href="bot/new">Submit now</a>
                                   </div>
                                </div>	 
  <?php
}
  echo '</div></div>';
}
?>
<script>
function scrollToResult() {
  alert('Success! Scroll down to see your result!');
  var elmnt = document.getElementById("search_result");
  elmnt.scrollIntoView();
}
</script>
</section>
<section class="banner_content_searchbar">
<p class="bot_info"><a href="bot/search?tag=music"><i class="fa fa-music"></i> Music Bots</a></p>
<p class="bot_info" style="margin-left: 1rem"><a href="bot/search?tag=mod"><i class="fas fa-wrench"></i> Moderation Bots</a></p>
<p class="bot_info" style="margin-left: 1rem"><a href="bot/search?tag=web"><i class="fas fa-globe"></i> Bots with a Web-Dashboard</a></p>
</section>
<section class="banner_content_searchbar">
<p class="bot_info"><a href="bot/search?tag=music"><i class="fas fa-level-up-alt"></i> Bots with a Level-System</a></p>
<p class="bot_info" style="margin-left: 1rem"><a href="bot/search?tag=fun"><i class="fas fa-smile"></i> Fun Bots</a></p>
<p class="bot_info" style="margin-left: 1rem"><a href="bot/search?tag=eco"><i class="fas fa-money-bill-wave"></i> Economy Bots</a></p>
<p class="bot_info" style="margin-left: 1rem"><a href="bot/search?tag=sound"><i class="fas fa-headphones"></i> Soundboard Bots</a></p>
</section>
</section>
</section>
</div>
</div>

<div class="container">
<h1>Featured bots</h1>
<div class="row">

			 
			    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
               									 
					<div class="box-part text-center">
					  <img src="https://cdn.discordapp.com/avatars/493066387183632387/c3b24d124c4c7ecdcff99595426425f3.png?size=1024" class="BotIcon" />
					  <br/><br/>
					<div class="title white">
							<h3 class="title">KEKSBOT</h3>
                            <span class="status green"><ul style="display:inline-table"><li>ONLINE</li></ul></span>
						</div>
                        
						<div class="text white">
							<h4>Your completely free DiscordBot who can face any challange. </h4>
						</div>
						
						<a class="btn btn-primary" href="bot/result?bot=493066387183632387">To the botpage</a>
                        <div class="topnumber" >
                        <img style="box-shadow: none!important;" src="assets/images/stars.svg" width="50px" height="50px">
                        </div>
					 </div>
				</div>	 
			    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
               									 
					<div class="box-part text-center">
					  <img src="https://cdn.discordapp.com/avatars/645322918909182003/9a4dcafa6f8f914998055a52a4ba2ff0.png?size=1024" class="BotIcon" />
					  <br/><br/>
					<div class="title white">
							<h3 class="title">HELPFUL BOT</h3>
                            <span class="status green"><ul style="display:inline-table"><li>ONLINE</li></ul></span>
						</div>
                        
						<div class="text white">
							<h4>Helpful Bot is a bot that helps you manage your server with tons of commands.</h4>
						</div>
						
						<a class="btn btn-primary" href="bot/result?bot=645322918909182003">To the botpage</a>
                        <div class="topnumber" >
                        <img style="box-shadow: none!important;" src="assets/images/stars.svg" width="50px" height="50px">
                        </div>
					 </div>
				</div>	 
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
               									 
                                  <div class="box-part text-center">
                                    <img src="https://cdn.discordapp.com/avatars/555462171958444052/f30e012177eff1d4daaf36086327f1af.png?size=1024" class="BotIcon" />
                                    <br/><br/>
                                  <div class="title white">
                                      <h3 class="title">HERUKAN</h3>
                                                    <span class="status green"><ul style="display:inline-table"><li>ONLINE</li></ul></span>
                                    </div>
                                                
                                    <div class="text white">
                                      <h4>Herukan is a Discord Bot looking to bring great new features to your Discord server!</h4>
                                    </div>
                                    
                                    <a class="btn btn-primary" href="bot/result?bot=555462171958444052">To the botpage</a>
                                                <div class="topnumber" >
                                                <img style="box-shadow: none!important;" src="assets/images/stars.svg" width="50px" height="50px">
                                                </div>
                                   </div>
                                </div>	 	
			    		
			
		
		</div>		
    </div>
</div>
<div class="container">
<h1>Latest added bots</h1>
<div class="row">

			 <?php
      $sql = "SELECT * FROM r ORDER BY ix DESC LIMIT 3";
      $result = mysqli_query($pdo, $sql);
      while($data = mysqli_fetch_array($result)) {
        $sql2 = "SELECT * FROM bot_meta WHERE bot_id=".$data['bot_id'];
      $result2 = mysqli_query($pdo, $sql2);
      while($data2 = mysqli_fetch_array($result2)) {
        $status = "green";
        if($data["onlineStatus"] == "offline") {
          $status = "red";
        }

       ?>
			    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
               									 
					<div class="box-part text-center">
					  <img src="<?php echo $data2["avatar_url"]?>?size=1024" class="BotIcon" />
					  <br/><br/>
					<div class="title white">
							<h3 class="title"><?php echo $data2["username"]?></h3>
                            <span class="status <?php echo $status ?>"><ul style="display:inline-table"><li><?php echo $data["onlineStatus"] ?></li></ul></span>
						</div>
                        
						<div class="text white">
							<h4><?php echo $data["short_description"]?></h4>
						</div>
						
						<a class="btn btn-primary" href="bot/result/?bot=<?php echo $data['bot_id'] ?>">To the botpage</a>
					 </div>
				</div>	 
			    <?php
      }
    }
      ?>
			    		
			
		
		</div>		
    </div>
</div>
<div class="container">
<h1>Most voted bots</h1>
<div class="row">
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
               									 
                                  <div class="box-part text-center">
                                    <img src="https://cdn.discordapp.com/avatars/493066387183632387/c3b24d124c4c7ecdcff99595426425f3.png?size=1024" class="BotIcon" />
                                    <br/><br/>
                                  <div class="title white">
                                      <h3 class="title">KEKSBOT</h3>
                                                    <span class="status green"><ul style="display:inline-table"><li>ONLINE</li></ul></span>
                                    </div>
                                                
                                    <div class="text white">
                                      <h4>Your completely free DiscordBot who can face any challange. </h4>
                                    </div>
                                    
                                    <a class="btn btn-primary" href="#popup1">To the botpage</a>
                                                <div class="info">
                                                <div class="topnumber" >
                                                <img style="box-shadow: none!important;" src="assets/images/stars.svg" width="50px" height="50px">
                                                </div>
                                                </div>
                                   </div>
                                </div>
<?php
      $votes = 0;
      $sql_votes = "SELECT * FROM totalBotVotes ORDER BY amt DESC LIMIT 4";
      $result_votes = mysqli_query($pdo, $sql_votes);
      while($data_votes = mysqli_fetch_array($result_votes)) {
        $sql2_votes = "SELECT * FROM bot_meta WHERE bot_id=".$data_votes['bot_id'];
      $result2_votes = mysqli_query($pdo, $sql2_votes);
      while($data2_votes = mysqli_fetch_array($result2_votes)) {

        $votes = $votes + 1;
        $sql_bot = "SELECT * FROM r WHERE bot_id=".$data_votes['bot_id'];
        $result_bot = mysqli_query($pdo, $sql_bot);
        $row_bot = mysqli_fetch_array($result_bot);
        $status = "green";
        if($row_bot["onlineStatus"] == "offline") {
          $status = "red";
        }
?>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
               									 
                                  <div class="box-part text-center">
                                    <img src="<?php echo $data2_votes["avatar_url"]?>?size=1024" class="BotIcon" />
                                    <br/><br/>
                                  <div class="title white">
                                      <h3 class="title"><?php echo $data2_votes["username"]?></h3>
                                                    <span class="status <?php echo $status ?>"><ul style="display:inline-table"><li> <?php echo $row_bot["onlineStatus"] ?></li></ul></span>
                                    </div>
                                                
                                    <div class="text white">
                                      <h4><?php echo $row_bot["short_description"]?></h4>
                                    </div>
                                    
                                  	<a class="btn btn-primary" href="bot/result/?bot=<?php echo $data_votes['bot_id'] ?>">To the botpage</a>
                        <div class="topnumber">
                        <li class="number"><?php echo $votes ?></li>
                                                </div>
                                   </div>
                                </div>	 
			   <?php
      }
    }
         ?>
         			    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
               									 
                                  <div class="box-part text-center">
                                    <img src="https://cdn.discordapp.com/avatars/645322918909182003/9a4dcafa6f8f914998055a52a4ba2ff0.png?size=1024" class="BotIcon" />
                                    <br/><br/>
                                  <div class="title white">
                                      <h3 class="title">HELPFUL BOT</h3>
                                                    <span class="status green"><ul style="display:inline-table"><li>ONLINE</li></ul></span>
                                    </div>
                                                
                                    <div class="text white">
                                      <h4>Helpful Bot is a bot that helps you manage your server with tons of commands.</h4>
                                    </div>
                                    
                                    <a class="btn btn-primary" href="bot/result?bot=645322918909182003">To the botpage</a>
                                                <div class="topnumber" >
                                                <img style="box-shadow: none!important;" src="assets/images/stars.svg" width="50px" height="50px">
                                                </div>
                                   </div>
                                </div>	
    		</div>		
    </div>
</div>

<footer style="background-color: #2C2F33">
<div class="container" style="padding-top: 20px; padding-bottom: 20px">
<a href="//www.dmca.com/Protection/Status.aspx?ID=8833ea4a-449a-49f4-8bac-4d922ce25b5c" title="DMCA.com Protection Status" class="dmca-badge"> <img src ="https://images.dmca.com/Badges/dmca_protected_sml_120m.png?ID=8833ea4a-449a-49f4-8bac-4d922ce25b5c"  alt="DMCA.com Protection Status" /></a>  <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
<center><h4 style="color: white">Made with ❤ by KeksStudios by using <img src="https://snippetsofcode.files.wordpress.com/2011/08/php.png" width="30px" height="30px"><img src="https://icons-for-free.com/iconfiles/png/512/award+badge+html+html5+reward+trophy+icon-1320184828635374270.png" width="30px" height="30px"><img src="https://cdn.iconscout.com/icon/free/png-512/css-118-569410.png" width="37px" height="37px"> and <img src="https://cdn2.iconfinder.com/data/icons/nodejs-1/512/nodejs-512.png" width="37px" height="37px"></h4></center>
</div>
</footer>
<script src="assets/jquery/jquery.min.js"></script>
  <script src="assets/jquery/jquery-migrate.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
