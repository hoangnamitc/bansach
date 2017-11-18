<?php session_start(); ?>
<?php
	$title = "Quản lý sách"; 
	require_once("../includes/connect.php");
	include("../includes/function.php");
	include("../includes/header-admin.php");
	include("../includes/sidebar-admin.php");
 ?>
<div class="noidung">
<?php
//Kiểm tra có phải Admin không?
if (is_admin())
{
		$tableName = " sach, danhmuc WHERE sach.dmuc_id = danhmuc.dmuc_id ";
		$tableName .= " ORDER BY sach_id DESC ";
		$targetpage = "ql_sach.php"; // Ten trang dang dc dung phan trang
		$limit = 10;// So hang hien thi cua du lieu
		include("../includes/phantrang1.php");
	 ?>
	<table border='1' cellspacing='0' cellpadding='5'>
		<caption>Quản lý sách</caption>
		<thead>
			<tr>
				<th>ID</th>
				<th>Tên sách</th>
				<th>T.giả</th>
				<th>S.lượng</th>
				<th>Giá</th>
				<th>giảm giá</th>
				<th>Sửa</th>
				<th>Xóa</th>
				<th>Xem</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				if (mysql_num_rows($result) > 0) {
				while ($r = mysql_fetch_assoc($result)) {
					echo "<tr>";
						echo "<td>".$r['sach_id']."</td>";
						echo "<td>".$r['sach_name']."</td>";
						echo "<td>".$r['tacgia']."</td>";
						echo "<td>".$r['soluong']." cuốn</td>";
						echo "<td>".$r['dongia']."đ</td>";
						echo "<td>".$r['giamgia']."%</td>";
						echo "<td class='sua'><a href='edit_sach.php?do={$r['sach_id']}'><img src='./style/images/edit.png'></a></td>";
						echo "<td class='xoa'><a href='del_sach.php?do={$r['sach_id']}' onClick=\"return confirm('Bạn có muốn xóa || $r[sach_name] || không?')\"><img src='./style/images/delete.png'></a></td>";
						echo "<td class='xem'><a href='xem_sach.php?do={$r['sach_id']}'><img src='./style/images/view.gif'></a></td>";
					echo "</tr>";
				}// end while
			} else {
				echo "Không có dữ liệu !";
			}// end IF num_rows
			 ?>
		</tbody>
	</table>
	<?php include("../includes/phantrang2.php"); ?>
</div><!-- end noidung -->
<?php 
} else {
	//Nếu không phải Admin thì chuyển hướng về Index.
	echo "<script>window.location.href='login.php'</script>";
}
 ?>
<?php include("../includes/footer.php"); ?>