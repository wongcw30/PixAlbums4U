<?php 
	$username_list = array();
	
	$mysqli = new mysqli('localhost', 'root', '', 'PixAlbums4U');
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') '
				. $mysqli->connect_error);
	}
	
	$sql = <<<SQL
SELECT Username FROM Users ORDER BY Username
SQL;
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($username);
	while($stmt->fetch()) {
		$username_list[] = $username;
	}
	
	$stmt->close();
	
	header('Content-type: application/json');
	echo json_encode($username_list);
?>