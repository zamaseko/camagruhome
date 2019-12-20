
	include_once("head.php");
	$u = $_GET['u'];
?>
<html>
	<body>
		<div style="text-align:center">
			<div>
				<div>
					<img id="crazy" style = "display:inline-block; margin-right:5px;" src="stickers/crazy.png" alt="crazy" width=100 height=100>
					<img id="crying" style = "display:inline-block; margin-right:5px;" src="stickers/crying_kim.png" alt="crying" width=100 height=100>
					<img id="sharp" style = "display:inline-block; margin-right:5px;" src="stickers/sharp.png" alt="sharp" width=100 height=100>
					<img id="un" style = "display:inline-block; margin-right:5px;" src="stickers/un.png" alt="un" width=100 height=100>
				</div>
				<div style="margin-bottom: 15px">
					<video id="video" autoplay></video><br/>
				</div>
				<div style="margin-bottom: 15px">
					<button class="btn profile_buttons outline" id="snap">Capture</button>
					<br>
					<select id="stickers" style="font-size: 20px;height: 40px;">
						<option value="none">none</option>
						<option value="crazy">Crazy</option>
						<option value="crying">Crying Kim</option>
						<option value="sharp">Sharp</option>
						<option value="un">Kim Jon Un</option>
					</select>
					<br>
					<button class="btn profile_buttons outline" id="apply">Apply</button>
					<button class="btn profile_buttons blue" id="save" name="img">Upload</button>
				</div>
				<div style="margin-bottom: 15px">
						<canvas id="edit" width=416 height=300></canvas>
				</div>
		</div>
				
				<br>
			</div>
		<div>
	</div> 
	<script>
		
		const video = document.getElementById('video');
		const canvas = document.getElementById('edit');
		const snap = document.getElementById('snap');
		const apply = document.getElementById('apply');
		const crazy = document.getElementById('crazy');
		const crying = document.getElementById('crying');
		const sharp = document.getElementById('sharp');
		const un = document.getElementById('un');
		feed();
		var context = canvas.getContext('2d');
		snap.addEventListener("click", function () {
			context.drawImage(video, 0, 0, 416, 300);
		});
		function feed() {
			var constrains = {
				video: { width: 416, height: 300 }
			};
			navigator.mediaDevices.getUserMedia(constrains).then(stream => {
				video.srcObject = stream;
			});
		}
		apply.addEventListener("click", function() {
			var x = document.getElementById('stickers').value;
			if (x == "crazy")
				context.drawImage(crazy, 20, 20, 80, 80);
			else if (x == "crying")
				context.drawImage(crying, 80, 20, 80, 80);
			else if (x == "sharp")
				context.drawImage(sharp, 20, 80, 80, 80);
			else if (x == "un")
				context.drawImage(un, 80, 80, 80, 80);
			else
				context.drawImage(video, 0, 0, 416, 300);
		})
		var save = document.getElementById("save");
		save.addEventListener("click", function () {
			var data = "img=" + canvas.toDataURL();
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function () {
				if (this.readyState == 4 && this.status == 200) {
					alert("success");
					location.reload();
				}
			};
			xhttp.open("POST", "upload.php?u=<?php echo $u;?>", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send(data);
		});
	</script>
	</body>
</html>
