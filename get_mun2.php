<?php session_start();
include "header.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="css/register.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

</head>

<body>
<?
 $id_province=$_POST['id_province'];
$sqlSp="select id_mun,name_mun from municipality
 where id_province = '$id_province' ";

$resultSp=$db->query($sqlSp);

?><form id="form1" name="form1" method="post" action="manage_per_mun_proc.php">
<select name="id_mun" id="id_mun"><option value="">- เลือก -</option>
<? while($rsSp=$db->fetch_array($resultSp)){?>
<option value="<? echo $rsSp['id_mun'];?>"><? echo $rsSp['name_mun'];?></option>
<? }?>
</select></span></form>
</body>
</html>
<script type="text/javascript">
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>