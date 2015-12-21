<?php 
	$userID_list = array();
	
	$mysqli = new mysqli('localhost', 'root', '', 'PixAlbums4U');
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') '
				. $mysqli->connect_error);
	}
		
	$sql = <<<SQL
SELECT userID FROM Users ORDER BY userID
SQL;
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($userID);
	while($stmt->fetch()) {
		$userID_list[] = $userID;
	}
	
	$stmt->close();
	
	header('Content-type: application/json');
	echo json_encode($userID_list);
?>