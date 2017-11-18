<?php session_start(); ?>
<?php
	$title = "Thêm danh mục"; 
	require_once("../includes/connect.php");
	include("../includes/function.php");
	include("../includes/header-admin.php");
	include("../includes/sidebar-admin.php");
 ?>

<div class="noidung">
	<?php 
	// Kiểm tra có phải là Admin không?
	if (is_admin())
	{// admin da login
		$errors = array();
		if (isset($_POST['oke'])) {
			// Kiem tra error Form
			if (empty($_POST['txtDanhmuc'])) {
				$errors[] = "danhmuc";
			} else {
				$txtDanhmuc = mysql_real_escape_string(strip_tags($_POST['txtDanhmuc']));
			}

			if (empty($errors)) {
				//Kiem tra trung lap
				$s3 = "SELECT * FROM danhmuc WHERE dmuc_name = '$txtDanhmuc'";
				$q3 = mysql_query($s3) or die("Cannot select table");

				if (mysql_num_rows($q3) == 1) {
					$errors[] = "trung_danh_muc";
				} else {		
					//Khong con error thi INSERT
					$s = "INSERT INTO danhmuc (dmuc_name) VALUES ('$txtDanhmuc')";
					$q = mysql_query($s);

					if (mysql_affected_rows($dbc) == 1) {
						echo "<script>alert('Đã thêm thành công.')</script>";
						echo "<script>window.location.href='ql_dmuc.php'</script>";
					} else {
						$mess = "<span class='error'>Không thể thêm !</span>";
					}// end IF INSERT
				}// end kiem tra trung
			} else {
				$mess = "<span class='error'>Bạn chưa điền đầy đủ thông tin</span>";
			}// end IF ERRORS


		}// End ISSET
	 ?>
	<div>
		<h2>Tạo danh mục mới</h2>
		<form action="" method="post" accept-charset="utf-8">
			<fieldset>
				<legend>Thêm danh mục</legend>
				<?php if(!empty($mess)) echo $mess; ?>
					<div>
					<label>Tên danh mục:</label>
					<input type="text" name="txtDanhmuc" value="" placeholder="Nhập tên danh mục">
					<?php checkError($errors, 'danhmuc', '<span class=warning>Bạn chưa nhập tên danh mục !</span>'); ?>
					<?php checkError($errors, 'trung_danh_muc', '<span class=warning>Danh mục này đã tồn tại !</span>'); ?>
				</div>
				<div>
					<input type="submit" name="oke" value="Thêm">
				</div>
			</fieldset>
		</form>
    </div>
</div><!-- end noidung -->
<?php 
	} else {
	//Nếu không phải Admin thì chuyển hướng về Index.
		echo "<script>window.location.href='login.php'</script>";
	}
 ?>
<?php include("../includes/footer.php"); ?>


