<? session_start();
include "header.php";
include "chksession.php";

$tb_name="municipality";
$id_province=$_POST['id_province'];
$id_mun=$_REQUEST['id_mun'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<? 


	 $data['amount_way']=$_POST['amount_way']; 
	  $data['amount_phase_way']=$_POST['amount_phase_way']; 
	 $where="where id_mun='$id_mun'";
	 
	$db->update_data($tb_name,$data,$funcs,$where) ;
	 echo "<script>alert('แก้ไขเรียบร้อยแล้ว');	
				window.location = 'manage.php?page=manage_register&id_mun=$id_mun';</script>
				";
				$db->close_db();
	
	 ?>
</body>
</html>
