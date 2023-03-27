<?php
include "../bootstrap.php";

use CT275\Project\Product;

session_start();
$product = new Product($PDO);
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Tiệm bánh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
	<?php include('../partials/header.php') ?>
	<?php include('../partials/slider.php') ?>
	<!-- Main Page Content -->
	<div class="row">
        <div class="col-lg-4 col-md-6">
                <div>
                    <div>
                    <a href="#"><img style="width: 356px;height: 130px;" src="img/bg/banner8.jpg" alt="#"></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
            <div>
                <div>
                    <a href="#"><img style="width: 356px;height: 130px;" src="img/bg/banner9.jpg" alt="#"></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div>
                <div>
                    <a href="#"><img style="width: 356px;height: 130px;" src="img/bg/banner10.jpg" alt="#"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">   
        <div class="col-12 text-center">
            <div>
                <h2>Sản phẩm của chúng tôi</h2>
                <p>Các sản phẩm thiết kế hiện đại, mới nhất</p>
            </div>
        </div> 
    </div>    
    <div class="row">
        <?php 
            $products = $product->get_all_product();
            foreach($products as $product): 
        ?>
        <div class="col-3 mb-5 ">
            <div class="card shadow-lg" style="width: 16rem;">
                <a href="productdetails.php?proid=<?=htmlspecialchars($product->productId)?>"><img style="width: 254px;height: 130px; z-index:-1;" class="img-fluid" src="admin/uploads/<?=htmlspecialchars($product->image)?>" alt="First place"></a>
                <div class="card-body">
                    <h3><a class="text-decoration-none text-warning" href="#"><?=htmlspecialchars($product->productName)?></a></h3>
                    <span class="current_price"><?=htmlspecialchars($product->price). " "."VNĐ" ?></span>
                </div>
            </div>
        </div>
        <?php endforeach ?>
    </div>  

    <div class="row mt-3">   
        <div class="col-12 text-center">
            <div>
                <h2>Sản phẩm vừa mới ra mắt </h2>
                <p>Sản phẩm vừa mới được ra mắt</p>
            </div>
        </div> 
    </div>  

    <div class="row">
        <?php 
            $newproducts = $product->getproduct_new();
            foreach($newproducts as $product): 
        ?>
        <div class="col-3 mb-5 ">
            <div class="card shadow-lg" style="width: 16rem;">
                <a href="productdetails.php?proid=<?=htmlspecialchars($product->productId)?>"><img style="width: 254px;height: 130px; z-index:-1;" class="img-fluid" src="admin/uploads/<?=htmlspecialchars($product->image)?>" alt="First place"></a>
                <div class="card-body">
                    <h3><a class="text-decoration-none text-warning" href="#"><?=htmlspecialchars($product->productName)?></a></h3>
                    <span class="current_price"><?=htmlspecialchars($product->price). " "."VNĐ" ?></span>
                </div>
            </div>
        </div>
        <?php endforeach ?>
    </div>  
	

	
	<?php include('../partials/footer.php') ?>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>

</body>

</html>