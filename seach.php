<?php 
session_start();
require_once("./includes/connect.php");
include("./includes/function.php"); 
include("./includes/header.php");
include("./includes/sidebar-a.php");
?>
<style type="text/css">
.noidung {
	border: 1px solid #ccc;
	margin-top: 10px;
}
.noidung h2 {
	text-align: center;
	-webkit-margin-before: 0.02em;
	background-color: #EF77FA;
	padding: 11px;
	color: #FFFFFF;
}
.noidung span.tukhoatimkiem {
	color: yellow;
	text-transform: uppercase;
}
</style>
<div class="noidung">
	<?php 
	if (isset($_POST['txtSeach'])) {
		$txtSach = checkData($_POST['txtSeach']);
	} else {
		$txtSach = NULL;
	}
		// Phân trang
		$tableName=" sach WHERE sach_name LIKE '%$txtSach%' OR tacgia LIKE '%$txtSach%' ";// Ten Table		
		$targetpage = "seach.php"; // Ten trang dang dc dung phan trang
		$limit = 20;// So hang hien thi cua du lieu
		include("includes/phantrang1.php");
		// $s = "SELECT * FROM sach WHERE sach_name LIKE '%$txtSach%'";
		// $q = mysql_query($s) or die("Không thể tìm kiếm");
		echo "<h2>KẾT QUẢ TÌM KIẾM TỪ KHÓA: <span class='tukhoatimkiem'> $txtSach</span></h2>";
		if (mysql_num_rows($result) > 0) {
			while ($r = mysql_fetch_assoc($result)) {
				//---- Tinh so tien ban ---//
				$a = $r['dongia'];
				$b = $r['giamgia'] * 0.01;
				$c = $a * $b;
				$ban = $a - $c;
				//Hien thi san pham
				
				echo "<div class='product'>
				<div class='product_images'>
				<a href='#' title=''><img src='./style/images/img_sach/$r[hinhanh]'></a>
				</div> <!-- end product_images -->

				<div class='product_tieu_de'>
				<a href='#'>$r[sach_name]</a>
				</div> <!-- end product_tieu_de -->

				<div class='product_thong_tin'>
				<li>Tác giả: $r[tacgia]</li>
				<li>Giá bìa: <span class='gia_bia_index'>".number_format($r['dongia'],"0",",",".")."đ</span></li>
				<li>Giá bán: <span class='gia_bia_ban'>".number_format($ban,"0",",",".")."đ</span></li>
				<li>Giảm giá: <span class='tr_gia_giam'>$r[giamgia]%</span></li>
				</div> <!-- end product_thong_tin -->
				
				<div class='product_chitiet'>
				<a href='chitiet.php?ct=$r[sach_id]'><img src='./style/images/chi_tiet.png'></a>
				</div> <!-- end product_chitiet -->

				</div> <!-- end product -->";
			}
		} else {
			echo "Không tìm thấy kết quả nào !";
		}
		echo "<br/>";
		include("includes/phantrang2.php");
		?>
	</div><!-- end noidung -->
	<?php include("./includes/footer.php"); ?>


