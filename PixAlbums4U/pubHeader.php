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
				margin-top: 150px;
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
			
			li#pixlogo{
				padding-top: 3px;
			}
			
			li#signinli{
				padding-top: 13px;
				padding-right: 25px;
			}
			
			a#signin{
				font: 17px Candara, sans-serif;
			}
			
			a#signin:hover{
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
					</ul>
				</nav>
				<ul id="list-topright">
					<li id="signinli"><a id="signin" href="sign_in.php">Sign In</a></li>
				</ul>
			</div>
			
		<div id="colorbar-btm">
				<nav id="nav-btm" class="navi">
					<ul id="list-btm">
						<li><a class="menu-bar" href="signup.php"> &nbsp;Sign Up&nbsp; </a></li>
						<li><a class="menu-bar" href="about.php"> &nbsp;About Us&nbsp; </a></li>
					</ul>
				</nav>
			</div>
		</header>