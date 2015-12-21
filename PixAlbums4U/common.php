<?php
	$fields = array(
		'username' 		=> 'Username',
		'fname'			=> 'Full Name',
		'email'			=> 'Email',
		'password'		=> 'Password',
		'cfmpassword' 	=> 'Comfirm Password',
	);
	
	foreach($fields as $key => $val){
		$input[$key] = $errors[$key] =''; 
	}
?>