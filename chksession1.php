<?php $strSQL  =" select id_personnel   from personnel where username_per='$_SESSION[LOGUSER]' and password_per='$_SESSION[LOGPASS]' and type_personnel='5'";
$query =$db->query($strSQL );
$row = $db->fetch_array($query);
$id_personnel = $row['id_personnel'];



if($id_personnel==""||$_SESSION['LOGID']==""){
	echo "<script>	
					window.location = 'logout.php';
					</script>";
}	

?>