<?php

namespace CT275\Project;

class Cart
{
	private $db;
	

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	protected function fillCartFromDB(array $row)
	{
		[
		'cartId' => $this->cartId,
		'productId' => $this->productId,
		'sId' => $this->sId,
		'productName' => $this->productName,
		'price' => $this->price,
		'quantity' => $this->quantity,
        'image' => $this->image,
        'sl_conlai' => $this->sl_conlai
		] = $row;
		return $this;
	}

    protected function fillOrderFromDB(array $row)
	{
		[
		'id' => $this->id,
		'productId' => $this->productId,
		'productName' => $this->productName,
        'customer_id' => $this->customer_id,
		'quantity' => $this->quantity,
		'total' => $this->total,
        'image' => $this->image,
        'status' => $this->status,
        'date_order' => $this->date_order
		] = $row;
		return $this;
	}

	public function add_to_cart($quantity,$id) {
		$quantity = trim($quantity);
		$sId = session_id();

		$stmt = $this->db->prepare('SELECT * FROM tbl_product WHERE productId = :productId');
		$stmt->execute(['productId' => $id]);

		$result = $stmt->fetch();

		$image = $result['image'];
		$price = $result['price'];  
		$productName = $result['productName'];

		$stmt2 = $this->db->prepare('INSERT INTO tbl_cart(productId,quantity,sId,image,price,productName) 
									VALUES(:productId,:quantity,:sId,:image,:price,:productName)');

		$stmt2->execute(['productId' => $id, 'quantity' => $quantity, 'sId' => $sId, 'image' => $image, 'price' => $price,'productName' => $productName]);

		if($stmt2 -> rowCount() > 0) {
			echo "<script>window.location ='cart.php'</script>";
		}
			else{
				echo "<script>window.location ='404.php'</script>";
		}
	}

	// Thêm vào phần đặt hàng từ người dùng
        public function insertOrder($customer_id){
            $sId = session_id();

            $stmt = $this->db->prepare("SELECT * FROM tbl_cart WHERE sId = :sId");
			$stmt->execute(['sId' => $sId]);

            if($stmt -> rowCount() > 0) {
                while($result = $stmt->fetch()) {
                    $productid = $result['productId'];
                    $productName = $result['productName'];
                    $quantity = $result['quantity'];
                    $total = $result['price'] * $quantity;
                    $image = $result['image'];
                    $customer_id = $customer_id;

                    $stmt = $this->db->prepare("INSERT INTO tbl_order(productId,productName,quantity,total,image,customer_id) 
                                                VALUES(:productId,:productName,:quantity,:total,:image,:customer_id)");

			        $stmt->execute([
                                    'productId' => $productid,
                                    'productName' => $productName,
                                    'quantity' => $quantity,
                                    'total' => $total,
                                    'image' => $image,
                                    'customer_id' => $customer_id
                                ]);
                }
            }
        }
        
        // Lấy sản phẩm chỉ định từ giỏ hàng ràng buộc số lượng trong kho
        public function get_product_cart() {
            $carts = [];
            $sId = session_id();
            $stmt = $this->db->prepare("
                                        SELECT tbl_cart.*, tbl_product.sl_conlai
                                        FROM tbl_cart INNER JOIN tbl_product ON tbl_cart.productId = tbl_product.productId
	                                    WHERE tbl_cart.sId = :sId ");

			$stmt->execute(['sId' => $sId]);
            while ($row = $stmt->fetch()) {
                $cart = new Cart($this->db);
                $cart->fillCartFromDB($row);
                $carts[] = $cart;
            }
            return $carts;
        }
        
        //Lấy giá của sản phẩm từ đơn hàng
        public function getAmountTotal($customer_id) {       
            $stmt = $this->db->prepare("SELECT total FROM tbl_order WHERE customer_id = :customer_id ");
			$stmt->execute(['customer_id' => $customer_id]);
        }

        //Lấy tất cả đơn hàng đã đặt từ chính người dùng đó
        public function get_cart_ordered($customer_id) {
            $carts = [];
            $stmt = $this->db->prepare("SELECT * FROM tbl_order WHERE customer_id = :customer_id ");
			$stmt->execute(['customer_id' => $customer_id]);
            while ($row = $stmt->fetch()) {
                $cart = new Cart($this->db);
                $cart->fillOrderFromDB($row);
                $carts[] = $cart;
            }
            return $carts;
        }

        // Lấy toàn bộ đơn hàng đã đặt đưa vào order
         public function get_inbox_cart(){
            $carts = [];
            $stmt = $this->db->prepare("SELECT * FROM tbl_order ORDER BY date_order");
			$stmt->execute();
            while ($row = $stmt->fetch()) {
                $cart = new Cart($this->db);
                $cart->fillOrderFromDB($row);
                $carts[] = $cart;
            }
            return $carts;

        }

        // Cập nhật số lượng giỏ hàng
        public function update_quantity_cart($quantity,$cartId) {

            $quantity = trim($quantity);

            $stmt = $this->db->prepare("UPDATE tbl_cart SET quantity = :quantity WHERE cartId = :cartId");
			$stmt->execute(['quantity' => $quantity, 'cartId' => $cartId ]);

            if($stmt -> rowCount() > 0) {
                echo "<script>window.location ='cart.php'</script>"; 
            }else{
                $msg = "<span class='error'>Cập nhật số lượng bánh thất bại</span>";
                return $msg;
            }
        }

        //Cập nhật trạng thái đơn hàng
        public function shifted($id,$time,$total) {
            // $id = trim($id);
            // $time = trim($time);
            // $total = trim($total);
            
            $stmt = $this->db->prepare("UPDATE tbl_order SET status = '1' WHERE id = :id AND date_order= :date_order AND total= :total");
			$stmt->execute(['id' => $id, 'date_order' => $time, 'total' => $total  ]);

            if($stmt -> rowCount() > 0) {
                echo "<script>window.location ='inbox.php'</script>";
            }else{
                $msg = "<span class='error'>Cập nhật đơn hàng thất bại</span>";
                return $msg;
            }
        }

        // Xóa 1 sản phẩm từ giỏ hàng
        public function del_product_cart($cartid) {

            $stmt = $this->db->prepare(" DELETE FROM tbl_cart where cartId = :cartId");
			$stmt->execute(['cartId' => $cartid]);

            if($stmt -> rowCount() > 0) {
                echo "<script>window.location ='cart.php'</script>";               
            }
            else{
                $alert = "<span class='error'>Xóa sản phẩm thất bại</span>";
                return $alert;
            }
        }


        //Xóa tất cả dữ liệu giỏ hàng
        public function del_all_data_cart() {
            $sId = session_id();
            $stmt = $this->db->prepare("DELETE FROM tbl_cart WHERE sId = :sId");
			$stmt->execute(['sId' => $sId]);
        }

        // Xóa đơn hàng sau khi đã thanh toán của admin
        public function del_shifted_admin($id,$time,$total) {

            $stmt = $this->db->prepare("DELETE FROM tbl_order WHERE id = :id AND date_order= :date_order AND total= :total");
			$stmt->execute(['id' => $id, 'date_order' => $time, 'total' => $total]);

            if($stmt -> rowCount() > 0) {
                echo "<script>window.location ='inbox.php'</script>";
            }else{
                $msg = "<span class='error'>Xóa đơn hàng thất bại</span>";
                return $msg;
            }
        }

        // Xóa đơn hàng sau khi đã thanh toán của admin
        public function del_shifted_customer($id,$time,$total) {
            $stmt = $this->db->prepare("DELETE FROM tbl_order WHERE id = :id AND date_order= :date_order AND total= :total");
			$stmt->execute(['id' => $id, 'date_order' => $time, 'total' => $total]);

            if($stmt -> rowCount() > 0) {
                echo "<script>window.location ='orderdetails.php'</script>";
            }else{
                $msg = "<span class='error'>Xóa đơn hàng thất bại</span>";
                return $msg;
            }
        }

        // Kiểm tra giỏ hàng
        public function check_cart() {
            $sId = session_id();
            $stmt = $this->db->prepare("SELECT * FROM tbl_cart WHERE sId = :sId");
			$stmt->execute(['sId' => $sId]);
            return $stmt -> rowCount();
        }

        // Kiểm tra đặt hàng
        public function check_order($customer_id) {
            $sId = session_id();
            
            $stmt = $this->db->prepare("SELECT * FROM tbl_order WHERE customer_id = :customer_id");
			$stmt->execute(['customer_id' => $customer_id]);
        }
        
        
        // Xác nhận thanh toán đơn hàng
        public function shifted_confirm($id,$time,$total){
            
            $stmt = $this->db->prepare("UPDATE tbl_order SET status = '2' WHERE customer_id = :customer_id AND date_order=:date_order AND total=:total");
			$stmt->execute(['customer_id' => $id, 'date_order' => $time , 'total' => $total ]);

            if($stmt -> rowCount() > 0) {
                echo "<script>window.location ='orderdetails.php'</script>";
            }else{
                $msg = "<span class='error'>Xác nhận đơn hàng thành công</span>";
                return $msg;
            } 

        }

        // Kiểm tra đặt hàng
        public function filter_product() {

            if($_GET['sanpham'] == 'banchay') {
                $stmt = $this->db->prepare("SELECT *,sum(quantity) as soluong FROM tbl_order GROUP BY productId,productName ORDER BY sum(quantity) desc LIMIt 1");
			    $stmt->execute();
            }
            else if($_GET['sanpham'] == 'bankhongchay'){
                $stmt = $this->db->prepare("SELECT *,sum(quantity) as soluong FROM tbl_order GROUP BY productId,productName ORDER BY sum(quantity) asc LIMIT 1");
			    $stmt->execute();
            }   
            else {
                $stmt = $this->db->prepare("SELECT *,sum(quantity) as soluong FROM tbl_order GROUP BY productId,productName ORDER BY productId");
			    $stmt->execute();
            }  
        }
}
