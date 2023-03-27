<?php

namespace CT275\Project;

class Adminlogin
{
	private $db;

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function login_admin($adminUser,$adminPass)
	{	
		$adminUser = trim($adminUser);
		$adminPass = trim($adminPass);

		if(empty($adminUser) || empty($adminPass)) {
			$alert = "Tài khoản và mật khẩu không được rỗng";
			return $alert;
		}
		else {
			$stmt = $this->db->prepare('SELECT * FROM tbl_admin WHERE adminUser = :adminUser AND adminPass = :adminPass');
			$stmt->execute(['adminUser' => $adminUser,'adminPass' => $adminPass]);

			$row = $stmt->fetch();
			if ($stmt -> rowCount() > 0) {
				session_start();
				$_SESSION["adminlogin"] = true;
				$_SESSION["adminId"] = $row["adminId"];
				$_SESSION["adminUser"] = $row["adminUser"];
				$_SESSION["adminName"] = $row["adminName"];
				header('Location:index.php');
			} 
			else {
				$alert = "Tài khoản và mật khẩu không khớp";
				return $alert;
			}  
		}
	}
}
