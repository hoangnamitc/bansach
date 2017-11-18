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
		$tableName="users";// Ten Table		
		$targetpage = "ql_user.php"; // Ten trang dang dc dung phan trang
		$limit = 5;// So hang hien thi cua du lieu
		include("../includes/phantrang1.php");
	 ?>
	<table border='1' cellspacing='0' cellpadding='5'>
		<caption>Quản lý thành viên</caption>
		<thead>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Địa chỉ</th>
				<th>Họ tên</th>
				<th>Giới tính</th>
				<th>Phone</th>
				<th>Level</th>
				<th>Sửa</th>
				<th>Xóa</th>
				<th>Xem</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				if (mysql_num_rows($result) > 0) {
				while ($r = mysql_fetch_assoc($result)) {
					$g = $r['gioitinh'];
					if ($g == 1) {
						$gt = "Nam";
					} else {
						$gt = "Nữ";
					}
					$lv = $r['user_level'];
					if ($lv == 1) {
						$leve = "admin";
					} else {
						$leve = "user";
					}
					echo "<tr>";
						echo "<td>".$r['user_id']."</td>";
						echo "<td>".$r['user_name']."</td>";
						echo "<td>".$r['diachi'].", ".$r['thanhpho']."</td>";
						echo "<td>".$r['hoten']."</td>";
						echo "<td>".$gt."</td>";
						echo "<td>".$r['phone']."</td>";
						echo "<td>".$leve."</td>";
						echo "<td class='sua'><a href='edit_user.php?do={$r['user_id']}'><center><img src='./style/images/edit.png'></center></a></td>";
						echo "<td class='xoa'><a href='del_user.php?do={$r['user_id']}' onClick=\"return confirm('Bạn có muốn xóa || $r[user_name] || không?')\"><center><img src='./style/images/delete.png'></center></a></td>";
						echo "<td class='xem'><a href='xem_user.php?do={$r['user_id']}'><center><img src='./style/images/view.gif'></center></a></td>";
					echo "</tr>";
				}// end while
			}// end IF num_rows
			 ?>
		</tbody>
	</table>
	<?php include("../includes/phantrang2.php"); ?>
</div><!-- end noidung -->
<?php 
} else {
	//Neu admin chua login
	echo "<script>window.location.href='login.php'</script>";
}
 ?>
<?php include("../includes/footer.php"); ?>