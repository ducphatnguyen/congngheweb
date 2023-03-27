<?php
include "../bootstrap.php";
session_start();

use CT275\Project\Product;

$product = new Product($PDO);
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tukhoa'])) {
    $tukhoa = $_POST['tukhoa']; 
}
else{
    echo "<script>window.location ='index.php'</script>";
}


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
		<div class="col-12 text-center">
            <div class="section_title">
                <h2>Tìm kiếm từ khóa: </h2>
                <p>Sản phẩm mang lại sự trải nghiệm tuyệt vời nhất</p>
            </div>
	    </div> 
	</div> 

	<div class="row mt-3">   
        <div class="row">
            <?php 
                $products = $product->search_product($tukhoa);
                foreach($products as $product): 
            ?>
           <div class="col-3 mb-5 ">
                <div class="card shadow-lg" style="width: 16rem;">
                    <a href="productdetails.php?proid=<?=htmlspecialchars($product->productId)?>"><img style="width: 254px;height: 130px; z-index:-1;" class="img-fluid" src="admin/uploads/<?=htmlspecialchars($product->image)?>" alt="First place"></a>
                    <div class="card-body">
                        <h3><a class="text-decoration-none text-warning" href="#"><?=htmlspecialchars($product->productName)?></a></h3>
                        <span class="current_price"><?=htmlspecialchars($product->price)." "."VNĐ" ?></span>         
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