<?php

namespace CT275\Project;

class Product
{
	private $db;
	
	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	protected function fillFromDB(array $row)
	{
		[
		'productId' => $this->productId,
		'productName' => $this->productName,
		'catId' => $this->catId,
		'product_desc' => $this->product_desc,
		'sl_nhap' => $this->sl_nhap,
		'sl_banra' => $this->sl_banra,
		'sl_conlai' => $this->sl_conlai,
		'price' => $this->price,
		'catName' => $this->catName,
		'image' => $this->image,
		'status_product' => $this->status_product,
		'ngaynhap' => $this->ngaynhap
		] = $row;
		return $this;
	}

	protected function fillProductFromDB(array $row)
	{
		[
		'productId' => $this->productId,
		'productName' => $this->productName,
		'catId' => $this->catId,
		'product_desc' => $this->product_desc,
		'sl_nhap' => $this->sl_nhap,
		'sl_banra' => $this->sl_banra,
		'sl_conlai' => $this->sl_conlai,
		'price' => $this->price,
		'mode' => $this->mode,
		'image' => $this->image,
		'status_product' => $this->status_product,
		'ngaynhap' => $this->ngaynhap
		] = $row;
		return $this;
	}

	protected function filltoshowProductFromDB(array $row)
	{
		[
		'productId' => $this->productId,
		'productName' => $this->productName,
		'catId' => $this->catId,
		'product_desc' => $this->product_desc,
		'sl_nhap' => $this->sl_nhap,
		'sl_banra' => $this->sl_banra,
		'sl_conlai' => $this->sl_conlai,
		'price' => $this->price,
		'image' => $this->image,
		'status_product' => $this->status_product,
		'ngaynhap' => $this->ngaynhap
		] = $row;
		return $this;
	}

	// Tìm kiếm sản phẩm
	public function search_product($tukhoa) {

		$tukhoa = trim($tukhoa);
		
		if($tukhoa != NULL) {
			$products = [];
			$stmt = $this->db->prepare("SELECT * FROM tbl_product WHERE productName like '%$tukhoa%' ");
			$stmt->execute();
			while ($row = $stmt->fetch()) {
				$product = new Product($this->db);
				$product->filltoshowProductFromDB($row);
				$products[] = $product;
			}
			return $products;
		}
	}


