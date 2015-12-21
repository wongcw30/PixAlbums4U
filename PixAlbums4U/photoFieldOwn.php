<p id="albumTitle" style="font: bold 40px Century gothic, sans-serif; margin: 0px; padding-left: 15px;" ></p>
<p id="albumDesc" style="font:20px Helvetica, sans-serif; margin: 0px; padding-left: 23px"></p>
<div id="shareLink_content" style="padding-left: 15px; padding-top: 5px" >
	<button id="copyBtn"type="button" class="btn btn-default btn-sm">
        <span class="glyphicon glyphicon-share"></span> Share
    </button>
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	  <link rel="stylesheet" href="header.css">
	<textarea style="display:none" cols="30" row="2" id="shareLink" name="shareLink" readonly><?php echo 'localhost'.$_SERVER["PHP_SELF"].'?userID='.$_SESSION['userID']."&albumNo=".$_GET['albumNo']; ?></textarea><br/>
</div>	
<div id="layer1" onclick="endSlideShow()"></div>
<img id="leftBtn" class="LR_Btn" src="images/left_arrow.png" onclick="slideShow(-1)"/>
<img id="photoShow"/>
<div id="photoDesc"></div>
<img id="rightBtn" class="LR_Btn" src="images/right_arrow.png" onclick="slideShow(1)"/>
<fieldset class="pixfield" style="min-height:800px; width:inherit; padding: 0 10px;" >
<div class="photo_container" id="photo_container" >
<img id="loadPhoto" src="images/loadingblue.gif"/>
</div>
</fieldset>
