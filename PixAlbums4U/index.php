<?php
session_start();

if(isset($_SESSION['userID'])) {
	header('Location: album.php');
}
else {
	header('Location: sign_in.php');
}
?>