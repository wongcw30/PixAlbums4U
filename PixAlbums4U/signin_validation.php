<?php
		include('common.php');

		if($_SERVER['REQUEST_METHOD'] == "POST") {
			
			$input['username'] = $_POST['username'];
			$input['password'] = $_POST['password'];
			
			$hasError = false;

			if(strlen($input['username']) == 0){
				$errors['username'] = "{$fields['username']} cannot be blank";
				$hasError = true;
			}

			if(strlen($input['password']) == 0){
				$errors['password'] = "{$fields['password']} cannot be blank";
				$hasError = true;
			}

			if(!$hasError){
				$mysqli = new mysqli('localhost', 'root', '', 'PixAlbums4U');
				if ($mysqli->connect_error) {
					die('Connect Error (' . $mysqli->connect_errno . ') '
							. $mysqli->connect_error);
				}
				
				$sql = <<<SQL
SELECT Password FROM Users WHERE Username= ?
SQL;
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('s', $input['username']);
				$stmt->execute();
				$stmt->bind_result($password);
				
				if($stmt->fetch()){	//if the email exist
					if($password != $input['password']){
						$errors['password'] = "{$fields['username']} or {$fields['password']} are invalid";
						$hasError=true;
					}
				}
				else{	//if the email does not exist
					$errors['password'] = "{$fields['username']} or {$fields['password']} are invalid";
					$hasError=true;
				}
				$stmt->close();
			}

			if(!$hasError){
				$mysqli = new mysqli('localhost', 'root', '', 'PixAlbums4U');
				if ($mysqli->connect_error) {
					die('Connect Error (' . $mysqli->connect_errno . ') '
							. $mysqli->connect_error);
				}
				
				$sql = <<<SQL
SELECT UserID FROM Users WHERE Username = ?
SQL;
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('s', $input['username']);
				$stmt->execute();
				$stmt->bind_result($userID);
				$stmt->fetch();
				$stmt->close();
				
				$_SESSION['userID'] = $userID;	//Using user ID as the login session
				header('Location: album.php');
			}
		}
?>