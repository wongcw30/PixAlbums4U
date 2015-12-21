<?php
	session_start();
	
	if(isset($_SESSION['userID'])) {
		
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			
			include('class.php');
			$user = new User($_SESSION['userID']);
			
			$albumNo = $user->addAlbum($_POST['albumTitle'],$_POST['albumDesc']);
			$albumInfo = $user->getAlbum($albumNo);
			
			if (!file_exists('photo/'.$_SESSION['userID'].'/'.$albumInfo['albumID'])) {
				mkdir('photo/'.$_SESSION['userID'].'/'.$albumInfo['albumID'], 0777, true);	//Create Directory
			}
			
			$mysqli = new mysqli('localhost', 'root', '', 'PixAlbums4U');
			if ($mysqli->connect_error) {
				die('Connect Error (' . $mysqli->connect_errno . ') '
						. $mysqli->connect_error);
			}
			$sql = <<<SQL
INSERT INTO photo (UserID, AlbumID, PhotoName, Description, PhotoSize, PhotoDate, SourcePath) VALUES
(?,?,?,?,?,?,?)
SQL;
			
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('ddssdss',
				$_SESSION['userID'],
				$albumInfo['albumID'],
				$photoName,
				$description,
				$photoSize,
				$photoDate,
				$sourcePath
			);
			
			$mysqli->query("START TRANSACTION");
			
			$j=0;
			for($i=0;$i<count($_POST['validPhoto']);$i++) {
				
				if($_POST['validPhoto'][$i]) {
					
					$photoName = $_FILES['file']['name'][$i];
					$description = $_POST['photoDesc'][$j];
					$photoSize = $_FILES['file']['size'][$i];
					if($_POST['date'][$j] != "") { 	
						$photoDate = $_POST['date'][$j];
					}
					else {
						$photoDate = null;
					}
					$sourcePath = 'photo/'.$_SESSION['userID'].'/'.$albumInfo['albumID'].'/'.$_FILES['file']['name'][$i];
					
					$stmt->execute();
					
					move_uploaded_file($_FILES['file']['tmp_name'][$i], 'photo/'.$_SESSION['userID'].'/'.$albumInfo['albumID'].'/'.$_FILES['file']['name'][$i]);
					
					//*************************************************** Start Create Thumbnails ******************************************************************
					$filepath = 'photo/'.$_SESSION['userID'].'/'.$albumInfo['albumID'].'/'.$_FILES['file']['name'][$i];
					
					$thumbfilepath = 'photo/'.$_SESSION['userID'].'/'.$albumInfo['albumID'].'/thumbnail/';								//Directory of Thumbnails
					$thumbnailpath = 'photo/'.$_SESSION['userID'].'/'.$albumInfo['albumID'].'/thumbnail/'.$_FILES['file']['name'][$i];	//file path of a Thumbnails
					
					if (!file_exists($thumbfilepath)) {
						mkdir($thumbfilepath, 0777, true);	//Create Directory
					}
					
					$img = imageCreateFromJpeg($filepath); 
					$width = imagesx( $img );
					$height = imagesy( $img );
					
					$temp_width = 250;
					$temp_height=250;
			
					
					
					if($width>$height)
					{
					$new_height = floor(( $height/ $width )*$temp_width );
					$new_width=$temp_width;
					}
					else{
						$new_width=floor(($width/$height)*$temp_height);
						$new_height=$temp_height;
					}
					
					
					$tmp_img = imagecreatetruecolor($new_width, $new_height);
					imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					$img = imagejpeg($tmp_img, $thumbnailpath); 
					
					//*************************************************** End of Create Thumbnails *****************************************************************
					
					$j++;
				}
			}
			
			$stmt->close();
			$mysqli->query("COMMIT");
?>
	<script src="jquery.js"></script>		
	<script>		
		var userID = <?php echo json_encode($_SESSION['userID']); ?>;
		$.ajax({
			url: "updateUser.php",
			data: {
				updateUser : userID
			},
			type: "POST",
			dataType : "json",
			success: function( json ) {
				
			},
			error: function( xhr, status, errorThrown ) {
				alert( "Sorry, there was a problem!" );
				console.log( "Error: " + errorThrown );
				console.log( "Status: " + status );
				console.dir( xhr );
			},
			complete: function( xhr, status) {
				window.location.replace("album.php");
			}
		});
	</script>
<?php
			echo "Uploading Album To Server...";
		}
		else {
			$title = 'Create Album';
			include('userHeader.php');
?>
		<style>
			#createAlbum a:link{
				background-color: rgba(0,0,0,0.65);
				color: #FFFFFF;
			}
			
			#createAlbum a:visited{
				background-color: rgba(0,0,0,0.65);
				color: #FFFFFF;
			}
 <?php
