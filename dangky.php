<?php session_start(); ?>
<?php 
require_once("includes/connect.php");
include("includes/function.php");
include("includes/header.php");
include("includes/sidebar-a.php");
?>
<?php 
 	//Kiểm tra đã login chưa
if (!isset($_SESSION['user_level'])) {
	?>
	<div class="noidung">
		<div>
			<link rel="stylesheet" href="./register/register.css">
			<?php include("./register/register.php"); ?>
		</div>
	</div><!-- end noidung -->

	<?php 
	include("./includes/footer.php");
} else {
	echo "<script>alert('Bạn đã đăng nhập vào hệ thống.')</script>";
	echo "<script>window.location.href='index.php'</script>";
}
?>


