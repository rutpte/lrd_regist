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
<? 

if($_POST['sess_ba_del']){
$sess_ba_del=$_POST['sess_ba_del'];
unset($_SESSION['sess_distance_regis2'][$sess_ba_del]);

}
if($_POST['send_edit_distance_regis']){

unset($_SESSION['sum_road']);
unset($_SESSION['sum_droad']);

$dist=explode(",",$_POST['send_edit_distance_regis']);
$numDi=count($dist);

for($i=0;$i<$numDi;$i++){

$_SESSION['sess_distance_regis2'][$_SESSION['numD']+$i]=$dist[$i];
}

}
if($_SESSION['sess_distance_regis2']!=""){
$_SESSION['sum_road']=array_sum($_SESSION['sess_distance_regis2']);}
$_SESSION['sum_droad']= $_SESSION['amount_phase_way']-$_SESSION['sum_road'];

 ?>
<input type="text" id="sum_droad1" name="sum_droad1" style="width:80px; background-color:#CCCC99" readonly="" value="<? echo number_format($_SESSION['sum_droad'],3,'.',',');?>"  /> 
<input type="hidden" id="sum_droad" name="sum_droad" style="width:80px; background-color:#CCCC99" readonly="" value="<? echo $_SESSION['sum_droad'];?>"  />
<input type="hidden" id="sum_amount_phase_wayB" name="sum_amount_phase_wayB" style="width:80px; background-color:#CCCC99" readonly="" value="<? echo $_SESSION['amount_phase_way'];?>"  />
    <input type="hidden" id="sum_d2" name="sum_d2" style="width:80px; background-color:#CCCC99" readonly="" value="<? echo array_sum($_SESSION['sum_d2']);?>"  />


</body>
</html>
