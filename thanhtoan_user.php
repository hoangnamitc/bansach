<?php @session_start(); ?>
<link rel="stylesheet" href="style/cart.css">
<?php
// Kiểm tra người người dùng đã login chưa?
if(isset($_SESSION['user_level'])) {
	$id = $_SESSION['uid']; 
	$tt = "SELECT * FROM users WHERE user_id = '$id'";
	$tt2 = mysql_query($tt) or die("Cannot select table");
	if (mysql_num_rows($tt2) > 0) {
		$tt3 = mysql_fetch_assoc($tt2);
	} else {
		echo "<script>alert('Không tìm thấy người dùng !')</script>";
	}
	//Tách các thông tin mảng
	$ns = explode("-", $tt3['birthday']);
	?>
	<form action="complete_cart.php" method="post">
		<fieldset>
			<legend>Thông tin khách hàng</legend>
			<!-- ############################################################## -->
			<?php
	// Gán biến cho SESSION giỏ hàng
			$giohang = $_SESSION['giohang'];
			?>
			<table style="width: 100%">

				<form action="" method="post">
					<thead>
						<tr class="table_title">
							<th>STT</th>
							<th>Hình</th>
							<th>Tên sản phẩm</th>
							<th>Số lượng</th>
							<th>Đơn giá (VNĐ)</th>
							<th>Thành tiền(VNĐ)</th>
						</tr>
					</thead>
					<tbody>
						<?php 
	// Hiển thị giỏ hàng
						$tt = 1;
						$thanhtien = 0;

						foreach ($giohang as $id => $sl) {
							$sql = mysql_query("SELECT * FROM sach WHERE sach_id in ('$id')") 
							or die("Cannot select table SACH");
							$rows = mysql_fetch_assoc($sql);
	//---- Tinh so tien ban ---//
							$a   = $rows['dongia'];
							$b   = $rows['giamgia'] * 0.01;
							$c   = $a * $b;
							$ban = $a - $c;

							echo "<tr class='tr_td'>";
							echo "<td>".$tt++."</td>";
							echo "<td><img src='./style/images/img_sach/".$rows['hinhanh']."' width='70px;'></td>";
							echo "<td>".$rows['sach_name']."</td>";
							echo "<td><input type='text' name='soluong[".$id."]' value='".$sl."' style='width:50px;' disabled></td>";
							echo "<td>".number_format($ban,"0",",",".")."đ</td>";
							echo "<td>".number_format($ban*$sl,"0",",",".")."đ</td>";
							echo "</tr>";

	// Tổng tiền
							$thanhtien +=  $ban*$sl;

	}// End foreach
	echo '
	<tr class="tr_td">
	<td colspan="4" style="font-weight:bold;">Tổng số tiền: </td>
	<td colspan="2" style="color:red;font-weight:bold;">'.number_format($thanhtien,"0",",",".").'đ</td>
	</tr>	
	';
	?>

</tbody>
</form>
</table>
<!-- ############################################################## -->
<div class="thong_tin_thanh_toan_kh_header"></div>

<div class="thong_tin_quy_khach_1"><img src="style/images/icon_nguoi.jpg"></div>
<div class="thong_tin_quy_khach_2">
	<li class="thong_tin_quy_khach_title">Thông tin mua hàng của quý khách</li>
	<li>
		<span> Họ và tên  <font class="do">*</font></span>
		<input type="text" name="txtHoTen" value="<?php if(isset($tt3['hoten'])) {echo $tt3['hoten'];} ?>">
	</li>
	<li>
		<span> Giới tính </span>
		<select name="txtGioiTinh">
			<option value="1" <?php if($tt3['gioitinh'] == 1) {echo "selected='selected'";} ?>>Nam</option>
			<option value="0" <?php if($tt3['gioitinh'] == 0) {echo "selected='selected'";} ?>>Nữ</option>
		</select>
	</li>
	<li>
		<span> Ngày sinh </span>
		<select name="txtNgaySinh" class="ngaythang">
			<?php 
			for ($i=1; $i <=31 ; $i++) { 
				echo "<option value='".$i."'";
				if($ns[2] == $i) {echo "selected='selected'";}
				echo ">ngày ".$i."</option>";
			}
			?>
		</select>
		<select name="txtThangSinh" class="ngaythang2">
			<?php 
			for ($i=1; $i <=12 ; $i++) { 
				echo "<option value='".$i."'";
				if($ns[1] == $i) {echo "selected='selected'";}
				echo ">tháng ".$i."</option>";
			}
			?>
		</select>
		<input type="text" name="txtNamSinh" value="<?php if(isset($ns[0])) {echo $ns[0];} ?>" class="ngaythang">

	</li>
	<li>
		<span> Điện thoại di động  <font class="do">*</font></span>
		<input type="text" name="txtDiDong" value="<?php if(isset($tt3['phone'])) {echo $tt3['phone'];} ?>">
	</li>
	<li>
		<span> Email  <font class="do">*</font></span>
		<input type="text" name="txtEmail" value="<?php if(isset($tt3['email'])) {echo $tt3['email'];} ?>">
	</li>
</div><!-- end thong_tin_quy_khach_2 -->
<div style="clear:both"></div>
<div class="thong_tin_quy_khach">
	<div class="thong_tin_quy_khach_1"><img src="style/images/icon_book.jpg"></div>
	<div class="thong_tin_quy_khach_2">
		<li class="thong_tin_quy_khach_title">Địa chỉ nhận hàng</li>
		<li>
			<span> Địa chỉ  <font class="do">*</font></span>
			<input type="text" name="txtDiaChi" value="<?php if(isset($tt3['diachi'])) {echo $tt3['diachi'];} ?>">
		</li>
		<li>
			<span> Tỉnh/Thành phố  <font class="do">*</font></span>
			<input type="text" name="txtThanhPho" value="<?php if(isset($tt3['thanhpho'])) {echo $tt3['thanhpho'];} ?>">
		</li>
		<li>
			<span> Mã Zip  <font class="do">*</font></span>
			<input type="text" name="txtMaBD" value="<?php if(isset($tt3['mabuudien'])) {echo $tt3['mabuudien'];} ?>">
		</li>
		<li>
			<input type="submit" name="oke" value="Thanh toán" class="button_tieptuc">
		</li>
	</div><!-- end thong_tin_quy_khach_2 -->
</div><!-- end thong_tin_quy_khach -->

</fieldset>
</form>
<?php 
} else {
		// Nếu người dùng chưa login thì chuyển hướng về chon_thanhtoan.php
	echo "<script>window.location.href='chon_thanhtoan.php'</script>";
}
?>

<?php include("./includes/footer.php"); ?>