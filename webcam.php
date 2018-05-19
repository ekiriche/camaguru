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
		<br>
		<div id="center_center">
		<div>
		<div id="map">
			<video autoplay="true" id="videoElement"></video>
			<canvas id="myCanvas" width="640" height="480"></canvas>
		</div>
		<div id="buttons">	
			<button id="button_snap" onclick="snapshot();">Snap!</button>
			<button id="button_save" onclick="save();">Save!</button>
			<button id="button_remove" onclick="removeElementsByClass('drag');">Clear all!</button>
			<button id="button_try_again" onclick="try_again();">Try Again!</button>
			<input type="file" name="input" id="input" onchange="upload_img();" accept="image/jpeg,image/jpg,image/png"/>
		</div>
	</div>
	<div id="users_images">
			<?php
				include "config/setup.php";
				session_start();

				$query = $db->query("SELECT * FROM users");
				while ($r = $query->fetch())
				{
					if ($r["login"] == $_SESSION["loged_in_user"])
					{
						$user_id = $r["id"];
						break ;
					}
				}
				$sql = "SELECT image_path FROM images WHERE user_id = " . $user_id . " ORDER BY date DESC";
				$query = $db->query($sql);
				while ($r = $query->fetch())
				{ ?>
					<img src="<?php echo $r['image_path']; ?>" width="100px" height="100px"/>
					<form method="post" action="delete_image.php">
						<input type="hidden" name="img_src" value="<?php echo $r["image_path"]; ?>"/>
						<input type="submit" name="submit" value="Delete"/>
					</form>
				<?php } ?>
		</div>
				<script type="text/javascript">
					function upload_img()
					{
						var newImg = document.createElement('img');
					    var parentDiv = document.getElementById('map');
					    var file = document.querySelector('input[type=file]').files[0];
					    var reader = new FileReader();

						if (file) {
					        reader.readAsDataURL(file);
					    }

					    reader.onloadend = function () {
					        var videoTag = document.getElementById('videoElement');
					        parentDiv.removeChild(videoTag);
					        newImg.setAttribute('src', reader.result);
					        newImg.setAttribute('id', 'videoElement');
					        newImg.setAttribute(
					            'style',
					            'width: 100%; max-width: 640px; max-height: 480px;'
					        );
					        parentDiv.appendChild(newImg);
					    }
					}

					function try_again()
					{
						document.getElementById("myCanvas").style.display = "none";
						document.getElementById("videoElement").style.display = "block";
						document.getElementById("button_snap").style.display = "block";
						document.getElementById("button_remove").style.display = "block";
						document.getElementById("button_save").style.display = "none";
						document.getElementById("button_try_again").style.display = "none";
						location.reload();
					}

					function save()
					{
						var c = document.getElementById("myCanvas");
						var img = c.toDataURL("image/png");
						var xhr = new XMLHttpRequest();
						xhr.open("POST", "save.php", true);
						xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
						var data = "img=" + img;
						xhr.send(data);
						location.reload();
					}

					var video = document.querySelector("#videoElement");

					navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;
	 
					if (navigator.getUserMedia) {
	    				navigator.getUserMedia({video: true}, handleVideo, videoError);
					}
	 
					function handleVideo(stream) {
					    video.src = window.URL.createObjectURL(stream);
					}
	 
					function videoError(e) {
					}

					var canvas, ctx, img;

					function snapshot()
					{
						var cartinka = document.getElementById("map").querySelectorAll(".drag");
						if (!cartinka[0])
							return ;
						canvas = document.getElementById("myCanvas");
	      				ctx = canvas.getContext('2d');
	      				ctx.drawImage(document.getElementById("videoElement"), 0,0, canvas.width, canvas.height);
	      				
	      				var length = document.getElementById("map").querySelectorAll(".drag").length;
	      				var i = 0;
	      				var x;
	      				var y;
	      				var width;
	      				var height;

	      				while (i < length)
	      				{
	      					x = parseInt(cartinka[i].style.left);
	      					y = parseInt(cartinka[i].style.top);
	      					width = parseInt(cartinka[i].style.width);
	      					height = parseInt(cartinka[i].style.height);
	      					ctx.drawImage(cartinka[i], x, y, width, height);
	      					i++;
	      				}
	      				removeElementsByClass("drag");
	      				document.getElementById("videoElement").style.display = "none";
	      				document.getElementById("button_snap").style.display = "none";
	      				document.getElementById("myCanvas").style.display = "block";
	      				document.getElementById("button_save").style.display = "block";
	      				document.getElementById("button_remove").style.display = "none";
	      				document.getElementById("button_try_again").style.display = "block";
					}

					function create_elem(e)
					{
						var img = document.createElement("img");
						img.setAttribute("src", e.src);
						img.setAttribute("class", "drag");
						img.setAttribute("style", "position: absolute; top: 0; left: 0; width: 200px; height: 200px");
						document.getElementById("map").appendChild(img);
					}

					function removeElementsByClass(className)
					{
				    	var elements = document.getElementsByClassName(className);
				    	while(elements.length > 0){
				    	    elements[0].parentNode.removeChild(elements[0]);
				    }
				}
				</script>
		</div>
		<div id="fun_images">
			<img src="./fun_images/1.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/2.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/3.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/4.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/5.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/6.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/7.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/8.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/9.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/10.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/11.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/12.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/13.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/14.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/15.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/16.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/17.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/18.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/19.png" width=100px height=100px onclick="create_elem(this);"/>
			<img src="./fun_images/20.png" width=100px height=100px onclick="create_elem(this);"/>
		</div>
		<script>
			var _startX = 0;            // mouse starting positions
			var _startY = 0;
			var _offsetX = 0;           // current element offset
			var _offsetY = 0;
			var _dragElement;           // needs to be passed from OnMouseDown to OnMouseMove
			var _oldZIndex = 0;         // we temporarily increase the z-index during drag
			var _debug = $('debug');

			InitDragDrop();

			function InitDragDrop()
			{
			    document.onmousedown = OnMouseDown;
			    document.onmouseup = OnMouseUp;
			}

			function OnMouseDown(e)
			{    
			    var target = e.target;

			    if ((e.button == 1 && window.event !== null || 
			        e.button == 0) && 
			        target.className == 'drag')
			    {
			        _startX = e.clientX;
			        _startY = e.clientY;
			        _offsetX = ExtractNumber(target.style.left);
			        _offsetY = ExtractNumber(target.style.top);
			        _oldZIndex = target.style.zIndex;
			        target.style.zIndex = 10000;
			        _dragElement = target;
			        document.onmousemove = OnMouseMove;
			        document.body.focus();
			        
			        return false;
				}
			}

			function OnMouseMove(e)
			{
			    if (e === null) 
			        e = window.event; 

			    _dragElement.style.left = (_offsetX + e.clientX - _startX) + 'px';
			    _dragElement.style.top = (_offsetY + e.clientY - _startY) + 'px';  
			}

			function OnMouseUp(e)
			{
			    if (_dragElement !== null)
			    {
			        document.onmousemove = null;
			        document.onselectstart = null;
    
			        _dragElement = null;
			    }
			}

			function ExtractNumber(value)
			{
			    var n = parseInt(value);
				
			    return n === null || isNaN(n) ? 0 : n;
			}

			function $(id)
			{
			    return document.getElementById(id);
			}
		</script>
	</div>
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