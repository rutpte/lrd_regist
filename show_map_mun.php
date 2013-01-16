<? include("header.php");
	$id_regis=$_GET['id_regis'];
	$sql="SELECT `province`.id_province,name_province,drop_name,`municipality`.name_mun,`register_road`.pic_map_mun,name_residence,`register_road`.name_road
FROM
  `register_road`
    INNER JOIN `municipality` ON (`municipality`.`id_mun` = `register_road`.`id_mun`)
  INNER JOIN `province` ON (`province`.`id_province` = `municipality`.`id_province`)
  INNER JOIN `residence` ON (`province`.`id_residence` = `residence`.`id_residence`) where `register_road`.id_regis='$id_regis'";
  $result=$db->query($sql);
  $rs=$db->fetch_array($result);
  $type_file=explode(".",$rs['pic_map_mun']);
  if($type_file[1]!="pdf"){
   if($rs['pic_map']==""){
	$sa=getimagesize("image/no_image.jpg");
	$shW=$sa[0]+300;
 $shH=$sa[1]+300;
   }
  else{
	  $sa=getimagesize($rs['pic_map_mun']);
		$shW=$sa[0]+100;
 $shH=$sa[1]+100;
}}else if($type_file[1]=="pdf"){
		echo "<script>
				window.location.href('download_map.php?id_mun=$id_mun')</script>";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type ="text/javascript" language="javascript" >
function resize_(){
    window.resizeTo(<? echo $shW;?>,<? echo $shH;?>);

	moveTo(350,0);
}
</script>


<style type="text/css">




@media print {
				input#printButton 
					{
						display: none;
					}
				input#pic_print 
					{
						display: none;
					}
					input#printDownload 
					{
						display: none;
					}
			}

</style>


<link href="css/register.css" rel="stylesheet" type="text/css" />
</head>

<body onload="javascript:resize_();">

<div align="center"><br/>
 <input name="pic_print" id="pic_print" type="image"   src="image/b_print.gif" onClick="javascript:window.print();"/>
  <input type="button" id="printButton" onClick="javascript:window.print();" value="พิมพ์แผนที่" />
   <input type="button" id="printDownload" onClick="javascript:window.location.href('download_map.php?id_mun=<? echo $id_mun; ?>');" value="ดาวน์โหลด" />
  &nbsp;&nbsp;
 
  
</div><br/>
<table width="601" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="">

     
	    <tr>
        <td class="th14bgray"  align="center">ทชจ.&nbsp;<? echo $rs['name_province'];?>&nbsp;&nbsp;<? echo $rs['name_residence']?>
          </td>
      </tr>
	     <tr>
        <td class="th14bgray"  align="center">หน่วยงาน&nbsp;<? echo $rs['name_mun'];?>  </td>
      </tr>
      <tr>
        <td class="th14bgray_line"  align="center">ชื่อสายทาง&nbsp;<? echo $rs['name_road'];?>  </td>
      </tr>
      
    </table>
<table  border="0" align="center">

  <tr>
    <td align="center"><? if($rs['pic_map_mun']!=""){?><img src="<? echo $rs['pic_map_mun'];?>"  /><? }else{?><img src="image/no_image.jpg"  /><? }?></td>
  </tr>

</table>    

</body>
</html>
