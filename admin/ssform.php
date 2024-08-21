<?php
    $ssid = ""; 
    $title = "";
    $subtitle = "";
    $text = "";
    $link = "";
    $enable = "1";
    $img = "";
    if(isset($_GET['ssid'])){
        $ssid = $_GET['ssid'];
        $result = dbSelect("tbl_slideshow","*", "ssid=$ssid", "");
        $row = mysqli_fetch_array($result);
        $title = $row['title'];
        $subtitle = $row['subtitle'];
        $text = $row['text'];
        $link = $row['link'];
        $enable = $row['enable'];
        $img = $row['img'];
    }
?>
<main class="content">
	<div class="container-fluid p-0">
		<h1 class="h3 mb-3 "><?=$ssid==""? "Add ":"Edit" ?> Slideshow</h1>

	<form action="index.php?p=slideshow&action=<?=$ssid==""?"1":"3&ssid=$ssid"?>" method="POST" enctype="multipart/form-data">
		<div class="mb-3">
			<label for="txttitle" class="form-label">Title</label>
			<input type="text" class="form-control" id="txttitle" name="txttitle" value="<?=$title?>" required>
		</div>
		<div class="mb-3">
			<label for="txtsubtitle" class="form-label">Subtitle</label>
			<input type="text" class="form-control" id="txtsubtitle" name="txtsubtitle" value="<?=$subtitle?>">
		</div>
		<div class="mb-3">
			<label for="tatext" class="form-label">Text</label>
			<textarea class="form-control" id="tatext" name="tatext" rows="3" ></textarea>
		</div>
		<div class="mb-3">
			<label for="txtlink" class="form-label">Link</label>
			<input type="text" class="form-control" id="txtlink" name="txtlink" value="<?=$link?>">
		</div>
		<div class="form-check form-switch">
			<input class="form-check-input" type="checkbox" id="chkenable" name="chkenable" <?=($enable=="1"?"checked":"")?>  >
			<label class="form-check-label" for="chkenable">Enable</label>
		</div>
		<div class="mb-3">
			<label for="fileimg" class="form-label">Select slideshow image to upload</label>
			<input class="form-control form-control-sm" id="fileimg" name="fileimg" type="file" accept="image/png, image/gif , image/jpeg" <?=$ssid==""?"required":""?>>
		</div>
		<?php
                if($ssid != "" ){
                    echo "<img src='../images/thumbnail/$img' /> ";
                }
            ?>
            <br>
            <br>
		<input type="submit" class="btn btn-primary" value="<?=$ssid==""? "Add": "Update"?> slideshow">
		<a href="index.php?p=slideshow" class="btn btn-secondary">Cancel</a>
	</form>
	</div>
</main>