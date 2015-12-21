<?php
$statement = false;

class User
{
	public $userID;
	public $username;
	public $fname;
	public $email;
	public $password;
	public $album = array();
	
	function __construct($userID) {

		$mysqli = new mysqli('localhost', 'root', '', 'PixAlbums4U');
			if ($mysqli->connect_error) {
				die('Connect Error (' . $mysqli->connect_errno . ') '
						. $mysqli->connect_error);
			}
			
		$sql = <<<SQL
SELECT * FROM Users WHERE UserID=?
SQL;

		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('d',$userID);
		$stmt->execute();
		$stmt->bind_result(
			$this->userID,
			$this->username,
			$this->fname,
			$this->email,
			$this->password
		);
		$stmt->fetch();
		$stmt->close();
		
		$sql = <<<SQL
SELECT AlbumID, AlbumName, Description FROM Album WHERE UserID=?
SQL;

		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('d',$this->userID);
		$stmt->execute();
		$stmt->bind_result(
			$userAlbum['albumID'],
			$userAlbum['albumName'],
			$userAlbum['description']
		);
		
		while($stmt->fetch()){
			$this->album[] = new Album($userAlbum['albumID'],$userAlbum['albumName'],$userAlbum['description']);
		}
		$stmt->close();
		
		$sql = <<<SQL
SELECT PhotoID, PhotoName, Description, PhotoSize, PhotoDate, SourcePath FROM Photo WHERE (UserID=?) AND (AlbumID=?)
SQL;
		
		for($i=0;$i<count($this->album);$i++) {
			$x = $this->album[$i];
			$y = $x->getAlbum();
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('dd',$this->userID, $y['albumID']);
			$stmt->execute();
			$stmt->bind_result(
				$userPhoto['photoID'],
				$userPhoto['photoName'],
				$userPhoto['description'],
				$userPhoto['photoSize'],
				$userPhoto['photoDate'],
				$userPhoto['sourcePath']
			);
			
			while($stmt->fetch()){
				$x->addPhoto($userPhoto['photoID'],$userPhoto['photoName'],$userPhoto['description'],$userPhoto['photoSize'],$userPhoto['photoDate'],$userPhoto['sourcePath']);
			}
			$stmt->close();
		}
	}

	function getUser() {
		$x = (array) $this;
		$y = array();
		if(count($x['album'])>0) {
			foreach($x['album'] as $z) {
				$y[] = $z->getAlbum();
			}
		}
		$x['album'] = $y;
		return $x;
	}
	
	function editUser($username,$fname,$email,$password) {
		
		$mysqli = new mysqli('localhost', 'root', '', 'PixAlbums4U');
			if ($mysqli->connect_error) {
				die('Connect Error (' . $mysqli->connect_errno . ') '
						. $mysqli->connect_error);
			}
		
		//Date Format = 'YYYY-MM-DD'
		$sql = <<<SQL
UPDATE Users 
SET 
	Username = ?,
	FullName = ?,
	Email = ?,
	Password = ?,
WHERE UserID=?
SQL;
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ssssd',
			$username,
			$fname,
			$email,
			$password,
			$this->userID
		);
		$stmt->execute();
		$stmt->close();
		
