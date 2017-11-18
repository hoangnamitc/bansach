<?php session_start(); ?>
<?php
$title = "Thông tin thanh toán"; 
require_once("./includes/connect.php");
include("./includes/function.php");
include("./includes/header.php");
include("./includes/sidebar-a.php");

	// Kiểm tra người người dùng đã login chưa?
if(isset($_SESSION['user_level'])) {
	include("thanhtoan_user.php");
} else {
	include("thanhtoan_guest.php");
}
?>
