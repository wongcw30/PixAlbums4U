<?php
	session_start();
	
	if(isset($_SESSION['userID'])) {	//Just in case, if the user login click 'backspace' or purposely revisit signin.php
		unset($_SESSION['userID']);		//Unset the user session
		
		//Login Page
		include('signin_validation.php');
		include('signin_page.php');
	}
	else {
		//Login Page
		include('signin_validation.php');
		include('signin_page.php');
	}
?>