<?php
    // Ket noi voi CSDL
	$hostName = "localhost";
	$userName = "root";
	$passName = "";
	$dbName   = "bansach";

    $dbc = mysql_connect("$hostName", "$userName", "$passName") 
    	or die("Could not connect to SERVER!");
    mysql_query("set names 'utf8'");
    mysql_select_db("$dbName")
    	or die("Could not connect to Database!");
    
?>