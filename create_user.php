<?php
	include "./config/setup.php";
	session_start();
	if($_POST["username"] && $_POST["email"] && $_POST["password"] && $_POST["confirm_password"] && $_POST["submit"] == "OK")
	{
		if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
		{
			$_SESSION["register_error"] = "email";
			header("Location: register.php");
			die();
		}
		if ($_POST["password"] != $_POST["confirm_password"])
		{
			$_SESSION["register_error"] = "different_passwords";
			header("Location: register.php");
			die();
		}
		if (strlen($_POST["username"]) < 4)
		{
			$_SESSION["register_error"] = "short_username";
			header("Location: register.php");
			die();
		}
		if (strlen($_POST["password"]) < 6)
		{
			$_SESSION["register_error"] = "short_password";
			header("Location: register.php");
			die();
		}
		$query = $db->query('SELECT `login`, `email`, `password` FROM users');
		while ($r = $query->fetch())
		{
			if ($r["login"] == $_POST["username"] || $r["email"] == $_POST["email"])
			{
				$_SESSION["register_error"] = "user_exists";
				header("Location: register.php");
				die();
			}
		}
		$encoding = "utf-8";
		$subject_preferences = array(
			"input-charset" => $encoding,
			"output-charset" => $encoding,
			"line-length" => 76,
			"line-break-chars" => "\r\n"
		);
		$mail_subject = "mah duuuuuuuuuuude";
		$header = "Content-type: text/html; charset=".$encoding." \r\n";
		$header .= "From: webmaster@example.com \r\n";
		$header .= "MIME-Version: 1.0 \r\n";
		$header .= "Content-Transfer-Encoding: 8bit \r\n";
		$header .= "Date: ".date("r (T)")." \r\n";
		$hashed_link = hash("sha256", rand(0, 1000));
		$header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);
		$mail = $_POST["email"];
		$mail_message = 'http://localhost:8100/Camigiru/verify.php?email='.$mail.'&hash='.$hashed_link.'';
		mail($_POST["email"], $mail_subject, $mail_message, $header);
		$hashed_passwd = hash("sha256", $_POST["password"]);
		$stm = $db->prepare("INSERT INTO users (login, email, password, reg_link) VALUES (?, ?, ?, ?)");
		$stm->bindParam(1, $_POST["username"]);
		$stm->bindParam(2, $_POST["email"]);
		$stm->bindParam(3, $hashed_passwd);
		$stm->bindParam(4, $hashed_link);
		$stm->execute();
		$_SESSION["register_error"] = "confirm";
		header("Location: register.php");
	}
    else
    {
        $_SESSION["register_error"] = "empty";
        header("Location: register.php");
    }
?>