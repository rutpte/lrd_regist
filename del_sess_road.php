<? session_start();
include "header.php";
include "chksession.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body><? 
$chk[]=$_POST['sess_road_del'];

for ($i=0;$i<count($_SESSION['sess_period_regis']);$i++) {

		if (!in_array($_SESSION['sess_period_regis'][$i],$chk)) {
		
			$temp_period_regis[]=$_SESSION['sess_period_regis'][$i];
			$temp_kate_regis[]=$_SESSION['sess_kate_regis'][$i];
			$temp_distance_regis[]=$_SESSION['sess_distance_regis'][$i];
			$temp_jarat_road[]=$_SESSION['sess_jarat_road'][$i];
			$temp_type_ja[]=$_SESSION['sess_type_ja'][$i];
			$temp_width_ja[]=$_SESSION['sess_width_ja'][$i];
			$temp_type_sh[]=$_SESSION['sess_type_sh'][$i];
			$temp_width_sh[]=$_SESSION['sess_width_sh'][$i];
			$temp_type_fo[]=$_SESSION['sess_type_fo'][$i];
			$temp_width_fo[]=$_SESSION['sess_width_fo'][$i];
			$temp_note[]=$_SESSION['sess_note'][$i];
		}
}

$_SESSION['sess_period_regis']=$temp_period_regis;
$_SESSION['sess_kate_regis']=$temp_kate_regis;
$_SESSION['sess_distance_regis']=$temp_distance_regis;
$_SESSION['sess_jarat_road']=$temp_jarat_road;
$_SESSION['sess_type_ja']=$temp_type_ja;
$_SESSION['sess_width_ja']=$temp_width_ja;
$_SESSION['sess_type_sh']=$temp_type_sh;
$_SESSION['sess_width_sh']=$temp_width_sh;
$_SESSION['sess_type_fo']=$temp_type_fo;
$_SESSION['sess_width_fo']=$temp_width_fo;
$_SESSION['sess_note']=$temp_num;
$_SESSION['sess_sum_distance']=array_sum($_SESSION['sess_distance_regis']);



?>	
		<script language="JavaScript">
window.open('','_self');
window.close() ;
</script> 


	
</body>
</html>
