<?php
	session_start();
	
	function Delete($path) {
		if (is_dir($path) === true) {
			$files = array_diff(scandir($path), array('.', '..'));

			foreach ($files as $file) {
				Delete(realpath($path) . '/' . $file);
			}
			return rmdir($path);
		}

		else if (is_file($path) === true) {
			return unlink($path);
		}
		return false;
	}
	
	if(isset($_SESSION['userID'])){
		
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				
				$mysqli = new mysqli('localhost', 'root', '', 'PixAlbums4U');
				if ($mysqli->connect_error) {
					die('Connect Error (' . $mysqli->connect_errno . ') '
							. $mysqli->connect_error);
				}
				
				$sql = <<<SQL
DELETE FROM Photo WHERE AlbumID=?
SQL;
				
				$stmt = $mysqli->prepare($sql);
				
				for($i=0;$i<count($_POST['albumNameList']);$i++) {
					$stmt->bind_param('d',$_POST['albumNameList'][$i]);
					$stmt->execute();
				}
				$stmt->close();

				$sql = <<<SQL
DELETE FROM Album WHERE AlbumID=?
SQL;
				$stmt = $mysqli->prepare($sql);
				
				for($i=0;$i<count($_POST['albumNameList']);$i++) {
					$stmt->bind_param('d',$_POST['albumNameList'][$i]);
					$stmt->execute();
				}
				$stmt->close();
				
				for($i=0;$i<count($_POST['albumNameList']);$i++) {
					Delete('photo/'.$_SESSION['userID'].'/'.$_POST['albumNameList'][$i]);
				}
				
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
	
	$title = 'PixAlbums4U: Delete Albums';
	include('userHeader.php');
?>
	<style>
		#deleteAlbum a:link{
			background-color: rgba(0,0,0,0.65);
			color: #FFFFFF;
		}
		
		#deleteAlbum a:visited{
			background-color: rgba(0,0,0,0.65);
			color: #FFFFFF;
		}
		
		#flex-container1 {
			display: -webkit-flex;
			display: flex;
		
		}
			
	</style>
	  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  </head>
	<h1 style="padding-left: 18px; font-family: Century gothic, sans-serif;">Delete Album</h1>
	<p style="padding-left: 20px; font: bold 16px Century gothic, sans-serif;"> Select the name of the album to delete it.</p>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="delete-form">
		
		<fieldset style="border:0;">
			<div id="flex-container1">
				<select id="albumNameList" name="albumNameList[]" style="width:200px; border-radius:15px;padding-left:5px;"  ></select>
				<button type="button" id="confirm" class="btn btn-default btn-sm" style="color:#FF0000" disabled>
					<span class="glyphicon glyphicon-trash"></span> Delete 
				</button>
				<img id="loadingAlbum" src="images/loadingblue.gif" />
			</div>
		</fieldset><br/>
		
	</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>	
<script src="jquery.js"></script>
<script>
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
		
		for(var i=0;i<userInfo.album.length;i++) {
			$("#albumNameList").append("<option value="+ userInfo.album[i].albumID +">"+ userInfo.album[i].albumName +"</option>");
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

$("#confirm").click(function(){
	var r = confirm("Confirm delete?");
	if(r) {
		$("#confirm").attr("type","submit");
	}
	else {
		$("#confirm").attr("type","button");
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