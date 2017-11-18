<?php 
session_start();
require_once("./includes/connect.php");
include("./includes/function.php");

	// Kiểm tra ID truyền vào
if($id = validate_id($_GET['sid'])) 
{
		if ($id != "") // Nếu có ID truyền vào
		{
			if (isset($_SESSION['giohang'][$id])) 
			{
				// Tăng số lượng lên
				$_SESSION['giohang'][$id]++;
			}
			else
			{
				// Ngược lại thì bằng 1
				$_SESSION['giohang'][$id] = 1;
			}
		} 
		else 
		{

		}
		echo "<script>window.location.href='cart.php'</script>";
	} else {
		// Nếu ID không hợp lệ thì chuyển hướng về Index.
		echo "<script>window.location.href='index.php'</script>";
	}

	
	?>