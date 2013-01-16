<? session_start();
include "header.php";
include "chksession.php";
$proc=$_REQUEST['proc'];
$tb_name="province";
$province_id=$_REQUEST['province_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<?   ////////// รับค่าไว้ก่อน   ///////////////// เอาไว้ใช้ บันทึก ,แก้ไข
	 $data['id_residence']=$_POST['id_residence'];
	 $data['province_name']=$_POST['province_name']; 
	  $data['drop_name']=$_POST['drop_name']; 
	 

	 //$data['location']=$_post or $_session //บันทึก จังหวัดของคน กรอกข้อมูล หรือป่าว

     $date=date("Y-m-d H:i:s");
     //echo $date;
   //$data['create_date']=$date;

	///----------------------->
	 if($proc=="add"){      //บันทึก
	 $data['create_date']=$date;
	 $data['create_by']=$_SESSION['LOGNAME'];
	 $add_data = $db->add_data($tb_name,$data,$funcs) ;
	 echo "<script>alert('บันทึกเรียบร้อยแล้ว');	
				window.location = 'manage.php?page=manage_province';</script>
				";
				$db->close_db();
				////////////////////////////////////////////////////
	 }else if($proc=="edit"){      //แก้ ใช้ตัวแปรข้างบน
	 $where="where province_id='$province_id'";
	 $data['update_date']=$date;
	 $data['update_by']=$_SESSION['LOGNAME'];
	$db->update_data($tb_name,$data,$funcs,$where) ;
	 echo "<script>alert('แก้ไขเรียบร้อยแล้ว');	
				window.location = 'manage.php?page=manage_province';</script>
				";
				$db->close_db();
				//////////////////////////////////////////////////// del
	 }
	 else if($proc=="del"){
	 $where="where province_id='$province_id'";
		$db->del_data($tb_name,$where) ;    //ฟังชั่นนี้ลบจริงๆ
	 echo "<script>alert('ลบเรียบร้อยแล้ว');	
				window.location = 'manage.php?page=manage_province';</script>
				";
				$db->close_db();
	 }
	 ?>
</body>
</html>