	// Thêm sản phẩm
	public function insert_product($data,$files)
	{
		$productName = trim($data['productName']);
		$category = trim($data['category']);
		$product_desc = trim($data['product_desc']);
		$sl_nhap = trim($data['sl_nhap']);
		$price = trim($data['price']);
		$status_product = trim($data['status_product']);

		//Kiểm tra hình ảnh và lấy hình ảnh cho vào folder 
		$permited = array('jpg','jpeg','png','gif');
		$file_name = $_FILES['image']['name'];
		$file_size = $_FILES['image']['size'];
		$file_temp = $_FILES['image']['tmp_name'];

		$div = explode('.',$file_name);
		$file_ext = strtolower(end($div));
		$unique_image = substr(md5(time()), 0, 10).".".$file_ext;
		$upload_image = "uploads/".$unique_image;

		if($productName == "" || $category == "" || $product_desc == "" || $price == "" || $sl_nhap == "" || $status_product == "" || $file_name = "") {
			$alert = "<span class='error'>Các trường không được rỗng</span>";
			return $alert;
		}
		else {
			move_uploaded_file($file_temp,$upload_image);

			$stmt = $this->db->prepare("INSERT INTO tbl_product(productName,catId,product_desc,sl_nhap,sl_conlai,price,status_product,image) 
			VALUES(:productName,:catId,:product_desc,:sl_nhap,:sl_conlai,:price,:status_product,:image)");
			return $stmt->execute(['productName' => $productName,
								 'catId' => $category,
								 'product_desc' => $product_desc,
								 'sl_nhap' => $sl_nhap,
								 'sl_conlai' => $sl_nhap,	
								 'price' => $price,
								 'status_product' => $status_product,
								 'image' => $unique_image]);

			if($stmt -> rowCount() > 0) {
				$alert = "<span class='success'>Thêm bánh thành công</span>";
				return $alert;
			}
			else{
				$alert = "<span class='error'>Thêm bánh thất bại</span>";
				return $alert;
			}
		}
	}

	// Hiển thị sản phẩm
	public function show_product(){
		$products = [];
		$stmt = $this->db->prepare("
									SELECT tbl_product.*, tbl_category.catName
									FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
									ORDER BY tbl_product.productId asc");
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$product = new Product($this->db);
			$product->fillFromDB($row);
			$products[] = $product;
		}
		return $products;
	}
	
	// Lấy sản phẩm từ id
	public function getproductbyId($id) {
		$products = [];
		$stmt = $this->db->prepare("SELECT tbl_product.*, tbl_category.catName
									FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId where productId = :productId");
		$stmt->execute(['productId' => $id]);
		while ($row = $stmt->fetch()) {
			$product = new Product($this->db);
			$product->fillFromDB($row);
			$products[] = $product;
		}
		return $products;
		
	}

	// Cập nhật sản phẩm
	public function update_product($data,$file,$id) {
		$productName = trim($data['productName']);
		$category = trim($data['category']);
		$product_desc = trim($data['product_desc']);
		$price = trim($data['price']);
		$status_product = trim($data['status_product']);

		//Kiểm tra hình ảnh và lấy hình ảnh cho vào folder 
		$permited = array('jpg','jpeg','png','gif');
		$file_name = $_FILES['image']['name'];
		$file_size = $_FILES['image']['size'];
		$file_temp = $_FILES['image']['tmp_name'];

		$div = explode('.',$file_name);
		$file_ext = strtolower(end($div));

		$unique_image = substr(md5(time()), 0, 10).".".$file_ext;
		$upload_image = "uploads/".$unique_image;

		if($productName == "" || $category == ""  || $product_desc == "" || $price == "" ||  $status_product == "" ) {
			$alert = "<span class='error'>Các trường không được rỗng</span>";
			return $alert;
		}
		else{
			//Trường hợp người dùng chọn ảnh
			if(!empty($file_name)){
				if($file_size > 204800){
					$alert = "<span class='error'>Hình ảnh không được dưới 2MB!</span>";
					return $alert;
				}    
				else if(in_array($file_ext,$permited) === false)
				{
					$alert = "<span class='error'>Bạn chỉ có thể upload file:".implode(',',$permited)."</span>";
					return $alert;
				}
				move_uploaded_file($file_temp,$upload_image);

				$stmt = $this->db->prepare("UPDATE tbl_product SET 
											productName = :productName, 
											catId = :catId, 
											
											status_product = :status_product,
											price = :price, 
											image = :image, 
											product_desc = :product_desc
																
											WHERE productId = :productId");

				$stmt->execute([
								'productName' => $productName,
								'catId' => $category,
								'status_product' => $status_product,
								'price' => $price,
								'image' => $unique_image,
								'product_desc' => $product_desc,
								'productId' => $id
								]);

			}
			else{
				$stmt = $this->db->prepare("UPDATE tbl_product SET 
											productName = :productName, 
											catId = :catId, 
											status_product = :status_product,
											price = :price, 
											product_desc = :product_desc
																
											WHERE productId = :productId");
				$stmt->execute([
					'productName' => $productName,
					'catId' => $category,
					'status_product' => $status_product,
					'price' => $price,
					'product_desc' => $product_desc,
					'productId' => $id
					]);
			}

			if($stmt -> rowCount() > 0) {
				$alert = "<span class='success'>Chỉnh sửa bánh thành công</span>";
				return $alert;
			}
			else{
				$alert = "<span class='error'>Chỉnh sửa bánh thất bại</span>";
				return $alert;
			}
		}
	}
	
	// Xóa sản phẩm chỉ định
	public function del_product($id) {
		$stmt = $this->db->prepare(" DELETE FROM tbl_product where productId = :productId");
		$stmt->execute(['productId' => $id]);

		if($stmt -> rowCount() > 0) {
			$alert = "<span class='success'>Xóa bánh thành công</span>";
			return $alert;
		}
		else{
			$alert = "<span class='error'>Xóa bánh thất bại</span>";
			return $alert;
		}
	}

	

	// Lấy sản phẩm mới 
	public function getproduct_new(){
		$products = [];
		$stmt = $this->db->prepare("
									SELECT tbl_product.*, tbl_category.mode
									FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
									WHERE tbl_product.status_product = '1' AND tbl_category.mode = '1'
									order by tbl_product.productId desc LIMIT 4");
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$product = new Product($this->db);
			$product->fillProductFromDB($row);
			$products[] = $product;
		}
		return $products;
	} 

	//Lay san pham tu catId
	public function getproductbycatId($id) {
		$products = [];
		$stmt = $this->db->prepare("SELECT * FROM tbl_product where catId = :catId and status_product ='1'");
		$stmt->execute(['catId' => $id]);
		while ($row = $stmt->fetch()) {
			$product = new Product($this->db);
			$product->filltoshowProductFromDB($row);
			$products[] = $product;
		}
		return $products;
	}

	// Lấy toàn bộ sản phẩm giới hạn 8 
	public function get_all_product(){
		$products = [];
		$stmt = $this->db->prepare("
									SELECT tbl_product.*, tbl_category.mode
									FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
									WHERE tbl_product.status_product = '1' AND tbl_category.mode = '1'
									order by tbl_product.productId asc LIMIT 8");
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$product = new Product($this->db);
			$product->fillProductFromDB($row);
			$products[] = $product;
		}
		return $products;

	} 

	// Lấy toàn bộ sản phẩm
	public function get_all_product_shop(){
		$stmt = $this->db->prepare("
									SELECT tbl_product.*, tbl_category.mode
									FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
									WHERE tbl_product.status_product = '1' AND tbl_category.mode = '1'
									order by tbl_product.productId asc ");
		return $stmt->execute();
	} 

	//Lấy chi tiết sản phẩm
	public function get_details($id){
		
		$stmt = $this->db->prepare("SELECT * FROM tbl_product where productid = :productid order by productId desc LIMIT 1");
		$stmt->execute(['productid' => $id]);
	} 

	public function update_quantity($productId,$quantity) {
		$quantity = trim($quantity);

		$stmt = $this->db->prepare("SELECT * FROM tbl_product WHERE productId = :productId");
		return $stmt->execute(['productId' => $productId]);
		$result_select = $stmt->fetch();

		$sl_nhap = $result_select['sl_nhap'];
		$sl_banra = $quantity + $result_select['sl_banra'];
		$sl_conlai = $sl_nhap - $sl_banra;

		if($sl_conlai != 0) {
			$stmt2 = $this->db->prepare("UPDATE tbl_product SET sl_banra = :sl_banra, sl_conlai = :sl_conlai WHERE productId = :productId");
			$stmt2->execute(['sl_banra' => $sl_banra, 'sl_conlai' => $sl_conlai, 'productId' => $productId ]);

		}else if($sl_conlai == 0){
			$stmt2 = $this->db->prepare("UPDATE tbl_product SET sl_banra = :sl_banra, sl_conlai = :sl_conlai, status_product = '0' WHERE productId = :productId");
			$stmt2->execute(['sl_banra' => $sl_banra, 'sl_conlai' => $sl_conlai, 'productId' => $productId ]);
		}
		if($stmt2 -> rowCount() > 0) {
			$alert = "<span class='success'>Chỉnh sửa thành công</span>";
			return $alert;
		}
		else{
			$alert = "<span class='error'>Chỉnh sửa thật bại</span>";
			return $alert;
		}
	}

}
