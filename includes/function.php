<?php
	//Ham kiem tra loi cho cac input
	function checkError($loi, $nhap, $xuat='error')
	{
		if (isset($loi) && in_array($nhap, $loi)) 
		{
			echo $xuat;
		}
	}

	//Ham Save value trong input
	function saveValue($va='')
	{
		if(isset($_POST[$va])) echo $_POST[$va];
	}

	//Ham $_POST[]
	function get($valu)
	{
		return $_POST[$valu];
	}

	//Kiem tra du lieu truoc khi dua vao CSDL
	function checkData($content)
	{
		$content = trim($content);
		$content = mysql_real_escape_string($content);
		$$content = strip_tags($content);

		return $content;
	}

	// Tao paragraph tu CSDL
    function the_content($text) {
        $sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');
        return str_replace(array("\r\n", "\n"),array("<br>", ""),$sanitized);
    }

    // Rut gon doan van ban dai
    function short_text ($text) {
    	return substr($text, 0, strrpos($text, ' '));
    }

    // Kiem tra xem $id co hop le, la dang so hay khong?
    function validate_id($id) {
        if(isset($id) && filter_var($id, FILTER_VALIDATE_INT, array('min_range' =>1))) {
            $val_id = $id;
            return $val_id;
        } else {
            return NULL;
        }
    }

    // Ham tao ra de kiem tra xem co phai la admin hay khong
    function is_admin() {
        return isset($_SESSION['user_level']) && ($_SESSION['user_level'] == 1);
    }
	
?>