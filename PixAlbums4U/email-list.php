<?php 
	$email_list = array();
	
	$mysqli = new mysqli('localhost', 'root', '', 'PixAlbums4U');
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') '
				. $mysqli->connect_error);
	}
	
	$sql = <<<SQL
SELECT Email FROM Users ORDER BY Email
SQL;
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($email);
	while($stmt->fetch()) {
		$email_list[] = $email;
	}
	
	$stmt->close();
	
	header('Content-type: application/json');
	echo json_encode($email_list);
?>