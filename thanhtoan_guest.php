<?php @session_start(); ?>
<link rel="stylesheet" href="style/cart.css">
<?php 
// Kiểm tra người người dùng đã login chưa?
if(isset($_SESSION['user_level'])) {
	echo "<script>window.location.href='chon_thanhtoan.php'</script>";
} else {
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
		<input type="text" name="txtHoTen" value="">
	</li>
	<li>
		<span> Giới tính </span>
		<select name="txtGioiTinh">
			<option value="1">Nam</option>
			<option value="0">Nữ</option>
		</select>
	</li>
	<li>
		<span> Ngày sinh </span>
		<select name="txtNgaySinh" class="ngaythang">
			<?php 
			for ($i=1; $i <=31 ; $i++) { 
				echo "<option value='".$i."'>ngày ".$i."</option>";
			}
			?>
		</select>
		<select name="txtThangSinh" class="ngaythang2">
			<?php 
			for ($i=1; $i <=12 ; $i++) { 
				echo "<option value='".$i."'>tháng ".$i."</option>";
			}
			?>
		</select>
		<input type="text" name="txtNamSinh" value="" class="ngaythang">

	</li>
	<li>
		<span> Điện thoại di động  <font class="do">*</font></span>
		<input type="text" name="txtDiDong">
	</li>
	<li>
		<span> Email  <font class="do">*</font></span>
		<input type="text" name="txtEmail">
	</li>
</div><!-- end thong_tin_quy_khach_2 -->
<div style="clear:both"></div>
<div class="thong_tin_quy_khach">
	<div class="thong_tin_quy_khach_1"><img src="style/images/icon_book.jpg"></div>
	<div class="thong_tin_quy_khach_2">
		<li class="thong_tin_quy_khach_title">Địa chỉ nhận hàng</li>
		<li>
			<span> Địa chỉ  <font class="do">*</font></span>
			<input type="text" name="txtDiaChi" value="">
		</li>
		<li>
			<span> Tỉnh/Thành phố  <font class="do">*</font></span>
			<input type="text" name="txtThanhPho" value="">
		</li>
		<li>
			<span> Mã Zip  <font class="do">*</font></span>
			<input type="text" name="txtMaBD" value="">
		</li>
		<li>
			<input type="submit" name="oke" value="Thanh toán" class="button_tieptuc">
		</li>
	</div><!-- end thong_tin_quy_khach_2 -->
</div><!-- end thong_tin_quy_khach -->


</fieldset>
</form>
<?php 
}// End isset($_SESSION['user_level']
?>
<?php include("./includes/footer.php"); ?>