		$this->username = $username;
		$this->fname = $fname;
		$this->email = $email;
		$this->password = $password;

	}
	
	function getAlbum($i)  {
		$x = $this->album[$i];
		return $x->getAlbum();
	}
	
	function editAlbum($i,$albumName,$description) {
		$x = $this->album[$i];
		$y = $x->getAlbum();
		$albumID = $y['albumID'];
		
		$mysqli = new mysqli('localhost', 'root', '', 'PixAlbums4U');
			if ($mysqli->connect_error) {
				die('Connect Error (' . $mysqli->connect_errno . ') '
						. $mysqli->connect_error);
			}
		
		$sql = <<<SQL
UPDATE Album 
SET 
	AlbumName = ?,
	Description = ? 
WHERE UserID=? AND AlbumID=?
SQL;
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ssdd',
			$albumName,
			$description,
			$this->userID,
			$albumID
		);
		$stmt->execute();
		$stmt->close();
		
		$x->editAlbum($albumName,$description);
	}
	
	function addAlbum($albumName,$description) {
		$mysqli = new mysqli('localhost', 'root', '', 'PixAlbums4U');
			if ($mysqli->connect_error) {
				die('Connect Error (' . $mysqli->connect_errno . ') '
						. $mysqli->connect_error);
			}
		$sql1 = <<<SQL
INSERT INTO Album (UserID, AlbumName, Description) VALUES
(?,?,?)
SQL;
		$stmt1 = $mysqli->prepare($sql1);
		$stmt1->bind_param('dss',
			$this->userID,
			$albumName,
			$description
		);
		$stmt1->execute();
		
		$sql2 = <<<SQL
SELECT LAST_INSERT_ID()
SQL;
		$stmt2 = $mysqli->prepare($sql2);
		$stmt2->execute();
		$stmt2->bind_result($albumID);
		While($stmt2->fetch()) {
			$this->album[] = new Album($albumID,$albumName,$description);
		}
		$mysqli->close();
		
		return (count($this->album)-1);
		
	}
	
	function getPhoto($i,$j) {
		$x = $this->album[$i];
		$y = $x->getPhoto($j);
		return $y;
	}
	
	function editPhoto($i,$j,$description,$photoDate) {
		$x = $this->album[$i];
		$y = $x->getAlbum();
		$mysqli = new mysqli('localhost', 'root', '', 'PixAlbums4U');
			if ($mysqli->connect_error) {
				die('Connect Error (' . $mysqli->connect_errno . ') '
						. $mysqli->connect_error);
			}
		if($photoDate == "") {
			$photoDate = null;
		}
		
		//Date Format = 'YYYY-MM-DD'
		$sql = <<<SQL
UPDATE Photo 
SET 
	Description = ?,
	PhotoDate = ?
WHERE PhotoID=?
SQL;
		
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ssd',
			$description,
			$photoDate,
			$y['photo'][$j]['photoID']
		);
		$stmt->execute();
		$stmt->close();
		
		$x->editPhoto($j,$description,$photoDate);
	}
	
	function addPhoto($i,$photoName,$description,$photoSize,$photoDate,$sourcePath) {
		$x = $this->album[$i];
		$y = $x->getAlbum();
		
		
		$mysqli = new mysqli('localhost', 'root', '', 'PixAlbums4U');
			if ($mysqli->connect_error) {
				die('Connect Error (' . $mysqli->connect_errno . ') '
						. $mysqli->connect_error);
			}
		$sql1 = <<<SQL
INSERT INTO photo (UserID, AlbumID, PhotoName, Description, PhotoSize, PhotoDate, SourcePath) VALUES
(?,?,?,?,?,?,?)
SQL;
		$stmt1 = $mysqli->prepare($sql1);
		$stmt1->bind_param('ddssdss',
			$this->userID,
			$y['albumID'],
			$photoName,
			$description,
			$photoSize,
			$photoDate,
			$sourcePath
		);
		$stmt1->execute();
		
		$sql2 = <<<SQL
SELECT LAST_INSERT_ID()
SQL;
		$stmt2 = $mysqli->prepare($sql2);
		$stmt2->execute();
		$stmt2->bind_result($photoID);
		While($stmt2->fetch()) {
			$x->addPhoto($photoID,$photoName,$description,$photoSize,$photoDate,$sourcePath);
		}
		$mysqli->close();
		
	}
	
	function deletePhoto($i,$j) {
		$x = $this->album[$i];
		$y = $x->getAlbum();
		
		
		$mysqli = new mysqli('localhost', 'root', '', 'PixAlbums4U');
			if ($mysqli->connect_error) {
				die('Connect Error (' . $mysqli->connect_errno . ') '
						. $mysqli->connect_error);
			}
		
		$sql = <<<SQL
DELETE FROM Photo
WHERE PhotoID = ?
SQL;
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('d',$y['photo'][$j]['photoID']);
		
		$stmt->execute();
		$stmt->close();
		
		$x->deletePhoto($j);
		
	}
}

class Album
{
	public $albumID;
	public $albumName;
	public $description;
	public $photo = array();
	
	function __construct($albumID,$albumName,$description) {
		$this->albumID = $albumID;
		$this->albumName = $albumName;
		$this->description = $description;
	}
	
	function getAlbum() {
		
		$x = (array) $this;
		$y = array();
		if(count($x['photo'])>0) {
			foreach($x['photo'] as $z) {
				$y[] = $z->getPhoto();
			}
		}
		$x['photo'] = $y;
		return $x;
	}
	
