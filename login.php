<?php
	include "config/setup.php";
	session_start();
	if ($_POST["login"] && $_POST["password"] && $_POST["submit"] == "Login")
	{
		$query = $db->query('SELECT `login`, `password` FROM users');
		while ($r = $query->fetch())
		{
			if ($r['login'] == $_POST['login'] && ($r['password'] == hash('sha256', $_POST['password'])))
			{
				$_SESSION["loged_in_user"] = $_POST['login'];
				header('Location: index.php');
				die();
			}
		}
		$_SESSION["login_error"] = "wrong_data";
		header('Location: index.php');
	}
	else
	{
		$_SESSION["login_error"] = "missing_data";
		header('Location: index.php');
	}
?>