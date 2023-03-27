<?php
include "../bootstrap.php";
session_start();

use CT275\Project\Product;
use CT275\Project\Category;

$product = new Product($PDO);
$cat = new Category($PDO);

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

	<!-- Main Page Content -->
    <div class="row">
        <div class="col-lg-3 col-md-12">
            <div>
                <div style="margin-bottom: 55px"></div>
                <div class="dropdown">
                    <a class="btn btn-success dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Danh mục bánh
                    </a>
                    <ul class="dropdown-menu">
                        <?php 
                            $cats = $cat->show_category_frontend();
                            foreach($cats as $cat):
                        ?>
                        <li><a class="dropdown-item" href="shopcategory.php?catid=<?=htmlspecialchars($cat->catId)?>"><?=htmlspecialchars($cat->catName)?></a></li>
                        <?php endforeach ?>	
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-12">
            <div>
                <h1 class="text-center">SHOP</h1>
            </div>
            <div class="row">
                <?php 
                    if(isset($_GET['catid']) && $_GET['catid']!=NULL) {
                    $id = $_GET['catid'];
                    $products = $product->getproductbycatId($id);
                    foreach($products as $product): 
                ?>
                
                <div class="col-4 mb-5">
                    <div class="card shadow-lg" style="width: 16rem;">
                        <a href="productdetails.php?proid=<?=htmlspecialchars($product->productId)?>"><img style="width: 254px;height: 130px;" class="img-fluid" src="admin/uploads/<?=htmlspecialchars($product->image)?>" ></a>
                        <div class="card-body">
                            <h3><a class="text-decoration-none text-warning" href="#"><?=htmlspecialchars($product->productName)?></a></h3>
                            <span class="current_price"><?=htmlspecialchars($product->price)." "."VNĐ" ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>  

            <?php
            }else {   
                $products = $product->get_all_product();
                foreach($products as $product): 
            ?>
            <div class="col-4 mb-5">
                <div class="card shadow-lg" style="width: 16rem;">
                <a href="productdetails.php?proid=<?=htmlspecialchars($product->productId)?>"><img style="width: 254px;height: 130px;" class="img-fluid" src="admin/uploads/<?=htmlspecialchars($product->image)?>" ></a>
                    <div class="card-body">
                        <h3><a class="text-decoration-none text-warning" href="#"><?=htmlspecialchars($product->productName)?></a></h3>
                        <span class="current_price"><?=htmlspecialchars($product->price)." "."VNĐ" ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
            <?php
            }
            ?>                                                        
        </div>
    </div>


	<?php include('../partials/footer.php') ?>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
	
</body>

</html>