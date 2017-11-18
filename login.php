<?php 
session_start();
require_once("./includes/connect.php");
include("./includes/function.php");
include("./includes/header.php");
include("./includes/sidebar-a.php");
?>
<div class="noidung">

	<div class="dangnhap">
		<?php 
		$errors = array();
		if (isset($_POST['oke'])) 
		{
			// Gán biến đếm số lần login
			@$_SESSION['diemdn']++;
			//Check form
			if (empty($_POST['txtTendn'])) 
			{
				$errors[] = "txtTendn";
			} 
			else 
			{
				$txtTendn = checkData($_POST['txtTendn']);
			}// end Tendn
			if (empty($_POST['txtMatkhau'])) 
			{
				$errors[] = "txtMatkhau";
			} 
			else 
			{
				$txtMatkhau = checkData($_POST['txtMatkhau']);
			}// end Pass
			if (!empty($_POST['captcha']) || isset($_SESSION['diemdn']) && $_SESSION['diemdn'] >= 5)
			{
				if(empty($_POST['captcha'])) 
				{
					$errors[] = "empty_captcha";
				} 
				elseif ($_POST['captcha'] != $_SESSION['security_code']) 
				{
					$errors[] = "wrong_captcha";
				}// end captcha
			}
			

			// Check loi complete -> Get du lieu trong csdl
			if (empty($errors)) 
			{
				$s = "SELECT user_id, user_name, user_level FROM users WHERE user_name='$txtTendn' AND password='$txtMatkhau' LIMIT 1";
				$q = mysql_query($s) or die("Không thể login !");
				if (mysql_num_rows($q) == 1) 
				{
					list($uid, $user_name, $user_level) = mysql_fetch_array($q);

					$_SESSION['uid']        = $uid;
					$_SESSION['user_name']  = $user_name;
					$_SESSION['user_level'] = $user_level;

					echo "<script>window.location.href='index.php'</script>";
				} 
				else 
				{
					$mess = "<span class='error'>Sai thông tin đăng nhập!</span>";
				}// End if num_rows
			}
			else 
			{
				$mess = "<span class='error'>Đăng nhập thất bại, vui lòng thử lại!</span>";
			}// End Empty Errors

		}// end IF main

		//Kiem tra nguoi dung da login hay chua
		if (isset($_SESSION['user_level'])) 
		{
				// Neu user da login thanh cong thi hide form login
			echo "<script>window.location.href='index.php'</script>";
		} 
		else 
		{
			// Neu nguoi dung chua login thi show form login
			?>
			<form action="" method="post" accept-charset="utf-8">
				<fieldset>
					<legend>Đăng nhập</legend>
					<?php if(!empty($mess)) echo $mess; ?>
					<div>
						<label>Username:</label>
						<input type="text" name="txtTendn" value="" placeholder="Tên tài khoản">
						<?php checkError($errors, 'txtTendn', '<span class="warning">Bạn chưa nhập tên đăng nhập !</span>'); ?>
					</div>
					<div>
						<label>Password:</label>
						<input type="password" name="txtMatkhau" value="" placeholder="Mật khẩu">
						<?php checkError($errors, 'txtMatkhau', '<span class="warning">Bạn chưa nhập mật khẩu !</span>'); ?>
					</div>
					<?php 
						if (isset($_SESSION['diemdn']) && $_SESSION['diemdn'] >= 5)
						{
							echo '
		<div>
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
			
		echo '</div>';
				}
				else
				{
					echo '<div></div>';
				}

					 ?>
					
					<div style="width:220px">
						<input type="submit" name="oke" value="" class="login22">
						<a href="dangky.php"><div class="signup"></div></a>
					</div>
					<div>
						<!-- <a href="" title="" class="forgetpass">Quên mật khẩu?</a> -->
					</div>
				</fieldset>
			</form>
			<?php
	}// end ELSE IF
	?>

</div><!--- end sidebar-b -->
<div style="clear:both"></div>

</div><!-- end noidung -->
<?php include("./includes/footer.php"); ?>