<?php 
//Kiem tra nguoi dung da login hay chua
if (isset($_SESSION['user_level'])) {
	echo "<script>window.location.href='index.php'</script>";
} else {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Khi bam nut submit thi xu ly form


		$errors = array(); // Array bat loi
		$now    = getdate(); // Lay thoi gian hien tai
		

/* Xu ly cac truong cua form
################################################################################################*/
		if (empty($_POST['hoten'])) {
			$errors[] = "empty_hoten";
		} elseif (strlen($_POST['hoten']) < 2 || strlen($_POST['hoten']) > 40) { // Quy dinh cac ky tu cho hoten
			$errors[] = "long_hoten";
		} else { // Khi tat ca deu True thi get du lieu cho hoten
			$txtHoten = checkData($_POST['hoten']);
		}//End hoten


		if (empty($_POST['tendn'])) {
			$errors[] = "empty_tendn";
		} elseif (!preg_match('/^[\w.-]{4,20}$/', $_POST['tendn'])) { 
			$errors[] = "long_tendn";
		} else { //Khi tat ca dieu True thi get du lieu cho tendn
			$txtTendn = checkData($_POST['tendn']);
		}//End tendn


		if (empty($_POST['pass'])) {
			$errors[] = "empty_pass";
		} elseif (strlen($_POST['pass']) < 6 || strlen($_POST['pass']) > 20) { 
			$errors[] = "long_pass";
		}// End Pass

		if (empty($_POST['pass2'])) {
			$errors[] = "empty_pass2";
		} elseif (strlen($_POST['pass2']) < 6 || strlen($_POST['pass2']) > 20) {
			$errors[] = "long_pass2";
		} elseif ($_POST['pass'] != $_POST['pass2']) {
			$errors[] = "ss_pass";
		} else {
			$txtPass2 = checkData($_POST['pass2']);
		}// End Pass2


		if(empty($_POST['email'])) {
			$errors[] = "empty_email";
		} elseif (!preg_match('/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$/', $_POST['email'])) {
			$errors[] = "wrong_email";
		} else {
			$txtEmail = checkData($_POST['email']);
		}// End Mail


		if (!empty($_POST['namsinh'])) {
			if (!is_numeric($_POST['namsinh']) || $_POST['namsinh'] < 0 || $_POST['namsinh'] > $now['year'] ) {
				$errors[] = "wrong_namsinh";
			} else {
				$txtNamsinh = checkData($_POST['namsinh']);
			}
		} else {
			$txtNamsinh = checkData($_POST['namsinh']);
		}// End namsinh


		if (empty($_POST['phone'])) {
			$errors[] = "null_phone";
		} if (!is_numeric($_POST['phone']) || strlen($_POST['phone']) < 10) {
			$errors[] = "wrong_phone";
		} else {
			$txtPhone = checkData($_POST['phone']);
		}// End Phone

		if (empty($_POST['txtDiaChi'])) {
			$errors[] = "null_diachi";
		} elseif (is_numeric($_POST['txtDiaChi'])) {
			$errors[] = "wrong_diachi";
		} else {
			$txtDiaChi = checkData($_POST['txtDiaChi']);
		}// End DiaChi

		if (empty($_POST['txtThanhPho'])) {
			$errors[] = "null_thanhpho";
		} elseif (is_numeric($_POST['txtThanhPho'])) {
			$errors[] = "wrong_thanhpho";
		} else {
			$txtThanhPho = checkData($_POST['txtThanhPho']);
		} // End ThanhPho

		if (empty($_POST['txtMaBD'])) {
			$errors[] = "null_mabd";
		} elseif (!is_numeric($_POST['txtMaBD'])) {
			$errors[] = "wrong_mabd";
		} else {
			$txtMaBD = checkData($_POST['txtMaBD']);
		} // End MA BUU DIEN


		if (!isset($_POST['agree']) && "checked == 'checked'") {
			$errors[] = "null_agree";
		}// End Agree


		if(empty($_POST['captcha'])) {
			$errors[] = "empty_captcha";
		} elseif ($_POST['captcha'] != $_SESSION['security_code']) {
			$errors[] = "wrong_captcha";
		} // End Captcha
################################################################################################*/

		if (empty($errors)) {
			
			// Lay du lieu tu form
			$txtNS = checkData($_POST['ngaysinh']);
			$txtTS = checkData($_POST['thangsinh']);
			$txtGT   = checkData($_POST['gt']);
			$birth = $txtNamsinh. "-" .$txtTS. "-" .$txtNS;

			// SQL SELECT EMAIL
			$sql_e = "SELECT email FROM users WHERE email = '$txtEmail'";
			$kq_e = mysql_query($sql_e);

			if (mysql_num_rows($kq_e) == 0) {
				// Neu Email khong trung, thi cho phep dang ky
				
				// SQL SELECT TENDN
				$sql_nic = "SELECT user_name, email FROM users WHERE user_name = '$txtTendn' OR email = '$txtEmail'";
				$kq_nic = mysql_query($sql_nic);

				if (mysql_num_rows($kq_nic) == 0) {
					// Neu khong trung gi ca, thi cho dang ky thanh vien
					
					// Chen du lieu vao CSDL
					$sql = "INSERT INTO users (
												user_name, 
												password, 
												hoten, 
												gioitinh, 
												email, 
												birthday, 
												phone, 
												diachi, 
												thanhpho, 
												mabuudien, 
												registration_date
												)
							VALUES (
									'$txtTendn', 
									'$txtPass2', 
									'$txtHoten', 
									'$txtGT', 
									'$txtEmail', 
									'$birth', 
									'$txtPhone', 
									'$txtDiaChi', 
									'$txtThanhPho', 
									'$txtMaBD', 
									NOW()
									)";
					$kq = mysql_query($sql);

					// Kiem tra va xuat thong bao tinh trang dang ky
					if (mysql_affected_rows($dbc) == 1) {
						$message = "<span class='success'>Đăng ký thành công !</span>";
					} else {
						$message = "<span class='error'>Đăng ký thất bại !</span>";
					}
					
				} else { // End IF tendn
					// Neu trung tendn, thi xuat thong bao
					echo "<script>alert('email hoặc tên đăng nhập đã tồn tại !')</script>";
				}

			} else { // End IF email
				// Neu trung mail, thi xuat thong bao
				$errors[] = "trung_mail";
			}
						
		}// End main IF 

	}// End Submit
}//end else
 ?>
