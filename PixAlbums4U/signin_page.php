<!DOCTYPE html>
<html>
<?php $title = 'PixAlbums4U - Login';
?>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="bootstrap.min.js"></script>
		<script src="jquery.js"></script>
		<script type="text/javascript" src="background.cycle.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
                $("body").backgroundCycle({
                    imageUrls: [
                        'images/littleg3.jpg',
						'images/cat1.jpg',
						'images/littleg5.jpg',
						'images/littleg4.jpg',
                        'images/littleg1.jpg',
						'images/cat2.jpg',
						'images/littleg2.jpg'
                    ],
                    fadeSpeed: 3000,
                    duration: 4500,
                    backgroundSize: SCALING_MODE_COVER
                });
            });
		</script>
		
		<link rel="stylesheet" href="bootstrap.min.css">
		
		<style type="text/css">
			body{
				color: #FFFFFF;
				font: 18px Lucida Sans Unicode, sans-serif;
				background-color: #000000;
			}
			
			header{
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 60px;
				background-color: #56BC8A;
				color: #FFFFFF;
			}
			
			a#mytitle{
				font: 50px Century gothic, sans-serif;
				float: left;
			}
			
			a.header-ele{
				text-decoration: none;
				color: #FFFFFF;
			}
			
			a#mytitle{
				float: left;
				margin-left: 45px;
				margin-top: 8px;
				text-decoration: none;
			}
			
			div#color-box{
				top: 60px;
				left: 0;
				position: fixed;
				width: 100%;
				height: 100%;
				background-color: rgba(0,0,0,0.25);
			}
			
			div#header-container{
				width: 1300px;
				margin-left: auto;
				margin-right: auto;
			}
			
			div#container{
				width: 1180px;
				margin-left: auto;
				margin-right: auto;
			}
			
			div#content{
				float: left;
				margin-top: 65px;
				margin-left: 45px;
				margin-right: 45px;
			}
			
			p#home-desc{
				width: 600px;
			}
			
			div#registration{
				float: right;
				border: 1px solid #CCCCCC;
				padding: 20px 25px 40px 25px;
				background: #FFFFFF;
				border-radius: 25px;
				color: #000000;
				margin-top: 65px;
				margin-left: 30px;
				margin-right: 30px;
				width: 380px;
			}
			
			p#desc-signup{
				margin: 2px;
			}
			
			hr.style-two {
				border: 0;
				height: 1px;
				background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0));
				background-image:    -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0));
				background-image:     -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0));
				background-image:      -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0));
			}
			
			
			button#btn-signup{
				float: right;
			}
			
			a#signup-link{
				float: right;
				padding-top: 17px;
				font:20px Helvetica, sans-serif;
			}
			
			a#signup-link:hover{
				color: rgba(255,255,255,0.7);
			}
			
			span.error_msg{
			color: #FF0000;
			font: 16px Palatino Linotype, serif;
			}
			
			a#aboutus{
				text-decoration: none;
				
			}
			
			a#aboutus:hover{
				color: #3399FF;
				text-decoration: overline;
			}
		</style>
		<title>Welcome to PixAlbums4U - Photo Sharing</title>
		<link rel="shortcut icon" href="monkey.ico" />
	</head>
	<body style="margin: 0;">
		<header>
			<div id="header-container">
				<a class="header-ele" id="mytitle"href="">PixAlbums4U</a>
				<a class="header-ele" id="signup-link" href="signup.php">Sign Up</a>
			</div>
		</header>
		
		<div id="color-box">
			<div id="container">
				
				<div id="content">
					<p id="home-desc" style="padding-top: 30px;">
					<strong>Share and connect with the PixAlbums4U Community. </br>Discover billions of beautiful photos.</strong>
					</br>
					</br>
					Become obsessed with our social feed of daily inspiration from the photographers you follow. 
					Explore PixAlbums4U to easily find everything you're interested in. 
					Join the world's largest photography community, discover billions of beautiful photos and share your own.
				   </p>
				 </div>
				 
				 
					<div id="registration">
						<p id="desc-signup">Welcome to PixAlbums4U. <a id="aboutus" href="about.php">About Us</a></p>
						<hr class="style-two">
						   <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" role="form" id="form-signup" name="login-page">
								<div class="form-group">
									<input type="text" name="username" class="form-control" id="username" placeholder="Username" value="<?php echo $input['username']; ?>" autofocus required/>&nbsp;<span class="error_msg" id="username_error"><?php echo $errors['username']; ?></span><br/>
								</div>
								
								<div class="form-group">
									<input type="password" name="password" class="form-control" id="userpassword" placeholder="Password" value="<?php echo $input['password']; ?>" required/>&nbsp;<span class="error_msg" id="password_error"><?php echo $errors['password'];?></span><br/>
								</div>
								<button type="submit" class="btn btn-primary" id="btn-signin">Sign In</button>
						   </form>
					</div>
					
			</div>
		</div>
		
	</body>
</html>