	function editAlbum($albumName,$description) {
		$this->albumName = $albumName;
		$this->description = $description;
	}
	
	function getPhoto($j) {
		$x = $this->photo[$j];
		return $x->getPhoto();
	}
	
	function addPhoto($photoID,$photoName,$description,$photoSize,$photoDate,$sourcePath) {
		$this->photo[] = new Photo($photoID,$photoName,$description,$photoSize,$photoDate,$sourcePath); 
	}
	
	function editPhoto($j,$description,$photoDate) {
		$x = $this->photo[$j];
		$x->editPhoto($description,$photoDate);
	}
	
	function deletePhoto($j) {
		var_dump($j);
		unset($this->photo[$j]);
	}
}

class Photo
{	
	public $photoID;
	public $photoName;
	public $description;
	public $photoSize;
	public $photoDate;
	public $sourcePath;
	
	function __construct($photoID,$photoName,$description,$photoSize,$photoDate,$sourcePath) {
		$this->photoID = $photoID;
		$this->photoName = $photoName;
		$this->description = $description;
		$this->photoSize = $photoSize;
		$this->photoDate = $photoDate;
		$this->sourcePath = $sourcePath;
	}
	
	function getPhoto() {
		return (array) $this;
	}
	
	function editPhoto($description,$photoDate) {
		$this->description = $description;
		$this->photoDate = $photoDate;
	}
}


if(isset($_POST['getUser'])) {
	$user = new User($_POST['getUser']);
	$statement = $user;
	//$statement = $user->getUser();
} 
else if(isset($_POST['editUser'])) {
	$user = new User($_POST['editUser']);
	$statement = $user->editUser(
		$_POST['username'],
		$_POST['fname'],
		$_POST['email'],
		$_POST['password']
	);
} 
else if(isset($_POST['getAlbum'])) {
	$user = new User($_POST['getAlbum']);
	$statement = $user->getAlbum($_POST['i']);
} 
else if(isset($_POST['editAlbum'])) {
	$user = new User($_POST['editAlbum']);
	$user->editAlbum(
		$_POST['i'],
		$_POST['albumName'],
		$_POST['description']
	);
	$statement = true;
} 
else if(isset($_POST['addAlbum'])) {
	$user = new User($_POST['addAlbum']);
	$statement = $user->addAlbum(
		$_POST['albumName'],
		$_POST['description']
	);
} 
else if(isset($_POST['getPhoto'])) {
	$user = new User($_POST['getPhoto']);
	$statement = $user->getPhoto(
		$_POST['i'],
		$_POST['j']
	);
} 
else if(isset($_POST['editPhoto'])) {
	$user = new User($_POST['editPhoto']);
	$user->editPhoto(
		$_POST['i'],
		$_POST['j'],
		$_POST['description'],
		$_POST['photoDate']
	);
	
	$statement = true;
	
} 
else if(isset($_POST['addPhoto'])) {
	$user = new User($_POST['addPhoto']);
	$statement = $user->addPhoto(
		$_POST['i'],
		$_POST['photoName'],
		$_POST['description'],
		$_POST['photoSize'],
		$_POST['photoDate'],
		$_POST['sourcePath']
	);	
}
else if(isset($_POST['deletePhoto'])) {
	$user = new User($_POST['deletePhoto']);
	
	if(is_array($_POST['j'])) { //allow to delete multiple photo at a times by pass array of integers
		rsort($_POST['j']); //to make sure that deletion will start for behind
		for($i=0;$i<count($_POST['j']);$i++) {
			$photoInfo = $user->getPhoto(
				$_POST['i'],
				$_POST['j'][$i]
			);
			
			unlink($photoInfo['sourcePath']);
			
			$user->deletePhoto(
				$_POST['i'],
				$_POST['j'][$i]
			);
		}
		$statement = true;
	}
	else {
		
		$photoInfo = $user->getPhoto(
			$_POST['i'],
			$_POST['j']
		);
		
		unlink($photoInfo['sourcePath']);
		
		$user->deletePhoto(
			$_POST['i'],
			$_POST['j']
		);
		$statement = true;
	}
}	

header('Content-type: application/json');
echo json_encode($statement);

?>