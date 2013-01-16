<? //session_start(); 
include "header.php";



if($page==""){
$vh="";

}
else {
$vh="valign='top'";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $project_title;?></title>
<link href="css/register.css" rel="stylesheet" type="text/css" />
</head>
<body>

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#79BD87">
  <tr>
    <td valign="top"><table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="middle" align="center" height="125" ><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="1000" height="125">
  <param name="movie" value="image/banner.swf" />
  <param name="quality" value="high" />
  <param name="allowScriptAccess" value="always" />
     <embed src="image/banner.swf"
      quality="high"
      type="application/x-shockwave-flash"
      width="1000"
      height="125"
      pluginspage="http://www.macromedia.com/go/getflashplayer"
      allowScriptAccess="always" />
</object></td>
  </tr>
  <tr>
    <td valign="middle" align="right"    height="10" bgcolor="#D3EFFB" class="th12bgray"><a href="index.php">กลับหน้า Login</a>&nbsp;<span class="th_red12b">บริการบุคคลทั่วไป</span></td>
  </tr>
  <tr>
    <td valign="middle" align="left"    background="image/bg.bmp" class="th12black"></td>
  </tr>
  <tr>
    <td height="500" align="center"   <? echo $vh;?> background="image/bg.bmp" ><br/><? if($page==""){ ?><table width="50%" border="2" cellpadding="0" cellspacing="0" bordercolor="#CC9933" bgcolor="#FFFFCC">
  <tr>
    <td class="th_head_back" align="center" height="200"><em class="th_head_back">ยินดีต้อนรับเข้าสู่</em><br/>
      <br/>  
      <em>ระบบรายงานผลการลงทะเบียนทางหลวงท้องถิ่น</em></td>
  </tr>
</table><? 
}else if($page=="edit_register"){ include "add_personnel_mun_regis.php";
}else if($page=="register"){ include "add_personnel_mun_regis.php";
}else if($page=="manage"){ include "manage_per_mun.php";}
else if($page=="residence"){ include "manage_residence.php";}
else if($page=="province"){ include "manage_province.php";}
else if($page=="province_mun"){ include "manage_province_mun.php";}
else if($page=="mun"){ include "manage_mun.php";}
else if($page=="report9"){  include "report_register9.php";}
else if($page=="report8"){  include "report_register8.php";}
else if($page=="report7"){  include "report_register7.php";}
else if($page=="report6"){  include "report_register6.php";}
?></td>

  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
