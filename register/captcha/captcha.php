<?php 
	session_start();
	function create_image()
	{
		$md5_hash = md5(rand(0, 999)); //Create 1 String Random(0, 999)
		$security_code = substr($md5_hash, 15, 6); //Cut String $md5_hash -> Substr(vitri:15, 6 kytu)
		$_SESSION['security_code'] = $security_code; //Gan SESSION cho Substr $security_code
		$width = 72; // chieu dai cua String
		$height = 30; // chieu rong cua String
		$image = imagecreate($width, $height); //Create image
		$white = imagecolorallocate($image, 255, 255, 255); //Set color
		$black = imagecolorallocate($image, 0, 0, 0);		//Set color
		imagefill($image, 0, 0, $black); 
		imagestring($image, 5, 10, 6, $security_code, $white); // vi tri cua str(size, x, y)
		header("Content-Type: image/png");
		imagejpeg($image);
		imagedestroy($image);
	}
	create_image();
	exit();
 ?>