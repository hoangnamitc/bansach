<?php
	session_start(); 
	$title = "Thông tin liên hệ";
	require_once("../includes/connect.php");
	include("../includes/function.php");
	include("../includes/header-admin.php");
	include("../includes/sidebar-admin.php");
 ?>
<meta charset="utf-8">
<link rel="stylesheet" href="./style/chitiet_sach.css">
<div class="noidung">
<div class="product_detail">
<?php
	// Kiểm tra có phải là Admin không?
if(is_admin()) { 
		if ($id = validate_id($_GET['do'])) {
			
		// SELECT SP
		$s = "SELECT * FROM lienhe WHERE lhe_id='$id' LIMIT 1";
		$q = mysql_query($s) or die("Không thể truy vấn");

		if (mysql_num_rows($q) == 1) {
			$r = mysql_fetch_assoc($q);

			$ngaygui = explode("-", $r['ngaygui']);

			echo '

			<div class="product_detail_2">
				<div class="product_detai_title">
					<h1>Người Gửi: '.$r['lhe_name'].'</h1>
				</div><!-- end product_detai_title -->				
			</div><!-- end product_detail_2 -->

			<div style="clear:both"></div>

			<div class="thong_tin_sp">
			<div class="product_detail_thong_tin_khac">
			<div class="product_detai_tac_gia">
				<h2>Email: <span>'.$r['lhe_email'].'</span></h2><br />
			</div><!-- end product_detai_tac_gia -->
				<span>Ngày gửi: '.$ngaygui[2]."/".$ngaygui[1]."/".$ngaygui[0].'</span>
			</div>
				<div class="chi_tiet_thong_tin_sp_header">
					<h2 class="font_size_14">Nội dung Email : 
					</h2>
				</div><!-- end chi_tiet_thong_tin_sp_header -->
				<div class="chi_tiet_thong_tin_sp_content">
					<p>
						'. $r['lhe_comment'] .'
					</p>
				</div><!-- end chi_tiet_thong_tin_sp_content -->
			</div><!-- end thong_tin_sp -->
			';
		}// End if NUM_ROWS
	} else {// Nếu ID không hợp lệ thì chuyển hướng về Index.
			echo "<script>window.location.href='index.php'</script>";
		}// END ID
// Nếu không phải Admin thì chuyển hướng về Index.		
} else {
	echo "<script>window.location.href='index.php'</script>";
}		
 ?>
	
</div><!-- end product_detail -->

</div><!-- end noidung -->
<?php include("../includes/footer.php"); ?>