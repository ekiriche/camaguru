<!DOCTYPE html>
<html>
<head>
	<title>Web Page Design</title>
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
		<br>
			<?php
				include "config/setup.php";
				session_start();
				$limit = 5;
				$number_of_results = $db->query("SELECT count(*) FROM images")->fetchColumn();
				$number_of_pages = ceil($number_of_results/$limit);
				if (!isset($_GET["page"]))
				{
					$page = 1;
				}
				else
					$page = $_GET["page"];
				$this_page_first_result = ($page - 1) * $limit;
				$sql = "SELECT * FROM images ORDER BY `date` DESC LIMIT " . $this_page_first_result . ',' . $limit;
				$query = $db->query($sql);
				while ($r = $query->fetch())
				{ ?> <div class="post"> <?php
					echo '<img src="'.$r["image_path"].'"/><br>';
					echo '<p>' . 'Likes: ' . $r["likes"] . '</p>';
					$sql2 = "SELECT * FROM comments WHERE `image_id` = " . $r["id"];
					$query2 = $db->query($sql2);
					while ($r2 = $query2->fetch())
					{
						echo "<p class=" . 'comment_box' . ">" . $r2["login"] . ": " . $r2["comment"] . "</p>";
					}
					?>
					<form action="like_comment.php" method="post">
						<input type="hidden" name="img" value="<?php echo $r["id"]; ?>" />
						<input type="text" name="comment" value="" />
						<input type="submit" name="comment_submit" value="Comment" />
						<?php
							$flag = 0;
							$query2 = $db->query("SELECT * FROM likes");
							while ($e = $query2->fetch())
							{
								if ($_SESSION["loged_in_user"] == "")
									break ;
								if ($_SESSION["loged_in_user"] == $e["login"] && $r["id"] == $e["image_id"])
								{
									$flag = 1;
									echo "<input type='submit' name='unlike' value='Unlike' />";
								}
							}
							if ($flag == 0)
								echo "<input type='submit' name='like' value='Like' />";
						?>
					</form>
					<br>
					</div>
					<br>
				<?php } ?>
				<div id="pages">
					<?php
					$page = 1;
					while ($page <= $number_of_pages)
					{
						echo '<a href="index.php?page=' . $page . '">' . $page . " " . '</a>';
						$page++;
					}
				?>
			</div>
			<br>
	</div>
	<div class="footer">
		<div class="footerText">
			<p>Copyright 1999-2018 by my bare hands. All Rights Reserved.</p>
			<p>Powered by -42</p>
		</div>
	</div>
</body>
</html>