<?php
include"config.php";
include"libraries/db.php";

    $page = "home.php";
    $slider = true;
    $aside = true;
    if(isset($_GET['p']))
    {
        $p = $_GET['p'];
        switch($p)
        {
            case "shop":    
                $page = "shop.php";
                $slider = false;
                $aside = true;
                break;
            case "contact":
                $page = "contact.php";
                $slider = false;
                $aside = false;
                break;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php include "includes/header.php" ?>
<body>
    <?php include "includes/nav.php" ?>
    <?php if($slider)include "includes/hero.php" ?>
    <?php include $page ?>
    <?php include "includes/footer.php" ?>
    <?php include "includes/script.php" ?>
    </body>

</html>