<?php session_start(); ?>
<?php 
	$title = "Quản lý liên hệ";
	require_once("../includes/connect.php");
	include("../includes/function.php");
	include("../includes/header-admin.php");
	include("../includes/sidebar-admin.php");
 ?>
<div class="noidung">
<?php 
//Kiểm tra có phải Admin không ?
if (is_admin())
{
		$tableName="lienhe";// Ten Table		
		$targetpage = "ql_lienhe.php"; // Ten trang dang dc dung phan trang
		$limit = 5;// So hang hien thi cua du lieu
		include("../includes/phantrang1.php");
	 ?>
	<table border='1' cellspacing='0' cellpadding='5'>
		<caption>Quản lý liên hệ</caption>
		<thead>
			<tr>
				<th>Người gửi</th>
				<th>Email</th>
				<th>Nội dung</th>
				<th>Xem</th>
				<th>Xóa</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				if (mysql_num_rows($result) > 0) {
				while ($r = mysql_fetch_assoc($result)) {
					$subcomment = substr($r['lhe_comment'], 0, 300);
					$comment = short_text($subcomment);
					echo "<tr>";
						echo "<td>".$r['lhe_name']."</td>";
						echo "<td>".$r['lhe_email']."</td>";
						echo "<td>".$comment." ... <a href='xem_lienhe.php?do={$r['lhe_id']}' title='Xem chi tiết'>Read more</a></td>";
						echo "<td class='xem'><a href='xem_lienhe.php?do={$r['lhe_id']}'><img src='./style/images/view.gif'></a></td>";echo "<td class='xoa'><a href='del_lienhe.php?do={$r['lhe_id']}' onClick=\"return confirm('Bạn có muốn xóa thư của || $r[lhe_name] ||  không?')\"><img src='./style/images/delete.png'></a></td>";
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


