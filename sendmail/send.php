<?php
if($_POST['to']=="" || $_POST['subject']=="" || $_POST['message']=="" || $_POST['from']=="" )//ตรวจสอบการส่งข้อความว่าครบหรือไม่
{
		echo"<center>กรอกข้อมูลไม่ครบ<br>";
		echo"<a href=javascript:history.back();>กลับไปแก้ไข</a></center>";
		exit();

}else{//ถ้าถูกต้องดำเนินการส่งเมล์ได้เลย

if (mail($_POST['to'], $_POST['subject'], $_POST['message'], $_POST['from']))
	{
	
	echo "<center>ขณะนี้ส่งเมลล์ไปให้ $to เรียบร้อยแล้ว</br>";
	echo"<a href=formmail.html>กลับไปส่งต่ออีก</a></center>";

	}
}
?>

