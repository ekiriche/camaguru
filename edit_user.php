<?php
	session_start();
	if ($_SESSION["loged_in_user"] == "")
	{
		$_SESSION["lost_in_woods"] = "true";
	}
?>
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
		<div class="hello_name">
		<?php
			session_start();
			if ($_SESSION["loged_in_user"])
			{
				echo "Welcome, ", $_SESSION["loged_in_user"]; ?>
			</div>
				<div>
				<form action="logout.php" method="post">
					<input type="submit" name="logout" class="logout" value="Logout"/>
				</form>
			</div>
				<?php
			} ?>
	</div>
	<div class="center">
		<h1>Choose your new life</h1>
		<p>If you dont want to change certain data - leave it blank</p>
		<?php 
				session_start();
				if ($_SESSION["changed_login"] == "error")
					echo "<p class=\"error_message\">Login's length must be >= 4<?p>";
				if ($_SESSION["changed_login"] == "exists")
					echo "<p class=\"error_message\">That login already exists<?p>";
				if ($_SESSION["changed_email"] == "error")
					echo "<p class=\"error_message\">Wrong formated email<?p>";
				if ($_SESSION["changed_email"] == "exists")
					echo "<p class=\"error_message\">That email already exists<?p>";
				if ($_SESSION["changed_password"] == "error")
					echo "<p class=\"error_message\">Password's length must be >= 6<?p>";
				if ($_SESSION["changed_login"] == "true" || $_SESSION["changed_password"] == "true" || $_SESSION["changed_email"] == "true")
					echo "<p class=\"error_message\">Data successfully changed!<?p>";
				$_SESSION["changed_login"] = "";
				$_SESSION["changed_email"] = "";
				$_SESSION["changed_password"] = "";
			?>
		<form action="actualy_edit.php" method="post">
			<input type="text" placeholder="Login..." name="login" value=""/>
			<input type="text" placeholder="Email..." name="email" value=""/>
			<input type="password" placeholder="Password..." name="password" value=""/>
			<input type="submit" name="submit" value="Change"/>
		</form>
		<br>
	</div>
	<div class="footer">
		<div class="footerText">
			<p>Copyright 1999-2018 by my bare hands. All Rights Reserved.</p>
			<p>Powered by -42</p>
		</div>
	</div>
</body>
</html>