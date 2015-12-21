<?php
session_start();

if(isset($_SESSION['userID'])) {
	
	if(isset($_GET['userID'])) {
		
	if($_GET['userID']==$_SESSION['userID']) { //userID send from album.php|| check whether the userID is same with login one or not
			
			unset($_GET['userID']);
			
			if(isset($_GET['albumNo'])) {  //when user accessing the own account. only show albumNo
				?> <!-- albumNo is send from album.php-->
					<script>
						window.location.replace("photo.php?albumNo=" + <?php echo $_GET['albumNo']; ?>);//when clicking <a> element, replace this with the URL
					</script>
				<?php
			}
			else {
				header('Location: 404.php');
			}
		}
		else {
			if(isset($_GET['albumNo'])) { //when you accessing people's album. 1 end slide show is here
			$title = 'PixAlbums4U: Photos';
			include('viewHeader.php');
?>
		<link rel="stylesheet" type="text/css" href="photo.css" />
			
			<?php include("photoField.php"); ?>
			<?php include("pubPhotoScript.php"); ?>
			<?php
						
						}
						else {
							header('Location: 404.php');
						}
					}
				}
				else {
					if(isset($_GET['albumNo'])) {	//user with mention albumNo
						$title = 'PixAlbums4U: Your Photos'; //when user accessing their OWN album.
						include('userHeader.php');
			?>	
			
			<style>
			.photo_item {
				cursor: pointer;
			}
			
			textarea { 
						width: 375px;
						height: 41px;
						resize: none;
				}
			</style>
			<link rel="stylesheet" type="text/css" href="photo.css" />
		
		
		<?php include("photoFieldOwn.php");?>
		<?php include("ownPhotoScript.php"); ?>
		<?php	
		}
			else { //user didn't mention the albumNo
				header('Location: 404.php');
			}		
		}

		}
		else if(isset($_GET['userID'])) {//this is for public one. no need log in
		if(isset($_GET['albumNo'])) {
		$title = 'PixAlbums4U: Photos';
		include('pubHeader.php');
		?>
<link rel="stylesheet" type="text/css" href="photo.css" /> 
	
	<?php include("photoField.php");?>
	<?php include("pubPhotoScript.php"); ?>

<?php
	}
	else {
		header('Location: 404.php');
	}
}
else {
	header('Location: 404.php');
}
?>