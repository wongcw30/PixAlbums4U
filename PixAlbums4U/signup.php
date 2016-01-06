<?php
	session_start();
	
	if(!isset($_SESSION['userID'])){
		
		
		include('common.php');
		
		date_default_timezone_set('Asia/Kuala_Lumpur');
		$date = date('Y-m-d',time());
		
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			
			foreach($fields as $key => $val) {
				if($key != 'username' &&$key != 'password' && $key != 'cfmpassword'){	//Only the password and confirm password are not allow to trim()
					$input[$key] = isset($_POST[$key]) ? trim($_POST[$key]) : '';
				}
				else{
					$input[$key] = isset($_POST[$key]) ? $_POST[$key] : '';
				}
			}
			
			$errorFound = false;
			
			foreach($input as $key => $val){
				if(strlen($val)==0){
					$errors[$key] = "{$fields[$key]} cannot be empty";
					$errorFound = true;
				}
				else{
					$errors[$key] = '';
				}
			}
			
			if($input['password'] != $input['cfmpassword']){
				$error['cfmpassword'] = "{$fields['password']} The password does not match";
				$errorFound = true;
			}
			
			if(!$errorFound){
				$mysqli = new mysqli('localhost', 'root', '', 'PixAlbums4U');
				if ($mysqli->connect_error) {
					die('Connect Error (' . $mysqli->connect_errno . ') '
							. $mysqli->connect_error);
				}

				$num_row = 0;
				$sql = <<<SQL
SELECT count(*) AS num_row FROM Users WHERE Username = ? OR Email = ?
SQL;
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('ss', $input['username'], $input['email']);
				$stmt->execute();
				$stmt->bind_result($num_row);
				$stmt->fetch();
				if($num_row!=0){
					$errorFound = true;
				}
				$stmt->close();
			}
			
			if(!$errorFound){
				$mysqli = new mysqli('localhost', 'root', '', 'PixAlbums4U');
				if ($mysqli->connect_error) {
					die('Connect Error (' . $mysqli->connect_errno . ') '
							. $mysqli->connect_error);
				}
			
				$sql = <<<SQL
INSERT INTO Users ( Username, FullName, Email, Password )
VALUES (?,?,?,?)
SQL;
				
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('ssss', 
					$input['username'],
					$input['fname'],
					$input['email'],
					$input['password']
				);

				$stmt->execute();
				
				$sql = <<<SQL
SELECT LAST_INSERT_ID()
SQL;
				//Get the user ID which is auto generate from the database
				$stmt = $mysqli->prepare($sql);
				$stmt->execute();
				$stmt->bind_result($userID);			
				$stmt->fetch();
				$_SESSION['userID'] = $userID;	//Create session for the successful sign up user
				$stmt->close();
?>
<script src="jquery.js"></script>		
<script>		
	var userID = <?php echo $_SESSION['userID']; ?>;
	$.ajax({
		url: "updateUser.php",
		data: {
			updateUser : userID
		},
		type: "POST",
		dataType : "json",
		success: function( json ) {
			
		},
		error: function( xhr, status, errorThrown ) {
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );
		},
		complete: function( xhr, status) {
			window.location.replace("album.php");	//When The request is success, directing to album.php
		}
	});
</script>

<?php		
				echo "Redirecting To PixAlbums4U...";
			}//close of if no error and store all values
			
		}//close of if server method is post
		else {
	
			$title = 'Sign Up';
			include('signUpHeader.php');
?>
	<style type="text/css">
		div#body-wrapper{
			width: 1190px;
			margin-left: auto;
			margin-right: auto;
			
		}
		
		div#contain-box{
			margin-top: 120px;
		}
		
		div#color-box{
			width: 890px;
			height: 647px;
			background-color: #FFFFFF;
			margin-left: auto;
			margin-right: auto;
			border-radius: 25px;
			
		}
		
		p#join-us{
			font: 50px Tahoma, sans-serif;
			padding-top: 55px;
			padding-left: 130px;
			padding-bottom: 20px;
		}
		
		div#registration{
			padding-left: 130px;
		}
		
		form#myForm{
			width: 570px;
		}
		
		span.error_msg{
			color: #FF0000;
		}
		
	</style>

	<div id="body-wrapper">
		<div id="contain-box">
			<div id="color-box">
			<p id="join-us">Join PixAlbums4U Today!</p>
				<div id="registration">
				<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="sign-up-form" id="myForm">
				<div class="form-group">
					<input type="text" 		id="username" 		class="form-control"	name="username" 	placeholder="Username" 			onblur="validateUsername()" 	oninput="validateUsername()" 		value="<?php echo $input['username'] ?>" 	maxlength="50" autofocus required/>&nbsp;<span class="error_msg" id="username_error"><?php echo $errors['username']; ?></span><br/>
					</div>
					
				<div class="form-group">
					<input type="text" 		id="fname" 			class="form-control"	name="fname" 		placeholder="Full Name" 		onblur="validateFullName()" 	oninput="validateFullName()" 		value="<?php echo $input['fname'] ?>" 	maxlength="150" autofocus required/>&nbsp;<span class="error_msg" id="fname_error"><?php echo $errors['fname']; ?></span><br/>
				</div>
				
				<div class="form-group">
					<input type="email" 	id="email" 			class="form-control"	name="email" 		placeholder="Your Email" 			onblur="validateEmail()" 		oninput="validateEmail()" 			value="<?php echo $input['email'] ?>" 		maxlength="150" required/>&nbsp;<span class="error_msg" id="email_error"><?php echo $errors['email'];?></span><br/>
				</div>
				
				<div class="form-group">
					<input type="password" 	id="password" 		class="form-control"	name="password" 	placeholder="New Password" 			onblur="validatePassword()" 	oninput="validatePassword()"  		value="<?php echo $input['password'] ?>" 	maxlength="150" required/>&nbsp;<span class="error_msg" id="password_error"><?php echo $errors['password'];?></span><br/>
				</div>
				
				<div class="form-group">
					<input type="password" 	id="cfmpassword" 	class="form-control"	name="cfmpassword" 	placeholder="Re-enter New Password"	onblur="validateCfmPassword()" 	oninput="validateCfmPassword()" 	value="<?php echo $input['cfmpassword'] ?>" maxlength="150" required/>&nbsp;<span class="error_msg" id="cfmpassword_error"><?php echo $errors['cfmpassword'];?></span><br/>
				</div>
				
				<p id="tAndC">By signing up, you agree to the Terms of Service and Privacy Policy, including Cookie Use. </p>
				<button id="signUpBtn" class="btn btn-primary btn-block"	type="button">Sign Up</button>
				</form>
				</div>
			</div>
		</div>
	</div>
	<script src="jquery.js"></script>
		<script>
			var usernameList;
			var emailList;
			var cfmPasswordVisited = false;

			function validateUsername() {
				
				$.ajax({
				url: "username-list.php",
				type: "POST",
				dataType : "json",
				success: function( json ) {
					usernameList = json;
				},
				error: function( xhr, status, errorThrown ) {
					alert( "Sorry, there was a problem!" );
					console.log( "Error: " + errorThrown );
					console.log( "Status: " + status );
					console.dir( xhr );
				},
				complete: function( xhr, status) {
					
				}
			});
				
				if($('#username').val().length > 0) {
					var errorFound = false;
					for(var i=0; i < usernameList.length; i++) {
						if($('#username').val() == usernameList[i]) {
							errorFound = true;
							
						}
						else {
							$("#username_error").html("");
						}
					}
					
					if(errorFound) {
						$("#username_error").html("This username is registered.");
					}
					else {
						$("#username_error").html("");
					}
				}
				else {
					$("#username_error").html("Your username is required.");
				}
			}
			
			function validateFullName() {
				if($("#fname").val().length > 0) {
					$("#fname_error").html("");
				}
				else {
					$("#fname_error").html("Your full name is required.");
				}
			}
			
			function validateEmail() {
				
				$.ajax({
				url: "email-list.php",
				type: "POST",
				dataType : "json",
				success: function( json ) {
					emailList = json;
				},
				error: function( xhr, status, errorThrown ) {
					alert( "Sorry, there was a problem!" );
					console.log( "Error: " + errorThrown );
					console.log( "Status: " + status );
					console.dir( xhr );
				},
				complete: function( xhr, status) {
					
				}
			});
				
				if($('#email').val().length > 0) {
					var errorFound = false;
					for(var i=0; i < emailList.length; i++) {
						if($('#email').val() == emailList[i]) {
							errorFound = true;
						}
						else {
							$("#email_error").html("");
						}
					}
					
					if(errorFound) {
						$("#email_error").html("This Email Is Used");
					}
					else {
						$("#email_error").html("");
					}
				}
				else {
					$("#email_error").html("Your email address is required.");
				}
			}
			
			function validatePassword() {
				var errorFound = false;
				if($("#password").val().length > 7) {
					$("#password_error").html("");
				}
				else if($("#password").val().length > 0){
					$("#password_error").html("Your password need to be at least 8 characters.");
					errorFound = true;
				}
				else {
					$("#password_error").html("Your password is required.");
				}
				
				if(($("#cfmpassword").val().length > 0)&&($("#password").val() == $("#cfmpassword").val())) {
					$("#cfmpassword_error").html("");
				}
				else if(cfmPasswordVisited){
					$("#cfmpassword_error").html("The password does not match. Try again.");
				}
			}
			
			function validateCfmPassword() {
				cfmPasswordVisited = true;
				if($("#password").val().length > 0 && $("#cfmpassword").val().length > 0) {
					if($("#password").val()!=$("#cfmpassword").val()) {
						$("#cfmpassword_error").html("The password does not match. Try again.");
					}
					else {
						$("#cfmpassword_error").html("");
					}
				}
				else if($("#password").val().length > 0 && $("#cfmpassword").val().length == 0){
					$("#cfmpassword_error").html("Your confirm password is required.");
				}
				else if($("#password").val().length == 0 && $("#cfmpassword").val().length > 0){
					$("#password_error").html("Your password is required.");
					$("#cfmpassword_error").html("");
				}
				else {
					$("#password_error").html("Your password is required.");
					$("#cfmpassword_error").html("Your confirm password is required.");
				}
				
			}

			$("#signUpBtn").click(function(){
				
				$(this).attr({
					type:'button'
				})
				
				validateUsername();
				validateFullName();
				validateEmail();
				validatePassword();
				validateCfmPassword();
				
				var errorFound = false;
				$(".error_msg").each(function(){
					if($(this).html().length>0) {
						errorFound = true;
					}
				});
				
				if(!errorFound){
					$(this).attr({
						type:'submit'
					})
					
					var btn = $(this); 		//hide the button for 5 seconds
					btn.hide();				//to prevent user double click
					setTimeout(function(){	//which may cause the ajax request of
					btn.show();				//update userInfo.json file fail
					}, 5*1000);
					
				}
			});		
		</script>
	</body>
</html>

<?php
		}
	}
	else{
		header('Location: album.php');
	}
?>