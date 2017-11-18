<?php 
session_start();
require_once("./includes/connect.php");
include("./includes/function.php");
include("./includes/header.php");
include("./includes/sidebar-a.php");
?>

<div class="noidung">
    <?php 
    $errors = array();
    if (isset($_POST['submit'])) {

        //Check Form
        if (empty($_POST['txtName'])) {
            $errors[] = "txtName";
        } else {
            $txtName = checkData($_POST['txtName']);
        }// end name

        if(empty($_POST['txtEmail'])) {
            $errors[] = "txtEmail";
        } elseif (!preg_match('/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$/', $_POST['txtEmail'])) {
            $errors[] = "wrong_email";
        } else {
            $txtEmail = checkData($_POST['txtEmail']);
        }// end Mail

        if (empty($_POST['txtNoidung'])) {
            $errors[] = "txtNoidung";
        } else {
            $txtNoidung = mysql_real_escape_string(trim($_POST['txtNoidung']));
        }// end noidung

        // Chen vao CSDL
        if (empty($errors)) {
            $s = "INSERT INTO lienhe(lhe_name, lhe_email, lhe_comment, ngaygui) 
            VALUES('$txtName', '$txtEmail', '$txtNoidung', NOW())";
            $q = mysql_query($s) or die("Không thể chèn !");
            if (mysql_affected_rows($dbc) == 1) {
                $mess = "<span class='success'>Thành công ! Cảm ơn bạn đã đóng góp ý kiến.</span>";
            } else {
                $mess = "<span class='error'>Email của bạn không thể gửi, vui lòng thử lại sau !</span>";
            }
        } else {
            $mess = "<span class='error'>Bạn chưa điền đầy đủ thông tin</span>";
        }
    }// end IF ISSET
    ?>
    <div class="lienhe">
        <form id="contact" action="" method="post">
            <fieldset>
               <legend>Liên hệ</legend>
               <?php 
               if (!empty($mess)) {
                echo $mess;
            }
            ?>
            <div>
                <label for="Name">Họ tên: <span class="required">*</span>
                </label>
                <input type="text" name="txtName" id="name" value='<?php saveValue('txtName'); ?>' size="20" maxlength="80" tabindex="1" />
                <?php checkError($errors, 'txtName', '<span class="warning">Bạn chưa nhập tên !</span>') ?>
            </div>
            <div>
                <label for="email">Email: <span class="required">*</span>
                </label>
                <input type="text" name="txtEmail" id="email" value='<?php saveValue('txtEmail'); ?>' size="20" maxlength="80" tabindex="2" />
                <?php checkError($errors, 'txtEmail', '<span class="warning">Bạn chưa nhập Email !</span>') ?>
                <?php checkError($errors, 'wrong_email', '<span class="warning">Email không hợp lệ !</span>') ?>
            </div>
            <div>
                <label for="comment">Nội dung: <span class="required">*</span>
                 <?php checkError($errors, 'txtNoidung', '<span class="warning">Bạn chưa nhập nội dụng !</span>') ?>
             </label>
             <div id="contact">
                <textarea name="txtNoidung" id="comment" rows="10" cols="45" tabindex="3"></textarea>
            </div>
        </div>
    </fieldset>
    <div><input type="submit" name="submit" value="Gửi" /></div>
</form>
</div>
</div><!-- end noidung -->
<?php include("./includes/footer.php"); ?>