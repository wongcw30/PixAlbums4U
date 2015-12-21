<!DOCTYPE html>
<html>
	<head>

	<?php include('slidefunc.php'); ?>
		<style type="text/css">
			header{
				height: 250px;
				background-image: url("images/sweet.jpg");
				background-repeat: no-repeat;
				background-position: center;
				width: 100%;
			}
			div#colorbar-top{
				background-color: rgba(0,0,0,0.8);
				height: 50px;
				width: 100%;
			}
			
			div#colorbar-btm{
				background-color: rgba(0,0,0,0.3);
				margin-top: 45px;
				height: 50px;
			}

			nav#nav-left li{
				float: left;
				display: inline;
				text-decoration: none;
				margin-left: 12px;
			}
			
			nav#nav-btm li{
				float: left;
				display: inline;
				text-decoration: none;
			}
			
			ul#list-topright{
				float: right;
			}
			
			ul{
				list-style-type: none;
				margin: 0;
				padding: 0;
				text-align: center;
			}
			
			a{
				text-decoration: none;
				color: #FFFFFF;
			}
			
			a#pixalb{
				font: bold 32px Century Gothic, sans-serif;
			}
			
			li#youralb{
				padding-top: 13px;
				padding-left: 30px;
			}
			
			li#pixlogo{
				padding-top: 3px;
			}
			
			li#signoutli{
				padding-top: 13px;
				padding-right: 25px;
			}
			
			a#youralb-link ,a#signout{
				font: 17px Candara, sans-serif;
			}
			
			a#youralb-link:hover , a#signout:hover{
				color: rgba(255,255,255,0.7);
			}
			#list-btm{
				padding-top: 16px;

			}
			#nav-btm a:link{
				font: 16px Gill Sans, sans-serif;
				color: #FFFFFF;
				border: 0px solid #FFFFFF;
				padding: 16px ;
				text-decoration: none;
			}
			
			#nav-btm a:hover{
				background-clip: padding-box;
				background-color: rgba(0,0,0,0.6);
				color: #FFFFFF;
			}
			
		</style>
<?php
if(!isset($title)){
	$title="PixAlbums4U";
}
?>		
		<title><?php echo $title; ?></title>
		<link rel="shortcut icon" href="monkey.ico" />
	</head>
	<body style="margin: 0;">
		<header id="header" style="margin: 0;">
			<div id="colorbar-top">
				<nav id="nav-left" class="navi">
					<ul id="list-topleft">
						<li id="pixlogo"><a id="pixalb" href="index.php">PixAlbums4U</a></li>
						<li id="youralb"><a id="youralb-link" href="album.php">Your Album</a></li>
					</ul>
				</nav>
				<ul id="list-topright">
					<li id="signoutli"><a id="signout" href="logout.php">Sign out</a></li>
				</ul>
			</div>
			
			<p id="my-fname" style="color:#FFFFFF; padding-top: 45px; padding-left: 30px; margin: 1px; font: 32px Franklin Gothic Medium, sans-serif;"></p>
			<p id="my-username" style="color:#FFFFFF; padding-left: 35px; margin: 0px; font: 20px Futura, sans-serif;"></p>
			<?php include('displayName.php');?>
		<div id="colorbar-btm">
				<nav id="nav-btm" class="navi">
					<ul id="list-btm">
						<li id="createAlbum"><a class="menu-bar" href="createAlbum.php"> &nbsp;Create Album&nbsp; </a></li>
						<li id="editAlbum"><a class="menu-bar" href="editAlbum.php"> &nbsp;Edit Album&nbsp; </a></li>
						<li id="deleteAlbum"><a class="menu-bar" href="deleteAlbum.php"> &nbsp;Delete Album&nbsp; </a></li>
						<li id="uploadPhotos"><a class="menu-bar" href="uploadPhotos.php"> &nbsp;Upload Photos&nbsp; </a></li>
					</ul>
				</nav>
			</div>
		</header>