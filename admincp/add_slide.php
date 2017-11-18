<?php session_start(); ?>
<meta charset="utf-8">
<?php 
	$title = "Thêm Slideshow"; 
	require_once("../includes/connect.php");
	include("../includes/function.php");
	include("../includes/header-admin.php");
	include("../includes/sidebar-admin.php");
 ?>
<div class="noidung">
<?php 
	// Kiểm tra có phải là Admin không?
	if (is_admin())
	{
		$errors = array();
		if (isset($_POST['oke'])) {
			// Kiem tra error Form
			if (empty($_POST['txtLink'])) {
				$errors[] = "txtLink";
			} elseif (!preg_match('/^(http:\/\/+)/i', $_POST['txtLink'])) {
					$errors[] = "wrong_link";
				} elseif (strlen($_POST['txtLink']) < 10) {
					$errors[] = "len_link";
				} else {
				$txtLink = mysql_real_escape_string(trim($_POST['txtLink']));
			}// end Link

			if (empty($errors)) {
				//Kiem tra trung lap
				$s3 = "SELECT * FROM slideshow WHERE slide_link = '$txtLink'";
				$q3 = mysql_query($s3) or die("Không thể chọn được CSDL !");

				if (mysql_num_rows($q3) == 1) {
					$errors[] = "trung_link";
				} else {
				// xu ly hinh anh
				$image = $_FILES["hinhanh"]["name"];
				if ($image != "") {// da chọn anh
					// kiem tra su ton tai cua hinh anh
					if (file_exists("../style/slide_img/img/" . $_FILES["hinhanh"]["name"])) {
						echo $_FILES["hinhanh"]["name"] . " Đã tồn tại !";
						die();
					}

				} else {
					//header("location: add_slide.php");
					echo "<script>alert('Bạn chưa chọn hình ảnh !')</script>";
					die();
				}		
					//Khong con error thi INSERT
					$s = "INSERT INTO Slideshow (slide_img, slide_link) 
						VALUES ('$image', '$txtLink')";
					$q = mysql_query($s);

					if (mysql_affected_rows($dbc) == 1) {
						// Upload image
						move_uploaded_file($_FILES["hinhanh"]["tmp_name"], "../style/slide_img/img/".$_FILES["hinhanh"]["name"]);
						echo "<script>alert('Đã thêm thành công.')</script>";
						echo "<script>window.location.href='ql_slide.php'</script>";
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
		<h2>Tạo slideShow mới</h2>
		<form action="" method="post" enctype="multipart/form-data">
			<fieldset>
				<legend>Thêm SlideShow</legend>
				<?php if(!empty($mess)) echo $mess; ?>
				<div>
					<label>Hình ảnh:</label>
					<input type="file" name="hinhanh" value="Browser">
				</div>
				<div>
					<label>Link:</label>
					<input type="text" name="txtLink" value='<?php saveValue('txtLink'); ?>' placeholder="Nhập link cho hình ảnh">
					<?php checkError($errors, 'txtLink', '<span class=warning>Bạn chưa nhập link !</span>'); ?>
					<?php checkError($errors, 'wrong_link', '<span class=warning>Link phải bắt đầu bằng http:// </span>'); ?>
					<?php checkError($errors, 'len_link', '<span class=warning>Độ dài của link phải lớn hơn 10 ký tự !</span>'); ?>

					<?php checkError($errors, 'trung_link', '<span class=warning>Link đã tồn tại !</span>'); ?>
				</div>

				<div>
					<input type="submit" name="oke" value="Thêm">
				</div>
			</fieldset>
		</form>
    </div>
</div><!-- end noidung -->
<?php
//Nếu không phải Admin thì chuyển hướng về Index. 
	} else {
		echo "<script>window.location.href='login.php'</script>";
	}
 ?>
<?php include("../includes/footer.php"); ?>


