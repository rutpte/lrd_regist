<?php  	 	 $PAGE=$_GET['PAGE'];
			 $Page=$_GET['Page'];
			 $page=$_GET['page'];
			   $mainpath = '';
			   include($mainpath.'../include/config.inc.php');
			   include($mainpath.'../include/class_db.php');
			   include($mainpath.'../include/class_display.php');
			   include($mainpath.'../include/class_application.php');	   
			   $CLASS['db']   = new db();
			   $CLASS['db']->connect ();
			   $CLASS['app'] = new application();
			   $CLASS['disp'] = new display();
			   $db   = $CLASS['db'];
			   $disp = $CLASS['disp'];
			   $app = $CLASS['app'];
/*eader("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i ") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0*/
date_default_timezone_set("Asia/Bangkok");
?>