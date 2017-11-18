<?php session_start(); ?>
<?php 
$title = "Quản lý giỏ hàng"; 
require_once("../includes/connect.php");
include("../includes/function.php");
include("../includes/header-admin.php");
include("../includes/sidebar-admin.php");
?>
<div class="noidung">
<?php 
	// Kiểm tra Admin đã login hay chưa
	if (is_admin()) {
		if ($kid = validate_id($_GET['kid'])) {
		$result = mysql_query("SELECT * FROM khach_hang WHERE kh_id='$kid'");
?>
	<table cellspacing="0" cellpadding="0" border="0" class="thong_tin_cart">
	<caption>Danh sách hàng hóa</caption>
	<thead>
		<tr class="le">
			<th>ID</th>
			<th>Tên Khách hàng</th>
			<th>Giới tính</th>
			<th>Ngày sinh</th>
			<th>Điện thoại</th>
			<th>Email</th>
			<th>Địa chỉ</th>
			<th>Zip</th>
		</tr>
	</thead>
	<tbody>
<?php 
	if (mysql_num_rows($result) > 0) {
		$r = mysql_fetch_assoc($result);
			$ns = explode("-", $r['kh_birthday']);
			$ns2 = $ns[2]."/".$ns[1]."/".$ns[0];
			if ($r['kh_gender'] == 1) {
				$GT = "Nam";
			} else {
				$GT = "Nữ";
			}

			echo "<tr class='nd-1'>";
				echo "<td><center>".$r['kh_id']."</center></td>";
				echo "<td>".$r['kh_name']."</td>";
				echo "<td><center>".$GT."</center></td>";
				echo "<td><center>".$ns2."</center></td>";
				echo "<td><center>".$r['kh_phone']."</center></td>";
				echo "<td><center>".$r['kh_email']."</center></td>";
				echo "<td>".$r['kh_address'].", ".$r['kh_city']."</td>";
				echo "<td><center>".$r['kh_zip']."</center></td>";
				
			echo "</tr>";
	} else {
		echo "<tr><td>Không có dữ liệu !</td></tr>";
	}// End Num_rows
 ?>		

	</tbody>
</table>
<?php
} else {
	// Nếu ID không hợp lệ chuyển về Index.
	echo "<script>window.location.href='index.php'</script>";
}
} else {
	//Nếu không phải là Admin thì chuyển hướng về Index.
	echo "<script>window.location.href='login.php'</script>";
}
?>	
</div>
<?php include("../includes/footer.php"); ?>	