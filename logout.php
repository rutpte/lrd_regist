<?php session_start();
session_regenerate_id();
session_destroy();
unset($_SESSION);
session_start();
 
echo "<script>	
				window.location = 'login.php';
				</script>";
?>