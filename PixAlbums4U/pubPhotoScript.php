	<script src="jquery.js"></script>
	<script>
	$("body").keydown(function(e) {
		if($("#layer1").css("display")!="none") {
			if(e.keyCode == 37) { // left
				slideShow(-1);
			}
			else if(e.keyCode == 39) { // right
				slideShow(1);
			}
			else if(e.keyCode == 27) { // Escape
				endSlideShow();
			}
		}
	});
	
	var imgObject = new Array();
	var imgNo = 0;
	

	var userID = <?php echo json_encode($_GET['userID']); ?>;
	var userInfo;
	$.ajax({
		url: "userID-list.php",
		type: "POST",
		dataType : "json",
		success: function(json) {
			var userID_List = json;
			var invalidID = true;
			for(var j=0; j < userID_List.length; j++) {
				if(userID == userID_List[j]) {
					invalidID = false;
				}
			}
			
			if(!invalidID) {
				$.ajax({
					url: "userInfo.php",
					data: {userInfo : userID},
					type: "POST",
					dataType : "json",
					success: function( json ) {
						
						userInfo = json;
						var invalidAlbum = true;
						
						var albumNo;
						try {
							var albumNo = <?php echo $_GET['albumNo'];?>;
						}
						catch (err){
							albumNo = -1;
						}

						if(albumNo >=0 && albumNo < userInfo.album.length) {
							if(Number.isInteger(albumNo)) {
								invalidAlbum = false;
							}
						}
						
						if(!invalidAlbum) {
							$("#albumTitle").html(userInfo.album[<?php echo $_GET['albumNo'];?>].albumName);
							$("#albumDesc").html(userInfo.album[<?php echo $_GET['albumNo'];?>].description);
							if(userInfo.album[<?php echo $_GET['albumNo'];?>].photo.length > 0) {
								for(var i=0;i<userInfo.album[<?php echo $_GET['albumNo'];?>].photo.length;i++) {
									var pic_container = document.getElementById("photo_container");
									var pic_div = document.createElement("div");
									pic_div.setAttribute("class","photo_item photo_box"+i);
									pic_div.setAttribute("id","photo_box"+i);
									pic_div.style.display = "none";
									
									pic_container.appendChild(pic_div);
									
									imgObject[i] = new Image();
									imgObject[i].src = userInfo.album[<?php echo $_GET['albumNo'];?>].photo[i].sourcePath;
									
									var pic_thumb = document.createElement("img");
									pic_thumb.setAttribute("src",getThumbLink(userInfo.album[<?php echo $_GET['albumNo'];?>].photo[i].sourcePath));
									pic_thumb.setAttribute("width","250");
									pic_thumb.setAttribute("height","250");
									pic_thumb.setAttribute("id","photo"+i);
									pic_thumb.setAttribute("class","photo");
									pic_thumb.setAttribute("onclick","startSlideShow("+i+")");
									
									pic_div.appendChild(pic_thumb);
									
								}
								$("#loadPhoto").fadeOut("slow");
								for(var i=0;i<userInfo.album[<?php echo $_GET['albumNo'];?>].photo.length;i++) {
									$("#photo_box"+i).fadeIn(500+100*i);
								}
							}
							else {
								
								var myfield = document.querySelector("fieldset");
								myfield.style.display = "flex";
								myfield.style.justifyContent = "center";
								myfield.style.textAlign = "center";
								
								var field_div = document.createElement("div");
								field_div.setAttribute("id","message");
								
								myfield.appendChild(field_div);
								
								var pic_empty1 = document.createElement("h1");
								pic_empty1.setAttribute("class","noAlbMsg");
								pic_empty1.appendChild(document.createTextNode("Hello!! "));
								pic_empty1.style.display = "none";
								pic_empty1.style.font = "35px Segoe UI, Sans-serif";
								
								myfield.appendChild(pic_empty1);
								
								var pic_empty2 = document.createElement("h1");
								pic_empty2.setAttribute("class","noAlbMsg");
								pic_empty2.appendChild(document.createTextNode("Albums need photos like a story needs words."));
								pic_empty2.style.display = "none";
								pic_empty2.style.font = "35px Segoe UI, Sans-serif";
								
								myfield.appendChild(pic_empty2);
								
								$("#loadPhoto").fadeOut("fast");
								$(".noAlbMsg").each(function(){
									$(this).fadeIn();
								});
								
							}
						}
						else {
							window.location.replace("404.php");
						}
					},
					error: function( xhr, status, errorThrown ) {
						alert( "Sorry, there was a problem!" );
						console.log( "Error: " + errorThrown );
						console.log( "Status: " + status );
						console.dir( xhr );
					},
					complete: function( xhr, status) {}
				});	
			}
			else {
				window.location.replace("404.php");
			}
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
	</script>