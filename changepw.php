<?php session_start(); ?>
<?php 
require_once("./includes/connect.php");
include("./includes/function.php");
include("./includes/header.php");
include("./includes/sidebar-a.php");
?>
<div class="noidung">
<?php 
	// Kiểm tra đăng nhập
	if(isset($_SESSION['user_level'])) 
	{
		// Check ID USER
		if ($id = validate_id($_SESSION['uid']))
		{
			// GET thông tin người dùng
			$errors = array();
			$get = "SELECT user_name, password FROM users WHERE user_id = '$id' LIMIT 1";
			$getok = mysql_query($get) or die("SAI SQL");

			// Kiểm tra người dùng có trong CSDL không?
			if (mysql_num_rows($getok) > 0)
			{
				$rows = mysql_fetch_assoc($getok);
			}
			else
			{
				echo "<script>alert('Không tìm thầy người dùng!')</script>";
				echo "<script>window.location.href='index.php'</script>";
			}
// Xử lý Form
			if (isset($_POST['dongy']))
			{

				// xử lý thông tin đổi mật khẩu
				if (empty($_POST['old_pw']))
				{
					$errors[] = "null_oldpw";
				}
				elseif ($_POST['old_pw'] != $rows['password']) 
				{
					$errors[] = "false_oldpw";
				}
				elseif (empty($_POST['new_pw']))
				{
					$errors[] = "null_newpw";
				}
				elseif (empty($_POST['pre_pw']))
				{
					$errors[] = "null_prepw";
				}
				elseif ($_POST['new_pw'] != $_POST['pre_pw'])
				{
					$errors[] = "false_prepw";
				}
				else
				{
					$matkhau = checkData($_POST['pre_pw']);
				}

				// Update Password
				if (empty($errors))
				{
					$uppw = "UPDATE users SET password = '$matkhau' WHERE user_id = '$id' LIMIT 1";
					$pwok = mysql_query($uppw) or die("SAI SQL");

					if (mysql_affected_rows($dbc) == 1)
					{
						echo "<script>alert('Mật khẩu của bạn đã được thay đổi.')</script>";
						echo "<script>window.location.href='index.php'</script>";
					}
					else
					{
						echo "<script>alert('Không thể đổi mật khẩu.')</script>";
					}
				}
			}
?>
<fieldset>
	<legend>Đổi mật khẩu</legend>
	<form action="" method="post">
		<div>
			<label>Tên đăng nhập:</label>
			<input type="text" name="" value="<?php echo $rows['user_name']; ?>" disabled>
		</div>
		<div>
			<label>Mật khẩu hiện tại:</label>
			<input type="password" name="old_pw" value="">
			<?php 
				checkError($errors, 'null_oldpw', '<span class="warning"> Hãy nhập mật khẩu hiện tại.</span>');
				checkError($errors, 'false_oldpw', '<span class="warning"> Mật khẩu hiện tại không đúng.</span>');
			 ?>
		</div>
		<div>
			<label>Mật khẩu mới:</label>
			<input type="password" name="new_pw" value="">
			<?php 
				checkError($errors, 'null_newpw', '<span class="warning"> Hãy nhập mật khẩu mới.</span>');
			 ?>
		</div>
		<div>
			<label>Nhập lại mật khẩu mới:</label>
			<input type="password" name="pre_pw" value="">
			<?php 
				checkError($errors, 'null_prepw', '<span class="warning"> Hãy nhập lại mật khẩu mới.</span>');
				checkError($errors, 'false_prepw', '<span class="warning"> Mật khẩu không khớp.</span>');
			 ?>
		</div>
		<div>
			<input type="submit" name="dongy" value="Hoàn tất">
			<input type="reset" name="canle" value="Nhập lại">
		</div>
	</form>
</fieldset>
<?php
			
		}
		else
		{
			// ID False
			echo "<script>alert('Người dùng không tồn tại!')</script>";
			echo "<script>window.location.href='index.php'</script>";
		}
	}
	else 
	{
	// Chưa login
		echo "<script>alert('Hãy đăng nhập để đổi mật khẩu!')</script>";
		echo "<script>window.location.href='index.php'</script>";
	}
?>
</div><!-- end noidung -->
<?php include("./includes/footer.php"); ?>		