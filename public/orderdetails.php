<?php
include "../bootstrap.php";
session_start();

use CT275\Project\Product;
use CT275\Project\Cart;

$product = new Product($PDO);
$cart = new Cart($PDO);

if(isset($_GET['confirmid'])){
    $quantity = $_GET['quantity'];  
    $productId = $_GET['productId'];
    $update_quantity = $product->update_quantity($productId,$quantity);
    
    $id = $_GET['confirmid'];  
    $time = $_GET['time'];
    $total = $_GET['total'];
    $shifted_confirm = $cart->shifted_confirm($id,$time,$total);
    
}
if(isset($_GET['delid'])){
    $id = $_GET['delid'];
    $time = $_GET['time'];
    $total = $_GET['total'];
    $del_shifted = $cart->del_shifted_customer($id,$time,$total);
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
    <div class="row text-center">
		<div class="col-12">
			<table>
				<thead>
					<tr>
					<th style="width:5%">STT</th>
					<th style="width:12%">Sản Phẩm</th>
					<th style="width:12%">Hình Ảnh</th>
					<th style="width:10%">Số Lượng</th>
					<th style="width:10%">Thành Tiền</th>
					<th style="width:15%">Ngày Đặt</th>
					<th style="width:10%">Trạng Thái</th>
					<th style="width:10%">Hành Động</th>
					</tr>
				</thead>
				
                <?php 
                    $customer_id = $_SESSION["customer_id"];
                    $carts = $cart->get_cart_ordered($customer_id);
                    $i = 0;
                    $qty = 0;
                    foreach($carts as $cart): $i++; 
                ?>
				<tbody>
					<tr>
						<td><?=$i?></td>
						<td><a href="#"></a><?=htmlspecialchars($cart->productName)?></td>
						<td><a href="#"><img img style="width:50%" src="admin/uploads/<?=htmlspecialchars($cart->image)?>" alt=""/></a></td>
						<td><a class="text-decoration-none text-warning" href="#"><?=htmlspecialchars($cart->quantity)?></a></td>
						<td><?=htmlspecialchars($cart->total) . " ". "VNĐ"?></td>
						<td><?=	htmlspecialchars($cart->date_order)?></td>
						<td>
							<?php
							if(htmlspecialchars($cart->status) == '0') {
								echo 'Đang xử lý';
							}
							else if(htmlspecialchars($cart->status) == '1'){
							?>
							<span>Đang giao...</span>
							<?php
							}else {
								echo 'Đã Nhận';
							}
							?>                                       
						</td>
						<?php
							if(htmlspecialchars($cart->status) == '0') {
						?>
						<td><a class="btn btn-danger" onclick = "return confirm('Are you sure?')" href="?delid=<?=	htmlspecialchars($cart->id)?>&total=<?=	htmlspecialchars($cart->total)?>&time=<?=htmlspecialchars($cart->date_order)?>">Xóa</a></td>                                    
						<?php
							}else if(htmlspecialchars($cart->status) =='1'){
						?>
						<td><a class="btn btn-success" href="?confirmid=<?=	htmlspecialchars($cart->customer_id)?>&productId=<?=	htmlspecialchars($cart->productId)?>&quantity=<?=	htmlspecialchars($cart->quantity)?>&total=<?=	htmlspecialchars($cart->total)?>&time=<?=	htmlspecialchars($cart->date_order)?>">Xác nhận</a></td>
						<?php
						}else if(htmlspecialchars($cart->status) =='2'){   
						?>
						<td><?php echo 'N/A' ?></td>
						<?php
						}
						?>   
					</tr>
				</tbody>  
				<?php endforeach ?>                               
			</table>   
		</div>
	</div>   

	<script>
        function myFunction() {
        alert("Bạn chắc chứ!!!");
        }
    </script> 

	<?php include('../partials/footer.php') ?>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
	
</body>

</html>