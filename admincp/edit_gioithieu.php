<?php session_start(); ?>
<?php 
	$title = "Chỉnh sửa giới thiệu"; 
	require_once("../includes/connect.php");
	include("../includes/function.php");
	include("../includes/header-admin.php");
	include("../includes/sidebar-admin.php");
 ?>
<div class="noidung">
<?php 
//Kiểm tra có phải là Admin không?
if (is_admin())
{	
		$errors = array();
		// Hien thi du lieu ra textbox
		if (!isset($_POST['oke'])) {
			if ($edit = validate_id($_GET['do'])) {
	
				$s = "SELECT * FROM gioithieu WHERE gt_id = '$edit' LIMIT 1";
				$q = mysql_query($s) or die("Không thể chọn giới thiệu");
				if (mysql_num_rows($q) > 0) {
					$r = mysql_fetch_assoc($q);
				} else {
					echo "Không có dữ liệu !";
				}
			} else {// Nếu ID không hợp lệ thì chuyển hướng về Index.
				echo "<script>window.location.href='ql_gioithieu.php'</script>";
			}	
		}// End ISSET

		//KIEM TRA FORM VA CHEN DU LIEU
		if (isset($_POST['update'])) {
			//Check form
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
			$id = $_POST['ID'];
			if (empty($errors)) {
					
					//Update data
					$s3 = "UPDATE gioithieu SET gt_tieude='$txtTieuDe', gt_noidung='$txtNoiDungGT' WHERE gt_id = '$id' LIMIT 1";
					$q3 = mysql_query($s3) or die("Không thể cập nhật!");
					if (mysql_affected_rows($dbc) == 1) {
						echo "<script>alert('Cập nhật thành công !')</script>";
						echo "<script>window.location.href='ql_gioithieu.php'</script>";
					} else {
						$mess = "<span class='error'>Cập nhật thất bại !</span>";
					}
			}
		}// End ISSET2
	 ?>
	<div>
		<h2>Chỉnh sửa danh mục</h2>
		<?php if(!empty($mess)) echo $mess; ?>
		<form action="" method="post">
		<fieldset>
			<legend>Giới thiệu</legend>
			<input type="hidden" name="ID" value="<?php if(isset($edit)) {echo $edit;} ?>">
			<div>
				<label>Tiêu đề</label>
				<input type="text" name="txtTieuDe" value="<?php if(isset($r['gt_tieude'])) {echo $r['gt_tieude'];} ?>">
				<?php checkError($errors, 'null_tieude', '<span class="warning">Bạn chưa nhập tiêu đề !</span>'); ?>
			</div>
			<div>
				<label>Nội dung:</label>
				<?php checkError($errors, 'null_noidung', '<span class="warning">Bạn chưa nhập nội dung !</span>'); ?>
				<textarea name="txtNoiDungGT"><?php if(isset($r['gt_noidung'])) {echo $r['gt_noidung'];} ?></textarea>

			</div>
			<div>
				<input type="submit" name="update" value="Cập nhật">
			</div>
		</fieldset>
	</form>
    </div>
</div><!-- end noidung -->
<?php 
} else {
	//Nếu không phải là Admin thì chuyển hướng về Index.
	echo "<script>window.location.href='login.php'</script>";
}
 ?>
<?php include("../includes/footer.php"); ?>