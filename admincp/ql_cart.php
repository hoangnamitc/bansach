<?php session_start(); ?>
<?php 
$title = "Quản lý giỏ hàng"; 
require_once("../includes/connect.php");
include("../includes/function.php");
include("../includes/header-admin.php");
include("../includes/sidebar-admin.php");
?>
<div class="noidung">
<?php 
	// Kiểm tra Admin đã login hay chưa
	if (is_admin()) {
		$tableName  =" hoadon, khach_hang ";// Ten Table	
		$tableName .= " WHERE hoadon.MaHoaDon=khach_hang.MaHoaDon ";
		$tableName .= " ORDER BY hd_id DESC ";	
		$targetpage = "ql_cart.php"; // Ten trang dang dc dung phan trang
		$limit = 10;// So hang hien thi cua du lieu
		include("../includes/phantrang1.php");
?>
<table cellspacing="0" cellpadding="0" border="0" class="thong_tin_cart">
	<h4 style="margin-top:20px;font-size:20px;">Danh Sách giỏ hàng</h4>
	<thead>
		<tr class="le">
			<th>Mã hóa đơn</th>
			<th>Tổng sản phẩm</th>
			<th>Tổng tiền</th>
			<th>Ngày mua</th>
			<th>Tình trạng</th>
			<th>Khách hàng</th>
			<th>Chi tiết</th>
			<th>Xác nhận</th>
			<th>Xóa</th>
		</tr>
	</thead>
	<tbody>
<?php 
	if (mysql_num_rows($result) > 0) {
		while ($r = mysql_fetch_assoc($result)) {
			$datebuy = explode("-", $r['NgayMua']);
			$datebuy2 = $datebuy[2]."/".$datebuy[1]."/".$datebuy[0];
			if ($r['TinhTrang'] == 0) {
				$trang_thai = "<img src='style/images/x.png'>";
				$cf = "<img src='./style/images/confirm.gif'>";
			} elseif ($r['TinhTrang'] == 1) {
				$trang_thai = "<img src='style/images/v.png'>";
				$cf = "";
			}

			echo "<tr class='nd-1'>";
				echo "<td><center>".$r['MaHoaDon']."</center></td>";
				echo "<td><center>".$r['TongSanPham']."</center></td>";
				echo "<td><center>".number_format($r['TongSoTien'],"0",",",".")."đ</center></td>";
				echo "<td><center>".$datebuy2."</center></td>";
				echo "<td><center>".$trang_thai."</center></td>";
				echo "<td><center><a href='kh_info.php?kid=".$r['kh_id']."'>".$r['kh_name']."</a></center></td>";

				echo "<td><center><a href='ct_cart.php?kid=".$r['MaHoaDon']."'><img src='./style/images/view.gif'></a></center></td>";
				echo "<td><center><a href='cf_cart.php?cid=".$r['MaHoaDon']."' onClick=\"return confirm('Xác nhận |-$r[MaHoaDon]-| đã thanh toán?')\">".$cf."</a></center></td>";
				echo "<td><a href='del_cart.php?cid={$r['MaHoaDon']}' onClick=\"return confirm('Bạn có muốn xóa tất cả thông tin về || $r[MaHoaDon] || không?')\"><img src='./style/images/delete.png'></a></td>";
				
			echo "</tr>";
		}// End While
	} else {
		echo "<tr><td>Không có dữ liệu !</td></tr>";
	}// End Num_rows
 ?>		

	</tbody>
</table>
<?php include("../includes/phantrang2.php"); ?>
<?php	 
} else {
	//Nếu không phải là Admin thì chuyển hướng về Index.
	echo "<script>window.location.href='login.php'</script>";
}
?>
</div>
<?php include("../includes/footer.php"); ?>