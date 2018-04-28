<?php
	include "config/setup.php";
	session_start();
	if(strlen($_POST["login"]) >= 4)
	{
		$stm = $db->prepare("UPDATE users SET `login` = ? WHERE `login` = ?");
		$stm->bindParam(1, $_POST["login"]);
		$stm->bindParam(2, $_SESSION["loged_in_user"]);
		$stm->execute();
		$_SESSION["changed_login"] = "true";
		$_SESSION["loged_in_user"] = $_POST["login"];
	}
	else if ($_POST["login"] != "")
		$_SESSION["changed_login"] = "error";
	if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
	{
		$stm = $db->prepare("UPDATE users SET `email` = ? WHERE `login` = ?");
		$stm->bindParam(1, $_POST["email"]);
		$stm->bindParam(2, $_SESSION["loged_in_user"]);
		$stm->execute();
		$_SESSION["changed_email"] = "true";
	}
	else if ($_POST["email"] != "")
		$_SESSION["changed_email"] = "error";
	if (strlen($_POST["password"]) >= 6)
	{
		$stm = $db->prepare("UPDATE users SET `password` = ? WHERE `login` = ?");
		$stm->bindParam(1, hash("sha256", $_POST["password"]));
		$stm->bindParam(2, $_SESSION["loged_in_user"]);
		$stm->execute();
		$_SESSION["changed_password"] = "true";
	}
	else if ($_POST["password"] != "")
		$_SESSION["changed_password"] = "error";
	header("Location: edit_user.php");
?>