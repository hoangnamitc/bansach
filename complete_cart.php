<?php session_start(); ?>
<?php 
require_once("./includes/connect.php");
include("./includes/function.php");
include("./includes/header.php");
include("./includes/sidebar-a.php");
?>
<link rel="stylesheet" href="style/cart.css">
<div class="noidung">
<?php 
$rong = array();
		// Bấm nút đặt hàng => Chèn CSDL
if (empty($_POST['txtHoTen'])) {
	echo "<script>alert('Bạn chưa nhập họ tên !')</script>";
	echo "<script>window.location.href='thanhtoan.php'</script>";
	$rong[] = "ht";
} else {
	$txtHoTen = checkData($_POST['txtHoTen']);
			}// End HoTen

			if (empty($_POST['txtDiDong'])) {
				echo "<script>alert('Bạn chưa nhập di động !')</script>";
				echo "<script>window.location.href='thanhtoan.php'</script>";
				$rong[] = "dd";
			} elseif (!is_numeric($_POST['txtDiDong']) || strlen($_POST['txtDiDong']) < 10 || strlen($_POST['txtDiDong']) > 11) {
				echo "<script>alert('Di động không hợp lệ !')</script>";
				echo "<script>window.location.href='thanhtoan.php'</script>";
				$rong[] = "dd2";
			} else {
				$txtDiDong = checkData($_POST['txtDiDong']);
			}// End DiDong

			if (empty($_POST['txtEmail'])) {
				echo "<script>alert('Bạn chưa nhập Email !')</script>";
				echo "<script>window.location.href='thanhtoan.php'</script>";
				$rong[] = "mail";
			} elseif (!preg_match('/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$/', $_POST['txtEmail'])) {
				echo "<script>alert('Email không hợp lệ !')</script>";
				echo "<script>window.location.href='thanhtoan.php'</script>";
				$rong[] = "mail2";
			} else {
				$txtEmail = checkData($_POST['txtEmail']);
			}// End txtEmail

			if (empty($_POST['txtDiaChi'])) {
				echo "<script>alert('Bạn chưa nhập địa chỉ !')</script>";
				echo "<script>window.location.href='thanhtoan.php'</script>";
				$rong[] = "dc";
			} else {
				$txtDiaChi = checkData($_POST['txtDiaChi']);
			}// End DiaChi

			if (empty($_POST['txtThanhPho'])) {
				echo "<script>alert('Bạn chưa nhập thành phố !')</script>";
				echo "<script>window.location.href='thanhtoan.php'</script>";
				$rong[] = "tp";
			} else {
				$txtThanhPho = checkData($_POST['txtThanhPho']);
			}// End ThanhPho

			if (empty($_POST['txtMaBD'])) {
				echo "<script>alert('Bạn chưa nhập Mã Zip !')</script>";
				echo "<script>window.location.href='thanhtoan.php'</script>";
				$rong[] = "zip";
			} elseif (!is_numeric($_POST['txtMaBD'])) {
				echo "<script>alert('Mã Zip không hợp lệ !')</script>";
				echo "<script>window.location.href='thanhtoan.php'</script>";
				$rong[] = "zip2";
			} else {
				$txtMaBD = checkData($_POST['txtMaBD']);
			}// End DiDong

			// Get thêm thông tin các
			$sn = $_POST['txtNamSinh']."-".$_POST['txtThangSinh']."-".$_POST['txtNgaySinh'];
			$txtGioiTinh = $_POST['txtGioiTinh'];

			$ngaysinh = $_POST['txtNgaySinh']."/".$_POST['txtThangSinh']."/".$_POST['txtNamSinh'];
			$now = getdate();
			$currentDate = $now["mday"] . "/" . $now["mon"] . "/" . $now["year"];
			
			///////////////////////////////////
			// Khai báo các biến cần dùng //
			///////////////////////////////////
			
			// Gán biến cho SESSION giỏ hàng
			$giohang = $_SESSION['giohang'];
			// Tạo mã ngẫu nhiên
			$md5_hash = md5(rand(0, 999));
			$MaKhachHang = substr($md5_hash, 15, 6);
			$summoney = 0;
			
	if (empty($rong)) {// Nếu nhập đầy đủ thông tin mới chạy SQL.
		foreach ($giohang as $id => $sl) {

////////////////////////////
// Cập nhật lượt mua sách //
////////////////////////////
			$sl_sach = mysql_query("SELECT luot_mua, soluong FROM sach WHERE sach_id in ('$id')");
			$sl_sach2 = mysql_fetch_assoc($sl_sach);
			$ups = $sl_sach2['luot_mua'] + 1;
			$upsach = "UPDATE sach SET luot_mua = '$ups' WHERE sach_id in ('$id')";
			$upsach2 = mysql_query($upsach) or die("Cannot Update sach");
////////////////////////////////
// End Cập nhật lượt mua sách //
////////////////////////////////
			
			$sql = mysql_query("SELECT * FROM sach WHERE sach_id in ('$id')") 
			or die("Cannot select table SACH");
			$rows = mysql_fetch_assoc($sql);
				//---- Tính số tiền bán ---//
			$a   = $rows['dongia'];
			$b   = $rows['giamgia'] * 0.01;
			$c   = $a * $b;
			$ban = $a - $c;
			$total = $ban*$sl;

			$ca = "INSERT INTO ct_hoadon (
										sach_id,
										MaHoaDon, 
										SL, 
										tong_tien
										) 
									VALUES (
										'$id',
										'$MaKhachHang',
										'$sl', 
										'$total'
										)";
		$ca2 = mysql_query($ca) or die("Cannot insert to CT_HOADON");
		
////////////////////////////////////
// Trừ số lượng mà khách đã mua //
////////////////////////////////////
		$rest = $sl_sach2['soluong'] - $sl;
		$upsl = "UPDATE sach SET soluong = '$rest' WHERE sach_id in ('$id')";
		$upsl2 = mysql_query($upsl) or die("Cannot Update so luong");
////////////////////////////////////////
// End Trừ số lượng mà khách đã mua //
////////////////////////////////////////
		$summoney += $ban*$sl;
}// End foreach
	if (isset($_SESSION['giohang']) && count($_SESSION['giohang']) > 0) {

	$sumsp = count($_SESSION['giohang']);

	$hoadon = "INSERT INTO hoadon (
									MaHoaDon,
									TongSanPham,
									TongSoTien,
									NgayMua,
									TinhTrang
									)
							VALUES (
									'$MaKhachHang',
									'$sumsp',
									'$summoney',
									NOW(),
									0
									)
									";
	$hoadon2 = mysql_query($hoadon) or die("Cannot Insert to HOADON");

	$kh = "INSERT INTO khach_hang ( 
									MaHoaDon,
									kh_name,
									kh_gender,
									kh_birthday,
									kh_phone,
									kh_email,
									kh_address,
									kh_city,
									kh_zip
									)
							VALUES (
									'$MaKhachHang',
									'$txtHoTen',
									'$txtGioiTinh',  
									'$sn',  
									'$txtDiDong',  
									'$txtEmail',  
									'$txtDiaChi',  
									'$txtThanhPho',  
									'$txtMaBD'
									)
									";
	$kh2 = mysql_query($kh) or die("Cannot Insert to khach_hang");


