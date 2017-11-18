<?php session_start(); ?>
<?php 
require_once("./includes/connect.php");
include("./includes/function.php");
include("./includes/header.php");
include("./includes/sidebar-a.php");
?>
<div class="noidung">
	<?php 
// Kiểm tra đăng nhập
	if(isset($_SESSION['user_level'])) {
		$errors = array();
		if(validate_id($_GET['uid'])) {
			$sql = "SELECT * FROM users WHERE user_id = '$_GET[uid]' LIMIT 1";
			$que = mysql_query($sql) or die("SAI SQL");
			if (mysql_num_rows($que) > 0) {
				$r = mysql_fetch_assoc($que);
				if($r['gioitinh'] == true) {
					$gt = "Nam";
				} else {
					$gt = "Nữ";
				}
				$ns = explode("-", $r['birthday']);
				echo '
				<form action="" method="post" class="thongtin" accept-charset="utf-8">
				<fieldset>
				<legend>Thông tin của: <strong class="tt_user">'.$r['user_name'].'</strong></legend>
				<div>
				<label>Tên đăng nhập: <span class="tt_user">'.$r['user_name'].'</span></label>
				</div>
				<div>
				<label>Họ và tên: <span class="tt_user">'.$r['hoten'].'</span></label>
				</div>
				<div>
				<label>Giới tính: <span class="tt_user">'.$gt.'</span></label>
				</div>
				<div>
				<label>Email: <span class="tt_user">'.$r['email'].'</span></label>
				</div>
				<div>
				<label>Ngày sinh: <span class="tt_user">'.$ns[2] ."/".$ns[1]."/".$ns[0].'</span></label>
				</div>
				<div>
				<label>Số điện thoại: <span class="tt_user">'.$r['phone'].'</span></label>
				</div>
				<div>
				<label>Địa chỉ: <span class="tt_user">'.$r['diachi']." - ".$r['thanhpho'].'</span></label>
				</div>
				<div>
				<label>Mã bưu điện: <span class="tt_user">'.$r['mabuudien'].'</span></label>
				</div>

				</fieldset>

				<div>
				<input type="submit" name="oke" class="tt_user" value="Sửa thông tin">
				<a href="changepw.php" title=""><input type="button" name="" value="Đổi mật khẩu"></a>
				</div>
				</form>
				';
			} else {
				echo "<script>alert('Không tìm thấy người dùng này')</script>";
				echo "<script>window.location.href='index.php'</script>";
			}
		}

		if (isset($_POST['oke'])) 
		{
			echo "<style>
			form.thongtin {
				display: none;
			}
			</style>";
			?>
			<form action="" method="post" class="thongtin2" accept-charset="utf-8">
				<fieldset>
					<legend>Sửa thông tin của: <strong class="tt_user"><?php echo $r['user_name'] ?></strong></legend>
					<?php if (!empty($mess)) {
						echo $mess;
					} ?>
					<div>
						<label>Tên đăng nhập: </label>
						<input type="text" name="txtTendn" value="<?php if(isset($r['user_name'])) echo "$r[user_name]"; ?>" disabled>
					</div>
					<div>
						<label>Họ và tên: </label>
						<input type="text" name="txtHoTen" value="<?php if(isset($r['hoten'])) echo "$r[hoten]"; ?>" >
					</div>
					<div>
						<label>Giới tính</label>
						<input type="radio" name="txtGioiTinh" value="1" <?php if($r['gioitinh'] == true) echo "checked='checked'"; ?>> Nam &nbsp;&nbsp;
						<input type="radio" name="txtGioiTinh" value="0" <?php if($r['gioitinh'] == false) echo "checked='checked'"; ?>> Nữ
					</div>
					<div>
						<label>Email: </label>
						<input type="text" name="txtEmail" value="<?php if(isset($r['email'])) echo "$r[email]"; ?>" >
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

			</div>
			<div>
				<label>SĐT: </label>
				<input type="text" name="txtSDT" value="<?php if(isset($r['phone'])) echo "$r[phone]"; ?>" >
			</div>
			<div>
				<label>Nơi ở: </label>
				<input type="text" name="txtDiaChi" value="<?php if(isset($r['diachi'])) echo "$r[diachi]"; ?>" >
			</div>
			<div>
				<label>Thành phố: </label>
				<input type="text" name="txtThanhPho" value="<?php if(isset($r['thanhpho'])) echo "$r[thanhpho]"; ?>" >
			</div>
			<div>
				<label>Mã bưu điện: </label>
				<input type="text" name="txtMaBD" value="<?php if(isset($r['mabuudien'])) echo "$r[mabuudien]"; ?>" >
			</div>
			

		</fieldset>

		<div>
			<input type="submit" name="submit" class="tt_user" value="Cập nhật">
		</div>
	</form>
	<?php
		}// End If ISSET oke
		if (isset($_POST['submit'])) {
			//Validate Form
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

			$bd = $_POST['txtNamSinh']. "-" .$_POST['txtThangSinh']. "-" .$_POST['txtNgaySinh'];

			//Check lỗi hoàn thành, chèn dữ liệu vào CSDL
			if (empty($errors)) {
				//check trung Mail
				if ($txtEmail != $r['email']) {
					$m = mysql_query("SELECT email FROM users WHERE email = '$txtEmail'");
				} else {
					$m = mysql_query("SELECT email FROM users WHERE email = ''");
				}
				

				if (mysql_num_rows($m) == 1) {
					echo "<script>alert('Email đã tồn tại.')</script>";;
				} else {

					$s = "UPDATE users SET 
					hoten         = '$txtHoTen',
					gioitinh      = '$_POST[txtGioiTinh]',
					email         = '$txtEmail',
					birthday      = '$bd',
					phone         = '$txtSDT',
					diachi        = '$txtDiaChi',
					thanhpho      = '$txtThanhPho',
					mabuudien     = '$txtMaBD'
					WHERE user_id = '$_GET[uid]' LIMIT 1
					";
					$q = mysql_query($s) or die("SAI SQL");
					if (mysql_affected_rows($dbc) == 1) {
						echo "<script>alert('Cập nhật thành công !')</script>";
						echo "<script>window.location.href=''</script>";
					} else {
						echo "<script>alert('Không thể cập nhật !')</script>";
						echo "<script>window.location.href=''</script>";
					}
				}// check trung mail
			} else {
				$mess = "<span class='warning'>Bạn chưa điền đầy đủ thông tin</span>";
			}// End Errors
		}// End Submit
	} else {
	// Chưa login
		echo "<script>window.location.href='index.php'</script>";
	}
	?>
</div><!-- end noidung -->
<?php include("./includes/footer.php"); ?>