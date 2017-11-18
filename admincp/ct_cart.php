<?php session_start(); ?>
<?php 
$title = "Chi tiết giỏ hàng"; 
require_once("../includes/connect.php");
include("../includes/function.php");
include("../includes/header-admin.php");
include("../includes/sidebar-admin.php");
?>
<div class="noidung">
<?php 
// Kiểm tra Admin đã login hay chưa
if (is_admin()) {
	if ($kid = $_GET['kid']) {
		$thanhtien = 0;
		$result = mysql_query("SELECT * FROM ct_hoadon, sach WHERE ct_hoadon.sach_id=sach.sach_id AND MaHoaDon = '$kid'");
?>
<table cellspacing="0" cellpadding="0" border="0" class="thong_tin_cart">
	<h4 style="margin-top:20px;font-size:20px;">Thông tin chi tiết của hóa đơn: <span style="color:red;"><?php echo $kid; ?></span></h4>
	<thead>
		<tr class="le">
			<th>Hình</th>
			<th>Tên sản phẩm</th>
			<th>Số lượng</th>
			<th>Giá bán</th>
			<th>Thành tiền</th>
		</tr>
	</thead>
	<tbody>
<?php 
	if (mysql_num_rows($result) > 0) {
		$cols = mysql_num_rows($result);
		while ($r = mysql_fetch_assoc($result)) {
			//---- Tinh so tien ban ---//
			$a   = $r['dongia'];
			$b   = $r['giamgia'] * 0.01;
			$c   = $a * $b;
			$ban = $a - $c;
			echo "<tr class='nd-1'>";
				echo "<td><center><img src='../style/images/img_sach/".$r['hinhanh']."' width='100px'; height='100px'></center></td>";
				echo "<td>".$r['sach_name']."</td>";
				echo "<td><center>".$r['SL']." cuốn</center></td>";
				echo "<td><center>".number_format($ban,"0",",",".")."đ</center></td>";
				echo "<td>".number_format($ban*$r['SL'],"0",",",".")."đ</td>";
			echo "</tr>";
			$thanhtien += $ban*$r['SL'];
		}// End While
		echo "<tr class='nd-1' style='color:red;font-size:16px;font-weight:bold;'>";
			echo "<td colspan='3'><center>Tổng tiền:</center></td>";
			echo "<td colspan='3'><center>".number_format($thanhtien,"0",",",".")."đ</center></td>";
		echo "</tr>";
	} else {
		echo "<tr><td>Không có dữ liệu !</td></tr>";
	}// End Num_rows
 ?>		

	</tbody>
</table>
<?php
	} else {
		// Nếu ID không hợp lệ thì chuyển về QL_CART.
		echo "<script>window.location.href='ql_cart.php'</script>";
	}	 
} else {
	//Nếu không phải là Admin thì chuyển hướng về Index.
	echo "<script>window.location.href='login.php'</script>";
}
?>
</div>
<?php include("../includes/footer.php"); ?>