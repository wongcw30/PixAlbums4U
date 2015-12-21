<script src="jquery.js"></script>
	<script>
		var userID = <?php echo json_encode($_SESSION['userID']); ?>;
		$.ajax({
			url: "userInfo.php",
			data: {userInfo : userID},
			type: "POST",
			dataType : "json",
			success: function( json ) {
				var userInfo = json;
				
				$("#my-fname").html(userInfo.fname);
				$("#my-username").html(userInfo.username);
			},
			error: function( xhr, status, errorThrown ) {
				alert( "Sorry, there was a problem!" );
				console.log( "Error: " + errorThrown );
				console.log( "Status: " + status );
				console.dir( xhr );
			},
			complete: function( xhr, status) {}
		});
	</script>