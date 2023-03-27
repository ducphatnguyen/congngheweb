
<?php session_start(); ?>
<div class="row mt-4 ">
    <div class="col-1 d-flex" style="margin-right: 111px">
        <h1><img  class="ms-4"src="../img/logo/logo.png"/></h1>
    </div>
    <div class="col-10">
        <nav class="navbar navbar-expand-lg bg-primary bg-opacity-25 bg-gradient border rounded">
            <div class="container-fluid text-uppercase fw-bold fst-italic " >
                <a class="nav-link active" aria-current="page" href="index.php">Trang Chủ</a>
                <div class="collapse navbar-collapse " id="navbarSupportedContent" >
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../index.php">Xem trang web</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <!-- Thông tin Admin -->
                        <li style="list-style-type:none;">Hello 
                            <?php echo $_SESSION["adminName"]  ?>
                        </li>
                        <?php
                            if(isset($_GET['action']) && $_GET['action'] == 'logout') { //Tồn tại và kiểm tra giá trị
                                header("Location:login.php");
                            }
                        ?>
                        <li style="list-style-type:none;"><a class="text-decoration-none" href="?action=logout">Đăng xuất</a></li> 
                    </ul>
                </div>
            </div>   
        </nav>        
    </div>
</div>
<br>