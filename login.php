<? session_start(); 
include "header.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $project_title;?></title>
<link href="css/register.css" rel="stylesheet" type="text/css" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript">

<!-- Copyright 2003, Sandeep Gangadharan -->
<!-- For more free scripts go to http://sivamdesign.com/scripts/ -->
<!-- 

function sivamtime() {
  now=new Date();
  hour=now.getHours();
  min=now.getMinutes();
  sec=now.getSeconds();

if (min<=9) { min="0"+min; }
if (sec<=9) { sec="0"+sec; }
if (hour>12) { hour=hour-12; add="pm"; }
else { hour=hour; add="am"; }
if (hour==12) { add="pm"; }

time = ((hour<=9) ? "0"+hour : hour) + ":" + min + ":" + sec + " " + add;

if (document.getElementById) { theTime.innerHTML = time; }
else if (document.layers) {
 document.layers.theTime.document.write(time);
 document.layers.theTime.document.close(); }

setTimeout("sivamtime()", 1000);
}
window.onload = sivamtime;

// -->

</script>
</head>

<body>

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#79BD87">
  <tr>
    <td valign="top"><table width="1025" border="0" align="center" cellpadding="0" cellspacing="0" >
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
  <tr>
    <td valign="middle" align="right"    height="10" bgcolor="#D3EFFB" class="th12black">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle" align="right"    background="image/bg.bmp" class="th12black"><span id="theTime" style=" font-family: arial; font-size: 9pt"></span>&nbsp;</td>
  </tr>
  <tr>
    <td height="500" align="center"  background="image/bg.bmp" ><form action="login_proc.php" name="form_login" id="form_login" method="post"><table width="35%" border="2" cellpadding="0" cellspacing="0" bordercolor="#3399FF" bgcolor="#CCFFCC">
  <tr>
    <td><table width="80%" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#66CCCC" bgcolor="#CCFFCC">
      <tr>
        <td colspan="2" class="th14b_Green"  align="left"><img src="image/login.png" width="48" height="30" />Login System <br/></td>
        </tr>
      <tr>
        <td width="42%" class="th_red14b" align="left">ชื่อเข้าระบบ</td>
        <td width="58%"  align="left"><span id="sprytextfield1"><input type="text" name="username_per" id="username_per" style="width:140px"></span></td>
      </tr>
      <tr>
        <td class="th_red14b" align="left">รหัสผ่าน</td>
        <td  align="left"><span id="sprytextfield2"><input type="password" name="password_per" id="password_per" style="width:140px"></span></td>
      </tr>
      <tr>
        <td class="th_red14b" align="left">&nbsp;</td>
        <td  align="left" class="th_red14b"><a href="main.php?page=report9">บริการบุคคลทั่วไป</a></td>
      </tr>
   <!--   <tr>
        <td class="th_red14b" align="left"><img src="captcha/captcha_img.php"  width="300"/></td>
        <td align="left"><span id="sprytextfield3"><input type="text" name="capt_per" id="capt_per" style="width:80px"></span> </td>
      </tr>-->
     <!-- <tr>
        <td class="th_red14b" align="left">&nbsp;</td>
        <td align="left" class="th11graydata"><a href="main.php?page=register">สมัครเข้าใช้ระบบ</a></td>
      </tr>-->
      <tr>
        <td class="th12bgray" align="left"></td>
        <td align="left"><br/><input type="submit" value="เข้าสู่ระบบ" />
        &nbsp;<input type="reset" value="ยกเลิก" /></td>
      </tr>
    </table></td>
  </tr>
</table></form></td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
//var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
</script>
