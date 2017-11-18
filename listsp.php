<?php session_start(); ?>
<?php
$title = "Thông tin sách"; 
require_once("./includes/connect.php");
include("./includes/function.php");
include("./includes/header.php");
include("./includes/sidebar-a.php");
?>

<div class="noidung">

	<!-- DANH SÁCH SẢN PHẨM -->
	<?php 
	if ($paid = validate_id($_GET['paid'])) {
		$s2 = mysql_query("SELECT dmuc_name FROM danhmuc WHERE dmuc_id='$paid'") or die("SAI SQL");
		if (mysql_num_rows($s2) > 0) {
			$r2 = mysql_fetch_assoc($s2);
		}
		?>
		<div class="sach_sap_phat_hanh" style="margin-top: 10px;background: url(./style/images/bg-listsp.png) no-repeat;width:740px;">
			<div class="header_sach_sap_phat_hanh">
				<!-- Tiêu đề chuyên mục -->
				<li class="title_sach_sap_phat_hanh">
					<h2>
						<a href="" title=""><?php echo $r2['dmuc_name'] ?></a>
					</h2>
				</li><!-- end title_sach_sap_phat_hanh -->
			</div><!-- end header_sach_sap_phat_hanh -->
			<div style="clear:both"></div>
			<div class="sach_sap_phat_hanh_body">
				<?php 

	// Phân trang
	$tableName=" sach WHERE dmuc_id='$paid' ORDER BY sach_id DESC ";// Ten Table		
	$targetpage = "listsp.php"; // Ten trang dang dc dung phan trang
	$limit = 20;// So hang hien thi cua du lieu
	include("includes/phantrang1.php");
	if (mysql_num_rows($result) > 0) {
		while ($r = mysql_fetch_assoc($result)) {
			//---- Tinh so tien ban ---//
			$a   = $r['dongia'];
			$b   = $r['giamgia'] * 0.01;
			$c   = $a * $b;
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


		}// end while
	} else {
		echo "<p class='error'>Không có sản phẩm</p>";
	}// end IF NUM_ROWS
	
	?>
</div> <!-- end sach_sap_phat_hanh_body -->

<div class="sach_sap_phat_hanh_footer"></div>

</div> <!-- end sach_sap_phat_hanh -->
<!-- END SACH MOI PHAT HANH -->


<?php include("includes/phantrang2.php"); ?>
</div><!-- end noidung -->
<?php 
include("./includes/footer.php");
} else {
	// Neu ID khong hop le thi chuyen ve index.php
	header("location: index.php");
}
?>


