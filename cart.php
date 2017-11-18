<?php 
session_start();
$title = "Thông tin mua sách";
require_once("./includes/connect.php");
include("./includes/function.php");
include("./includes/header.php");
include("./includes/sidebar-a.php");
?>
<meta charset="utf-8">
<link rel="stylesheet" href="style/cart.css">

<?php
	// Gán biến cho SESSION giỏ hàng
	if(isset($_SESSION['giohang'])) 
	{
		$giohang = $_SESSION['giohang'];
	}

	// Xử lý cập nhật
if (isset($_POST['capnhat']) && count($_SESSION['giohang']) != "") 
{
	
	$soluong_cn = $_POST['soluong'];

	foreach ($soluong_cn as $id => $sl) 
	{

			// Lấy số lượng trong CSDL.
		$max = mysql_fetch_assoc(mysql_query("SELECT soluong FROM sach WHERE sach_id = '$id'"));
		$max2 = $max['soluong'];
		
			// Nếu như người dùng đặt lại số lượng = 0 Thì ta hủy luôn
		if ($sl == 0) 
		{
				// Nếu số lượng = 0 thì xóa hàng đó.
			unset($_SESSION['giohang'][$id]);
		}
		else
		{
				// Ngược lại số lượng mà > 0 thì ta cập nhật số lượng cho sản phẩm.
			$_SESSION['giohang'][$id] = $sl;
		}
		
			if (!is_numeric($sl) || $sl < 0) // Nếu số lượng ko phải là số và là số âm thì gán là 1.
			{
				$_SESSION['giohang'][$id] = 1;
			}
			elseif ($sl > $max2) // Nếu số lượng vượt quá cho phép thì gán là tối đa.
			{
				$_SESSION['giohang'][$id] = $max2;
			}

			// refresh lại trang.
			echo "<script>window.location.href='cart.php'</script>";

		}// End foreach

}// End $_POST['capnhat']
	?>
	<div class="noidung2">
		<?php 
	// Kiểm tra số lượng giỏ hàng
		if(isset($_SESSION['giohang'])&&count($_SESSION['giohang']) > 0)
		{
			?>
			<table style="width: 77%">
				<br />
				<h2>Đây là giỏ hàng của bạn</h2>
				<form action="" method="post">

					<caption>Hiện tại bạn có
						<?php 
						echo "<strong>".count($_SESSION['giohang'])."</strong>";
						?>
						sản phẩm trong giỏ hàng</caption>
						<thead>
							<tr class="table_title">
								<th>STT</th>
								<th>Hình</th>
								<th>Tên sản phẩm</th>
								<th>Số lượng</th>
								<th>Đơn giá (VNĐ)</th>
								<th>Thành tiền(VNĐ)</th>
								<th>Hủy</th>
							</tr>
						</thead>
						<tbody>
							<?php 
	// Hiển thị giỏ hàng
							$tt = 1;
							$thanhtien = 0;

							foreach ($giohang as $id => $sl) 
							{
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
								echo "<td><input type='text' name='soluong[".$id."]' value='".$sl."' style='width:50px;'></td>";
								echo "<td>".number_format($ban,"0",",",".")."đ</td>";
								echo "<td>".number_format($ban*$sl,"0",",",".")."đ</td>";
								echo "<td><a href='xoa_cart.php?sid=".$id."' title='xóa sản phẩm này'><input type='button' value='Xoa' class='xoa_sl'></a></td>";
								echo "</tr>";

	// Tổng tiền
								$thanhtien +=  $ban*$sl;

	}// End foreach
	
	echo '
	<tr class="tr_td">
	<td colspan="2"><input type="submit" name="capnhat" value="cap nhat" class="update_sl" /></td>
	<td colspan="2" style="font-weight:bold;">Tổng số tiền: </td>
	<td colspan="3" style="color:red;font-weight:bold;">'.number_format($thanhtien,"0",",",".").'đ</td>

	</tr>	
	';
	?>

</tbody>
</form>
</table>
<br />
<center>
	<form action="chon_thanhtoan.php" method="POST">
		<input type="submit" name="Submit" value="Thực hiện thanh toán" class="button_thanh_toan">
	</form>
</center>
<a href="index.php" title="Quay lại trang chủ" class="button_thanh_toan">Tiếp tục mua sách</a>
<?php 
}
else 
	{// Nếu không tồn tại SESSION['giohang'] thì báo ra là:
echo "<span class='error'><br />Bạn không có sản phẩm nào trong giỏ hàng !</span>";
}
?>

</div><!-- End noidung -->
<?php include("./includes/footer.php"); ?>