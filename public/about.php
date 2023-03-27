<?php
include_once "C:/xampp/apps/project/bootstrap.php";
session_start();
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
	    <h2 class="text-center my-3">Về chúng tôi</h2>
        <hr/>
        <div class="row my-4">
            <div class="col"><img class="w-100 h-80" alt="ve-chung-toi" src="img/about/about1.jpg" /></div>
            <div class="col lh-lg fst-italic">
                <p>Với sự cố gắng không ngừng cũng như hiểu được nhu cầu ăn uống của mọi người ở hiện tại. Chúng tôi đã cho ra đời hàng loạt những loại bánh mới, thơm ngon để phục vụ. Đối với cửa hàng, khách hàng luôn được đặt lên hàng đầu dù có ở bất kỳ địa vị, bằng cấp nào. Vậy còn chần chờ gì nữa, hãy đăng nhập và đặt cho mình những món bánh thơm ngon nhất nào!!! </p>
            </div>
        </div>


	<?php include('../partials/footer.php') ?>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
	
</body>

</html>