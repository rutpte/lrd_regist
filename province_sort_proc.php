<? session_start();
include "header.php";
include "chksession.php";
$tb_name="province";
$id_residence=$_POST['id_residence'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<?  $sql="select province_id from province where id_residence='$id_residence' order by num_orders,province_id";
	  $result=$db->query($sql);
	  $i=0;//ตั้งค่าไอ เป็น 0
while($rs=$db->fetch_array($result)){      /// while
	   if($_POST['num_orders'][$i]=="" or $_POST['num_orders'][$i]==":" or $_POST['num_orders'][$i]==";") {
          $_POST['num_orders'][$i]=0;
	   }
	 $where="where province_id='$rs[province_id]'";
	  $data['num_orders']=$_POST['num_orders'][$i]; // นี่คือค่าที่ส่งมา
	$db->update_data($tb_name,$data,$funcs,$where) ;
	$i++; //เพิ่ม ค่าไอ
}     
	 echo "<script>alert('เรียงใหม่เรียบร้อยแล้ว');	
				window.location = 'manage.php?page=manage_residence';</script>
				";
				$db->close_db();
 
	 
	 ?>
</body>
</html>
