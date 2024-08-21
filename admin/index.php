<?php
	include "../libraries/db.php";
	include "../config.php";
	include "../libraries/img.php";
	include "../libraries/auth.php";
	if(!isLogin())
	{
		header("location: login.php");
		exit (0);
	}
	$page = "dashboard.php";
	if (isset($_GET['p']))
	{
		$p = $_GET['p'];
		switch($p)
		{
			case "slideshow":
				$page = "slideshow.php";
				break;
			case "ssform":
				$page = "ssform.php";
				break;
			case "product":
				$page = "product.php";
				break;
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<?php include "includes/head.php" ?>
<body>
	<div class="wrapper">
		<?php include "includes/nav.php" ?>

		<div class="main">
		<?php include "includes/header.php" ?>
		<?php include "$page" ?>
		<?php include "includes/footer.php" ?>

		</div>
	</div>
	<?php include "includes/foot.php" ?>
</body>

</html>