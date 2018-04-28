<!DOCTYPE html>
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
			</div>
				<?php
			} ?>
	</div>
	<?php
		include "config/setup.php";

		session_start();
		$flag = 0;
		$query = $db->query("SELECT `login`, `is_authorised` FROM users");
		while ($r = $query->fetch())
		{
			if ($r["login"] == $_SESSION["loged_in_user"])
			{
				if ($r["is_authorised"] == 0)
				{
					$flag = 1;
					break ;
				}
			}
		}
		if($_SESSION["loged_in_user"] == "")
			echo "<h1>You should login first to view content of this page</h1>";
		else if ($flag == 1)
			echo "<h1>You should authorise via email link first to view content of this page</h1>";
		else
		{
	?>
	<div class="center">
		<video autoplay="true" id="videoElement"></video>
		<button onclick="snapshot();">Snap!</button>
		<canvas id="myCanvas" width="400" height="350"></canvas>
		<button onclick="save();">Save!</button>
			<script>
				var video = document.querySelector("#videoElement");

				navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;
 
				if (navigator.getUserMedia) {       
    				navigator.getUserMedia({video: true}, handleVideo, videoError);
				}
 
				function handleVideo(stream) {
				    video.src = window.URL.createObjectURL(stream);
				}
 
				function videoError(e) {
				    // do something
				}

				var canvas, ctx, img;

				function snapshot()
				{
					canvas = document.getElementById("myCanvas");
      				ctx = canvas.getContext('2d');
      				ctx.drawImage(video, 0,0, canvas.width, canvas.height);
				}

				function save()
				{
					var dude1 = document.getElementById("myCanvas");
   					var dude2 = dude1.toDataURL("image/png");
    				document.write('<img src="'+dude2+'"/>');
				}
			</script>

	</div>
	<?php } ?>
	<div class="footer">
		<div class="footerText">
			<p>Copyright 1999-2018 by my bare hands. All Rights Reserved.</p>
			<p>Powered by -42</p>
		</div>
	</div>
</body>
</html>