<?php 
session_start();
$title = "Chi tiết sách";
require_once("./includes/connect.php");
include("./includes/function.php");
include("./includes/header.php");
include("./includes/sidebar-a.php");
?>
<meta charset="utf-8">
<link rel="stylesheet" href="style/chitiet.css">
<div class="noidung">
	<div class="product_detail">
		<?php 
		if ($id = validate_id($_GET['ct'])) {
		// SELECT SP
			$s = "SELECT * FROM sach WHERE sach_id='$id'";
			$q = mysql_query($s) or die("Không thể truy vấn");

			if (mysql_num_rows($q) == 1) {
				$r = mysql_fetch_assoc($q);

			//---- Tinh so tien ban ---//
				$a = $r['dongia'];
				$b = $r['giamgia'] * 0.01;
				$c = $a * $b;
				$ban = $a - $c;

			//---- Kiểm tra tình trạng hàng còn ---//
				if ($r['soluong'] > 0) {
					$tinhtrang = '<span class="con_hang"><img src="style/images/v.png"> Còn hàng</span>';
					$btn = '<a href="them_cart.php?sid='.$r['sach_id'].'"><input type="button" name="add_cart" class="bt_dat_truoc_san_pham"></a>';
				} else {
					$tinhtrang = '<span class="het_hang"><img src="style/images/x.png"> Hết hàng</span>';
					$btn = '<input type="button" name="add_cart" class="bt_dat_truoc_san_pham2">';
				}

				echo '
				<div class="product_detail_1">
				<div class="product_detial_img">
				<img src="./style/images/img_sach/'.$r['hinhanh'].'" alt="">
				</div><!-- end product_detial_img -->
				</div><!-- end product_detail_1 -->

				<div class="product_detail_2">

				<div class="product_detai_title">
				<h1>'.$r['sach_name'].'</h1>
				</div><!-- end product_detai_title -->

				<div class="product_detai_tac_gia">
				<h2>Tác giả: <span>'.$r['tacgia'].'</span></h2>
				</div><!-- end product_detai_tac_gia -->

				<div class="product_detai_nha_xuat_ban">
				<h2>Nhà xuất bản: <span>'.$r['nxb'].'</span></h2>
				</div><!-- end product_detai_nha_xuat_ban -->

				<div class="product_detail_thong_tin_khac">
				<div class="product_detail_thong_tin_khac_1">
				<li>Số trang: '.$r['sotrang'].'</li>
				<li>Giá bìa: <span class="gia_bia">'.number_format($r['dongia'],"0",",",".").'đ</span></li>
				<li>Giá bán: <span class="gia_ban">'.number_format($ban,"0",",",".").'đ</span></li>
				<li>Giảm giá:<span class="giam_gia"> '.$r['giamgia'].'%</span></li>
				</div><!-- end product_detail_thong_tin_khac_1 -->
				<div class="product_detail_thong_tin_khac_2">
				<input type="hidden" name="txtID" value="'.$r['sach_id'].'">
				<li>Loại bìa: '.$r['loaibia'].'</li>
				<li>Số lượng: '.$r['soluong'].' cuốn</li>
				<li>Tình trạng: '.$tinhtrang.' </li>
				<li>
				<!-- NUT DAT HANG -->
				'.$btn.'
				</li>
				</div><!-- end product_detail_thong_tin_khac_2 -->
				</div><!-- end product_detail_thong_tin_khac -->
				</div><!-- end product_detail_2 -->
				<div class="gachduoi"></div>
				<div style="clear:both"></div>
				<div class="thong_tin_sp">
				<div class="chi_tiet_thong_tin_sp_header">
				<h2 class="font_size_14">Giới thiệu nội dung tác phẩm : 
				<span style="color:#000">'.$r['sach_name'].'</span>
				</h2>
				</div><!-- end chi_tiet_thong_tin_sp_header -->
				<div class="chi_tiet_thong_tin_sp_content">
				<p>
				'. $r['gioithieu'] .'
				</p>
				</div><!-- end chi_tiet_thong_tin_sp_content -->
				</div><!-- end thong_tin_sp -->
				';
			}
	} else {// ID không hợp lệ chuyển hướng về Index.
		echo "<script>window.location.href='index.php'</script>";
	}
	?>
	
</div><!-- end product_detail -->

</div><!-- end noidung -->
<?php //include("./includes/sidebar-b.php"); ?>
<?php include("./includes/footer.php"); ?>