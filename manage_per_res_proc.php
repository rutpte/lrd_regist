<? session_start();
  include "header.php";
include "chksession.php";
$proc=$_REQUEST['proc'];
$tb_name="personnel";
$id_personnel=$_REQUEST['id_personnel'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<? define('TOP_SECRET','The Top Secret From Drr Developer By Prapad Nedpakdee'); 
	 $data['username_per']=$_POST['username_per'];
	
	 $data['name_personnel']=$_POST['name_personnel']; 
	 $data['tel_personnel']=$_POST['tel_personnel']; 
	 $data['id_residence']=$_POST['id_residence'];   //สำนักทางหลวงชนบท(หลายจังหวัดรวมกัน)
	 /////  add ////////////////////////////////////////////////////////////////////////////
	 if($proc=="add"){
	 $data['password_per']=md5($_POST['password_per'].TOP_SECRET); 
	 $data['cre_date']=date("Y-m-d");
	 $data['type_personnel']="3";     //สทช ให้กำหนดค่าเริ่มต้นเป้น 3
	 //id_mun(orgc_id) ไม่ถูกส่งไป  //แสดงว่าคนกรอกไม่รู้ว่าเขาอยู่ อปท.ไหน
    //email_personnel ก็ไม่ี แสดงว่าไม่รู้ สงสัยพวกนี้คงเอาไปใส่ตอน user เข้าไปแก้ไขข้อมูลเอง
    //id_residence      ////////////////////// ตัวนี้มีอยู่ แต่สสท 2 ไม่มี
    //id_province จังหวัีด ก็ยังไม่ลงตอนนี้ ตอนแก้ไขส่วนตัวมั้ง  // สำนักทางหลวงชนบท(หลายจังหวัดรวมกัน)จึงยังไม่ใช้ตอนนี้
    //***status_personnel ถ้าเป้น 0 แสดงว่าใช้งานระบบได้ ถ้าเป็น 1 ไม่ให้ใช้ระบบ หรือลบออกจากระบบ ค่าดีฟอลน่าจะเป็น 0
    //***แต่ทั้งหมดที่ว่ามานี้ไม่มี ฟอร์มไหนให้เพิ่มได้เลย นอกจากเพิ่มที่ฐานข้อมูลโดยตรง

	 $add_data = $db->add_data($tb_name,$data,$funcs) ;
	 echo "<script>alert('บันทึกเรียบร้อยแล้ว');	
				window.location = 'manage.php?page=manage_per_res';</script>
				";
				$db->close_db();

///////////////////////////////////////////////////  edit  //////////////////////////////////				
	 }else if($proc=="edit"){
	 $where="where id_personnel='$id_personnel'";
	 $sqlS="select password_per from personnel $where";
	 $resultS=$db->query($sqlS);
	 $rsS=$db->fetch_array($resultS);
	 	 if($rsS['password_per']!=md5($_POST['password_per'].TOP_SECRET)&&$rsS['password_per']!=$_POST['password_per']){
	 	 $data['password_per']=md5($_POST['password_per'].TOP_SECRET);
	  if($_SESSION['LOGTYPE']==3){
		   $cc="มีการแก้ไขรหัสผ่าน ท่านจะออกจากระบบอัตโนมัติ  กรุณา Login เข้ามาใช้บริการใหม่โดยใช้รหัสผ่านใหม่";
	  }
	 }else {
	 
	  $data['password_per']=$rsS['password_per'];
	 }
	$db->update_data($tb_name,$data,$funcs,$where) ;
	 echo "<script>alert('แก้ไขเรียบร้อยแล้ว $cc');	
				window.location = 'manage.php?page=manage_per_res';</script>
				";
				$db->close_db();
	 }
	 else if($proc=="del"){
	 $data2['status_personnel']=1;
	 $where="where id_personnel='$id_personnel'";
	$db->update_data($tb_name,$data2,$funcs,$where) ;
	 echo "<script>alert('ลบเรียบร้อยแล้ว');	
				window.location = 'manage.php?page=manage_per_res';</script>
				";
				$db->close_db();
	 }
	 ?>
</body>
</html>
