<? session_start();
  include "header.php";
$proc=$_REQUEST['proc'];

include "chksession.php";

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
<? 
define('TOP_SECRET','The Top Secret From Drr Developer By Prapad Nedpakdee'); 
	 $data['username_per']=$_POST['username_per'];
	 $data['name_personnel']=$_POST['name_personnel']; 
	 $data['tel_personnel']=$_POST['tel_personnel']; 

	$data['email_personnel']=$_POST['email_personnel'];
	 if($proc=="add"){
	 $data['password_per']=md5($_POST['password_per'].TOP_SECRET); 
	 $data['cre_date']=date("Y-m-d");
	 $data['type_personnel']="5";

	 $add_data = $db->add_data($tb_name,$data,$funcs) ;

	 echo "<script>alert('บันทึกเรียบร้อยแล้ว');	
				window.location = 'manage.php?page=manage_per_mun';</script>
				";
				$db->close_db();
	 }else if($proc=="edit"){
	 $where="where id_personnel='$id_personnel'";
	 $sqlS="select username_per,password_per from personnel $where";
	 $resultS=$db->query($sqlS);
	 $rsS=$db->fetch_array($resultS);
	 	 if($rsS['password_per']!=md5($_POST['password_per'].TOP_SECRET)&&$rsS['password_per']!=$_POST['password_per']){
	 	 $data['password_per']=md5($_POST['password_per'].TOP_SECRET);
	 }else {
	 
	  $data['password_per']=$rsS['password_per'];
	 }
	$db->update_data($tb_name,$data,$funcs,$where) ;
		 		
					
	 echo "<script>alert('แก้ไขเรียบร้อยแล้ว');	
				window.location = 'manage.php?page=manage_per_mun';</script>
				";
				$db->close_db();
	 }
	 else if($proc=="del"){
	 $data2['status_personnel']=1;
	 $where="where id_personnel='$id_personnel'";
	$db->update_data($tb_name,$data2,$funcs,$where) ;
	 echo "<script>alert('ลบเรียบร้อยแล้ว');	
				window.location = 'manage.php?page=manage_per_mun';</script>
				";
				$db->close_db();
	 }
	 ?>
</body>
</html>
