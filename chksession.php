<?php  session_start();
//$strSQL  =" select id_personnel   from personnel where username_per='$_SESSION[LOGUSER]' and password_per='$_SESSION[LOGPASS]' and type_personnel!='5'";  //แสดงว่า logtype เป็น 5 ก็ไม่มีสิทธิื์เข้าแม้กะทั้งรายงาน หรือโดนบ็อกเลย
//$query =$db->query($strSQL );
//$row = $db->fetch_array($query);
//$id_personnel = $row['id_personnel'];


//$id_personnel==""||$_SESSION['LOGID']==""
if( $_SESSION['LOGNAME']==""){
	echo "<script>
	alert('กรุณา login ใหม่');
					window.location = 'logout.php';
					</script>";
		}
   // หน้านี้มีหน้าที่ ตรวจว่า มีค่า sessionที่ลงทะเบียนมา ตอนล็อกอินว่าตรงกับ user ในฐานข้อมูลหรือป่าว นอกจากlogtype=5 เท่้านั้นที่ไม่โดนตรวจสอบ
?>