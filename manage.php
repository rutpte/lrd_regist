<? session_start(); 
include "header.php";
include "chksession.php";     // เช็คว่าได้ผ่านการล็อกอินมาหรือป่าว แล้วเป็น  type_personnel='5'หรือป่าว ไม่งั้นมันจะ window.location = 'logout.php';

$REFERER=$_SERVER['HTTP_REFERER']; 

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
    <td valign="top"><table width="1024" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="middle" align="center" height="125" ><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="1024" height="125">
  <param name="movie" value="image/banner.swf" />
  <param name="quality" value="high" />
  <param name="allowScriptAccess" value="always" />
     <embed src="image/banner.swf"
      quality="high"
      type="application/x-shockwave-flash"
      width="1024"
      height="125"
      pluginspage="http://www.macromedia.com/go/getflashplayer"
      allowScriptAccess="always" />
</object></td>
  </tr>
  <!--////////////////////////////////////////////////////////////////////////////////////////////-->
  <tr>
    <td valign="middle" align="right"    height="10" bgcolor="#D3EFFB" class="th12bgray"><span class="th_red12b"><? echo $_SESSION['LOGNAME'];?></span> กำลังเข้าใช้ระบบ&nbsp;</td>
  </tr>
  <tr>
   <!--นี่คือส่วนแบ่งว่าใครได้เมนูไหน--><td valign="middle" align="left"    background="image/bg.bmp" class="th12black"><? if($_SESSION['LOGTYPE']==1||$_SESSION['LOGTYPE']==2){?><? include "menu_manage.php";?><? }else if($_SESSION['LOGTYPE']==3){?><? include "menu_manage_res.php";?><? }else if($_SESSION['LOGTYPE']==4){?><? include "menu_manage_province.php";?><? }?></td>
  </tr>
  <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
  <tr>
    <td height="500" align="center"   <? echo $vh;?> background="image/bg.bmp" ><br/>

    <!--/////////////////////////////////////////////////////////////////////////////////-->

    <? if($page==""){     //ถ้ายังไม่มีการกดที่เมนู

    ?><table width="50%" border="2" cellpadding="0" cellspacing="0" bordercolor="#CC9933" bgcolor="#FFFFCC">
  <tr>
    <td class="th_head_back" align="center" height="200"><em class="th_head_back">ยินดีต้อนรับเข้าสู่</em><br/>
      <br/>  
      <em>ระบบรายงานผลการลงทะเบียนทางหลวงท้องถิ่น</em></td>
  </tr>
</table>
 <!--///////////////////////////////////////////////////////////////////////-->
<?    // หน้านี้คือหน้าแรก ต่อจากการ login ผ่านมา จะมีแค่ นำเอา เมนูสำหรับ แต่ละlogtype(type_personnel)   line 47
     //เมนูเป็นไรก็ช่าง  กดตัวไหนมาให้เข้าหมด ถ้ากดได้
 }else if($page=="manage_per"){ include "manage_per.php";}
else if($page=="add_personnel"){ include "add_personnel.php";}
else if($page=="manage_per_res"){ include "manage_per_res.php";}
else if($page=="add_personnel_res"){ include "add_personnel_res.php";}
else if($page=="manage_per_province"){ include "manage_per_province.php";}
else if($page=="add_personnel_province"){ include "add_personnel_province.php";}
else if($page=="manage_residence"){ include "manage_residence.php";}
else if($page=="manage_province"){ include "manage_province.php";}
else if($page=="add_province"){ include "add_province.php";}
else if($page=="manage_province_mun"){ include "manage_province_mun.php";}
else if($page=="manage_mun"){ include "manage_mun.php";}
else if($page=="add_mun"){ include "add_mun.php";}
else if($page=="province_sort"){  include "province_sort.php";}
else if($page=="mun_sort"){  include "mun_sort.php";}
else if($page=="manage_register"){  include "manage_register.php";}
else if($page=="manage_province_register"){  include "manage_province_register.php";}
else if($page=="manage_mun_register"){  include "manage_mun_register.php";}
else if($page=="register_road"){  include "register_road.php";}
else if($page=="manage_province_amount"){  include "manage_province_amount.php";}
else if($page=="manage_mun_amount"){  include "manage_mun_amount.php";}
else if($page=="add_amount"){  include "add_amount.php";}
else if($page=="report_register9"){  include "report_register9.php";}
else if($page=="report_register8"){  include "report_register8.php";}
else if($page=="report_register7"){  include "report_register7.php";}
else if($page=="report_register6"){  include "report_register6.php";}
else if($page=="add_pic_mun"){  include "add_pic_mun.php";}
else if($page=="add_pic_map_mun"){  include "add_pic_map_mun.php";}
else if($page=="add_file_mun"){  include "add_file_mun.php";}
else if($page=="manage_province_register_mun"){  include "manage_province_register_mun.php";}
else if($page=="add_mun_register"){  include "add_mun_register.php";}
else if($page=="manage_per_mun"){  include "manage_per_mun.php";}
else if($page=="add_personnel_mun"){  include "add_personnel_mun.php";}
?></td>

  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
