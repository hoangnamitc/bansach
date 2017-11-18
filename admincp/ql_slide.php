<?php session_start(); ?>
<?php 
	$title = "Quản lý SlideShow";
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
		$tableName="slideshow";// Ten Table		
		$targetpage = "ql_slide.php"; // Ten trang dang dc dung phan trang
		$limit = 5;// So hang hien thi cua du lieu
		include("../includes/phantrang1.php");
	 ?>
	<table border='1' cellspacing='0' cellpadding='5'>
		<caption>Quản lý SlideShow</caption>
		<thead>
			<tr>
				<th>ID</th>
				<th>Hình ảnh</th>
				<th>Link</th>
				<th>Xóa</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			echo "<tr>
				<td colspan='5'><a href='add_slide.php'>
				<center><img src='./style/images/add-2.png'></center> </a></td>
				</tr>";
				if (mysql_num_rows($result) > 0) {
				while ($r = mysql_fetch_assoc($result)) {
					echo "<tr>";
						echo "<td>".$r['slide_id']."</td>";
						echo "<td><img src='../style/slide_img/img/".$r['slide_img']."' style='width:100px;height:100px;'></td>";
						echo "<td>".$r['slide_link']."</td>";
						echo "<td class='xoa'><a href='del_slide.php?do={$r['slide_id']}' onClick=\"return confirm('Bạn có muốn xóa không?')\"><img src='./style/images/delete.png'></a></td>";
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
	//Nếu không phải Admin thì chuyển hướng về Index.
	echo "<script>window.location.href='login.php'</script>";
}
 ?>
<?php include("../includes/footer.php"); ?>


