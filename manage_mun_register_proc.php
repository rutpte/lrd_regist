<? session_start();
include "header.php";
include "chksession.php";
$proc=$_REQUEST['proc'];
$tb_name="municipality";
$id_province=$_POST['id_province']; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<? 
	$amount_way=$_POST['amount_way'];
	$amount_phase_way=$_POST['amount_phase_way'];
	$id_mun=$_POST['id_mun'];
	 $num_a=count($id_mun);

	for($j=0;$j<$num_a;$j++){
	
	 $where="where id_mun='$id_mun[$j]'";
	$data['amount_way']=$amount_way[$j]; 
	$data['amount_phase_way']=$amount_phase_way[$j]; 
	$db->update_data($tb_name,$data,$funcs,$where) ;
}
	 echo "<script>alert('จัดเก็บหรือแก้ไขข้อมูลเรียบร้อยแล้ว');	
				window.location = 'manage.php?page=add_mun_register&id_province=$id_province';</script>
				";
				$db->close_db();
	?>
	 
</body>
</html>
