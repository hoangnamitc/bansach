<?php session_start(); ?>
<?php
$title = "Thông tin sách"; 
require_once("./includes/connect.php");
include("./includes/function.php");
include("./includes/header.php");
	// include("./includes/sidebar-a.php");
?>
<link rel="stylesheet" href="style/cart.css">
<?php 
 // Kiểm tra người người dùng đã login chưa?
if(isset($_SESSION['user_level'])) 
{
	echo "<script>window.location.href='thanhtoan.php'</script>";
} 
else 
{
	// Đăng nhập khi người dùng chưa đăng nhập
	$errors = array();
	if (isset($_POST['btnLogin'])) 
	{
		// Gán biến đếm số lần login
		@$_SESSION['diemdn']++;

		//Validate Form
		if (empty($_POST['txtUser'])) 
		{
			$errors[] = "null_user";
		} 
		else 
		{
			$txtUser = checkData($_POST['txtUser']);
		}// End User

			if (empty($_POST['txtPw'])) 
			{
				$errors[] = "null_pw";
			} 
			else 
			{
				$txtPw = checkData($_POST['txtPw']);
			}// End PW
			if (!empty($_POST['captcha']) || isset($_SESSION['diemdn']) && $_SESSION['diemdn'] >= 5)
			{
				if(empty($_POST['captcha'])) 
				{
					$errors[] = "empty_captcha";
				} 
				elseif ($_POST['captcha'] != $_SESSION['security_code']) 
				{
					$errors[] = "wrong_captcha";
				}
			}// end captcha

			if (empty($errors)) 
			{
				$s = "SELECT * FROM users WHERE user_name = '$txtUser' AND password = '$txtPw'";
				$q = mysql_query($s) or die("Cannot select table");
				if (mysql_num_rows($q) == 1) 
				{
					list($uid, $user_name, $user_level) = mysql_fetch_array($q);

					$_SESSION['uid']        = $uid;
					$_SESSION['user_name']  = $user_name;
					$_SESSION['user_level'] = $user_level;
					
					echo "<script>alert('Đăng nhập thành công !')</script>";
					echo "<script>window.location.href='thanhtoan.php'</script>";
				} 
				else 
				{
					$mess = "<span class='error'>Đăng nhập thất bại, vui lòng thử lại.</span>";
				}
			}
			else
			{
				$mess = "<span class='error'>Đăng nhập thất bại!</span>";
			}
			// End Errors

		}// End REQUEST_METHOD

		?>
		<!-- <div class="noidung"> -->
		<div class="dang_nhap">	

			<div class="dang_nhap_1">
				<div class="mod_dang_nhap_header den">Khách hàng đã có tài khoản</div>
				
				<div class="mod_dang_nhap_body dang_nhap_form">
					<form method="post">
						<li>Các thông tin khi đăng ký của thành viên sẽ được tự động điền vào giúp bạn. <span class="do">* các trường bắt buộc</span></li>
						<li><?php 
						if (!empty($mess))
						{
							echo $mess;
						}
						 ?></li>
						<li><b>Tên đăng nhập </b> <span class="do">* </span><br>
							<input type="text" name="txtUser" class="input_text_1">
							<?php checkError($errors, 'null_user', '<span class="warning">Bạn chưa điền tên đăng nhập</span>'); ?>
						</li>
						<li><b>Mật khẩu </b><span class="do">* </span><br>
							<input type="password" name="txtPw" class="input_text_1">
							<?php checkError($errors, 'null_pw', '<span class="warning">Bạn chưa điền mật khẩu</span>'); ?>
						</li>
						<li>
				<?php 
				// Hiện mã captcha khi đăng nhập sai quá 5 lần
					if (isset($_SESSION['diemdn']) && $_SESSION['diemdn'] >= 5)
					{
						echo '
						<label>Mã xác nhận: <span>*</span></label>
						<img src="./register/captcha/captcha.php"><br/>
						<input type="text" name="captcha" value="" class="capcha" maxlength="6" placeholder="Nhập chuỗi ở trên">';
						//DONG PHP
							if (isset($errors) && in_array("empty_captcha", $errors)) 
							{
								echo "<span class='warning'> Hãy nhập mã xác nhập !</span>";
							} 
							elseif (isset($errors) && in_array("wrong_captcha", $errors)) 
							{
								echo "<span class='warning'> Mã xác nhận không đúng, vui lòng thử lại !</span>";
							}
					}
					else
					{
						echo '';
					}

				 ?>
						</li>
						<li><input type="submit" class="button_dang_nhap" name="btnLogin" value="Đăng nhập"></li>
					</form>
				</div>
				<div class="mod_dang_nhap_footer"></div>
			</div>

			<div class="dang_nhap_2">
				<div class="mod_dang_nhap_header den">NẾU BẠN CHƯA CÓ TÀI KHOẢN</div>
				<div class="mod_dang_nhap_body">
					<li style="line-height:20px;">
						Click  <span class="xanh_dam"><b>"Tiếp tục thanh toán" </b> </span> để  đến các bước tiếp theo.<br>
					</li>								
					<li style="margin-top:131px;"><a href="thanhtoan.php"><input type="button" class="submit_button_thanh_toan" value="Tiếp tục thanh toán" id="button_1"></a></li>
				</div>
				<div class="mod_dang_nhap_footer"></div>
			</div>

		</div> <!-- end dang_nhap -->
		<?php 
}// End kiểm tra login của User
?>
<!-- </div>End noidung -->
<?php include("./includes/footer.php"); ?>