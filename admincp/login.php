<?php session_start(); ?>
<meta charset="utf-8">
<?php 
	require_once("../includes/connect.php");
	require_once("../includes/function.php");
 ?>
<link rel="stylesheet" href="./style/login.css">
<?php 
// Kiem tra nguoi dung Admin
if(is_admin()) {//Nếu Admin đã login thì chuyển hướng vào Index.
	echo "<script>window.location.href='index.php'</script>";
} else {
	$errors = array();
	if (isset($_POST['oke'])) {
	// Check form
	if (empty($_POST['txtTendn'])) {
		$errors[] = "txtTendn";
	} else {
		$txtTendn = checkData($_POST['txtTendn']);
	}// end txtTendn

	if (empty($_POST['txtMatkhau'])) {
		$errors[] = "txtMatkhau";
	} else {
		$txtMatkhau = checkData($_POST['txtMatkhau']);
	}// end txtMatkhau

	//Kiem tra tai khoan va vao login
	if (empty($errors)) {
		$s = "SELECT user_id, user_name, user_level FROM users WHERE user_name='$txtTendn' AND password='$txtMatkhau' LIMIT 1";
		$q = mysql_query($s) or die("Không thể login !");
		if (mysql_num_rows($q) == 1) {
			list($uid, $user_name, $user_level) = mysql_fetch_array($q);

			$_SESSION['uid']        = $uid;
			$_SESSION['user_name']  = $user_name;
			$_SESSION['user_level'] = $user_level;

			echo "<script>window.location.href='index.php'</script>";
		} else {
			$mess = "<span class='error'>Sai thông tin đăng nhập!</span>";
		}
	}// End Empty Errors
}// end IF Submit
 ?>
<div id="wrapper">
		
	<form action="" method="post" accept-charset="utf-8">
			<div id="login-sub-header">
                    <img src="./style/images/cpanel-logo.png" alt="logo">
            </div>
    <div id="login-sub">
    	<?php if(!empty($mess)) echo $mess; ?>
		<div>
			<label>Username:</label>
			<input type="text" name="txtTendn" value="" placeholder="Tên tài khoản">
			<?php checkError($errors, 'txtTendn', '<span class="warning"><br>Bạn chưa nhập tên đăng nhập !</span>'); ?>
		</div>
		<div>
			<label>Password:</label>
			<input type="password" name="txtMatkhau" value="" placeholder="Mật khẩu">
			<?php checkError($errors, 'txtMatkhau', '<span class="warning"><br>Bạn chưa nhập mật khẩu !</span>'); ?>
		</div>
		<div>
			<input type="submit" name="oke" value="Đăng nhập">
		</div>
		<div>
			<!-- <a href="" title="" class="forgetpass">Quên mật khẩu?</a> -->
		</div>
	</form>
</div> <!-- End  -->
</div> <!-- End Wrapper -->

<?php 
	}// End check Admin
 ?>