$maxPhoto = 50;


for($i = 0; $i<$maxPhoto;$i++){
	echo <<<STYLE
			#progress_bar{$i} {
				margin: 0px;
				padding: 3px;
				border: 1px solid #000;
				font-size: 14px;
				clear: both;
				opacity: 0;
				-moz-transition: opacity 1s linear;
				-o-transition: opacity 1s linear;
				-webkit-transition: opacity 1s linear;
			}
				
			#progress_bar{$i}.loading{$i} {
				opacity: 1.0;
			}
				
			#progress_bar{$i} .percent{$i} {
				background-color: #99ccff;
				height: auto;
				width: 0;
			}

STYLE;
}
?>
			.photo_container {
				display: -webkit-flex;
				display: flex;
				
				/*this is to enable to the item move to next line when the current line is no more space*/
				-webkit-flex-wrap:wrap;
				flex-wrap:wrap;
			}

			.photo_item {
				width:250px;
				height: 270px;
				margin:30px;
				padding: 2px;
				border:solid 3px;
			}
<?php
for($i = 0; $i<$maxPhoto;$i++){
	echo <<<STYLE
			#photo_box{$i} {
				display:none;
			}

STYLE;
}
?>
			textarea {
				width: 244px;
				height: 47px;
				resize: none;
				
			}
			
			#albumTitle{
				margin-left:0px;
				margin-bottom:10px;
				padding:2px;
				border:1px solid rgb(169, 169, 169);
				width:408px;
				height:23px;
			}
			
			#albumDesc{
				width:408px;
				height:36px;
			}
			
		</style>

		<h1 style="padding-left: 18px; font-family: Century gothic, sans-serif;">Create Your Album</h1>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="upload-form" enctype="multipart/form-data">
			<fieldset style="border:0;">
				<input id="albumTitle" name="albumTitle" style="border-radius:15px;padding-left:10px;" type="text" placeholder="Untitled Album" maxlength="100" onblur="validateAlbumName()" oninput="validateAlbumName()" required/>&nbsp;&nbsp;<span id="albumError"></span><br/>
				<textarea id="albumDesc" name="albumDesc" style="border-radius:15px; padding-left:10px;" placeholder="Add a description about this album" maxlength="500"></textarea>
				<h1 id="uploadProperty"></h1>
				<input id="files" name="file[]" type="file" style="border:2px solid;" accept="image/jpeg, image/jpg" required multiple/>
				<button type="button" onclick="cancelRead();">Cancel</button>

				<div class="photo_container">
