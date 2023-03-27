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
    <div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">          
                    <aside>
                        <div>
                            <form class="d-flex" role="search">
                                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </form>
                        </div>

                        <div class="mt-4">
                            <h3>Danh mục</h3>
                            <ul>
                                <li><a href="#">Sáng tạo</a>  (2)</li>
                                <li><a href="#">Sáng tạo</a>  (2)</li>
                                <li><a href="#">Sáng tạo</a>  (2)</li>
                            </ul>
                        </div>

                        <div>
                            <h3>Bài đăng gần đây</h3>
                            <div class="row">
                                <div class="col-5">
                                    <a href="#"><img class="w-100" src="img/blog/post1.jpg" alt="#"></a>
                                </div>
                                <div class="col-7">
                                    <a href="#">Bánh mì tươi</a>
                                    <span>October 1 , 2022</span>
                                </div>                               
                            </div>
                            <div class="row my-5">
                                <div class="col-5">
                                    <a href="#"><img class="w-100" src="img/blog/post2.jpg" alt="#"></a>
                                </div>
                                <div class="col-7">
                                    <a href="#">Bánh kem dâu tây</a>
                                    <span>November 4, 2022</span>
                                </div>                               
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <a href="#"><img class="w-100" src="img/blog/post3.jpg" alt="#"></a>
                                </div>
                                <div class="col-7">
                                    <a href="#">Bánh ngọt</a>
                                    <span>December 5, 2022</span>
                                </div>                               
                            </div>
                        </div>                           
                    </aside>
                </div>

                <div class="col-lg-9 col-md-12">
                    <div>
                        <div class="row">
                            <div class="col-4">
                                <a href="#"><img class="w-100" src="img/blog/blog4.jpg" alt="#"></a>
                            </div>
                            <div class="col-8">
                                <h3><a href="#">Bánh mì tươi</a></h3>
                                <p >Bánh mì được làm từ trứng và sữa mang lại cảm giác ngon miệng khi lần đầu trải nghiệm, vị ngọt kích thích cảm giác thèm ăn giúp cho món ăn kèm trở nên ngon lạ thường.</p>
                                <a href="#">Chi Tiết</a>
                                <div >
                                   <span>Đăng bởi </span>
                                    <span><a href="#">admin</a></span>
                                    <span><a href="#">/ Cake Bakery</a></span>
                                </div>
                            </div>
                        </div>

                        <div class="row my-5">
                            <div class="col-4">
                                <a href="#"><img class="w-100" src="img/blog/blog2.jpg" alt="#"></a>
                            </div>
                            <div class="col-8">
                                <h3><a href="#">Bánh kem sô cô la dâu</a></h3>
                                <p >Vị ngọt của sữa và kem hòa quyện với vị béo của sô cô la tạo cảm giác tan chảy khi lần đầu nếm thử.</p>
                                <a href="#">Chi Tiết</a>
                                <div >
                                   <span>Đăng bởi </span>
                                    <span><a href="#">admin</a></span>
                                    <span><a href="#">/ Cake Bakery</a></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <a href="#"><img class="w-100" src="img/blog/blog3.jpg" alt="#"></a>
                            </div>
                            <div class="col-8">
                                <h3><a href="#">Bánh bông lan trời xanh</a></h3>
                                <p >Bánh bông lan nhỏ nhắn, xinh xắn kèm lớp phủ xanh trời mang lại cảm giác mát mẻ cho thời tiết nóng nực này.</p>
                                <a href="#">Chi Tiết</a>
                                <div >
                                   <span>Đăng bởi </span>
                                    <span><a href="#">admin</a></span>
                                    <span><a href="#">/ Cake Bakery</a></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


	<?php include('../partials/footer.php') ?>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
	
</body>

</html>