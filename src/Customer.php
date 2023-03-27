<?php

namespace CT275\Project;

class Customer
{
	private $db;

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	protected function fillFromDB(array $row)
	{
		[
		'id' => $this->id,
		'name' => $this->name,
		'address' => $this->address,
		'phone' => $this->phone,
		'email' => $this->email,
		'password' => $this->password,
		] = $row;
		return $this;
	}
	
	public function insert_customers(Array $data){
		$name = trim($data['name']);
		$address = trim($data['address']);
		$phone = trim($data['phone']);
		$email = trim($data['email']);
		$password = trim(md5($data['password']));

		if($name == "" || $address == "" || $phone == "" || $email == "" || $password == "" ) {
			$alert = "<span class='error'>Các trường không được rỗng</span>";
			return $alert;
		}
		else {
			//Kiểm tra email đã tồn tại hay chưa
			$stmt = $this->db->prepare("SELECT * FROM tbl_customer WHERE email = :email LIMIT 1");
			$stmt->execute(['email' => $email]);

			if($stmt -> rowCount() > 0) {
				$alert = "<span class='error'>Email đã tồn tại ! Xin nhập email khác!!!</span>";
				return $alert;
			}
			else{
				$stmt2 = $this->db->prepare("INSERT INTO tbl_customer(name,address,phone,email,password) 
											VALUES(:name,:address,:phone,:email,:password)");
				$stmt2->execute(['name' => $name, 'address' => $address,'phone' => $phone,'email' => $email,'password' => $password]);

				if($stmt2 -> rowCount() > 0) {
					$alert = "<span class='success'>Đăng ký khách hàng thành công</span>";
					return $alert;
				}
				else{
					$alert = "<span class='error'>Đăng ký khách hàng thất bại </span>";
					return $alert;
				}
			}
		}
	}
	
	//Đăng nhập khách hàng
	public function login_customers(Array $data) {
		$email = trim($data['email']);
		$password = trim(md5($data['password']));

		if($email == "" || $password == "" ) {
			$alert = "<span class='error'>Các trường không được rỗng</span>";
			return $alert;
		}
		else {
			$stmt = $this->db->prepare("SELECT * FROM tbl_customer WHERE email = :email and password = :password");
			$stmt->execute(['email' => $email, 'password' => $password ]);

			if($row = $stmt -> fetch()) {
				$_SESSION["customer_login"] = true;
				$_SESSION["customer_id"] = $row["id"];
				$_SESSION["customer_name"] = $row["name"];
				echo "<script>window.location ='index.php'</script>"; 
			}
			else{
				$alert = "<span class='error'>Email hoặc mật khẩu không khớp</span>";
				return $alert;
			}
		}
	}
	
	// Hiển thị khách hàng
	public function show_customers($id){
		$customers = [];
		$stmt = $this->db->prepare("SELECT * FROM tbl_customer WHERE id = :id");
		$stmt->execute(['id' => $id]);
		while ($row = $stmt->fetch()) {
			$customer = new Customer($this->db);
			$customer->fillFromDB($row);
			$customers[] = $customer;
		}
		return $customers;

	}
	
	 // Hiển thị khách hàng
	 public function show_all_customers(){
		$customers = [];
		$stmt = $this->db->prepare("SELECT * FROM tbl_customer");
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$customer = new Customer($this->db);
			$customer->fillFromDB($row);
			$customers[] = $customer;
		}
		return $customers;

	}
	
}
