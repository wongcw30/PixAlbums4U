
<script>

	function getThumbLink(link) {
		return link.substr(0,link.lastIndexOf("/")) + "/thumbnail/" + link.substr(link.lastIndexOf("/")+1,link.length);
	}
			
function imageResize(width_temp,height_temp) {
		if(width_temp <=960) {
			var width1 = width_temp;
			var height1 = height_temp;
			
			if(height1 <= 550) {
				var width2 = width1;
				var height2 = height1;
				
				return{
					topMargin	:	(-1)*height2/2,
					leftMargin	:	(-1)*width2/2,
					width		:	width2,
					height		:	height2
				}	
			}
			else {
				var width2 = (550/ height1) * width1;
				var height2 = 550;
				
				return{
					topMargin	:	(-1)*height2/2,
					leftMargin	:	(-1)*width2/2,
					width		:	width2,
					height		:	height2
					
					
				}
			}
		}
		else{
			var width1 = 960;
			var height1 = (960 / width_temp) * height_temp;
			
			if(height1 >550) {
				var width2 = (550 / height1) * width1;
				var height2 = 550;
				
				return{
					width		:	width2,
					height		:	height2,
					leftMargin	:	(-1)*width2/2,
					topMargin	:	(-1)*height2/2
				}
			}
			else {
				var width2 = width1;
				var height2 = height1;
				
				return{
					width		:	width2,
					height		:	height2,
					leftMargin	:	(-1)*width2/2,
					topMargin	:	(-1)*height2/2
				}
			}			
		}	
			
	}

	
	function endSlideShow() { //if clicking the layer but not buttons, then end slide show
		$("#layer1").css("display","none");
		$("#photoShow").css("display","none");
		$(".LR_Btn").css("display","none");
		$("#photoDesc").css("display","none");
	}
	
	function slideShow(x) {
				
		N = imgObject.length - 1;
		if(imgNo==0) {
			if(x==1) {
				imgNo = imgNo + x;
			}
			else if(x== -1) {
				imgNo = N;
			}
		}
		else if(imgNo==N) {
			if(x==-1) {
				imgNo = imgNo + x;
			}
			else if(x== 1) {
				imgNo = 0;
			}
		}
		else if(imgNo > 0 && imgNo < N) {
			imgNo = imgNo + x;
		}
		
		var newImg = imageResize(imgObject[imgNo].width,imgObject[imgNo].height);
		$("#photoShow").attr({
			"width"		:	newImg.width,
			"height"	:	newImg.height,
			"src"		:	imgObject[imgNo].src
		});
		
		$("#photoShow").css({ //jquery
			"margin-left"	:	newImg.leftMargin + "px",
			"margin-top"	:	newImg.topMargin + "px",
			"display"		:	"none"
		});
	
		
		var date = userInfo.album[<?php echo $_GET['albumNo'];?>].photo[imgNo].photoDate;
		var desc = userInfo.album[<?php echo $_GET['albumNo'];?>].photo[imgNo].description;
		var imageName = userInfo.album[<?php echo $_GET['albumNo'];?>].photo[imgNo].photoName;
		
		
		if( !date && desc.length == 0) {
			$("#photoDesc").html(
			"Image Name: " +imageName);
		}
		else if( date && desc.length == 0) {
			$("#photoDesc").html(
				"Image Name: " +imageName+ "<br/>" +
				"Date : " + date
			);
		}
		else if( !date && desc.length != 0) {
			$("#photoDesc").html(
				"Image Name : " +imageName+"<br/>" +
				"Description : " + desc 
				
			);
		}
		else {
			$("#photoDesc").html(
				"Image Name: " +imageName+"<br/>" +
				"Description : " + desc +"<br/>" +
				"Date : " + date
			);
		}
		
		$("#photoShow").fadeIn();
				
	}
	
	function startSlideShow(k){ //display first picture of the slideshow
				imgNo = k;
				
				var newImg = imageResize(imgObject[k].width,imgObject[k].height);
				
				
				$("#photoShow").attr({
					"width"		:	newImg.width,
					"height"	:	newImg.height,
					"src"		:	imgObject[k].src
				});
				
				$("#photoShow").css({
					"margin-left"	:	newImg.leftMargin + "px",
					"margin-top"	:	newImg.topMargin + "px"
				});
			
				
		var date = userInfo.album[<?php echo $_GET['albumNo'];?>].photo[imgNo].photoDate;
		var desc = userInfo.album[<?php echo $_GET['albumNo'];?>].photo[imgNo].description;
		var imageName = userInfo.album[<?php echo $_GET['albumNo'];?>].photo[imgNo].photoName;
		
		
		if( !date && desc.length == 0) {
			$("#photoDesc").html(
			"Image Name: " +imageName);
		}
		else if( date && desc.length == 0) {
			$("#photoDesc").html(
				"Image Name: " +imageName+ "<br/>" +
				"Date : " + date
			);
		}
		else if( !date && desc.length != 0) {
			$("#photoDesc").html(
				"Image Name : " +imageName+"<br/>" +
				"Description : " + desc 
				
			);
		}
		else {
			$("#photoDesc").html(
				"Image Name: " +imageName+"<br/>" +
				"Description : " + desc +"<br/>" +
				"Date : " + date
			);
		
		
		}
	
				$("#layer1").fadeIn();
				$(".LR_Btn").fadeIn();
				$("#photoShow").fadeIn();
				$("#photoDesc").fadeIn();
			}
</script>
