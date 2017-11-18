<?php 
	session_start();
	$title = "Chỉnh sửa người sử dụng"; 
	require_once("../includes/connect.php");
	include("../includes/function.php");
	include("../includes/header-admin.php");
	include("../includes/sidebar-admin.php");
 ?>
 <meta charset="utf-8">
 <div class="noidung">
<?php 
// Kiểm tra có phải là Admin không ?
if (is_admin()) {
	// Kiểm tra tính hợp lệ của ID và gán ID cho $id
	if($id = validate_id($_GET['do'])) {
	$errors = array();
	// Hien thi du lieu ra textbox
	$s = "SELECT * FROM users WHERE user_id = '$id' LIMIT 1";
	$q = mysql_query($s) or die("SAI SQL");
	if(mysql_num_rows($q) > 0) {
		$r = mysql_fetch_assoc($q);
		//Giới tính và ngày sinh
		if($r['gioitinh'] == true) {
			$gt = "Nam";
		} else {
			$gt = "Nữ";
		}
		$ns = explode("-", $r['birthday']);
	} else {
		$mess = "<span class='warning'>Không tìm thấy người dùng !</span>";
	}// end if num_rows

	// Show form User
?>
<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			//Validate Form
			
			if (empty($_POST['txtTendn'])) {
				$errors[] = "null_Tendn";
			} else {
				$txtTendn = checkData($_POST['txtTendn']);
			}// End Tendn

			if (empty($_POST['txtPW'])) {
				$errors[] = "null_pw";
			} elseif (strlen($_POST['txtPW']) < 6) {
				$errors[] = "len_pw";
			} else {
				$txtPW = checkData($_POST['txtPW']);
			}// End PW

			if (empty($_POST['txtHoTen'])) {
				$errors[] = "null_HoTen";
			} else {
				$txtHoTen = checkData($_POST['txtHoTen']);
			}// End HoTen

			if (empty($_POST['txtEmail'])) {
				$errors[] = "null_Email";
			} elseif (!preg_match('/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$/', $_POST['txtEmail'])) {
				$errors[] = "Wrong_Email";
			} else {
				$txtEmail = checkData($_POST['txtEmail']);
			}// End Email

			if (empty($_POST['txtSDT'])) {
				$errors[] = "null_SDT";
			} elseif (!is_numeric($_POST['txtSDT'])) {
				$errors[] = "wrong_SDT";
			} else {
				$txtSDT = checkData($_POST['txtSDT']);
			}// End SDT

			if (empty($_POST['txtDiaChi'])) {
				$errors[] = "null_DiaChi";
			} else {
				$txtDiaChi = checkData($_POST['txtDiaChi']);
			}// End DiaChi

			if (empty($_POST['txtThanhPho'])) {
				$errors[] = "null_ThanhPho";
			} else {
				$txtThanhPho = checkData($_POST['txtThanhPho']);
			}// End ThanhPho

			if (empty($_POST['txtMaBD'])) {
				$errors[] = "null_MaBD";
			} elseif (!is_numeric($_POST['txtMaBD'])) {
				$errors[] = "wrong_MaBD";
			} else {
				$txtMaBD = checkData($_POST['txtMaBD']);
			}// End MaBD

			$txtLevel = checkData($_POST['txtLevel']);

			$bd = $_POST['txtNamSinh']. "-" .$_POST['txtThangSinh']. "-" .$_POST['txtNgaySinh'];

			if (empty($errors)) {
				//Kiểm tra trùng Mail
				if ($txtEmail != $r['email'] OR $txtTendn != $r['user_name']) {
					$m = mysql_query("SELECT user_name, email FROM users WHERE user_name = '$txtTendn' OR email = '$txtEmail'");
				} else {
					$m = mysql_query("SELECT user_name FROM users WHERE user_name = ''");
				}
				
				if (mysql_num_rows($m) == 0) {
					// Không trùng Email
					$up = "UPDATE users SET 
										user_name     = '$txtTendn',
										password      = '$txtPW',
										hoten         = '$txtHoTen',
										gioitinh      = '$_POST[txtGioiTinh]',
										email         = '$txtEmail',
										birthday      = '$bd',
										phone         = '$txtSDT',
										diachi        = '$txtDiaChi',
										thanhpho      = '$txtThanhPho',
										mabuudien     = '$txtMaBD',
										user_level    = '$txtLevel'
										WHERE user_id = '$_POST[uid]' LIMIT 1
										";
					$up2 = mysql_query($up) or die("SAI SQL");
					if (mysql_affected_rows($dbc) == 1) {
						echo "<script>alert('Cập nhật thành công !')</script>";
						echo "<script>window.location.href='ql_user.php'</script>";
					} else {
						echo "<script>alert('Không thể cập nhật !')</script>";
						echo "<script>window.location.href='ql_user.php'</script>";
					}// End affected
				} else {
					echo "<script>alert('Email hoặc Tên đăng nhập đã tồn tại !')</script>";
				}// end check mail trùng
			} else {
				$mess = "<span class='error'>Bạn chưa điền đầy đủ thông tin !</span>";
				// echo "<script>alert('Bạn chưa điền đầy đủ thông tin !')</script>";
			}// end errors
		}// end REQUEST_METHOD


	} else {
	// Nếu ID không hợp lệ thì chuyển hướng về Index.
	echo "<script>window.location.href='index.php'</script>";
	}// end Validate ID
} else {
	// Không phải Admin thì chuyển hướng về Index.
	echo "<script>window.location.href='index.php'</script>";
}// end Admin check
 ?>
