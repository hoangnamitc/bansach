<?php 
session_start();
$title = "Chi tiết sách";
require_once("./includes/connect.php");
include("./includes/function.php");
include("./includes/header.php");
include("./includes/sidebar-a.php");
?>
<meta charset="utf-8">
<div class="noidung">
<?php 
	$gt = mysql_query("SELECT * FROM gioithieu");
	while ($r = mysql_fetch_assoc($gt)) {
		echo "<div class='gt_tieude'>";
			echo $r['gt_tieude'];
		echo "</div>";

		echo "<div class='gt_noidung'>";
			echo $r['gt_noidung'];
		echo "</div>";
	}
 ?>
</div><!-- end noidung -->
<?php include("./includes/footer.php"); ?>