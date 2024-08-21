<?php
	$error = -1;
	$errmsg = "";
	if(isset($_GET['action']))
	{
		$action = $_GET['action'];
		switch($action)
		{
			case "0":
				$ssid = $_GET['ssid'];
				$result = dbSelect("tbl_slideshow", "img", "ssid=$ssid", "");
				$row = mysqli_fetch_array($result);
				$img = $row['img'];
				$result = dbDelete("tbl_slideshow", "ssid=$ssid");
				$path = "../images/$img";
				$thumbnailPath = "../images/thumbnail/$img";
				if(file_exists($path) && $result)
				{
					unlink($path);
					if(file_exists($thumbnailPath))
					{
						unlink($thumbnailPath);
					}
				}
				break;
			case "1":
				$title = $_POST['txttitle'];
				$subtitle = $_POST['txtsubtitle'];
				$text = $_POST['tatext'];
				$link = $_POST['txtlink'];
				$enable = "0";
				if(isset($_POST['chkenable']))
				$enable = "1";
				$result = dbSelect("tbl_slideshow", "ssorder", "", "order by ssorder desc limit 1");
				$row = mysqli_fetch_array($result);
				$ssorder = $row['ssorder'] + 1;
				$org_name = $_FILES["fileimg"]["name"];
				$path_parts = pathinfo($org_name);
				$extension = $path_parts['extension'];
				$img = time() . "." . $extension;
				$path = "../images/";
				$data = ["title"=>"$title","subtitle"=>"$subtitle" , "text"=>"$text", "link"=>"$link" , "enable"=>"$enable", "ssorder"=>$ssorder , "img"=>"$img" ];
				$result = dbInsert("tbl_slideshow" , $data);
				if($result)
				{
					$tmp_name = $_FILES['fileimg']['tmp_name'];
					$d= getimagesize($tmp_name);
					$width = $d[0];
					$height = $d[1];
					$imageType = $d[2];
					createThumbnail($imageType, $tmp_name, $width, $height, $path, $img);
					$error = 0;
					$errmsg = "A Slideshow has been add successfully";
					// move_uploaded_file($_FILES['fileimg']['tmp_name'], $path);
				}
				else
				{
					$error =1;
					$errmsg = "Failed to add a slideshow!";
				}
			break;
			case "3": 
				$ssid = $_GET['ssid'];
				$title = $_POST['txttitle'];
				$subtitle = $_POST['txtsubtitle'];
				$text = $_POST['tatext'];
				$link = $_POST['txtlink'];
				$enable = "0";
				if(isset($_POST['chkenable']))
					$enable = "1";
				$data = "";
				if(file_exists($_FILES['fileimg']['tmp_name'])){
					$result = dbSelect("tbl_slideshow","img","ssid=$ssid","");
					$row = mysqli_fetch_array($result);
					$oldimg = $row['img'];
	
					$org_name = $_FILES["fileimg"]["name"];
					$path_parts = pathinfo ($org_name);
					$extension = $path_parts['extension'];
					$img = time() . "." . $extension;
	
					$tmp_name = $_FILES['fileimg']['tmp_name'];
					$d = getimagesize($tmp_name);
					$width = $d[0];
					$height = $d[1];
					$imageType = $d[2];
					$path = "../images/";
					createThumbnail($imageType, $tmp_name, $width, $height, $path, $img);
	
					if(file_exists($path ."/". $oldimg)){
						unlink($path . "/" . $oldimg);
					}
					if(file_exists($path . "/thumbnail/" . $oldimg)){
						unlink($path . "/thumbnail/" . $oldimg);
					}
					$data = ["title"=> "$title", "subtitle"=>"$subtitle", "text"=>"$text","link"=>"$link","enable"=>"$enable","img"=>"$img"];
				}else{
					$data = ["title"=> "$title", "subtitle"=>"$subtitle", "text"=>"$text","link"=>"$link","enable"=>"$enable"];
				}
				$result = dbUpdate("tbl_slideshow",$data,"ssid=$ssid");
				break;   
			case "4":
				$ssid = $_GET['ssid'];
				$result = dbSelect("tbl_slideshow" ,"ssorder", "ssid=$ssid");
				$row = mysqli_fetch_array($result);
				$c_ssorder = $row['ssorder'];
				$n_ssid = "";
				$n_ssorder = "";
				$result = "";
				if($_GET['d'] == '0'){
					$result = dbSelect("tbl_slideshow","ssid, ssorder", "ssorder<$c_ssorder","order by ssorder desc");
				}else{
					$result = dbSelect("tbl_slideshow","ssid, ssorder", "ssorder>$c_ssorder","order by ssorder asc");
				}
				$row = mysqli_fetch_array($result);
				$n_ssid = $row['ssid'];
				$n_ssorder = $row['ssorder'];
				$data = ["ssorder" => $n_ssorder];
				dbUpdate("tbl_slideshow", $data,"ssid=$ssid");
				$data = ["ssorder"=> $c_ssorder];
				dbUpdate("tbl_slideshow", $data, "ssid=$n_ssid");
				break;
			case "5":
				$ssid = $_GET['ssid'];
				$enable = $_GET['status'];
				$data = ["enable"=>"$enable"];
				$result= dbUpdate("tbl_slideshow", $data , "ssid=$ssid");
				if($result)
				{
					$error = 0;
					$errmsg = "A Slideshow has been enable / disable successfully";
				}
				else
				{
					$error =1;
					$errmsg = "Failed to enable / disable a slideshow!";
				}
			break;	
		}
	}
	$result = dbSelect("tbl_slideshow","*","","order by ssorder");
	$num = mysqli_num_rows($result);
	$maxperpage = MAXPERPAGE;
	$numpage = ceil($num/$maxperpage);
	$current_page = 1;
	if(isset($_GET['pg']))
		$current_page = $_GET['pg'];
	$offset = ($current_page -1 )* $maxperpage;
	$result = dbSelect("tbl_slideshow","*","","order by ssorder limit $maxperpage offset $offset");

