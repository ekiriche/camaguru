<!DOCTYPE html>
<html>
<title>Web Page Design</title>
<head>
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="stylesheet" type="text/css" href="css/center.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
</head>
<body>
	<div class="header">
		<div class="logo">
			<a class="logoText" href="index.php">Camigiru</a>
		</div>
	</div>
	<div class="center">
		<h1>Please, enter your registred email here. We will send you required instructions.</h1>
		<?php
			session_start();
			if ($_SESSION["error"] == "empty")
				echo "<p class=\"error_message\">Field is empty</p>";
			if ($_SESSION["error"] == "not_exist")
				echo "<p class=\"error_message\">This email does not exists</p>";
			if ($_SESSION["error"] == "format")
				echo "<p class=\"error_message\">Wrong formated email</p>";
			if ($_SESSION["error"] == "gucci")
				echo "<p class=\"error_message\">Its all good. Check your email for new password</p>";
			$_SESSION["error"] = "";
		?>
		<form action="actualy_forgot.php" method="post">
			<input type="text" placeholder="Email..." name="email" value=""/>
			<input type="submit" name="submit" value="send"/>
		</form>
	</div>
	<div class="footer">
		<div class="footerText">
			<p>Copyright 1999-2018 by my bare hands. All Rights Reserved.</p>
			<p>Powered by -42</p>
		</div>
	</div>
</body>
</html>