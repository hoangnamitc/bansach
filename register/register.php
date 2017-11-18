<?php include("validateform.php"); ?>
<div class="register">
<form action="" method="POST" name="lhnam_form" id="contact">
	<fieldset>
		<legend>ĐĂNG KÝ THÀNH VIÊN</legend>

		<div class="gioitinh">
			<input type="radio" class="gt" value="1" name="gt" checked>
			<label>Anh</label>
			<input type="radio" class="gt" value="0" name="gt">
			<label>Chị</label>
		</div><!-- End giới tính -->

		<div> 
			<?php 
				if (!empty($message)) { 
					echo "{$message}";
				} 
			?>
		</div>

		<div class="firts">
			<label>Họ và tên: <span>*</span></label>
			<input type="text" name="hoten" value="<?php if(isset($_POST['hoten'])) echo strip_tags($_POST['hoten']); ?>" placeholder="Nhập tên thật...">

			<?php 
				echo "<br/>"; 
				if(isset($errors) && in_array("empty_hoten", $errors)) { 
					echo "<span class='warning'>Hãy nhập họ tên thật của bạn !</span>";
				} elseif (isset($errors) && in_array("long_hoten", $errors)) {
					echo "<span class='warning'>Tên phải là trong khoảng từ 2-40 ký tự !</span>";
				}
			 ?>

		</div><!-- End ten that -->

		<div>
			<label>Tên đăng nhập: <span>*</span></label>
			<input type="text" class="username" name="tendn" value="<?php if(isset($_POST['tendn'])) echo strip_tags($_POST['tendn']); ?>" placeholder="Tên đăng nhập..."/>

			<?php 
				if (isset($errors) && in_array("empty_tendn", $errors)) {
					echo "<span class='warning'>Hãy nhập tên đăng nhập để đăng nhập vào website !</span>";
				} elseif (isset($errors) && in_array("long_tendn", $errors)) {
					echo "<span class='warning'>Tên đăng nhập phải được viết liền không dấu và trong khoảng 4-20 ký tự !</span>";
				} elseif (isset($errors) && in_array("trung_tendn", $errors)) {
					echo "<span class='warning'>Tên đăng nhập này đã được sử dụng, 
													Vui lòng chọn tên khác !</span>";
				}
			 ?>
		</div><!-- End Username -->

		<div>
			<label>Mật khẩu: <span>*</span></label>
			<input type="password" class="pass" name="pass" value="<?php if(isset($_POST['pass'])) echo strip_tags($_POST['pass']); ?>" placeholder="Mật khẩu..."/>

			<?php 
				if (isset($errors) && in_array("empty_pass", $errors)) {
					echo "<span class='warning'>Hãy nhập mật khẩu !</span>";
				} elseif (isset($errors) && in_array("long_pass", $errors)) {
					echo "<span class='warning'>Độ dài của mật khẩu trong khoảng 6-20 ký tự !</span>";
				}
			 ?>
		</div><!-- End Password -->

		<div>
			<label>Nhập lại mật khẩu: <span>*</span></label>
			<input type="password" class="repass" name="pass2" value="<?php if(isset($_POST['pass2'])) echo strip_tags($_POST['pass2']); ?>" placeholder="Nhập lại mật khẩu..."/>

			<?php 
				if (isset($errors) && in_array("empty_pass2", $errors)) {
					echo "<span class='warning'>Hãy xác nhận nhập mật khẩu !</span>";
				} elseif (isset($errors) && in_array("long_pass2", $errors)) {
					echo "<span class='warning'>Độ dài của mật khẩu trong khoảng 6-20 ký tự !</span>";
				} elseif (isset($errors) && in_array("ss_pass", $errors)) {
					echo "<span class='warning'>Mật khẩu không khớp !</span>";
				}

			 ?>
		</div><!-- End password2 -->

		<div>
			<label>Email: <span>*</span></label>
			<input type="text" class="email" name="email" value="<?php if(isset($_POST['email'])) echo strip_tags($_POST['email']); ?>" placeholder="Email..." />

			<?php 
				if (isset($errors) && in_array("empty_email", $errors)) {
					echo "<span class='warning'>Hãy nhập Email của bạn !</span>";
				} elseif (isset($errors) && in_array("wrong_email", $errors)) {
					echo "<span class='warning'>Email không hợp lệ, vui lòng thử lại !</span>";
				} elseif (isset($errors) && in_array("trung_mail", $errors)) {
					echo "<span class='warning'>Email này đã được đăng ký, Vui lòng chọn Email khác !</span>";
				}
			 ?>
		</div><!-- End email -->

		<div>
			<label>Ngày sinh:</label>
				<?php 
					echo "<select class='ngay' name='ngaysinh'>";
						for ($i=1; $i <=31 ; $i++) { 
							echo "<option value='".$i."'";
								if (isset($_POST['ngaysinh']) && $_POST['ngaysinh'] == $i) {
									echo "selected = selected";
								}
							echo ">Ngày ".$i." </option>";
						}
					echo "</select>";
				 ?>

				 <?php 
				 	echo "<select class='thang' name='thangsinh'>";
				 		for ($j=1; $j <=12 ; $j++) { 
				 			echo "<option value='".$j."'";
				 				if (isset($_POST['thangsinh']) && $_POST['thangsinh'] == $j) {
				 					echo "selected = selected";
				 				}
				 			echo ">Tháng ".$j."</option>";
				 		}
				 	echo "</select>";
				  ?>

			<input type="text" class="namsinh" name="namsinh" value="<?php if(isset($_POST['namsinh'])) echo strip_tags($_POST['namsinh']); ?>" placeholder="Năm..."/>
			<?php 
				if (isset($errors) && in_array("wrong_namsinh", $errors)) {
					echo "<span class='warning'>Năm sinh của bạn không hợp lệ, vui lòng thử lại !</span>";
				}
			 ?>
		</div><!-- End birthday -->

		<div>
			<label>Số điện thoại: <span>*</span></label>
			<input type="text" class="phone" name="phone" value="<?php if(isset($_POST['phone'])) echo strip_tags($_POST['phone']); ?>" placeholder="Số điện thoại..." />

			<?php
				if(isset($errors) && in_array("null_phone", $errors)) {
					echo "<span class='warning'>Bạn chưa nhập số điện thoại !</span>";
				} elseif (isset($errors) && in_array("wrong_phone", $errors)) {
					echo "<span class='warning'>Điện thoại bạn nhập không hợp lệ, vui lòng thử lại !</span>";
				}
			 ?>
		</div><!-- End phone -->

		<div>
			<label>Địa chỉ: <span>*</span></label>
			<input type="text" name="txtDiaChi" value="<?php if(isset($_POST['txtDiaChi'])) {echo strip_tags($_POST['txtDiaChi']);} ?>" placeholder="Nhập địa chỉ">
			<?php 
				if(isset($errors) && in_array("null_diachi", $errors)) {
					echo "<span class='warning'>Bạn chưa nhập địa chỉ !</span>";
				} elseif (isset($errors) && in_array("wrong_diachi", $errors)) {
					echo "<span class='warning'>Địa chỉ không hợp lệ!</span>";
				}
			 ?>
		</div>

		<div>
			<label>Thành phố: <span>*</span></label>
			<input type="text" name="txtThanhPho" value="<?php if(isset($_POST['txtThanhPho'])) {echo strip_tags($_POST['txtThanhPho']);} ?>" placeholder="Nhập thành phố bạn đang sống">
			<?php 
				if(isset($errors) && in_array("null_thanhpho", $errors)) {
					echo "<span class='warning'>Bạn chưa nhập thành phố !</span>";
				} elseif (isset($errors) && in_array("wrong_thanhpho", $errors)) {
					echo "<span class='warning'>Thành phố không hợp lệ!</span>";
				}
			 ?>
		</div>

		<div>
			<label>Mã Bưu điện (Zip): <span>*</span></label>
			<input type="text" name="txtMaBD" value="" class="namsinh" placeholder="Mã bưu điện">
			<?php 
				if(isset($errors) && in_array("null_mabd", $errors)) {
					echo "<span class='warning'>Bạn chưa nhập mã bưu điện !</span>";
				} elseif (isset($errors) && in_array("wrong_mabd", $errors)) {
					echo "<span class='warning'>Mã bưu điện không hợp lệ!</span>";
				}
			 ?>
		</div>

		<div class="capcha">
			<label>Mã xác nhận: <span>*</span></label>
			<img src="./register/captcha/captcha.php">
			<input type="text" name="captcha" value="" class="capcha" maxlength="6" placeholder="Nhập chuỗi bên cạnh">
			<?php 
				if (isset($errors) && in_array("empty_captcha", $errors)) {
					echo "<span class='warning'>Hãy nhập mã xác nhập !</span>";
				} elseif (isset($errors) && in_array("wrong_captcha", $errors)) {
					echo "<span class='warning'>Mã xác nhận không đúng, vui lòng thử lại !</span>";
				}
			 ?>
		</div><!-- End Captcha -->

		<div>
			<input type="checkbox" class="agree" name="agree" value="" <?php if(isset($_POST['agree'])) echo "checked='checked'"; ?>>
			<label class="agree">Tôi đồng ý với <a href="#">điều khoản sử dụng.</a> </label>

			<?php 
				if (isset($errors) && in_array("null_agree", $errors)) {
					echo "<span class='warning'>Bạn phải đồng ý các điều khoản để được tiếp tục.</span>";
				}
			 ?>
			<input type="submit" name="oke" value="Đăng ký" class="button" />
		</div><!-- End Submit -->

	</fieldset><!-- End fieldset -->
</form>
</div><!-- end register -->