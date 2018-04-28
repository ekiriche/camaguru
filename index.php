<!DOCTYPE html>
<?php
//	include "./config/setup.php";
//
//	$query = $db->query('SELECT * FROM `users`');
//	while ($r = $query->fetch())
//		echo $r['login'], '<br>';
?>
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
		<?php
			session_start();
			if ($_SESSION["loged_in_user"])
			{
				?> <div class="hello_name"> <?php echo "Welcome, ", $_SESSION["loged_in_user"]; ?> </div>
				<div class=users_options>
				<form action="logout.php" method="post">
					<input class="logout" type="submit" name="logout" value="Logout"/>
				</form>
				<a href="edit_user.php" class="new_user_link">Edit profile</a>
				<a href="webcam.php" class="new_user_link">Take a picture</a>
			</div>
				<?php
			}
			else {
			?>
			<div class="welcome">
		<form action="login.php" method="post">
			<?php
				session_start(); 
				if ($_SESSION["login_error"] == "wrong_data")
					echo "<p class=\"error_message_login\">Something is wrong!</p>";
				else if ($_SESSION["login_error"] == "missing_data")
					echo "<p class=\"error_message_login\">Something is missing!</p>";
				$_SESSION["login_error"] = "";
			?>
			<p><input type="text" placeholder="Login..." name="login" value=""/></p>
			<p><input type="password" placeholder="Password..." name="password" value=""/></p>
			<p><input type="submit" name="submit" value="Login"/></p>
		</form>
		</div>
		<div>
			<a href="register.php" class="new_user_link">Don't have account yet?</a>
			<br>
			<a href="forgot_password.php" class="new_user_link">Forgot your password?</a>
		</div>
		<?php } ?>
	</div>
	<div class="center">
		
	</div>
	<div class="footer">
		<div class="footerText">
			<p>Copyright 1999-2018 by my bare hands. All Rights Reserved.</p>
			<p>Powered by -42</p>
		</div>
	</div>
</body>
</html>