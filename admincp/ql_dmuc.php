<?php session_start(); ?>
<?php 
	$title = "Quản lý danh mục"; 
	require_once("../includes/connect.php");
	include("../includes/function.php");
	include("../includes/header-admin.php");
	include("../includes/sidebar-admin.php");
 ?>
<div class="noidung">
<?php 
//Kiểm tra có phải là Admin không ?
if (is_admin())
{
		$tableName="danhmuc ORDER BY dmuc_id DESC ";// Ten Table		
		$targetpage = "ql_dmuc.php"; // Ten trang dang dc dung phan trang
		$limit = 5;// So hang hien thi cua du lieu
		include("../includes/phantrang1.php");
	 ?>
	<table border='1' cellspacing='0' cellpadding='5'>
		<caption>Quản lý danh mục</caption>
		<thead>
			<tr>
				<th>ID</th>
				<th>Tên danh mục</th>
				<th>Sửa</th>
				<th>Xóa</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				if (mysql_num_rows($result) > 0) {
				while ($r = mysql_fetch_assoc($result)) {
					echo "<tr>";
						echo "<td>".$r['dmuc_id']."</td>";
						echo "<td>".$r['dmuc_name']."</td>";
						echo "<td class='sua'><a href='edit_dmuc.php?do={$r['dmuc_id']}'><img src='./style/images/edit.png'></a></td>";
						echo "<td class='xoa'><a href='del_dmuc.php?do={$r['dmuc_id']}' onClick=\"return confirm('Bạn có muốn xóa || $r[dmuc_name] || không?')\"><img src='./style/images/delete.png'></a></td>";
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
	//Nếu không phải là Admin thì chuyển hướng về Index.
	echo "<script>window.location.href='login.php'</script>";
}
 ?>
<?php include("../includes/footer.php"); ?>


