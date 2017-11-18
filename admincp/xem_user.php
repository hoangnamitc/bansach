<?php session_start(); ?>
<?php 
	$title = "Quản lý thành viên";
	require_once("../includes/connect.php");
	include("../includes/function.php");
	include("../includes/header-admin.php");
	include("../includes/sidebar-admin.php");
 ?>
<div class="noidung">
<?php
//check admin login chua ?
if (is_admin())
{ 
	if($id = validate_id($_GET['do'])) {
		// Lấy thông tin vào form
		$xem = "SELECT * FROM users WHERE user_id = '$id' LIMIT 1";
		$xem2 = mysql_query($xem) or die("Cannot select table");
	 ?>
	<table border='1' cellspacing='0' cellpadding='5'>
		<caption>Thông tin chi tiết của thành viên</caption>
		<thead>
			<tr>
				<th>Username</th>
				<th>Email</th>
				<th>Ngày sinh</th>
				<th>Phone</th>
				<th>Mật khẩu</th>
				<th>Mã vùng</th>
				<th>Ngày tham gia</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				if (mysql_num_rows($xem2) > 0) {
					$r = mysql_fetch_assoc($xem2);
					$ns = explode("-", $r['birthday']);
					$tg = explode("-", $r['registration_date']);
					echo "<tr>";
						echo "<td>".$r['user_name']."</td>";
						echo "<td>".$r['email']."</td>";
						echo "<td>".$ns[2]."/".$ns[1]."/".$ns[0]."</td>";
						echo "<td>".$r['phone']."</td>";
						echo "<td>".$r['password']."</td>";
						echo "<td>".$r['mabuudien']."</td>";
						echo "<td>".$tg[2]."/".$tg[1]."/".$tg[0]."</td>";
					echo "</tr>";
			} else {
				echo "<script>alert('Không tìm thấy người dùng này !')</script>";
				echo "<script>window.location.href='ql_user.php'</script>";
			}// end IF num_rows
			 ?>
		</tbody>
	</table>
	<br />
	&nbsp;&nbsp;&nbsp;<a href='ql_user.php' title="Quay lại"><img src="style/images/back-icon.png"></a>
</div><!-- end noidung -->
<?php 
	} else {
		// Nếu ID không hợp lệ chuyển hướng về Quản lý User
		echo "<script>window.location.href='ql_user.php'</script>";
	}
} else {
	// Nếu Admin chưa login thì chuyển về login
	echo "<script>window.location.href='login.php'</script>";
}
 ?>
<?php include("../includes/footer.php"); ?>