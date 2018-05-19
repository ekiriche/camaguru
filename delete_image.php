<?php
	include "config/setup.php";
	session_start();

	$stm = $db->prepare("DELETE FROM images WHERE image_path = ?");
	$stm->bindParam(1, $_POST["img_src"]);
	$stm->execute();
	unlink($_POST["img_src"]);
	header("Location: webcam.php");
?>