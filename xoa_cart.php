<?php 
session_start();
require_once("./includes/connect.php");
include("./includes/function.php");

if($id = validate_id($_GET['sid'])) 
{
	unset($_SESSION['giohang'][$id]);
	echo "<script>window.location.href='cart.php'</script>";
}
else
{
	echo "<script>window.location.href='cart.php'</script>";
}
?>