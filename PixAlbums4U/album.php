<?php
	session_start();

	if(isset($_SESSION['userID'])){
	
		if(isset($_GET['userID'])){
		
			if($_GET['userID']==$_SESSION['userID']) {
				unset($_GET['userID']);
				?>
					<script>
						window.location.replace("album.php");
					</script>
				<?php
			}
			else {
				$title = 'Albums | PixAlbums4U - Photo Sharing';
				include('userHeader.php');
?>
	<link rel="stylesheet" type="text/css" href="album.css" />
	<h1 id="ownerAlbum"></h1>
	<?php include("albumField.php");?>
	<?php include("pubFieldScript.php"); ?>
<?php
			}
		}
		else {
			
			$title = 'Albums | PixAlbums4U - Photo Sharing';
			include('userHeader.php');
?>
	<link rel="stylesheet" type="text/css" href="album.css" />
	<style> 
		textarea {
				width: 375px;
				height: 41px;
				resize: none;
		}
	</style>

	
	<?php include("albumFieldOwn.php");?>
	<?php include("ownFieldScript.php"); ?>
<?php

		}
	}
	else if(isset($_GET['userID'])) {
	$title = 'Welcome to PixAlbums4U | Albums';
	include('pubHeader.php');


?>

	<link rel="stylesheet" type="text/css" href="album.css" />

	<h1 id="ownerAlbum"></h1>
	<?php include("albumField.php");?>
	<?php include("pubFieldScript.php");?>
<?php

	}
	else {
		header('Location: 404.php');
	}

?>