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

$nums=count($_SESSION['sess_period_regis'])+1;
$_SESSION['sess_period_regis'][]=$nums;
$_SESSION['sess_kate_regis'][]=$_POST['kate_regis'];
$_SESSION['sess_distance_regis'][]=$_POST['distance_regis'];
$_SESSION['sess_jarat_road'][]=$_POST['jarat_road'];
$_SESSION['sess_type_ja'][]=$_POST['type_ja'];
$_SESSION['sess_width_ja'][]=$_POST['width_ja'];
$_SESSION['sess_type_sh'][]=$_POST['type_sh'];
$_SESSION['sess_width_sh'][]=$_POST['width_sh'];
$_SESSION['sess_type_fo'][]=$_POST['type_fo'];
$_SESSION['sess_width_fo'][]=$_POST['width_fo']; 
$_SESSION['sess_note'][]=$_POST['note']; 
$_SESSION['sess_sum_distance']=array_sum($_SESSION['sess_distance_regis']);

?>	
		<script language="JavaScript">
								parent.parent.GB_hide();
						  </script>  

	
</body>
</html>
