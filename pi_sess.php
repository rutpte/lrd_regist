<?php session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<? if($_POST['active']==1){ 
$nums1=count($_SESSION['sess_period_regis1']);
$_SESSION['sess_period_regis1'][]=$nums1;
}
if($_POST['sess_road_del']!=""){
$sess_road_del=$_POST['sess_road_del'];
unset($_SESSION['sess_period_regis1'][$sess_road_del]);
}
if($_POST['numS']!=""){
unset($_SESSION['sess_period_regis1']);
for($i=0;$i<$_POST['numS'];$i++){
$_SESSION['sess_period_regis1'][]=$i;
}
}
?> 
เพิ่มข้อมูลลักษณะสายทางช่วงที่<?php echo count($_SESSION['sess_period_regis1'])+1; 

?>
</body>
</html>
