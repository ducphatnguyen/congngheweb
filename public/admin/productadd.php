<?php

include_once "C:/xampp/apps/project/bootstrap.php";

use CT275\Project\Session;
use CT275\Project\Product;
use CT275\Project\Category;

    $pd = new product($PDO);
    $cat = new category($PDO); 
    // còn lỗi hiển thị thêm bánh
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $insert_product = $pd->insert_product($_POST,$_FILES);
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

    <div class="col-lg-10">
        <div class="container border rounded">
            <h4 class="m-4 text-primary">Thêm bánh</h4>
            <div class="mt-5"> 
                <form action="" method="post" enctype="multipart/form-data">	
                    <?php
                        if(isset($insert_product)) {
                            echo $insert_product;
                        }
                    ?>
					<!-- Tên bánh -->
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Tên</label>
                        </div>
                        <div class="col-10 w-50">
                            <input class="form-control" type="text" name="productName" placeholder="Nhập tên bánh..."  />
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

                            <option value="<?=htmlspecialchars($cat->catId)?>">
                                <?=htmlspecialchars($cat->catName)?>
                            </option>
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
							<textarea class="form-control" name="product_desc" style="height: 100px; resize:none"></textarea>
                        </div>
                    </div>

					<!-- Số lượng -->
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold">Số lượng</label>
                        </div>
                        <div class="col-10 w-50">
                            <input class="form-control" type="number" name="sl_nhap" min="1" placeholder="Nhập số lượng..."  />
                        </div>
                    </div>

					<!-- Giá -->
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Giá</label>
                        </div>
                        <div class="col-10 w-50">
                            <input class="form-control" type="number" name="price"  placeholder="Nhập giá..."  />
                        </div>
                    </div>
					<!-- Ảnh bánh -->
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Upload ảnh</label>
                        </div>
                        <div class="col-10 w-50">
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
                            <option value="1">Còn Hàng</option>
                            <option value="0">Hết Hàng</option>
                        </select>
                        </div>
                    </div>

                    <div class="row" style="padding-bottom:5%">
                        <div class="col-2"></div>
                        <div class="col-10 ">
                            <input class="btn btn-success" type="submit" name="submit" Value="Thêm" />
                        </div>
                    </div>
                </form>
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