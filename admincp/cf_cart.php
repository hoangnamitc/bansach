<?php session_start(); ?>
<?php 
$title = "Xác nhận giỏ hàng"; 
require_once("../includes/connect.php");
include("../includes/function.php");
include("../includes/header-admin.php");
include("../includes/sidebar-admin.php");
?>
<div class="noidung">
<?php 
// Kiểm tra Admin đã login hay chưa
if (is_admin()) {
	if ($cid = $_GET['cid']) {
		$up = mysql_query("UPDATE hoadon SET TinhTrang = 1 WHERE MaHoaDon = '$cid' LIMIT 1");

		if (mysql_affected_rows($dbc) == 1) {
			echo "<script>window.location.href='ql_cart.php'</script>";
		} else {
			echo "<script>alert('Không thể xác nhận !')</script>";
		}
	} else {
	//Nếu ID không hợp lệ chuyển hướng về Index.
		echo "<script>window.location.href='index.php'</script>";
	}
} else {
//Nếu không phải là Admin thì chuyển hướng về Index.
	echo "<script>window.location.href='login.php'</script>";
}
?>
</div>
<?php include("../includes/footer.php"); ?>