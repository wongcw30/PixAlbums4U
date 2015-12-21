<?php
$statement = false;

if(isset($_POST['updateUser'])) {
	include('class.php');
	$user = new User($_POST['updateUser']);
		
	if (!file_exists('photo/'.$_POST['updateUser'])) {
		mkdir('photo/'.$_POST['updateUser'], 0777, true);
	}
	file_put_contents("photo/".$_POST['updateUser']."/userInfo.json", json_encode($user));
	$statement = true;
}
header('Content-type: application/json');
echo json_encode($statement);
?>