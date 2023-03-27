<?php

include_once "C:/xampp/apps/project/bootstrap.php";

use CT275\Project\Session;
use CT275\Project\Cart;

$cart = new Cart($PDO);
if(isset($_GET['shiftid'])){ 
	$id = $_GET['shiftid'];
	$time = $_GET['time'];
	$total = $_GET['total'];
	$shifted = $cart->shifted($id,$time,$total);
}

// if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['submit'])) {
// 	$filter_product = $ct->filter_product();
	
// }


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
	<div class="container border rounded" >
	<h4 class="m-4 text-primary">Danh sách đơn hàng</h4>
	<div class="row inner-wrapper ms-4 me-4">
		<?php
			if(isset($shifted)) {
				echo $shifted;
			}
		?>
		<?php
			if(isset($del_shifted)) {
				echo $del_shifted;
			}
		?>
		<table id="example" class="table text-center table-bordered align-middle table-striped table-responsive">
			<thead>
				<tr>
					<th class="text-center">STT</th>
					<th class="text-center">TG Đặt Hàng</th>
					<th class="text-center">Bánh</th>
					<th class="text-center">Số Lượng</th>
					<th class="text-center">Thành Tiền</th>
					<th class="text-center">Xem Thông Tin</th>
					<th class="text-center">Thao Tác</th>
				</tr>
			</thead>
			
			<tbody>
				<?php 
					$carts = $cart->get_inbox_cart();
					$i = 0;
					$doanhthu = 0;
					foreach($carts as $cart): $i++
				?>
				<tr>
					<td><?= $i ?></td>
					<td><?=htmlspecialchars($cart->date_order)?></td>
					<td><?=htmlspecialchars($cart->productName)?></td>
					<td><?=htmlspecialchars($cart->quantity)?></td>
					<td><?=htmlspecialchars($cart->total)." "."VNĐ"?></td>
					<td><a class="text-decoration-none fw-semibold link-warning" href="customer.php?customerid=<?=htmlspecialchars($cart->customer_id)?>">View Customer</a></td>
					<td>
						<?php
							if($cart->status == '0') {										
						?>	
						<a href="?shiftid=<?=htmlspecialchars($cart->id)?>&total=<?=htmlspecialchars($cart->total)?>&time=<?=htmlspecialchars($cart->date_order)?>">Pending</a> 
						<?php
							}else if($cart->status == '1'){								
						?>
							<?php
							echo 'Shipping...';
							?>
						<?php
							}else if($cart->status == '2'){
						?>
						<?php
							$doanhthu += htmlspecialchars($cart->total); 					
							echo 'N/A';
							}	
						?>
					</td>	
				</tr>
				<?php endforeach ?>	
			</tbody>  
							
		</table>   
	</div>
	<div class="row ms-3 ">
		<h5 class="mt-2 text-primary ">Doanh thu: <?php if(isset($doanhthu)) echo $doanhthu. " "."VND"; ?></h5>
		<form action="" method="GET" >
			<div class="row">
				<div class="col-2">
					<h5 class="mt-2 text-primary ">Lọc sản phẩm :</h5>
				</div>
				<div class="col-5">
					<select class="form-select w-50" aria-label="Default select example" name="sanpham">
						<option selected value="banchay">Bán chạy</option>
						<option value="bankhongchay">Bán không chạy</option>
						<option value="tungsanpham">Từng loại sản phẩm bán ra</option>
					</select>
					
				</div>
				
			</div>
			<div class="row">
				<div class="col-2"></div>
				<div class="col-5 my-3">
					<input class="btn btn-success"type="submit" value="Choose" name="submit" />
				</div>
			</div>
		</form>
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