<form action="" method="POST">
	<fieldset>
		<legend>Sửa thông tin của: 
		<strong class="tt_user">
			<?php echo $r['user_name']; ?>
		</strong></legend>

<?php if(!empty($mess)) echo $mess; ?>

	 <div>
		<input type="hidden" name="uid" value="<?php if(isset($id)) {echo $id;} ?>">
	</div>
	<div>
		<label>Tên đăng nhập: </label>
		<input type="text" name="txtTendn" value="<?php if(isset($r['user_name'])) echo "$r[user_name]"; ?>">
		<?php checkError($errors, 'null_Tendn', '<span class="warning">Bạn chưa điền tên đăng nhập !</span>') ?>
	</div>
	<div>
		<label>Mật khẩu:</label>
		<input type="text" name="txtPW" value="<?php if(isset($r['password'])) echo "$r[password]"; ?>" >
		<?php checkError($errors, 'null_pw', '<span class="warning">Bạn chưa điền mật khẩu !</span>') ?>
		<?php checkError($errors, 'len_pw', '<span class="warning">Độ dài mật khẩu phải lớn hơn 6 ký tự !</span>') ?>
	</div>
	<div>
		<label>Họ và tên: </label>
		<input type="text" name="txtHoTen" value="<?php if(isset($r['hoten'])) echo "$r[hoten]"; ?>" >
		<?php checkError($errors, 'null_HoTen', '<span class="warning">Bạn chưa điền họ tên !</span>') ?>
	</div>
	<div>
	<label>Giới tính</label>
		<input type="radio" name="txtGioiTinh" value="1" <?php if($r['gioitinh'] == true) echo "checked='checked'"; ?>> Nam &nbsp;&nbsp;
		<input type="radio" name="txtGioiTinh" value="0" <?php if($r['gioitinh'] == false) echo "checked='checked'"; ?>> Nữ
	</div>
	<div>
		<label>Email: </label>
		<input type="text" name="txtEmail" value="<?php if(isset($r['email'])) echo "$r[email]"; ?>" >
		<?php checkError($errors, 'null_Email', '<span class="warning">Bạn chưa điền Email !</span>') ?>
		<?php checkError($errors, 'Wrong_Email', '<span class="warning">Emai không hợp lệ !</span>') ?>
	</div>
	<div>
		<label>Ngày sinh:</label>
		Ngày: <select name="txtNgaySinh">
			<?php 
				for ($ngay=1; $ngay <= 31; $ngay++) { 
					echo "<option value='$ngay'";
						if($ns[2] == $ngay) {
							echo "selected='selected'";
						}
					echo ">$ngay</option>";
				}
			 ?>
		</select>
		Tháng: <select name="txtThangSinh">
			<?php 
				for ($thang=1; $thang <= 12; $thang++) { 
					echo "<option value='$thang'";
						if($ns[1] == $thang) {
							echo "selected='selected'";
						}
					echo ">$thang</option>";
				}
			 ?>
		</select>
		Năm: <input type="text" name="txtNamSinh" value="<?php if(isset($ns[0])) {echo $ns[0];} ?>" style="width: 45px;">
		<?php checkError($errors, '', '<span class="warning"></span>') ?>
	</div>
	<div>
		<label>SĐT: </label>
		<input type="text" name="txtSDT" value="<?php if(isset($r['phone'])) echo "$r[phone]"; ?>" >
		<?php checkError($errors, 'null_SDT', '<span class="warning">Bạn chưa điền SĐT !</span>') ?>
		<?php checkError($errors, 'wrong_SDT', '<span class="warning">SĐT không hợp lệ !</span>') ?>
	</div>
	<div>
		<label>Nơi ở: </label>
		<input type="text" name="txtDiaChi" value="<?php if(isset($r['diachi'])) { echo "$r[diachi]";} ?>" >
		<?php checkError($errors, 'null_DiaChi', '<span class="warning">Bạn chưa điền địa chỉ !</span>') ?>
	</div>
	<div>
		<label>Thành phố: </label>
		<input type="text" name="txtThanhPho" value="<?php if(isset($r['thanhpho'])) echo "$r[thanhpho]"; ?>" >
		<?php checkError($errors, 'null_ThanhPho', '<span class="warning">Bạn chưa điền thành phố !</span>') ?>
	</div>
	<div>
		<label>Mã bưu điện: </label>
		<input type="text" name="txtMaBD" value="<?php if(isset($r['mabuudien'])) echo "$r[mabuudien]"; ?>" >
		<?php checkError($errors, 'null_MaBD', '<span class="warning">Bạn chưa điền mã bưu điện !</span>') ?>
		<?php checkError($errors, 'wrong_MaBD', '<span class="warning">Mã bưu điện không hợp lệ !</span>') ?>
	</div>
	<div>
		<label>Quyền hạn:</label>
		<select name="txtLevel">
			<option value="0" <?php if($r['user_level'] == 0) {echo "selected='selected'";} ?>>Thành viên</option>
			<option value="1" <?php if($r['user_level'] == 1) {echo "selected='selected'";} ?>>Admin</option>
		</select>
	</div>
	<div>
		<input type="submit" name="oke" class="tt_user" value="Cập nhật">
	</div>

	</fieldset>		
</form>

 </div><!--  End div noidung -->
 <?php include("../includes/footer.php"); ?>