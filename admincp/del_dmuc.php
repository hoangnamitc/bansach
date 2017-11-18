<?php session_start(); ?>
<?php 
	require_once("../includes/connect.php");
	include("../includes/function.php");
 ?>
<meta charset="utf-8">
<?php
// Kiểm tra có phải là Admin không?
if (is_admin())
{
	if ($del = validate_id($_GET['do'])) {

		$s = "DELETE FROM danhmuc WHERE dmuc_id = '$del' LIMIT 1";
		$q = mysql_query($s) or die("Khong the xoa !");
		if (mysql_affected_rows($dbc) == 1) {
			echo "<script>window.location.href='ql_dmuc.php'</script>";
		} else {
			echo "Không thể xóa sản phẩm !";
		}
	} else {// Nếu ID không hợp lệ thì chuyển hướng về Index
		echo "<script>window.location.href='index.php'</script>";
	}// End ID
} else {
	//Nếu không phải Admin thì chuyển hướng về Index.
	echo "<script>window.location.href='login.php'</script>";
}	
 ?>