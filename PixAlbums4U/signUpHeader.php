<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="bootstrap.min.js"></script>
		<script src="jquery.js"></script>
		<?php include("slideFunc.php"); ?>
		<style type="text/css">
			header{
				position: fixed;
				top: 0;
				left:0;
				width: 100%;
				height: 49px;
				background-color: #FFFFFF;
				
			}
			div#top-bar{
				height: 48px;
			}
			
			div#global-nav{
				height: 47px;
				width: 1280px;
				margin-left: auto;
				margin-right: auto;
			}
			
			div#left-container{
				float: left;
			}
			
			div#monkey-logo{
				
				width: 0px;
				height: 0px;
				padding-top: 6px;
			}
			
			a#title-logo{
				font: bold 32px Century Gothic, sans-serif;
				color: #0A7567;
				padding-left: 35px;
				text-decoration: none;
			}
			
			div#right-container{
				float: right;
				margin-top: 15px;
			}
			
			a#signin-logo{
				color: #5C5C5C;
				font: 14px Helvetica, sans-serif;
				text-decoration: over-line;
			}
			
			body{
				background-color: #00934A;
			}
	
		</style>
		<link rel="stylesheet" href="bootstrap.min.css">
<?php
if(!isset($title)){
	$title="Sign Up For PixAlbums4U";
}
?>	
		<title><?php echo $title; ?></title>
		<link rel="shortcut icon" href="monkey.ico" /> <!-- set icon -->
	</head>
	<body style="background-color: #00934A">
		<header id="header">
			<div id="top-bar">
				<div id="global-nav">
					<div id="left-container">
						<div id="monkey-logo">
							<img src="monkey.ico" alt="" height="" width="">
						</div>
						<a id="title-logo" href="index.php">PixAlbums4U</a>
					</div>
					<div id="right-container">
						<a id="signin-logo" href="sign_in.php">Have an account? Sign In</a>
					</div>
				</div>
			</div>
		</header>