<?php
include "../bootstrap.php";
session_start();

use CT275\Project\Product;
use CT275\Project\Cart;
    $product = new Product($PDO);
    $cart = new Cart($PDO);

    if(isset($_GET['proid']) && $_GET['proid']!=NULL){
        $id = $_GET['proid'];
    }
    else {
        echo "<script>window.location ='index.php'</script>";
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $quantity = $_POST['quantity'];
        $Addtocart = $cart->add_to_cart($quantity,$id);
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
    <div>
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-5">
                   <div>
                        <div>
                            <a href="#">
                                <?php 
                                    $getdetailproducts = $product->getproductbyId($id);
                                    foreach($getdetailproducts as $getdetailproduct): 
                                ?>
                                <img class="shadow-lg" src="admin/uploads/<?=htmlspecialchars($getdetailproduct->image)?>" alt="big-1" style="width: 100%">
                                
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7">
                    <div>                       
                       <form action="#" method="POST">
                            <div style="margin-left:13px">
                                <h3><?=htmlspecialchars($getdetailproduct->productName)?></h3>
                                
                                <div>
                                    <span><?=htmlspecialchars($getdetailproduct->price) . " ". "VNĐ"?></span>
                                </div>           
                                <div class="fw-light">
                                    <p><?=htmlspecialchars($getdetailproduct->product_desc)?> </p>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <label class="col-form-label">Số Lượng: </label>

                                    </div>
                                    <div class="col">
                                        <input class="form-control"  min="1" max="<?=htmlspecialchars($getdetailproduct->sl_conlai)?>" value="1" type="number" name="quantity">
                                    </div>
                                    <?php
                                        if(isset($Addtocart)) {
                                            echo $Addtocart;
                                        }
                                    ?>            
                                </div>

                                <div class="my-3">
                                    <span>Số lượng trong kho: <?=htmlspecialchars($getdetailproduct->sl_conlai)?></span>
                                </div>
                                <div>
                                    <?php
                                        if(isset($_SESSION["customer_login"]) && $_SESSION["customer_login"] == true) {
                                            echo '<input class="btn btn-success" type="submit" name="submit" value="Thêm vào giỏ"></input>';
                                            
                                        }
                                        else {
                                            echo '<input onclick="myFunction()" class="btn btn-success" type="submit" value="Thêm vào giỏ"></input>';                        
                                        }                               
			                        ?> 
                                </div>
                            </div>                              
                        </form>    
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>    
    </div>   
    <div>
        <div class="container">   
            <div class="row">
                <div class="col-12 mt-5">
                    <div  style="margin-top:20px;width:50%">   
                        <div>
                            <form action="" method="POST">
                                <h2>Đánh giá</h2>
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea style ="resize: none; height: 200px" name ="binhluan" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                                            <label for="floatingTextarea2">Bình luận ngay</label>
                                        </div>
                                    </div> 
                                </div>
                                <input  class="btn btn-success" type="submit" value="Submit"></input>
                            </form>   
                        </div>   
                    </div>
                </div>
            </div>
        </div>    
    </div>  
    
    <script>
        function myFunction() {
        alert("Vui lòng đăng nhập để thêm vào giỏ");
        }
    </script>  
    


	<?php include('../partials/footer.php') ?>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
	
</body>

</html>