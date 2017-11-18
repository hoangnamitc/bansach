<?php session_start(); ?>
<?php 
$title = "Xóa giỏ hàng"; 
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
		$delhd = mysql_query("DELETE FROM hoadon WHERE MaHoaDon = '$cid' LIMIT 1");
		$delct = mysql_query("DELETE FROM ct_hoadon WHERE MaHoaDon = '$cid'");
		$delkh = mysql_query("DELETE FROM khach_hang WHERE MaHoaDon = '$cid' LIMIT 1");

		if ($delhd && $delct && $delkh) {
			echo "<script>window.location.href='ql_cart.php'</script>";
		} else {
			echo "<script>alert('Không thể xóa !')</script>";
			echo "<script>window.location.href='ql_cart.php'</script>";
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