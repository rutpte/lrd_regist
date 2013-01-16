<?php $strSQL  =" select id_personnel   from personnel where username_per='$_SESSION[LOGUSER]' and password_per='$_SESSION[LOGPASS]'";
   $query = mysql_query($strSQL) or die(mysql_error());
$row = mysql_fetch_array($query);
$id_personnel = $row['id_personnel'];



if($id_personnel==""){
	echo "<script>	
					window.location = '../login.php';
					</script>";
}	



?>