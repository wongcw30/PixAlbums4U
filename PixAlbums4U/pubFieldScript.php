<script src="jquery.js"></script>
<script>
	function getThumbLink(link) {
		return link.substr(0,link.lastIndexOf("/")) + "/thumbnail/" + link.substr(link.lastIndexOf("/")+1,link.length);
	}

	var userID = "<?php echo $_GET['userID']; ?>";

	$.ajax({
		url: "userID-list.php",
		type: "POST",
		dataType : "json",
		success: function(json) {
			var userID_List = json;
			var wrongID = true;
			for(var j=0; j < userID_List.length; j++) {
				if(userID == userID_List[j]) {
					wrongID = false;
				}
			}
			
			if(!wrongID) {
				$.ajax({
					
					url: "userInfo.php",
					data: {userInfo : userID},
					type: "POST",
					dataType : "json",
					success: function( json ) {
						var userInfo = json;
						
						if(userInfo.fname) { //check whether is null object
							if(userInfo.album.length > 0) {
								$("#ownerAlbum").html(userInfo.fname + "'s Album");
								var ownAlb = document.getElementById("ownerAlbum");
								ownAlb.style.paddingLeft = "20px";
								ownAlb.style.font= "bold 40px Century gothic, sans-serif";
								for(var i=0;i<userInfo.album.length;i++) {
									var alb_container = document.getElementById("album_container");
									var alb_div = document.createElement("div");
									alb_div.setAttribute("class","album_item "+"album_box"+i);
									alb_div.setAttribute("id","album_box"+i);
									alb_div.style.display = "none";
									
									alb_container.appendChild(alb_div);
									
									var in_album = document.createElement("a");
									in_album.setAttribute("class","photo_link");
									in_album.setAttribute("id","photo_link"+i);
									in_album.setAttribute("href","photo.php?userID=<?php echo $_GET['userID']; ?>&albumNo="+i);
									
									alb_div.appendChild(in_album);
									
									var alb_thumb = document.createElement("img");
									
									if(userInfo.album[i].photo.length > 0) {
										alb_thumb.setAttribute("src",getThumbLink(userInfo.album[i].photo[0].sourcePath));
									}
									else {
										alb_thumb.setAttribute("src",'images/empty_album.png');
									}
									
									alb_thumb.setAttribute("id","photo"+i);
									
									in_album.appendChild(alb_thumb);
									
									var alb_desc = document.createElement("div");
									alb_desc.style.fontWeight = "bold";
									alb_desc.setAttribute("id","album_title"+i);
									var albumName = userInfo.album[i].albumName;//create another variable album name in Java not object
									
									if(albumName.length > 20) {
										albumName = albumName.substr(0,20) + "..."; //take the partition of the name
									}
									alb_desc.appendChild(document.createTextNode(albumName));
									
									in_album.appendChild(alb_desc);
									
									var alb_size = document.createElement("div");
									alb_size.setAttribute("id","photo_num"+i);
									alb_size.appendChild(document.createTextNode(userInfo.album[i].photo.length + " photos")); 
									in_album.appendChild(alb_size);
									
									
								} //end for loop
								
								$("#loadAlbum").fadeOut("slow");
								for(var i=0;i<userInfo.album.length;i++) {
									$("#album_box"+i).fadeIn(500+100*i);
								}
							}//end of IF
							else {
					
								var myfield = document.querySelector("fieldset");
								myfield.style.display = "flex";
								myfield.style.justifyContent = "center";
								myfield.style.textAlign = "center";
								
								var field_div = document.createElement("div");
								field_div.setAttribute("id","message");
								
								myfield.appendChild(field_div);
								
								var alb_empty1 = document.createElement("h1");
								alb_empty1.setAttribute("class","noAlbMsg");
								alb_empty1.appendChild(document.createTextNode("Hello!! "));
								alb_empty1.style.display = "none";
								alb_empty1.style.font = "35px Segoe UI, Sans-serif";
								
								myfield.appendChild(alb_empty1);
								
								var alb_empty2 = document.createElement("h1");
								alb_empty2.setAttribute("class","noAlbMsg");
								alb_empty2.appendChild(document.createTextNode("Albums need photos like a story needs words."));
								alb_empty2.style.display = "none";
								alb_empty2.style.font = "35px Segoe UI, Sans-serif";
								
								myfield.appendChild(alb_empty2);
								
								$("#loadAlbum").fadeOut("fast");
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
				var in_album = document.querySelector("fieldset"); //get the fieldset element from HTML
				in_album.style.display = "flex";
				in_album.style.justifyContent = "center";
				in_album.style.textAlign = "center";
				
				var field_div = document.createElement("div");
				field_div.setAttribute("id","message");
				
				in_album.appendChild(field_div);
				
				var alb_empty1 = document.createElement("h1");
				alb_empty1.setAttribute("class","noAlbMsg");
				alb_empty1.appendChild(document.createTextNode("This user does not exist.")); //if userID is not in database then display it out
				alb_empty1.style.display = "none"; //otherwise hide it
				
				in_album.appendChild(alb_empty1);
				
				var alb_empty2 = document.createElement("h1")
				alb_empty2.setAttribute("class","noAlbMsg");
				alb_empty2.appendChild(document.createTextNode("Join us now to get your story started!! "));//if user dont have any album yet then display this
				alb_empty2.style.display = "none";//otherwise hide it
				
				in_album.appendChild(alb_empty2);
				
				$("#loadAlbum").fadeOut("fast");
					$(".noAlbMsg").each(function(){
					$(this).fadeIn();
				});
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