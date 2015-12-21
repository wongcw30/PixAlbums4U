<?php
	session_start();
	
	if(isset($_SESSION['userID'])) {
		$link = "album.php";
		include('404-body.php');
	}
	else {
		$link = "logout.php";
		include('404-body.php');
	}
?>













