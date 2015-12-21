<?php
	session_start();

	if(isset($_SESSION['userID'])){
		$userInfo = json_decode(
			file_get_contents('photo/'.$_SESSION['userID'].'/userInfo.json'),
			true
		);
		$maxPhoto = 0;
		for($i=0;$i < count($userInfo['album']);$i++) {
			if($maxPhoto < count($userInfo['album'][$i]['photo'])) {
				$maxPhoto = count($userInfo['album'][$i]['photo']);
			}
		}

		if($_SERVER['REQUEST_METHOD'] == "POST") {
			include('class.php');
			$user = new User($_SESSION['userID']);
			$userInfo = $user->getUser();
			$albumInfo = $user->getAlbum($_POST['editAlbumNo']);
			
			for($j=count($albumInfo['photo'])-1;$j>=0;$j--) {
				if($_POST['validPhoto'][$j]>0) {
					
					if($_POST['photoDesc'][$j]!=$albumInfo['photo'][$j]['description'] || $_POST['date'][$j]!=str_ireplace(" ","T",$albumInfo['photo'][$j]['photoDate'])) {
						$user->editPhoto($_POST['editAlbumNo'],$j,$_POST['photoDesc'][$j],$_POST['date'][$j]);
					}
				
				} else if($_POST['validPhoto'][$j]==0) {
					unlink($albumInfo['photo'][$j]['sourcePath']);
					unlink('photo/'.$_SESSION['userID'].'/'.$albumInfo['albumID'].'/thumbnail/'.$albumInfo['photo'][$j]['photoName']);
					$user->deletePhoto($_POST['editAlbumNo'],$j);
				}
			}
				
				if($albumInfo['albumName'] != $_POST['albumTitle'] || $albumInfo['description'] != $_POST['albumDesc']) {
					$user->editAlbum($_POST['editAlbumNo'],$_POST['albumTitle'],$_POST['albumDesc']);
				}
				
				unset($_POST);
?>
<script src="jquery.js"></script>		
<script>		
	var userID = <?php echo $_SESSION['userID']; ?>;
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
		echo "Saving the Changes To Server...";
	}
	else {
	
	$title = 'PixAlbums4U: Edit Albums';
	include('userHeader.php');
?>
	<style>
		#editAlbum a:link{
			background-color: rgba(0,0,0,0.65);;
			color: #FFFFFF;
		}
		
		#editAlbum a:visited{
			background-color: rgba(0,0,0,0.65);
			color: #FFFFFF;
		}

		.photo_container {
			display: -webkit-flex;
			display: flex;
			
			-webkit-flex-wrap:wrap;
			flex-wrap:wrap;
		}

		.photo_item {
			width:250px;
			//height: 270px;
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
		
		.deleteBtn {
			margin:0px;
			padding:0px;
			border:0px;
			border-radius:25px;
			cursor:pointer;
			
		}
		
		#flex-container1 {
			display: -webkit-flex;
			display: flex;
		}
			
	</style>
	
	<h1 style="padding-left: 18px; font-family: Century gothic, sans-serif;">Edit Albums</h1>
	<p style="padding-left: 20px; font: bold 16px Century gothic, sans-serif;"> Select the photos to delete it.</p>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="edit-form">
		<fieldset style="border:0;">
			<div id="flex-container1">
				<select id="albumNameList" style="border-radius:15px;padding-left:5px;" name="albumNameList"></select>
				<button id="confirm" type="button" disabled>Select</button>
				<img id="loadingAlbum" src="images/loadingblue.gif" width="30" style=""/>
			</div>
		</fieldset><br/>
		<fieldset style="border:0;">
			<input id="editAlbumNo" name="editAlbumNo" type="hidden" disabled>
			<input id="albumTitle" name="albumTitle" type="text" style="border-radius:15px;padding-left:10px;" placeholder="Untitled Album" maxlength="100" onblur="validateAlbumName()" oninput="validateAlbumName()" required/>&nbsp;&nbsp;<span id="albumError"></span><br/>
			<textarea id="albumDesc" name="albumDesc" style="border-radius:15px;padding-left:10px;" maxlength="500" placeholder="Add a description"></textarea>
			<div class="photo_container" style="padding-bottom: 20px;">
