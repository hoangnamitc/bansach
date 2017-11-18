<?php session_start(); ?>
<meta charset="utf-8">
<?php 
	require_once("../includes/connect.php");
	include("../includes/function.php");
 ?>
<?php
//Kiểm tra có phải là Admin không?
if (is_admin())
{
	if ($del = validate_id($_GET['do'])) {
		
		$s = "DELETE FROM sach WHERE sach_id = '$del' LIMIT 1";
		$q = mysql_query($s) or die("Khong the xoa !");
		if (mysql_affected_rows($dbc) == 1) {
			echo "<script>window.location.href='ql_sach.php'</script>";
		} else {
			echo "Không thể xóa sản phẩm !";
		}
	} else {// Nếu ID không hợp lệ thì chuyển hướng về Index.
		echo "<script>window.location.href='index.php'</script>";
	}
} else {
	//Nếu không phải là admin thì chuyển hướng về Index.
	echo "<script>window.location.href='login.php'</script>";
}	
 ?>