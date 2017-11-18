<?php session_start(); ?>
<meta charset="utf-8">
<?php 
	require_once("../includes/connect.php");
	require_once("../includes/function.php");
	include("../includes/header-admin.php");
	include("../includes/sidebar-admin.php");
 ?>
<?php 
// Kiểm tra có phải là Admin không ?
	if (is_admin()) {
?>
<div class="noidung">
	<div style="margin-top: 20px;">
		<h2>Chào mừng <font color="blue" size="5px;"> <?php if (isset($_SESSION['user_name'])) echo $_SESSION['user_name'] ?> </font> đến với trang Admin Panel - <?php echo " <a href='logout.php' style='color: red;'>Logout</a>"; ?></h2>
		<p style="font-size: 20px;">
			Tại đây bạn có thể thêm, sửa, xóa các danh mục và sản phẩm bên ngoài trang chủ !
		</p>
    </div>
</div><!-- end noidung -->

<?php include("../includes/footer.php"); ?>
<?php
	} else {
		// Không phải Admin thì đưa người dùng về login
		echo "<script>window.location.href='login.php'</script>";
	};
?>	