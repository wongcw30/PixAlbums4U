<?php
if(!isset($link)){
	$link = 'logout.php';
}
?>

<!DOCTYLE html>
<html>
	<head>
		<title>404 Error Page</title>
		<style>
			body {
				
				display: -webkit-flex;
				display: flex;
				
				-webkit-justify-content: center;
				justify-content: center;
				
				-webkit-align-items: center;
				align-items: center;

			}
			
			p{
				font-size: 20px;
				font-family: "Franklin Gothic Medium","Franklin Gothic","ITC Franklin Gothic",Arial,sans-serif;
				
			}
			
			a:link{text-decoration:none;};
			a:hover{text-decoration:none;};
			a:visited{text-decoration:none;};
			a:active{text-decoration:none;};
		</style>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

	<head>
	<body>
		<div id="404container">
		<div id="404img"><img src="images/404_error.png"/></div>
		<div id="404message">
			<p> 
				This content is currently unavailable. <br/> 
				The page you requested cannot be displayed right now. <br/>
				It may be temporarily unavailable, the link you clicked on may have expired, 
				or you may not have permission to view this page.
			</p>
			
		  <p>
			<a href="." class="btn btn-info btn-lg">
			  <span class="glyphicon glyphicon-home"></span>  Return Home
			</a>
		  </p> 
			
		</div>
		</div>
	<script src="jquery.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		
	</body>
</html>