<?php
$statement = false;
if(isset($_POST['userInfo'])){
	$statement = json_decode(
		file_get_contents('photo/'.$_POST['userInfo'].'/userInfo.json'),
		true
	);
}
header('Content-type: application/json');
echo json_encode($statement);
?>