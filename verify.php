<!DOCTYPE html>
<?php
	session_start();
	include "config/setup.php";

	if ($_GET["email"] && $_GET["hash"])
	{
		$_SESSION["authorised"] = "false";
		$query = $db->query('SELECT * FROM users');
		while ($r = $query->fetch())
		{
			if ($r["email"] == $_GET["email"] && $r["reg_link"] == $_GET["hash"])
				$_SESSION["authorised"] = "true";
		}
		if ($_SESSION["authorised"] == "true")
		{
			$stm = $db->prepare("UPDATE users SET `is_authorised` = 1 WHERE `email` = :email AND `reg_link` = :hash");
			$stm->bindParam(':email', $_GET["email"], PDO::PARAM_STR);
			$stm->bindParam(':hash', $_GET["hash"], PDO::PARAM_STR);
			$stm->execute();
		}
	}
	else
		$_SESSION["authorised"] = "false";
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
	</div>
	<div class="center">
		<?php 
			session_start();
			if ($_SESSION["authorised"] == "true")
				echo "<h1>Your account is authorised now. Good job!</h1>";
			else
				echo "<h1>Seems like you lost your way. Try again from starting page.</h1>";
		?>
	</div>
	<div class="footer">
		<div class="footerText">
			<p>Copyright 1999-2018 by my bare hands. All Rights Reserved.</p>
			<p>Powered by -42</p>
		</div>
	</div>
</body>
</html>