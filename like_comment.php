<?php
	include "config/setup.php";
	session_start();
	if ($_SESSION["loged_in_user"] == "")
	{
		$_SESSION["login_error"] = "not_loged_in";
		header("Location: index.php");
		die();
	}
	$name_id = "";
	$query = $db->query("SELECT * FROM users");
	while ($r = $query->fetch())
	{
		if ($r["login"] == $_SESSION["loged_in_user"])
		{
			if ($r["is_authorised"] == 0)
			{
				$_SESSION["login_error"] = "not_authorised";
				header("Location: index.php");
				die();
			}
			else
			{
				$name_id = $r["id"];
				break ;
			}
		}
	}
	if (($_POST["comment"] == "" || strlen($_POST["comment"] > 255)) && $_POST["comment_submit"] == "Comment")
	{
		$_SESSION["login_error"] = "incorrect_comment";
		header("Location: index.php");
		die();
	}
	else if ($_POST["comment"] != "" && strlen($_POST["comment"]) <= 255 && $_POST["comment_submit"] == "Comment")
	{
		$stm = $db->prepare("INSERT INTO comments (user_id, login, image_id, comment) VALUES (?, ?, ?, ?)");
		$stm->bindParam(1, $name_id);
		$stm->bindParam(2, $_SESSION["loged_in_user"]);
		$stm->bindParam(3, $_POST["img"]);
		$stm->bindParam(4, htmlspecialchars($_POST["comment"]));
		$stm->execute();

		$query = $db->query("SELECT * FROM images");
		while ($r = $query->fetch())
		{
			if ($r["id"] == $_POST["img"])
			{
				$name_id = $r["user_id"];
				break ;
			}
		}
		$query = $db->query("SELECT * FROM users");
		while ($r = $query->fetch())
		{
			if ($r["id"] == $name_id)
			{
				$email = $r["email"];
				$notification = $r["notifications"];
				break ;
			}
		}
		if ($notification == 1)
		{
			$encoding = "utf-8";
			$subject_preferences = array(
				"input-charset" => $encoding,
				"output-charset" => $encoding,
				"line-length" => 76,
				"line-break-chars" => "\r\n"
			);
			$mail_subject = "New comment!";
			$header = "Content-type: text/html; charset=".$encoding." \r\n";
			$header .= "From: localhost@omega.com \r\n";
			$header .= "MIME-Version: 1.0 \r\n";
			$header .= "Content-Transfer-Encoding: 8bit \r\n";
			$header .= "Date: ".date("r (T)")." \r\n";
			$header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);
			mail($email, $mail_subject, "There is a new comment on your image! Check it out!", $header);
		}
	}
	if ($_POST["like"] == "Like")
	{
		$stm = $db->prepare("INSERT INTO likes (user_id, login, image_id) VALUES (?, ?, ?)");
		$stm->bindParam(1, $name_id);
		$stm->bindParam(2, $_SESSION["loged_in_user"]);
		$stm->bindParam(3, $_POST["img"]);
		$stm->execute();

		$stm = $db->prepare("UPDATE images SET `likes` = `likes` + 1 WHERE `id` = ?");
		$stm->bindParam(1, $_POST["img"]);
		$stm->execute();
	}
	if ($_POST["unlike"] == "Unlike")
	{
		$stm = $db->prepare("DELETE FROM likes WHERE `login` = ? AND `image_id` = ?");
		$stm->bindParam(1, $_SESSION["loged_in_user"]);
		$stm->bindParam(2, $_POST["img"]);
		$stm->execute();

		$stm = $db->prepare("UPDATE images SET `likes` = `likes` - 1 WHERE `id` = ?");
		$stm->bindParam(1, $_POST["img"]);
		$stm->execute();
	}
	header("Location: index.php");
?>