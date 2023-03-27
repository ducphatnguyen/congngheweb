<?php

include_once "C:/xampp/apps/project/bootstrap.php";

use CT275\Project\Session;
use CT275\Project\Product;
use CT275\Project\Category;

    $pd = new product($PDO);
    $cat = new category($PDO); 

    if(isset($_GET['productid']) && $_GET['productid']!=NULL){
        $id = $_GET['productid'];
    }
    else {
        echo "<script>window.location ='productlist.php'</script>";
    }

	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
		$update_product = $pd->update_product($_POST,$_FILES, $id);
	} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiệm bánh</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <style>
        a {
            text-decoration:none;
        }
    </style>
</head>
<body class="container-fluid">
    <?php include('partials_admin/header.php') ?>
    <?php
        if($_SESSION["adminlogin"] == FALSE) {
            header("Location:login.php");
        }
    ?>
    <?php include('partials_admin/sidebar.php') ?>

    <div class="col-lg-10" >
        <div class="container border rounded">
            <h4 class="m-4 text-primary">Chỉnh sửa bánh</h4>
            <div class="mt-5"> 
                <?php
                    if(isset($update_product)) {
                        echo $update_product;
                    }
                ?>
                <?php 
						$pds = $pd->getproductbyId($id);
						foreach($pds as $pd): 
				?>
                <form action="" method="post" enctype="multipart/form-data">	
					<!-- Tên bánh -->
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Tên</label>
                        </div>
                        <div class="col-10 w-50">
                            <input class="form-control" type="text" name="productName" value="<?=htmlspecialchars($pd->productName)?>"/>
                        </div>
                    </div>
					<!-- Danh mục bánh -->
					<div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Danh mục bánh</label>
                        </div>
                        <div class="col-10 w-50">
                        <select class="form-select" aria-label="Default select example" name="category">
                            <option selected>Chọn danh mục bánh</option>
                            <?php 
                                $cats = $cat->show_category();
                                foreach($cats as $cat): 
                            ?>
                            <option
                            <?php
                                if($cat->catId == $pd->catId) {
                                    echo 'selected';
                                }
                            ?>
                            value="<?=htmlspecialchars($cat->catId)?>"><?=htmlspecialchars($cat->catName)?>
                            <?php endforeach ?>	
                        </select>
                        </div>
                    </div>
					<!-- Mô tả bánh -->
					<div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Mô tả</label>
                        </div>
                        <div class="col-10 w-50">
							<textarea class="form-control"  name="product_desc" style="height: 100px; resize:none"><?=htmlspecialchars($pd->product_desc)?></textarea>
                        </div>
                    </div>


					<!-- Giá -->
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Giá</label>
                        </div>
                        <div class="col-10 w-50">
                            <input class="form-control" type="number" name="price"  value="<?=htmlspecialchars($pd->price)?>"/>
                        </div>
                    </div>
					<!-- Ảnh bánh -->
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Upload ảnh</label>
                        </div>
                        <div class="col-10 w-50">
                            <img src="uploads/<?=htmlspecialchars($pd->image)?>" width="90">
                            <br>
                            <input class="form-control" type="file" name="image"/>
                        </div>
                    </div>
                    

					<!-- Trạng thái sản phẩm -->
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Trạng thái</label>
                        </div>
                        <div class="col-10 w-50">
                        <select class="form-select" aria-label="Default select example" name="status_product">
                            <option selected>Chọn trạng thái</option>
                            <?php
                                if($pd->status_product == 1) {
                            ?>
                                <option selected value="1">Còn Hàng</option>
                                <option value="0">Hết Hàng</option>
                            <?php
                                }else if($pd->status_product == 0){
                            ?>     
                                <option value="1">Còn Hàng</option>
                                <option selected value="0">Hết Hàng</option>
                            <?php
                                }
                            ?>    
                        </select>
                        </div>
                    </div>

                    <div class="row" style="padding-bottom:5%">
                        <div class="col-2"></div>
                        <div class="col-10 ">
                            <input class="btn btn-success" type="submit" name="submit" Value="Update" />
                        </div>
                    </div>
                </form>
                <?php endforeach ?>	
            </div>
        </div>  
    </div>    

 </div>
    <?php include('partials_admin/footer.php') ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    
    <script>
        $(document).ready(function () {
            $("#example").DataTable();
        });
    </script>
    
</body>