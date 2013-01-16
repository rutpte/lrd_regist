<? session_start();
include "header.php";
include "chksession.php";
$tb_name="org_comunity_detail";    //เปลี่ยนชื่อตารางใหม่ จาก org_comunity  เป็น org_comnity_detail
$province_id=$_POST['province_id'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<?  //org_comunity_detail.num_order,org_comunity.orgc_id

 $sql="select org_comunity.orgc_id
from org_comunity
inner join org_comunity_detail on org_comunity.orgc_id=org_comunity_detail.orgc_id
inner join amphur on org_comunity.amphur_id=amphur.amphur_id where amphur.province_id='$province_id' order by num_orders,org_comunity_detail.orgc_id asc";
	  $result=$db->query($sql);
	  $i=0;
while($rs=$db->fetch_array($result)){
	   if($_POST['num_orders'][$i]=="" or $_POST['num_orders'][$i]==":" or $_POST['num_orders'][$i]==";"){
           $_POST['num_orders'][$i]="0";
	   }
	 $where="where orgc_id='$rs[orgc_id]'";
	  $data['num_orders']=$_POST['num_orders'][$i];
	$db->update_data($tb_name,$data,$funcs,$where) ;
	$i++;
}     
	 echo "<script>alert('เรียงใหม่เรียบร้อยแล้ว');	
				window.location = 'manage.php?page=manage_mun&province_id=$province_id';</script>
				";
				$db->close_db();
 
	 
	 ?>
</body>
</html>
