<?php

namespace CT275\Project;

class Category
{
	private $db;

	public function getId()
	{
		return $this->id;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}
	
	protected function fillFromDB(array $row)
	{
		[
		'catId' => $this->catId,
		'catName' => $this->catName,
		'mode' => $this->mode
		] = $row;
		return $this;
	}
	
	public function insert_category($catName)
	{
		$catName = trim($catName);

		if(empty($catName)) {
			$alert = "<span class='error'>Danh mục không được rỗng</span>";
			return $alert;
		}
		else {
			$stmt = $this->db->prepare('INSERT INTO tbl_category(catName) 
								VALUES(:catName)');

			$stmt->execute(['catName' => $catName]);

			if($stmt -> rowCount() > 0) {
				$alert = "<span class='success'>Thêm danh mục thành công</span>";
				return $alert;
			}
			else{
				$alert = "<span class='error'>Thêm danh mục thất bại</span>";
				return $alert;
			}
		}
	}
	
	// Hiển thị loại sản phẩm
	public function show_category(){
		$cats = [];
		$stmt = $this->db->prepare("SELECT * FROM tbl_category order by catId desc");
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$cat = new Category($this->db);
			$cat->fillFromDB($row);
			$cats[] = $cat;
		}
		return $cats;
	}

	// Hiển thị loại sản phẩm ra phía giao diện
	public function show_category_frontend(){
		$cats = [];
		$stmt = $this->db->prepare("SELECT * FROM tbl_category where mode = '1' order by catId desc");
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$cat = new Category($this->db);
			$cat->fillFromDB($row);
			$cats[] = $cat;
		}
		return $cats;
	}
	
	
	// Lấy loại sản phẩm từ Id
	public function getcatbyId($id) {
		$cats = [];
		$stmt = $this->db->prepare('SELECT * FROM tbl_category where catId = :catId');
		$stmt->execute(['catId' => $id]);
		while ($row = $stmt->fetch()) {
			$cat = new Category($this->db);
			$cat->fillFromDB($row);
			$cats[] = $cat;
		}
		return $cats;
	}
	
	// Cập nhật loại sản phẩm
	public function update_category($catName,$id) {

		$catName = trim($catName);

		if(empty($catName)) {
			$alert = "<span class='error'>Danh mục không được rỗng</span>";
			return $alert;
		}
		else {
			$stmt = $this->db->prepare('UPDATE tbl_category SET catName = :catName WHERE catId = :catId');

			$stmt->execute(['catName' => $catName, 'catId' => $id]);

			if($stmt -> rowCount() > 0) {
				$alert = "<span class='success'>Cập nhật danh mục thành công</span>";
				return $alert;
			}
			else{
				$alert = "<span class='error'>Cập nhật danh mục thất bại</span>";
				return $alert;
			}
		}
	}
	
	// Xóa loại sản phẩm
	public function del_category($id) {

		$stmt = $this->db->prepare('DELETE FROM tbl_category where catId = :catId');

		$stmt->execute(['catId' => $id]);

		if($stmt -> rowCount() > 0) {
			$alert = "<span class='success'>Xóa danh mục thành công</span>";
			return $alert;
		}
		else{
			$alert = "<span class='error'>Xóa danh mục thất bại</span>";
			return $alert;
		}
	}
	
	

	// Cập nhật Mode category (0:1)
	public function update_mode_category($id,$mode) {	
		$stmt = $this->db->prepare("UPDATE tbl_category SET mode = :mode where catId = :catId ");
		return $stmt->execute(['mode' => $mode, 'catId' => $id]);
	}

	// Lấy sản phẩm từ catId
	public function get_product_by_cat($id) {
		$stmt = $this->db->prepare("SELECT * FROM tbl_product where catId = :catId order by catId desc LIMIT 8 ");
		return $stmt->execute(['catId' => $id]);
	}

	//Lấy tên sản phẩm từ loại sản phẩm (liên kết bảng)
	public function get_name_by_cat($id) {
		$stmt = $this->db->prepare("SELECT tbl_product.* , tbl_category.catName, tbl_category.catId
									FROM tbl_product,tbl_category 
									WHERE tbl_product.catId = tbl_category.catId AND tbl_category.catId = :catId LIMIT 1");
		return $stmt->execute(['catId' => $id]);
	}


}
