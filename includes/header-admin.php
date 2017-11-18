<!DOCTYPE html>
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
<div id="wrapper">
	<div id="header">
		<div class="banner"></div><!-- end banner -->	
		<div class="menu">
			<ul>
				<li><a href="index.php" >Trang chủ</a></li>
				<li><a href="ql_lienhe.php">Liên hệ</a></li>
				<li><a href="ql_gioithieu.php">Giới thiệu</a></li>
				<li><a href="../index.php" target="_blank">Website</a></li>
			</ul>
		</div><!-- end menu -->
	</div><!-- end header -->
	<!-- <div style="clear:both"></div> -->