<?php
for($i=0;$i<$maxPhoto;$i++){
	echo <<<HTML
					<div class="photo_item photo_box{$i}" id="photo_box{$i}">
						<div id="progress_bar{$i}">
							<div class="percent{$i}">0%</div>
						</div>
						<input id="validPhoto{$i}" name="validPhoto[]" type="hidden" value="{$i}" disabled> 
						<div>
							<img width="250" height="156" id="photo{$i}" />
							<textarea id="photoDesc{$i}" name="photoDesc[]" style="border-radius:15px; padding-left:4px;" rows="2" cols="5" placeholder="Add a description" disabled></textarea>
							<input style="border-radius:15px;padding-left:4px;" id="date{$i}" name="date[]" type="datetime-local" style="width: 250px;" disabled>
						</div>
					</div>
HTML;
}
?>
				</div>
			</fieldset><br/>
			<div style="width:100%; height: 54px; position:fixed; bottom:0px; left:15px; background-color:#FFFFFF; ">
				<button id="submitBtn" type="submit">Create Album</button>&nbsp;&nbsp;&nbsp;&nbsp;<img id="loadImage" src="images/loading2.gif" style="display:none;" />
			</div>
		</form>
		<script src="jquery.js"></script>
		<script>
			var existAlbum = new Array();
			$.ajax({
				url: "userInfo.php",
				data: {
					userInfo : <?php echo $_SESSION['userID']; ?>
				},
				type: "POST",
				dataType : "json",
				success: function( json ) {
					for(var i=0; i < json.album.length; i++) {
						existAlbum[i] = json.album[i].albumName;
					}
				},
				error: function( xhr, status, errorThrown ) {
					alert( "Sorry, there was a problem!" );
					console.log( "Error: " + errorThrown );
					console.log( "Status: " + status );
					console.dir( xhr );
				},
				complete: function( xhr, status) {
					
				}
			});
			
			
			function validateAlbumName() {
				if($("#albumTitle").val().length > 0) {
					var hasErrors = false;
					for(var i=0; i < existAlbum.length; i++) {
						if($('#albumTitle').val().toLowerCase() == existAlbum[i].toLowerCase()) {
							hasErrors = true;
						}
						else {
							$("#albumError").html("");
						}
						
						if(hasErrors) {
							$("#albumError").html("This Album Name Already Exist.");
						}
						else {
							$("#albumError").html("");
						}
						
					}
				}
			}
			
			function image(name, type, size, lastModifiedDate) { //create image class
				this.name = name;
				this.type = type;
				this.size = size;
				if(lastModifiedDate) {
					
					var date_x = lastModifiedDate.toLocaleDateString().split("/");
					
					if(date_x[0].length == 1){
						date_x[0] = "0" + date_x[0];
					}
					
					if(date_x[1].length == 1){
						date_x[1] = "0" + date_x[1];
					}
					
					//FROMAT : YYYY-MM-DDTHH:MM
					this.lastModifiedDate = date_x[2] + "-" + date_x[0] + "-" + date_x[1] + "T" + lastModifiedDate.toString().substr(lastModifiedDate.toString().indexOf(":")-2,5); 
				}
			}
			
			var k = 0;
			var maxPhoto = <?php echo $maxPhoto ?>;
			var z = 0;
			var reader = new Array();
			var progress = new Array();
			var photox = new Array();
			var g = null;
			
			function cancelRead() {
				if(k>0){
					for(var j=0;j<k;j++){
						reader[j].abort();
					}
				}
			}
			
			function handleFileSelect(evt) {
				
				//Reset the Variables
				for(var i=0;i<maxPhoto;i++){
					var photo_box = document.getElementById("photo_box"+i);
					photo_box.style.display = "none";
					reader[i]=null;
					
					photox[i]=null;
					
					document.getElementById("photo"+i).src = "";
					
					document.getElementById("photoDesc"+i).value = "";
					document.getElementById("photoDesc"+i).disabled = true;
					
					document.getElementById("date"+i).value = "";
					document.getElementById("date"+i).disabled = true;
					
					document.getElementById("photoDesc"+i).placeholder = "Add a description";
					
					document.getElementById("validPhoto"+i).value = "0";
					document.getElementById("validPhoto"+i).disabled = true;
				}
				
				g = null;
				z = 0;
				
				k = evt.target.files.length;

				
				
				document.getElementById("uploadProperty").innerHTML = z + "/" + k + " upload(s) completed" ;
				
				function _file(i){
					// Reset progress indicator on new file selection.
					progress[i].style.width = '0%';
					progress[i].textContent = '0%';
					
					
					reader[i] = new FileReader();
					
					reader[i].onerror = function errorHandler(evt) {
						switch(evt.target.error.code) {
							case evt.target.error.NOT_FOUND_ERR:
								alert('File Is Not Found!');
								break;
							case evt.target.error.NOT_READABLE_ERR:
								alert('File is not readable');
								break;
							case evt.target.error.ABORT_ERR:
								break;
							default:
								alert('An error occurred while reading this file.');
						};
					};
					
					reader[i].onprogress = function updateProgress(evt) {
						// evt is an ProgressEvent.
						if (evt.lengthComputable) {
							var percentageLoad = Math.round((evt.loaded / evt.total) * 100);
							// Increase the progress bar length.
							if (percentageLoad < 100) {
								progress[i].style.width = percentageLoad + '%';
								progress[i].textContent = percentageLoad + '%';
							}
						}
					};
					
					reader[i].onabort = function(e) {
						alert('File read cancelled');
					};
					
					reader[i].onloadstart = function(e) {
						var progress_bar_Name = 'progress_bar'+i;
						var loading_Name = 'loading'+i;
						document.getElementById(progress_bar_Name).className = loading_Name;
						var photo_box = document.getElementById("photo_box"+i);
						photo_box.style.display = "block";
					};
					
					reader[i].onload = function(e) {
						// Ensure that the progress bar displays 100% at the end.
						progress[i].style.width = '100%';
						progress[i].textContent = '100%';
						var onload_statement = "document.getElementById('progress_bar"+i+"').className='';";
						setTimeout(onload_statement, 2000);
						z++;
						
						document.getElementById("uploadProperty").innerHTML = z + "/" + k + " upload(s) completed";
						
						var x1 = "photo" + i;
						var photo = document.getElementById(x1);
						photo.setAttribute("id","photo"+i);
						photo.setAttribute("src",e.target.result); //e.target.result will show the address of the particular file.
						photo.setAttribute("width","250");
						photo.setAttribute("height","156");
						
						document.getElementById("photoDesc"+i).disabled = false;
						
						document.getElementById("date"+i).disabled = false;
						document.getElementById("date"+i).value = photox[i].lastModifiedDate;
						
						document.getElementById("validPhoto"+i).disabled = false;
						document.getElementById("validPhoto"+i).value = "1";
						
					}
					
					reader[i].readAsDataURL(evt.target.files[i]); //readAsDataURL  or  readAsBinaryString
				}
				
				if(k>0){
					
					g = evt.target.files;
					
					for(var j=0;j<k;j++){
						var x3 = ".percent" + j;
						progress[j] = document.querySelector(x3);
						photox[j] = new image(g[j].name, g[j].type, g[j].size, g[j].lastModifiedDate);
						if(photox[j].size < 4*1024*1024) { //4Mb file limit	
							if(photox[j].type.split("/")[0] == "image") {	
								_file(j);
							}
							else {
								document.getElementById("photoDesc"+j).placeholder = "The file format is invalid";
								document.getElementById("validPhoto"+j).disabled = false;
								document.getElementById("photo_box"+j).style.display = "block";
							}
						}
						else {
							document.getElementById("photoDesc"+j).placeholder = "The file size is too large";
							document.getElementById("validPhoto"+j).disabled = false;
							document.getElementById("photo_box"+j).style.display = "block";
						}
					}
				}
			}
			
			document.getElementById('files').addEventListener('change', handleFileSelect, false);
			
			$("#submitBtn").click(function(){
				
				$(this).attr({
					type:'button'
				})
				
				validateAlbumName();
				
				if($("#albumError").html().length==0){
					$(this).attr({
						type:'submit'
					})
					
					var btn = $(this);
					btn.hide();
					$("#loadImage").show();
					setTimeout(function(){
					$("#loadImage").hide();
					btn.show();
					}, 5*1000);
				}
			});
		</script>
	</body>
</html>

<?php
		}
	}
	else {
		header('Location: 404.php');
	}
?>