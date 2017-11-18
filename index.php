<?php 
session_start();
?>
<?php 
require_once("./includes/connect.php");
include("./includes/function.php");
include("./includes/header.php");
include("./includes/sidebar-a.php");
?>

<div class="slide">
	<?php include("./style/slide_img/slide.php"); ?>
	<a href="#"><div class="qc1" title="Quảng cáo 1">QC1</div></a>
	<a href="#"><div class="qc2" title="Quảng cáo 2">QC2</div></a>
</div><!-- end silde -->

<div class="noidung">
	<div>

		<!-- SÁCH BÁN CHẠY -->		
		<div class="san_pham_ban_chay">
			<div class="san_pham_ban_chay_header">
				<li class="li_san_pham_ban_chay_header">
					<h1><a href="list_banchay.php">Sản phẩm bán chạy</a></h1>
				</li>
				<li class="li_san_pham_ban_chay_xem_tat_ca">
					<a href="list_banchay.php">Xem tất cả</a>
				</li>
			</div> <!-- end sanphambanchay_header -->
			<div class="san_pham_ban_chay_body">
				<div style="clear:both"></div>
				<?php 
				$se = "SELECT * FROM sach ORDER BY luot_mua DESC LIMIT 12 ";
				$qse = mysql_query($se) or die("Không thể hiện thị sách");
				if (mysql_num_rows($qse) > 0) {
					while ($r = mysql_fetch_assoc($qse)) {
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

		}// end while
	}// end IF NUM_ROWS
	
	?>				
</div> <!-- end san_pham_ban_chay_body -->
<div class="san_pham_ban_chay_footer"></div>
</div> <!-- end sanphambanchay -->
<!-- END SÁCH BÁN CHẠY -->	

<div style="clear:both"></div>

<!-- SÁCH MỚI PHÁT HÀNH -->
<div class="sach_sap_phat_hanh">
	<div class="header_sach_sap_phat_hanh">

		<li class="title_sach_sap_phat_hanh">
			<h2>
				<a href="list_new.php" title="">Sách mới phát hành</a>
				<img src="style/images/new.png">
			</h2>
		</li> <!-- end title_sach_sap_phat_hanh -->

		<li class="xem_tat_ca_sach_sap_phat_hanh">
			<a href="list_new.php">Xem tất cả</a>
		</li> <!-- end xem_tat_ca_sach_sap_phat_hanh -->
	</div> <!-- end header_sach_sap_phat_hanh -->
	<div style="clear:both"></div>
	<div class="sach_sap_phat_hanh_body">
		<?php 
		$se = "SELECT * FROM sach ORDER BY sach_id DESC LIMIT 12 ";
		$qse = mysql_query($se) or die("Không thể hiện thị sách");
		if (mysql_num_rows($qse) > 0) {
			while ($r = mysql_fetch_assoc($qse)) {
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
	}// end IF NUM_ROWS
	
	?>
</div> <!-- end sach_sap_phat_hanh_body -->

<div class="sach_sap_phat_hanh_footer"></div>

</div> <!-- end sach_sap_phat_hanh -->
<!-- END SACH MOI PHAT HANH -->

<div style="clear:both"></div>
</div>
</div><!-- end noidung -->
<?php include("./includes/footer.php"); ?>


