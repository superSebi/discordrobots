<!DOCTYPE html>
<html>
    <head>
        <style>
            /**/
:root {
  --main-color: #738bdc;
  --stroke-color: black;
  
}
/**/
body {
  background: var(--main-color);
}
h1 {
  margin: 10px auto 0 auto;
  color: var(--stroke-color);
  font-family: 'Encode Sans Semi Condensed', Verdana, sans-serif;
  font-size: 60px;
  font-weight: 200;
  text-align: center;
}
img {
    margin-top: 60px;
    align: center;
}
h2 {
  margin: 20px auto 30px auto;
  font-family: 'Encode Sans Semi Condensed', Verdana, sans-serif;
  font-size: 1.5rem;
  font-weight: 200;
  text-align: center;
}
h1, h2 {
  -webkit-transition: opacity 0.5s linear, margin-top 0.5s linear; /* Safari */
  transition: opacity 0.5s linear, margin-top 0.5s linear;
}
.loading h1, .loading h2 {
  margin-top: 0px;
  opacity: 0;  
}
.gears {
  position: relative;
  margin: 0 auto;
  width: auto; height: 0;
}
.gear {
  position: relative;
  z-index: 0;
  width: 120px; height: 120px;
  margin: 0 auto;
  border-radius: 50%;
  background: var(--stroke-color);
}
.gear:before{
  position: absolute; left: 5px; top: 5px; right: 5px; bottom: 5px;
  z-index: 2;
  content: "";
  border-radius: 50%;
  background: var(--main-color);
}
.gear:after {
  position: absolute; left: 25px; top: 25px;
  z-index: 3;
  content: "";
  width: 70px; height: 70px;
  border-radius: 50%;
  border: 5px solid var(--stroke-color);
  box-sizing: border-box;
  background: var(--main-color);
}
.gear.one {
  left: -130px;
}
.gear.two {
  top: -75px;
}
.gear.three {
  top: -235px;
  left: 130px;
}
.gear .bar {
  position: absolute; left: -15px; top: 50%;
  z-index: 0;
  width: 150px; height: 30px;
  margin-top: -15px;
  border-radius: 5px;
  background: var(--stroke-color);
}
.gear .bar:before {
  position: absolute; left: 5px; top: 5px; right: 5px; bottom: 5px;
  z-index: 1;
  content: "";
  border-radius: 2px;
  background: var(--main-color);
}
.gear .bar:nth-child(2) {
  transform: rotate(60deg);
  -webkit-transform: rotate(60deg);
}
.gear .bar:nth-child(3) {
  transform: rotate(120deg);
  -webkit-transform: rotate(120deg);
}
@-webkit-keyframes clockwise {
  0% { -webkit-transform: rotate(0deg);}
  100% { -webkit-transform: rotate(360deg);}
}
@-webkit-keyframes anticlockwise {
  0% { -webkit-transform: rotate(360deg);}
  100% { -webkit-transform: rotate(0deg);}
}
@-webkit-keyframes clockwiseError {
  0% { -webkit-transform: rotate(0deg);}
  20% { -webkit-transform: rotate(30deg);}
  40% { -webkit-transform: rotate(25deg);}
  60% { -webkit-transform: rotate(30deg);}
  100% { -webkit-transform: rotate(0deg);}
}
@-webkit-keyframes anticlockwiseErrorStop {
  0% { -webkit-transform: rotate(0deg);}
  20% { -webkit-transform: rotate(-30deg);}
  60% { -webkit-transform: rotate(-30deg);}
  100% { -webkit-transform: rotate(0deg);}
}
@-webkit-keyframes anticlockwiseError {
  0% { -webkit-transform: rotate(0deg);}
  20% { -webkit-transform: rotate(-30deg);}
  40% { -webkit-transform: rotate(-25deg);}
  60% { -webkit-transform: rotate(-30deg);}
  100% { -webkit-transform: rotate(0deg);}
}
.gear.one {
  -webkit-animation: anticlockwiseErrorStop 2s linear infinite;
}
.gear.two {
  -webkit-animation: anticlockwiseError 2s linear infinite;
}
.gear.three {
  -webkit-animation: clockwiseError 2s linear infinite;
}
.loading .gear.one, .loading .gear.three {
  -webkit-animation: clockwise 3s linear infinite;
}
.loading .gear.two {
  -webkit-animation: anticlockwise 3s linear infinite;
}
        </style>
    </head>
    <link href="https://fonts.googleapis.com/css?family=Encode+Sans+Semi+Condensed:100,200,300,400" rel="stylesheet">
<body class="loading">
    <div style="text-align: center">
    <img height="200px" width="200px" src="https://cdn.discordapp.com/attachments/693961805260652626/695730872078565659/Logo.png" alt="">
</div>
  <h1>An unexpected error occurred</h1>
  <h2>Navid did something wrong</h2>
  <div class="gears">
    <div class="gear one">
      <div class="bar"></div>
      <div class="bar"></div>
      <div class="bar"></div>
    </div>
    <div class="gear two">
      <div class="bar"></div>
      <div class="bar"></div>
      <div class="bar"></div>
    </div>
    <div class="gear three">
      <div class="bar"></div>
      <div class="bar"></div>
      <div class="bar"></div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</body>
<footer>
<script>
    $(function() {
  setTimeout(function(){
    $('body').removeClass('loading');
  }, 1000);
});

</script>
</footer>
</html>