if (mysql_affected_rows($dbc) == 1) {

	// Xóa dữ liệu trong bảng tạm
	foreach ($giohang as $id => $sl) {
		unset($_SESSION['giohang'][$id]);
	}		
?>
	<!-- Giao Diện thành công ! -->
	<div class="thankyou-page">
		<h2><span class="border-bottom">ĐẶT HÀNG THÀNH CÔNG</span></h2>
		<div class="thankyou-text">Thank you!</div>
		<p>Cám ơn bạn đã mua sắm tại cửa hàng của chúng tôi. Đơn hàng của bạn đang được xử lý.
			<br>
			Mã số đơn hàng của bạn là: <span class="order-code"><?php echo $MaKhachHang; ?></span>
		</p>
		<p class="note">Đơn hàng của quý khách sẽ được nhanh chóng xử lý và giao đến quý khách trong thời gian sớm nhất, Chúc quý khách hàng một ngày tốt lành !</p>
	</div><!-- End thankyou-page -->

<?php
	} else {
		echo "<script>alert('Giao dịch thất bại, vui lòng thử lại !')</script>";
		echo "<script>window.location.href='index.php'</script>";
	}
} else {
		echo "<script>alert('Thất bại, Giỏ hàng của bạn trống rỗng !')</script>";
		echo "<script>window.location.href='index.php'</script>";
}	
}// End rong
?>
</div>
<?php include("./includes/footer.php"); ?>