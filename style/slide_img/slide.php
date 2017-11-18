	<script src="style/slide_img/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="style/slide_img/coin-slider.js"></script>
<div id="games">
		<?php 
			$s = mysql_query("SELECT * FROM slideshow");
			if (mysql_num_rows($s) > 0) {
				while ($r = mysql_fetch_assoc($s)) {
					echo '
	<a href="'.$r['slide_link'].'" target="_blank"><img src="style/slide_img/img/'.$r['slide_img'].'" /></a> 
					';
				}// end while
			} else {
				echo "Không tìm thấy dữ liệu !";
			}
		 ?>

</div>
	<script>
		$('#games').coinslider();
	</script>