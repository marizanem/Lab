<?php

$result = dbSelect('tbl_slideshow', '*', "enable='1'", "ORDER BY ssorder ASC");
$num = mysqli_num_rows($result);
?>

<!-- Hero Start -->
<div class="container-fluid py-5 mb-5 hero-header">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-md-12 col-lg-7">
                <h4 class="mb-3 text-secondary">100% Organic Foods</h4>
                <h1 class="mb-5 display-3 text-primary">Organic Veggies & Fruits Foods</h1>
                <div class="position-relative mx-auto">
                    <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="number" placeholder="Search">
                    <button type="submit" class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100" style="top: 0; right: 25%;">Submit Now</button>
                </div>
            </div>
            <div class="col-md-12 col-lg-5">
                <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $i = 0;
                        while ($row = mysqli_fetch_array($result)) {
                            $activeClass = ($i == 0) ? 'active' : '';
                        ?>
                            <div class="carousel-item <?= $activeClass ?> rounded">
                                <img src="images/<?= $row['img'] ?>" class="img-fluid w-100 h-100 bg-secondary rounded" alt="Slide <?= $i + 1 ?>">
                                <h2 class="text-primary text-center"><?= $row['title'] ?></h2>
                                <h3 class=" text-center"><?= $row['subtitle'] ?></h3>
                                <p  class=" text-center"><?= $row['text'] ?></p>
                            </div>
                        <?php
                            $i++;
                        }
                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->