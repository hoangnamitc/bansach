<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo (isset($title) ? $title : "Website bán sách"); ?></title>
	<script type="text/javascript" src="http://localhost/bansach/js/tinymce/tiny_mce.js"></script>
	<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		plugins : "emotions,spellchecker,advhr,insertdatetime,preview", 
		
        // Theme options - button# indicated the row# only
        theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,fontselect,fontsizeselect,formatselect",
        theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,|,code,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "insertdate,inserttime,|,spellchecker,advhr,,removeformat,|,sub,sup,|,charmap,emotions",      
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true
    });
	</script>		
	<link rel="stylesheet" href="style/style.css">
	<link rel="shortcut icon" href="style/book.ico" />
</head>
<body>
	<div id="taskbar-container">
		<div id="taskbar">
			<div class="taskbar-region-left">
				<div class="chuyenmuc">
					<a href="index.php" title="Trang chu" class="trang_chu">Home</a>
				</div><!-- end chuyenmuc -->
				<div class="login">
					<?php 
							//Kiem tra nguoi dung da login hay chua
					if (isset($_SESSION['user_level'])) {
								// Neu user da login thanh cong thi hide form login
						echo "Xin chào: <strong><a href='./thongtin_user.php?uid=$_SESSION[uid]'>". $_SESSION['user_name']."</a></strong>";
						echo " <a href='logout.php' title='Thoát'><span class='lout'>a</span></a>";
					} else {
						echo "<a href='login.php' title='Đăng nhập' class='loin'>Đăng nhập</a>";
					}
					?>
				</div><!-- end login -->
			</div><!-- end taskbar-region-left -->

			<div class="taskbar-region-right">
				<div class="search">
					<form action="seach.php" method="post">
						<input type="text" name="txtSeach" value="" placeholder="Nhập nội dung cần tìm">
						<input type="submit" name="seach" value="Tìm kiếm">
					</form>
				</div><!-- end seach -->
			</div><!-- end taskbar-region-right -->
		</div><!-- end taskbar -->
	</div><!-- end taskbar-container -->
	<div id="wrapper">
		<div id="header">
			<div class="banner"></div><!-- end banner -->
			
			<div class="menu">
				<ul>
					<li><a href="index.php" title="">Trang chủ</a></li>
					<li><a href="lienhe.php" title="">Liên hệ</a></li>
					<li><a href="gioithieu.php">Giới thiệu</a></li>
					<?php 
				// Nếu là Admin thì hiện thêm mục AdminCP
					if(isset($_SESSION['user_level']) && $_SESSION['user_level'] == 1) {
						echo "<li><a href='admincp/index.php' target='_blank'>AdminCP</a></li>";
					} else {
						echo "<li></li>";
					}

					?>
					
					<!-- Lấy số lượng giỏ hàng -->
					<li class="cart">
						<a href="cart.php" title="Xem giỏ hàng của bạn" class="ico_cart">Giỏ hàng:
							<span id="num_cart">
								<?php 
								if(isset($_SESSION['giohang'])) echo count($_SESSION['giohang']); else echo "0";
								?>
							</span></a>
						</li>
					</ul>
				</div><!-- end menu -->
			</div><!-- end header -->
	<!-- <div style="clear:both"></div> -->