<?php
for($i=0;$i<$maxPhoto;$i++){
	echo <<<HTML
					<div class="photo_item photo_box{$i}" id="photo_box{$i}">
						<button class = "deleteBtn" type="button" id="deleteBtn{$i}" ><img id="deleteImg{$i}" src="images/delete.jpeg" alt="delete" width="20" onclick="deleteOnClick{$i}()"/></button>
						<input id="validPhoto{$i}" name="validPhoto[]" type="hidden" value="1" disabled> 
						<div>
							<img width="250" height="180" id="photo{$i}" />
							<textarea id="photoDesc{$i}" name="photoDesc[]" style="border-radius:15px;padding-left:4px;" rows="3" cols="4" style="margin-top:5px;" placeholder="Add a description" disabled></textarea>
							<input id="date{$i}" name="date[]" style="border-radius:15px; padding-left:4px;" type="datetime-local" style="width: 244px;" disabled>
						</div>
					</div>
HTML;
}
?>
			</div>
		</fieldset>
		<div style="width:100%; height: 54px; position:fixed; bottom:0px; left:15px; background-color:#FFFFFF;">
				<button id="submitBtn" type="submit" disabled>Save</button>&nbsp;&nbsp;&nbsp;&nbsp;<img id="loadImage" src="images/loading2.gif" style="display:none;" />
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
			//alert("complete");
		}
	});
	
	function validateAlbumName() {
		if($("#albumTitle").val().length > 0) {
			var hasErrors = false;
			for(var i=0; i < existAlbum.length; i++) {
				if($('#albumTitle').val() != chosenAlbum && $('#albumTitle').val().toLowerCase() == existAlbum[i].toLowerCase()) {
					hasErrors = true;
				}
				else {
					$("#albumError").html("");
				}
				
				if(hasErrors) {
					$("#albumError").html("This Album Name Already Exist");
				}
				else {
					$("#albumError").html("");
				}
				
			}
		}
	}


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






var userID = <?php echo json_encode($_SESSION['userID']); ?>;
$.ajax({
	url: "request.php",
	data: {
		getUser : userID
	},
	type: "POST",
	dataType : "json",
	success: function( json ) {
		var userInfo = json;
		
		$("#albumNameList").append("<option value>" + "---Select Album---" + "</option>");
		for(var i=0;i<userInfo.album.length;i++) {
			$("#albumNameList").append("<option value="+ i +">"+ userInfo.album[i].albumName +"</option>");
		}
	},
	error: function( xhr, status, errorThrown ) {
		alert( "Sorry, there was a problem!" );
		console.log( "Error: " + errorThrown );
		console.log( "Status: " + status );
		console.dir( xhr );
	},
	complete: function( xhr, status, json ) {
		$("#confirm").removeAttr("disabled");
		$("#loadingAlbum").fadeOut(1000);
	}
});
<?php
for($i=0;$i<$maxPhoto;$i++) {
echo <<<SCRIPT
			function deleteOnClick{$i}() {
				if(document.getElementById("validPhoto{$i}").value == "1") {
					document.getElementById("deleteImg{$i}").src = "images/delete-onclick.jpeg";
					document.getElementById("validPhoto{$i}").value = "0";
				}
				else {
					document.getElementById("deleteImg{$i}").src = "images/delete.jpeg";
					document.getElementById("validPhoto{$i}").value = "1";
				}
			}
SCRIPT;
}
?>
	var chosenAlbum;
	$("#confirm").click(function(){
		if($("#albumNameList").val().length > 0) {
			$("#confirm").attr("disabled","disabled");
			var userID = <?php echo $_SESSION['userID']; ?>;
			$.ajax({
				url: "request.php",
				data: {
					getAlbum : userID,
					i : $("#albumNameList").val()
				},
				type: "POST",
				dataType : "json",
				success: function( json ) {
					var albumInfo = json;
					chosenAlbum = json.albumName;
					
					for(var i=0;i<albumInfo.photo.length;i++) {
						document.getElementById("photo"+i).src = albumInfo.photo[i].sourcePath;
						document.getElementById("photoDesc"+i).value = albumInfo.photo[i].description;
						
						if(albumInfo.photo[i].photoDate) {
							document.getElementById("date"+i).value = albumInfo.photo[i].photoDate.replace(" ","T");
						}
						
						document.getElementById("photo"+i).disabled = false;
						document.getElementById("photoDesc"+i).disabled = false;
						document.getElementById("date"+i).disabled = false;
						document.getElementById("validPhoto"+i).disabled = false;
						
						$("#photo_box"+i).fadeIn(3000);;
					}
					
					document.getElementById('albumNameList').disabled = true;
					document.getElementById('confirm').disabled = true;
					document.getElementById("editAlbumNo").disabled = false;
					document.getElementById("albumTitle").value = albumInfo.albumName;
					document.getElementById("albumDesc").value = albumInfo.description;
					document.getElementById("editAlbumNo").value = $("#albumNameList").val();
				},
				error: function( xhr, status, errorThrown ) {
					alert( "Sorry, there was a problem! " );
					console.log( "Error: " + errorThrown );
					console.log( "Status: " + status );
					console.dir( xhr );
				},
				complete: function( xhr, status) {
					$("#submitBtn").removeAttr("disabled");
				}
			});
		}
		else {
			$("#confirm").removeAttr("disabled");
		}
	});
</script>
	
<?php
		}	
	}
	else {
		header('Location: 404.php');
	}

?>