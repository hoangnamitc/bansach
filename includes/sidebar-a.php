<?php require_once("./includes/connect.php"); ?>
<div id="content">
		<div style="clear:both"></div>
		<div class="sidebar-a">
			<h3>Danh mục sách</h3>
				<ul class="dm_sach">
					<?php 
					// Kiểm tra biến truyền paid có hợp lệ ko, (Tô màu cho dmuc name)
						if (isset($_GET['paid']) && filter_var($_GET['paid'], FILTER_VALIDATE_INT, array('min_range => 1'))) {
							$pageid = $_GET['paid'];
						} else {
							$pageid = NULL;
						}
						$s = "SELECT * FROM danhmuc";
						$q = mysql_query($s) or die("Không thể chọn danh mục !");
						if (mysql_num_rows($q) > 0) {
							while ($r = mysql_fetch_assoc($q)) {
								echo "<li><a href='listsp.php?paid=".$r['dmuc_id']."'";
								// Nếu dmuc_id = biến truyền paid thì tô đỏ
										if ($r['dmuc_id'] == $pageid) {
											echo "class='selected'";
										}
								echo ">".$r['dmuc_name']."</a></li>";
							}
						}
					 ?>
					
				</ul>
		</div><!--- end sidebar-a -->