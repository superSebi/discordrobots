<!DOCTYPE html>
<html>

<?php
	
	if(!isset($_GET["request"])) {
	
		
		header("https://discord.gg/ExCrcDX");

	} else {

		if($_GET["request"] == "BotBan") {

			header("Location: https://docs.google.com/forms/u/2/d/e/1FAIpQLSdMKgnfLomC7IMLF28gpoU7MptJlYIy8cTvH3SgI9AuHs7psg/viewform");
			
		}
		
		if($_GET["request"] == "OwnerVerification") {
			header("Location: https://forms.gle/rnjSoa1AEoAfaYEU9");
		}
	}
?>

</html>
