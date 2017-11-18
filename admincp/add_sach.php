<?php session_start(); ?>
<?php 
	$title = "Thêm sách"; 
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
			if (empty($_POST['txtSachname'])) {
				$errors[] = "txtsachname";
			} else {
				$txtSachname = checkData($_POST['txtSachname']);
			}// end check txtSachname

			if (empty($_POST['txtTacgia'])) {
				$errors[] = "txttacgia";
			} else {
				$txttacgia = checkData($_POST['txtTacgia']);
			}// end check txtTacgia

			if (empty($_POST['txtNxb'])) {
				$errors[] = "txtnxb";
			} else {
				$txtnxb = checkData($_POST['txtNxb']);
			}// end check txtNXB

			if (empty($_POST['txtSoluong'])) {
				$errors[] = "txtsoluong";
			} elseif (!is_numeric($_POST['txtSoluong']) || $_POST['txtSoluong'] < 0) {
				$errors[] = "txtsoluong_int";
			} else {
				$txtSoluong = checkData($_POST['txtSoluong']);
			}// end check txtSoluong

			if (empty($_POST['txtDongia'])) {
				$errors[] = "txtdongia";
			} elseif (!is_numeric($_POST['txtDongia']) || $_POST['txtDongia'] < 0) {
				$errors[] = "txtdongia_int";
			} else {
				$txtDongia = checkData($_POST['txtDongia']);
			}// end check txtDongia

			if (!empty($_POST['txtSotrang'])) {
				if (!is_numeric($_POST['txtSotrang']) || $_POST['txtSotrang'] < 0) {
					$errors[] = "txtSotrang";
				} else {
					$txtSotrang = checkData($_POST['txtSotrang']);
				}
			}// end txtSotrang

			if (!empty($_POST['txtGiamgia'])) {
				if (!is_numeric($_POST['txtGiamgia']) || $_POST['txtGiamgia'] < 0) {
					$errors[] = "txtGiamgia";
				} else {
					$txtGiamgia = checkData($_POST['txtGiamgia']);
				}
			} else {
				$txtGiamgia = checkData($_POST['txtGiamgia']);
			}// end txtGiamgia

			if (empty($errors)) {
				//khong con Error -> kiem tra ton tai
				$c = "SELECT sach_name FROM sach WHERE sach_name = '$txtSachname'";
				$cq = mysql_query($c) or die("Không thể kiểm tra dữ liệu !");

				if (mysql_num_rows($cq) == 1) {
					//Du lieu da ton tai -> bao loi ra trinh duyet
					$errors[] = "txtsachname_trung";
				} else {
					//Du lieu khong ton tai -> xu ly hinh anh
					// xu ly hinh anh
					$image = $_FILES["hinhanh"]["name"];
					if ($image != "") {// da chọn anh
						// kiem tra su ton tai cua hinh anh
						if (file_exists("../style/images/img_sach/" . $_FILES["hinhanh"]["name"])) {
							echo $_FILES["hinhanh"]["name"] . " Đã tồn tại !";
							die();
						}

					} else {
						echo "Bạn chưa chọn hình ảnh !";
						die();
					}
					// Get data tu form
					$danhmuc = checkData($_POST['danhmuc']);
					$txtLoaibia = checkData($_POST['txtLoaibia']);
					$txtGioithieu = mysql_real_escape_string($_POST['txtGioithieu']);

					// Chen du lieu vao CSDL
					$s = "INSERT INTO sach (
											dmuc_id, 
											sach_name, 
											tacgia, 
											nxb, 
											soluong, 
											dongia, 
											sotrang, 
											loaibia, 
											giamgia, 
											gioithieu, 
											hinhanh, 
											post_date
											)"; 
					$s .= "	VALUES (
									'$danhmuc', 
									'$txtSachname', 
									'$txttacgia', 
									'$txtnxb', 
									'$txtSoluong', 
									'$txtDongia', 
									'$txtSotrang', 
									'$txtLoaibia', 
									'$txtGiamgia', 
									'$txtGioithieu', 
									'$image', 
									NOW()
									)";

					$q = mysql_query($s) or die("Không thể thêm dữ liệu !");

					if (mysql_affected_rows($dbc) == 1) {
						// Upload image
						move_uploaded_file($_FILES["hinhanh"]["tmp_name"], "../style/images/img_sach/".$_FILES["hinhanh"]["name"]);
						echo "<script>alert('Đã thêm thành công.')</script>";
						echo "<script>window.location.href='ql_sach.php'</script>";
					} else {
						$mess = "<span class='error'>Không thể thêm !</span>";
					}// end IF INSERT
				}// end IF kiem tra ton tai

			} else {
				$mess = "<span class='error'>Bạn chưa nhập đầy đủ dữ liệu !</span>";
			}// end IF errors


		}// End ISSET
	 ?>
	<div>
		<h2>Thêm sách mới</h2>
		<!-- FORM -->
		<form action="" method="post" enctype="multipart/form-data">
			<fieldset>
				<legend>Thêm Sách</legend>
				<!-- Hien thong bao error neu co -->
				<?php if (!empty($mess)) echo $mess; ?>
				<div>
					<label>Danh mục: </label>
					<select name="danhmuc">
						<?php 
							$dm = mysql_query("SELECT * FROM danhmuc");
							if (mysql_num_rows($dm) > 0) {
								while ($r = mysql_fetch_assoc($dm)) {
									echo "<option value='".$r['dmuc_id']."'>".$r['dmuc_name']."</option>";
								}
							}
						 ?>
					</select>
				</div>
				<div>
					<label>Tên sách: <span class='required'>*</span></label>
					<input type="text" name="txtSachname" value='<?php saveValue('txtSachname');?>' placeholder="Nhập tên sách">
					<?php 
						//Thong bao loi ra cho nguoi dung
						checkError($errors, 'txtsachname', '<span class="warning">Bạn chưa nhập tên sách !</span>');
						checkError($errors, 'txtsachname_trung', '<span class="warning">Tên sách đã tồn tại !</span>');

					 ?>
				</div>
				<div>
					<label>Tác giả: <span class='required'>*</span></label>
					<input type="text" name="txtTacgia" value='<?php saveValue('txtTacgia');?>' placeholder="Nhập tác giả">
					<?php 
						checkError($errors, 'txttacgia', '<span class="warning">Bạn chưa nhập tên tác giả !</span>');
					 ?>
				</div>
				<div>
					<label>Nhà xuất bản: <span class='required'>*</span></label>
					<input type="text" name="txtNxb" value='<?php saveValue('txtNxb');?>' placeholder="Nhập tên nhà xuất bản">
					<?php checkError($errors, 'txtnxb', '<span class="warning">Bạn chưa nhập tên nhà xuất bản !</span>'); ?>
				</div>
				<div>
					<label>Số lượng: <span class='required'>*</span></label>
					<input type="text" name="txtSoluong" value='<?php saveValue('txtSoluong');?>' placeholder="Nhập số lượng">
					<?php 
						//Thong bao loi ra cho nguoi dung
						checkError($errors, 'txtsoluong', '<span class="warning">Bạn chưa nhập số lượng !</span>'); 
						checkError($errors, 'txtsoluong_int', '<span class="warning">Số lượng không hợp lệ, vui lòng thử lại !</span>'); 

					?>
				</div>
				<div>
					<label>Giá bán: <span class='required'>*</span></label>
					<input type="text" name="txtDongia" value='<?php saveValue('txtDongia');?>' placeholder="Nhập đơn giá">đ
					<?php 
						//Thong bao loi ra cho nguoi dung
						checkError($errors, 'txtdongia', '<span class="warning">Bạn chưa nhập giá bán !</span>'); 
						checkError($errors, 'txtdongia_int', '<span class="warning">Giá bán không hợp lệ, vui lòng thử lại !</span>'); 

					?>
				</div>
				<div>
					<label>Số trang:</label>
					<input type="text" name="txtSotrang" value='<?php saveValue('txtSotrang');?>' placeholder="Nhập số trang của sách">
					<?php checkError($errors, 'txtSotrang', '<span class="warning">Số trang không hợp lệ !</span>'); ?>
				</div>
				<div>
					<label>Loại bìa:</label>
					<select name="txtLoaibia">
						<option value="mềm">mềm</option>
						<option value="cứng">cứng</option>
					</select>
				</div>
				<div>
					<label>Giảm giá:</label>
					<input type="text" name="txtGiamgia" value='<?php saveValue('txtGiamgia');?>' placeholder="Số % giảm cho sách"> % 
					<?php checkError($errors, 'txtGiamgia', '<span class="warning">Giá giảm không hợp lệ !</span>'); ?>
				</div>
				<div>
					<label>Giới thiệu: </label>
					<textarea name="txtGioithieu" rows="5" cols="20" style="height: 91px; width: 320px;"></textarea>
				</div>
				<div>
					<label>Hình ảnh:</label>
					<input type="file" name="hinhanh" value="Brows">
				</div>
				<div>
					<input type="submit" name="oke" value="Thêm">
				</div>
			</fieldset>
		</form>
    </div>
</div><!-- end noidung -->
<?php } else {
	////Nếu không phải Admin thì chuyển hướng về Index.
	echo "<script>window.location.href='login.php'</script>";
} ?>
<?php include("../includes/footer.php"); ?>


