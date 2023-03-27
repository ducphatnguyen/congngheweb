<?php
include "../bootstrap.php";
session_start();
use CT275\Project\Cart;

    $cart = new Cart($PDO);

    if(isset($_GET['cartid'])){
        $cartid = $_GET['cartid'];
        $delcart = $cart->del_product_cart($cartid);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $cartId = $_POST['cartId'];
        $quantity = $_POST['quantity'];
        $update_quantity_cart = $cart->update_quantity_cart ($quantity,$cartId);
    }
    if(isset($_GET['orderid']) && $_GET['orderid']=='order'){
        $customer_id = $_SESSION["customer_id"];
        $cart->insertOrder($customer_id);
        $cart->del_all_data_cart();
        echo "<script>window.location ='orderdetails.php'</script>"; 
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
	<form action="" method="POST"> 
        <div class="row text-center">
            <div class="col-12">
                <?php
                    if(isset($update_quantity_cart)){
                        echo $update_quantity_cart;
                    }
                ?>
                <table>
                    <thead>
                        <tr>
                            <th style="width:5%">STT</th>
                            <th style="width:20%">Sản Phẩm</th>
                            <th style="width:20%">Hình Ảnh</th>
                            <th style="width:15%">Giá</th>
                            <th style="width:15%">Số Lượng</th>
                            <th style="width:15%">Tổng Cộng</th>
                            <th style="width:10%">Xóa</th>
                        </tr>
                    </thead>
                    <?php 
                        $carts = $cart->get_product_cart();
                        $i=0;
                        $subtotal = 0;
                        $qty = 0;
                        foreach($carts as $cart): $i++; 
                    ?>

                    <tbody>
                        <tr>
                            <td><?=$i?></td>
                            <td><a href="#"></a><?=htmlspecialchars($cart->productName)?></td>
                            <td><a href="#"><img img style="width:50%" src="admin/uploads/<?=htmlspecialchars($cart->image)?>" alt=""/></a></td>
                            <td><?=htmlspecialchars($cart->price). " ". "VNĐ"?></td>
                            <td>
                                <form action="" method="POST">
                                    <input type="hidden" name="cartId" value="<?=htmlspecialchars($cart->cartId)?>"/>
                                    <div class="row">
                                        <div class="col-6">
                                            <input class="form-control"min="1" max="<?=htmlspecialchars($cart->sl_conlai)?>" name="quantity" value="<?=htmlspecialchars($cart->quantity)?>" type="number" class="w-50">
                                        </div>
                                        <div class="col-6">
                                            <input class="btn btn-warning" type="submit" name="submit" value="Update"/>
                                        </div>
                                    </div>
                                </form>                                                
                            </td>
                            <td>
                                <?php 
                                    $price1 = htmlspecialchars($cart->price);
                                    $quantity1 = htmlspecialchars($cart->quantity);
                                    $total = $price1 * $quantity1;
                                    echo $total . " " . "VNĐ";
                                ?>           
                            </td>
                            <td><a class="btn btn-danger" onclick = "return confirm('Are you sure?')" href="?cartid=<?=htmlspecialchars($cart->cartId)?>">Xóa</a></td>
                        </tr>
                    </tbody>  
                    <?php
                        $subtotal += $total; $qty += $quantity1;
                    ?>
                    <?php endforeach ?>                                 
                </table>   
            </div>
        </div>               

        <div class="row my-5">
            
            <div class="col-lg-8 col-md-8"> 
                <?php
                    $check_cart = $cart->check_cart();
                    if($check_cart == 0) {	
                        echo 'Giỏ hàng đang rỗng!!!';
                       
                    }
                ?>
            </div>

            <?php
                $check_cart = $cart->check_cart();
                    if($check_cart > 0) {				
            ?>
            <div class="col-lg-4 col-md-4">
                <div>
                    <h3 class="text-center fw-bolder">Chi Tiết</h3>
                    <div class="border rounded ">
                        <div class="row m-3">
                            <div class="col-4">Tổng cộng:</div>
                            <div class="col-8 text-end">
                                <?php 							
                                    echo $subtotal." "."VND";
                                    $_SESSION["sum"] = $subtotal;
                                    $_SESSION["qty"] = $qty;
                                ?>
                            </div>
                        </div>

                        <div class="row m-3">
                            <div class="col-4"></div>
                            <div class="col-8 text-end">
                                Free Ship
                            </div>
                        </div>

                        <div class="row m-3">
                            <div class="col-4">Thành Tiền</div>
                            <div class="col-8 text-end">
                                <?php 										
                                    $gtotal = $subtotal;
                                    echo $gtotal." "."VND";
                                ?> 
                            </div>
                        </div>
                       
                    </div>
                    <div class="mt-3">
                        <a class="btn btn-success" href="?orderid=order" onclick="myFunction()">Đặt Hàng</a>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </form> 

    <script>
        function myFunction() {
        alert("Bạn đã đặt hàng thành công, vui lòng nhấn OK để xem chi tiết lịch sử đặt hàng");
        }
    </script> 

	
	<?php include('../partials/footer.php') ?>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>

</body>

</html>