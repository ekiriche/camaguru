<?php
	include "config/setup.php";
	session_start();
	
	$img = $_POST["img"];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$date_of_creation = date("U");
	$path = "./images/" . date("U") . ".png";
	file_put_contents($path, $data);
	$query = $db->query("SELECT * FROM users");
	while ($r = $query->fetch())
	{
		if ($_SESSION["loged_in_user"] == $r["login"])
		{
			$user_id = $r["id"];
			break ;
		}
	}
	$stm = $db->prepare("INSERT INTO images (user_id, image_path) VALUES (?, ?)");
	$stm->bindParam(1, $user_id);
	$stm->bindParam(2, $path);
	$stm->execute();
?>
