<?php session_start(); ?>
<?php 
	$title = "Chỉnh sửa danh mục"; 
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
	
				$s = "SELECT * FROM danhmuc WHERE dmuc_id='$edit' LIMIT 1";
				$q = mysql_query($s) or die("Không thể chọn danh mục");
				if (mysql_num_rows($q) > 0) {
					$r = mysql_fetch_assoc($q);
				} else {
					echo "Không có dữ liệu !";
				}
			} else {// Nếu ID không hợp lệ thì chuyển hướng về Index.
				echo "<script>window.location.href='index.php'</script>";
			}	
		}// End ISSET

		//KIEM TRA FORM VA CHEN DU LIEU
		if (isset($_POST['oke'])) {
			//Check form
			if (empty($_POST['txtDanhmuc'])) {
				$errors[] = "danhmuc";
			} else {
				$txtDanhmuc = checkData($_POST['txtDanhmuc']);
			}

			if (empty($errors)) {
				//check exists
				$s2 = "SELECT dmuc_name FROM danhmuc WHERE dmuc_name='$txtDanhmuc'";
				$q2 = mysql_query($s2) or die("không thể kiểm tra");
				if (mysql_num_rows($q2) == NULL) {// Nếu ko trùng dữ liệu trong CSDL thì chạy cmd insert.

					//Update data
					$id = checkData($_POST['txtid']);
					$s3 = "UPDATE danhmuc SET dmuc_name='$txtDanhmuc' WHERE dmuc_id='$id' LIMIT 1";
					$q3 = mysql_query($s3) or die("Không thể cập nhật!");
					if (mysql_affected_rows($dbc) == 1) {
						echo "<script>alert('Cập nhật thành công !')</script>";
						echo "<script>window.location.href='ql_dmuc.php'</script>";
					} else {
						$mess = "<span class='error'>Cập nhật thất bại !</span>";
					}
				} else {
					$errors[] = "trung_danh_muc";
				}
			}
		}// End ISSET2
	 ?>
	<div>
		<h2>Chỉnh sửa danh mục</h2>
		<form action="" method="post" accept-charset="utf-8">
			<fieldset>
				<legend>Sửa danh mục</legend>
				<?php if(!empty($mess)) echo $mess; ?>
					<input type="hidden" name="txtid" value=<?php if(isset($edit)) echo $r['dmuc_id'] ?>>
					<div>
						<label>ID:</label>
						<input type="text" name="" value='<?php if(isset($edit)) echo $r['dmuc_id'] ?>' disabled>
					</div>
					<div>
					<label>Tên danh mục:</label>
					<input type="text" name="txtDanhmuc" value='<?php if(isset($edit)) echo $r['dmuc_name'] ?>' placeholder="Nhập tên danh mục">
					<?php checkError($errors, 'danhmuc', '<span class=warning>Bạn chưa nhập tên danh mục !</span>'); ?>
					<?php checkError($errors, 'trung_danh_muc', '<span class=warning>Danh mục này đã tồn tại !</span>'); ?>
				</div>
				<div>
					<input type="submit" name="oke" value="Cập nhật">
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