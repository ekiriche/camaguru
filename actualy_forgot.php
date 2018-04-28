<?php
	include "config/setup.php";
	session_start();
	if ($_POST["email"] == "")
	{
		$_SESSION["error"] = "empty";
		header("Location: forgot_password.php");
		die();
	}
	if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
	{
		$_SESSION["error"] = "format";
		header("Location: forgot_password.php");
		die();
	}
	$query = $db->query("SELECT `email` FROM users");
	$flag = 0;
	while ($r = $query->fetch())
	{
		if ($r["email"] == $_POST["email"])
			$flag = 1;
	}
	if ($flag == 0)
	{
		$_SESSION["error"] = "not_exist";
		header("Location: forgot_password.php");
		die();
	}
	$encoding = "utf-8";
	$subject_preferences = array(
		"input-charset" => $encoding,
		"output-charset" => $encoding,
		"line-length" => 76,
		"line-break-chars" => "\r\n"
	);
	$mail_subject = "New password";
	$header = "Content-type: text/html; charset=".$encoding." \r\n";
	$header .= "From: localhost:8100 \r\n";
	$header .= "MIME-Version: 1.0 \r\n";
	$header .= "Content-Transfer-Encoding: 8bit \r\n";
	$header .= "Date: ".date("r (T)")." \r\n";
	$header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);
	$mail = $_POST["email"];
	$random_passwd = chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90));
	$mail_message = "Your new password: ".$random_passwd."";
	mail($_POST["email"], $mail_subject, $mail_message, $header);
	$stm = $db->prepare("UPDATE users SET `password` = ? WHERE `email` = ?");
	$stm->bindParam(1, hash("sha256", $random_passwd));
	$stm->bindParam(2, $_POST["email"]);
	$stm->execute();
	$_SESSION["error"] = "gucci";
	header("Location: forgot_password.php");
?>