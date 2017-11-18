<?php session_start(); ?>
<?php 
	$title = "Chỉnh sửa sách"; 
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
		//GET DATA VAO FORM
		if (!isset($_POST['oke'])) {
			if ($edit = validate_id($_GET['do'])) {
				
				$sql = "SELECT * FROM sach WHERE sach_id = '$edit'";
				$queri = mysql_query($sql) or die("Không thể lấy thông tin sản phẩm");
				if (mysql_num_rows($queri) > 0) {
					$rau = mysql_fetch_assoc($queri);
				}
			} else {// Nếu ID không hợp lệ thì chuyển hướng về Index.
				echo "<script>window.location.href='index.php'</script>";
			}//End ID	
		}// End Submit

		//Check form va cap nhat thong tin cho Sach
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
				$txtTacgia = checkData($_POST['txtTacgia']);
			}// end check txtTacgia

			if (empty($_POST['txtNxb'])) {
				$errors[] = "txtnxb";
			} else {
				$txtNxb = checkData($_POST['txtNxb']);
			}// end check txtNXB

			if (empty($_POST['txtSoluong'])) {
				$errors[] = "txtsoluong";
			} elseif (!is_numeric($_POST['txtSoluong'])) {
				$errors[] = "txtsoluong_int";
			} else {
				$txtSoluong = checkData($_POST['txtSoluong']);
			}// end check txtSoluong

			if (empty($_POST['txtDongia'])) {
				$errors[] = "txtdongia";
			} elseif (!is_numeric($_POST['txtDongia'])) {
				$errors[] = "txtdongia_int";
			} else {
				$txtDongia = checkData($_POST['txtDongia']);
			}// end check txtDongia

			if (!empty($_POST['txtSotrang'])) {
				if (!is_numeric($_POST['txtSotrang'])) {
					$errors[] = "txtSotrang";
				} else {
					$txtSotrang = checkData($_POST['txtSotrang']);
				}
			}// End So trang

			if (!empty($_POST['txtGiamgia'])) {
				if (!is_numeric($_POST['txtGiamgia'])) {
					$errors[] = "txtGiamgia";
				} else {
					$txtGiamgia = checkData($_POST['txtGiamgia']);
				}
			}// End So trang

			if (empty($_POST['txtGioithieu'])) {
				$errors[] = "txtgioithieu";
			} else {
				$txtGioithieu = trim($_POST['txtGioithieu']);
			}// end check txtGioithieu


			if (empty($errors)) {
				//khong con Error -> kiem tra ton tai
				$c = "SELECT sach_name FROM sach WHERE sach_name = '$txtSachname'";
				$cq = mysql_query($c) or die("Không thể kiểm tra dữ liệu !");

				if (mysql_num_rows($cq) == 1) {
					//Dữ liệu tồn tại trong CSDL thì báo lỗi ra.
					$errors[] = "txtsachname_trung";
				} else {
					//Du lieu khong ton tai
					//
					// Get data tu form
					$danhmuc = checkData($_POST['danhmuc']);
					$txtLoaibia = $_POST['txtLoaibia'];
					$id = checkData($_POST['id']);

					// Cap nhat du lieu vao CSDL
					$s = "UPDATE sach SET 
										dmuc_id   = '$danhmuc', 
										sach_name = '$txtSachname', 
										tacgia    = '$txtTacgia', 
										nxb       = '$txtNxb', 
										soluong   = '$txtSoluong', 
										dongia    = '$txtDongia', 
										sotrang   = '$txtSotrang', 
										loaibia   = '$txtLoaibia', 
										giamgia   = '$txtGiamgia', 
										gioithieu = '$txtGioithieu' 
										WHERE sach_id = '$id' LIMIT 1"; 

					$q = mysql_query($s) or die("SAI SQL");

					if (mysql_affected_rows($dbc) == 1) {
						echo "<script>alert('Cập nhật thành công !')</script>";
						echo "<script>window.location.href='ql_sach.php'</script>";
					} else {
						$mess = "<span class='error'>Không thể cập nhật !</span>";
					}// end IF INSERT
				}// end IF kiem tra ton tai

			} else {
				$mess = "<span class='error'>Bạn chưa nhập đầy đủ dữ liệu !</span>";
			}// end IF errors


		}// End ISSET
	 ?>
	<div>
		<h2>Sửa thông tin Sách</h2>
		<!-- FORM -->
		<form action="" method="post" enctype="multipart/form-data">
			<fieldset>
				<legend>Thông tin của: </legend>
				<!-- Hien thong bao error neu co -->
				<?php if (!empty($mess)) echo $mess; ?>
				<input type="hidden" name="id" value='<?php if(isset($edit)) echo $edit; ?>'>
				<div>
					<label>Danh mục: </label>
					<select name="danhmuc">
						<?php 
							$dm = mysql_query("SELECT * FROM danhmuc");
							if (mysql_num_rows($dm) > 0) {
								while ($r = mysql_fetch_assoc($dm)) {
									echo "<option value='".$r['dmuc_id']."'";
										if (isset($rau['dmuc_id']) && $r['dmuc_id'] == $rau['dmuc_id']) {
											echo "selected = 'selected'";
										}
									echo ">".$r['dmuc_name']."</option>";
								}
							}
						 ?>
					</select>
				</div>
				<div>
					<label>Tên sách: <span class='required'>*</span></label>
					<input type="text" name="txtSachname" value='<?php if(isset($rau['sach_name'])) echo $rau['sach_name']; ?>'>
					<?php 
						//Thong bao loi ra cho nguoi dung
						checkError($errors, 'txtsachname', '<span class="warning">Bạn chưa nhập tên sách !</span>');
						checkError($errors, 'txtsachname_trung', '<span class="warning"><script>alert("Tên sách đã tồn tại.");window.location.href="ql_sach.php"</script></span>');

					 ?>
				</div>
				<div>
					<label>Tác giả: <span class='required'>*</span></label>
					<input type="text" name="txtTacgia" value='<?php if(isset($rau['tacgia'])) echo $rau['tacgia']; ?>'>
					<?php 
						checkError($errors, 'txttacgia', '<span class="warning">Bạn chưa nhập tên tác giả !</span>');
					 ?>
				</div>
				<div>
					<label>Nhà xuất bản: <span class='required'>*</span></label>
					<input type="text" name="txtNxb" value='<?php if(isset($rau['nxb'])) echo $rau['nxb']; ?>' placeholder="Nhập tên nhà xuất bản">
					<?php checkError($errors, 'txtnxb', '<span class="warning">Bạn chưa nhập tên nhà xuất bản !</span>'); ?>
				</div>
				<div>
					<label>Số lượng: <span class='required'>*</span></label>
					<input type="text" name="txtSoluong" value='<?php if(isset($rau['soluong'])) echo $rau['soluong']; ?>'>
					<?php 
						//Thong bao loi ra cho nguoi dung
						checkError($errors, 'txtsoluong', '<span class="warning">Bạn chưa nhập số lượng !</span>'); 
						checkError($errors, 'txtsoluong_int', '<span class="warning">Số lượng không hợp lệ, vui lòng thử lại !</span>'); 

					?>
				</div>
				<div>
					<label>Đơn giá: <span class='required'>*</span></label>
					<input type="text" name="txtDongia" value='<?php if(isset($rau['dongia'])) echo $rau['dongia']; ?>'> VNĐ
					<?php 
						//Thong bao loi ra cho nguoi dung
						checkError($errors, 'txtdongia', '<span class="warning">Bạn chưa nhập đơn giá !</span>'); 
						checkError($errors, 'txtdongia_int', '<span class="warning">Đơn giá không hợp lệ, vui lòng thử lại !</span>'); 

					?>
				</div>
				<div>
					<label>Số trang:</label>
					<input type="text" name="txtSotrang" value='<?php if(isset($rau['sotrang'])) echo $rau['sotrang']; ?>' placeholder="Nhập số trang của sách">
					<?php checkError($errors, 'txtSotrang', '<span class="warning">Số trang không hợp lệ !</span>'); ?>
				</div>
				<div>
					<label>Loại bìa:</label>
					<select name="txtLoaibia">
						<option value="mềm" <?php if($rau['loaibia']=='mềm') echo "selected='selected'"; ?>>mềm</option>
						<option value="cứng" <?php if($rau['loaibia']=='cứng') echo "selected='selected'"; ?>>cứng</option>
					</select>
				</div>
				<div>
					<label>Giảm giá:</label>
					<input type="text" name="txtGiamgia" value='<?php if(isset($rau['giamgia'])) echo $rau['giamgia']; ?>' placeholder="Số % giảm cho sách"> % 
					<?php checkError($errors, 'txtGiamgia', '<span class="warning">Giá giảm không hợp lệ !</span>'); ?>
				</div>
				<div>
					<label>Giới thiệu: </label>
					<textarea name="txtGioithieu" rows="5" cols="30" style="margin: 2px; height: 91px; width: 320px;" ><?php if(isset($rau['gioithieu'])) echo $rau['gioithieu']; ?></textarea>
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
	//Nếu không phải Admin thì chuyển hướng về Login.
	echo "<script>window.location.href='login.php'</script>";
}
 ?>
<?php include("../includes/footer.php"); ?>
