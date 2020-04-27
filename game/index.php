<?php
//include('../register.php');
session_start();
if (!isset($_COOKIE['id']))
{
    header('location: ../index.php');
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>خليك بالبيت</title>
		<meta content="Tradinos creative hub" name="description">
		<link rel="stylesheet" type="text/css" media="screen" href="index.css">
		<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta charset="utf-8">
	</head>
	<body>
		<!-- preview -->
		<div id="preview"><img src="fbPic.jpg">Khaleek belbiet</div>

		<!-- rotate warning -->
		<div id="block_land_true"><div id="rotateDevice" style="margin-top:0"><img src="data/img/gui/rotate_smart_p.png"></div></div>
		<div id="block_land_false"><div id="rotateDevice" style="margin-top:0"><img src="data/img/gui/rotate_smart_l.png"></div></div>
		
		<!-- Canvas placeholder -->
		<div id="screen"></div>

		<!-- ads -->
		<div id="ads" style="bottom:0; background-color:#000">HERE YOUR ADS CODE</div>

		
		<!-- melonJS Library -->
		<script type="text/javascript" src="lib/melonJS.js"></script>

		<!-- md5 Library -->
		<script type="text/javascript" src="lib/md5.js"></script>

		
		<!-- Game -->
		<script type="text/javascript" src="js/game.js"></script>
		
		<!-- Bootstrap & Mobile optimization tricks -->
		<script type="text/javascript">
			var PREFS;
			var SID = false;
			window.onReady(function onReady() {
				me.loader.load({name: "prefs",  type:"json",  src: "data/prefs.json"}, function () {
					PREFS = me.loader.getJSON('prefs');
					for (var key in PREFS) {
						if (PREFS.hasOwnProperty(key)) {
							if(PREFS[key]["type"]=="bool"){
								PREFS[key]["value"] = (PREFS[key]["value"]=="true");
							}
							if(PREFS[key]["type"]=="number" || PREFS[key]["type"]=="range"){
								PREFS[key]["value"] = parseFloat(PREFS[key]["value"]);
							}
						}
					}
					
					if(navigator.isCocoonJS){
						game.onload();
					}else{
						me.loader.load({name: "loading",  type:"image",  src: "data/img/gui/loading.png"}, function () {game.onload();});
					}
					// PREFS.SCORE_URL.value = 'http://localhost:8080/khaleek_belbet/game/saveScore.php';
					console.log(PREFS);
				});
				

				// Mobile browser hacks
				if (me.device.isMobile && !navigator.isCocoonJS) {
					// Prevent the webview from moving on a swipe
					window.document.addEventListener("touchmove", function (e) {
						e.preventDefault();
						window.scroll(0, 0);
						return false;
					}, false);

					// Scroll away mobile GUI
					(function () {
						window.scrollTo(0, 1);
						me.video.onresize(null);
					}).defer();

					me.event.subscribe(me.event.WINDOW_ONRESIZE, function (e) {
						window.scrollTo(0, 1);
					});
				}
			});
		</script>
	</body>
</html>
