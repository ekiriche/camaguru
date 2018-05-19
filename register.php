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
		<?php 
		session_start();
        if ($_SESSION["register_error"] == "empty")
			echo "<p class=\"error_message\">All fields must contain info</p>";
		else if ($_SESSION["register_error"] == "email")
			echo "<p class=\"error_message\">Wrong email</p>";
        else if ($_SESSION["register_error"] == "different_passwords")
            echo "<p class=\"error_message\">Different passwords</p>";
        else if ($_SESSION["register_error"] == "short_username")
            echo "<p class=\"error_message\">Username's lentght must be > 4</p>";
        else if ($_SESSION["register_error"] == "short_password")
            echo "<p class=\"error_message\">Password's length must be > 6</p>";
        else if ($_SESSION["register_error"] == "user_exists")
            echo "<p class=\"error_message\">This user already exists</p>";
        else if ($_SESSION["register_error"] == "confirm")
            echo "<p class=\"error_message\">Registration is almost over! Check your email for additional info</p>";
		$_SESSION["register_error"] = "";
		?>
		<form class="regForm" action="create_user.php" method="post">
			<p>Username</p>
			<input type="text" name="username" value=""/>
			<p>Email</p>
			<input type="text" name="email" value=""/>
			<p>Password</p>
			<input type="password" name="password" value=""/>
			<p>Confirm password</p>
			<input type="password" name="confirm_password" value=""/>
			<br>
			<input type="submit" name="submit" value="OK"/>
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