<? session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/register.css" rel="stylesheet" type="text/css" />
</head>

<body> 
<? if($_POST['distance_regis']!=""){
$_SESSION['sess_distance_regis1'][]=$_POST['distance_regis'];
}
if($_POST['sess_road_del']!=""){
$sess_road_del=$_POST['sess_road_del'];
unset($_SESSION['sess_distance_regis1'][$sess_road_del]);
}

if($_POST['send_edit_distance_regis']){
	
unset($_SESSION['sess_sum_distance1']);
unset($_SESSION['sess_distance_regis1']);

$dist=explode(",",$_POST['send_edit_distance_regis']);

$numDi=count($dist);
for($i=0;$i<$numDi;$i++){

 $_SESSION['sess_distance_regis1'][]=$dist[$i];

}

}
if($_POST['sum_se_road']){
unset($_SESSION['sess_sum_distance12']);
$_SESSION['sess_sum_distance12']=$_POST['sum_se_road'];	
}
//////////////////////////////////////////////////////////////  ส่วน onload  //////////////////////////////
if($_SESSION['sess_distance_regis1']!=""){
$_SESSION['sess_sum_distance1']=array_sum($_SESSION['sess_distance_regis1']);}
?>
<!--/////////////////////////////////////////////////////////////////////////////-->
<input type="text" id="distance_road1" name="distance_road1" style="width:100px;" disabled="disabled" value="<? echo number_format($_SESSION['sess_sum_distance12']-$_SESSION['sess_sum_distance1'],3,'.',',');?>"  /> 
<input type="hidden" id="distance_total" name="distance_total" style="width:100px;"  value="<? echo number_format($_SESSION['sess_sum_distance1'],3,'.',',');?>"  /> 
 
<span class="th11black">(กม.)</span>
</body>
</html>