?>
<main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3 float-start">Slideshow</h1>
					<a href="index.php?p=ssform" class="btn btn-primary float-end">Add new slideshow</a>
					<div style="clear:both"></div>
					<?php
					if($error != -1)
					{
					?>
					<div class="alert alert-<?=($error==0?'success': 'danger')?> alert-dismissible fade show" role="alert">
						<strong>Holy guacamole!</strong> 
						<?=$errmsg?>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
						<?php
					}
						if($num>0)
						{
						?>
					<table class="table">
						<tr>
							<th>No</th>
							<th>Image</th>
							<th>Title</th>
							<th>Subtitle</th>
							<th>Text</th>
							<th>Link</th>
							<th>Action</th>
						</tr>
						<?php

						$i = 1;
						while($row=mysqli_fetch_array($result))
						{
						?>
						<tr>
							<td><?=$i?></td>
							<td><img src="../images/thumbnail/<?=$row['img']?>" style="width:80px" alt=""></td>
							<td><?=$row['title']?></td>
							<td><?=$row['subtitle']?></td>
							<td><?=$row['text']?></td>
							<td><?=$row['link']?></td>
							<td>
								<a href="#"></a>
								<a href="index.php?p=slideshow&action=4&d=0&ssid=<?=$row['ssid']?>"><i data-feather="arrow-up"></i></a>
								<a href="index.php?p=slideshow&action=4&d=1&ssid=<?=$row['ssid']?>"><i data-feather="arrow-down"></i></a>
								<a href="index.php?p=slideshow&action=5&status=<?=$row['enable']=='1'?'0':'1'?>&ssid=<?=$row['ssid']?>"><i data-feather="<?=($row['enable']=='1'?'eye':'eye-off')?>"></i></a>
								<a href="#" data-bs-toggle="modal" data-bs-target="#ssDelModal" onclick="updateDelSSLink('<?=$row['ssid']?>')"><i data-feather="trash-2"></i></a>
								<a href="index.php?p=ssform&ssid=<?=$row['ssid']?>"><i data-feather="edit-2"></i></a>
							</td>
						</tr>
						<?php
						$i++;
						}
						?>
					</table>
					<nav aria-label="Page navigation example" class="d-flex justify-content-center">
						<ul class="pagination">
							<li class="page-item">
							<a class="page-link" href="index.php?p=slideshow&pg=<?=($current_page ==1?1:$current_page-1)?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
							</li>
							<?php
								for($i=1;$i<=$numpage;$i++)
								{
							?>
							<li class="page-item <?=$current_page == $i ? 'active' : '' ?> " ><a class="page-link" href="index.php?p=slideshow&pg=<?=$i?>"><?=$i?></a></li>
							<?php
								}
							?>

							<li class="page-item">
							<a class="page-link" href="index.php?p=slideshow&pg=<?=($current_page ==$numpage?$numpage:$current_page+1)?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
							</li>
						</ul>
						</nav>
					<?php
						}
						else
						{
							echo" <p class='text-center'> There is no slideshow </p>";
						}
					?>
				</div>
				<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="ssDelModal" tabindex="-1" aria-labelledby="ssDelModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ssDelModalLabel">Confirmation!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you what to delete this slideshow?
      </div>
      <div class="modal-footer">
	  <a href="#" id="ssDelLink" type="button" class="btn btn-primary">Yes</a>
        <a href="#"class="btn btn-secondary" data-bs-dismiss="modal">No</a>
      </div>
    </div>
  </div>
</div>
<!-- endmodal -->
<script>
	function updateDelSSLink(ssid)
	{
		document.getElementById("ssDelLink").href = "index.php?p=slideshow&action=0&ssid=" + ssid;
		// alert(document.getElementById("ssDelLink").href);
	}

	</script>
			</main>