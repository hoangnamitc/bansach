<?php session_start(); ?>
<?php
	$title = "Quản lý giới thiệu"; 
	require_once("../includes/connect.php");
	include("../includes/function.php");
	include("../includes/header-admin.php");
	include("../includes/sidebar-admin.php");
 ?>
	<style type="text/css">
		* {
			padding: 0; 
			margin: 0;
			float: none;
		}

	</style>
<div class="noidung">
<?php 
	// Kiểm tra có phải là Admin không?
	if (is_admin())
	{// admin da login
	//Check form
	$errors = array();
	if (isset($_POST['submit'])) {
		
		if (empty($_POST['txtTieuDe'])) {
			$errors[] = "null_tieude";
		} else {
			$txtTieuDe = checkData($_POST['txtTieuDe']);
		}
		if (empty($_POST['txtNoiDungGT'])) {
			$errors[] = "null_noidung";
		} else {
			$txtNoiDungGT = checkData($_POST['txtNoiDungGT']);
		}

		if (empty($errors)) {
			$chen = mysql_query("INSERT INTO gioithieu (gt_tieude, gt_noidung) VALUES ('$txtTieuDe', '$txtNoiDungGT')");
			if (mysql_affected_rows($dbc) == 1) {
				echo "<script>alert('Thành công !')</script>";
				echo "<script>window.location.href='ql_gioithieu.php'</script>";
			} else {
				echo "<script>alert('Thất bại !')</script>";
				echo "<script>window.location.href='ql_gioithieu.php'</script>";
			}
		}
	}

	$chec = mysql_num_rows(mysql_query("SELECT * FROM gioithieu"));
	if ($chec == NULL) {
?>
	<form action="" method="post">
		<fieldset>
			<legend>Giới thiệu</legend>
			<div>
				<label>Tiêu đề</label>
				<input type="text" name="txtTieuDe" value="" placeholder="Nhập tiêu đề">
				<?php checkError($errors, 'null_tieude', '<span class="warning">Bạn chưa nhập tiêu đề !</span>'); ?>
			</div>
			<div>
				<label>Nội dung:</label>
				<?php checkError($errors, 'null_noidung', '<span class="warning">Bạn chưa nhập nội dung !</span>'); ?>
				<textarea name="txtNoiDungGT"></textarea>

			</div>
			<div>
				<input type="submit" name="submit" value="Gửi">
			</div>
		</fieldset>
	</form>
<?php 
} else {
 ?>
 <table>
 	<h2 style="padding:10px;">GIỚI THIỆU</h2>
 	<thead>
 		<tr>
 			<th>Tiêu đề</th>
 			<th>Nội dung</th>
 			<th>Sửa</th>
 			<th>Xóa</th>
 		</tr>
 	</thead>
 	<tbody>
 <?php 
 		$gt = mysql_query("SELECT * FROM gioithieu");
 		while ($rows = mysql_fetch_assoc($gt)) {
 			$subcomment = short_text($rows['gt_noidung']);
 			echo "<tr>";
 				echo "<td>".$rows['gt_tieude']."</td>";
 				echo "<td>".$subcomment."...</td>";
 				echo "<td><a href='edit_gioithieu.php?do=$rows[gt_id]'><img src='./style/images/edit.png'></a></td>";
				echo "<td><a href='del_gioithieu.php?do=$rows[gt_id]' onClick=\"return confirm('Bạn có muốn xóa || $rows[gt_tieude] || không?')\"><img src='./style/images/delete.png'></a></td>";
 			echo "</tr>";
 		}

  ?>
 	</tbody>
 </table>

<?php 
}
} else {
//Nếu không phải Admin thì chuyển hướng về Index.
	echo "<script>window.location.href='login.php'</script>";
}
 ?>
</div><!-- end noidung -->
<?php include("../includes/footer.php"); ?>
