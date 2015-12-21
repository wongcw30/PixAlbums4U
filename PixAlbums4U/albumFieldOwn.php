<div id="shareLink_content">
	<label style="font:bold 23px Lucida Grande, sans-serif; padding-top: 30px; padding-left: 20px;" for="shareLink">Share this awesomeness to your friends!! </label>
	<button id="copyBtn"type="button" class="btn btn-default btn-sm">
        <span class="glyphicon glyphicon-share"></span> Share
    </button><br/>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="header.css">
	<textarea style="display: none;" cols="30" row="2" id="shareLink" name="shareLink" readonly><?php echo 'localhost'.$_SERVER["PHP_SELF"].'?userID='.$_SESSION['userID']; ?></textarea>
</div>
<fieldset style="min-height:800px;">
	<div class="album_container" id="album_container">
		<img id="loadAlbum" src="images/loadingblue.gif"/>
	</div>
</fieldset>