<?php
	session_start();
	$_SESSION["loged_in_user"] = "";
	header("Location: index.php");
?>