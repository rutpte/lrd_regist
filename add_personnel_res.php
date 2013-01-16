<? if($_SESSION['LOGTYPE']==1||$_SESSION['LOGTYPE']==2||$_SESSION['LOGTYPE']==3){?>
<script language="javascript">
function checkPwd(){
	var frm = document.form1;
	if(frm.password_per.value != frm.per_password.value){
		alert("กรุณาใส่รหัสผ่านให้ตรงกันด้วย");
		frm.password_per.value = "";
		frm.per_password.value = "";
		frm.password_per.focus();
		return false;
	}
}
/*//////////////////////////////////////////////////////////////*/
function check_n(){
	var frm = document.form1;


		frm.password_per.value = "";
	
		frm.password_per.focus();

}
/*//////////////////////////////////////////////////////////////*/
function check_n1(){
	
	var frm = document.form1;


		frm.per_password.value = "";
	
		frm.per_password.focus();

}
/*//////////////////////////////////////////////////////////////*/
function check_num1(e) 


{
var keyPressed; 
    
    if(window.event){ 
        keyPressed = window.event.keyCode; // IE 
     if ((keyPressed < 48) || (keyPressed > 59)) window.event.returnValue = false; 
    }else{ 
        keyPressed = e.which; // Firefox        
   if ((keyPressed < 48) || (keyPressed > 59)) keyPressed = e.preventDefault(); 
 } 

};
 /*//////////////////////////////////////////////////////////////*/
</script>
<? include "check.php"; 
include "unset_regis.php";
$proc=$_GET['proc'];               /////////////// ค่าที่ส่งมา สองค่า ///////////////
$id_personnel=$_GET['id_personnel'];
//////////////////////////////////// add ///////////////////////////////////////
if($proc==""){
	$sqlS1="select id_residence,name_residence from residence";
$resultS1=$db->query($sqlS1);
$proc="add";
$sqlS="select id_personnel from personnel where type_personnel='3' ";/// 3 สทช บุคลากร เมนู 2
$resultS=$db->query($sqlS);
$rsS=$db->fetch_array($resultS);
$numS=$db->num_rows($resultS);
if($numS==0){
$username_per="localroadres1";
}else{

$rn=$numS+1;
$username_per="localroadres".$rn; //fix
}

//////////////////////////////////// edite ///////////////////////////////////////
}else if($proc=="edit"){
$sql="select * from personnel where id_personnel='$id_personnel' ";
$result=$db->query($sql);
$rs=$db->fetch_array($result);
$username_per=$rs['username_per'];
	if($_SESSION['LOGTYPE']==3){
	$con="where id_residence='$rs[id_residence]'"; //id_residence คือ ค่าที่เฟสออกมา
}
$sqlS1="select id_residence,name_residence from residence $con";
$resultS1=$db->query($sqlS1);
}
?>
<script src="SpryAssets/SpryValidationTextField1.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField1.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<form id="form1" name="form1" method="post" action="manage_per_res_proc.php">


<table width="50%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCC33">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="26%" align="left" bgcolor="#006699" class="th16white">ชื่อเข้าใช้ระบบ</td>
    <td width="74%" align="left" bgcolor="#99CC99" class="th11bred"><input type="text" name="username_per" id="username_per" value="<? echo $username_per;?>" readonly="" style="width:140px"/></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th16white">รหัสผ่าน</td>
    <td align="left" bgcolor="#99CC99" class="th11bred"><span id="sprytextfield1"><input type="password" name="password_per" id="password_per" value="<? echo $rs['password_per'];?>" style="width:140px" class="th11bred" onclick="check_n();"/></span> กรอกตัวเลขหรือตัวอักษรอย่างน้อย 6 ตัว</td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th16white">ยืนยันรหัสผ่าน</td>
    <td align="left" bgcolor="#99CC99" class="th11bred"><span id="sprytextfield2"><input name="per_password" type="password" class="th11bred" id="per_password" style="width:140px" value="<? echo $rs['password_per'];?>" onBlur="checkPwd();" onclick="check_n1();"/></span> กรอกตัวเลขหรือตัวอักษรอย่างน้อย 6 ตัว</td>
  </tr>  
  <tr>
    <td align="left" bgcolor="#006699" class="th16white">เลือกสทช.</td>
    <td align="left" bgcolor="#99CC99" class="th11bred"><span id="spryselect1"><select name="id_residence" id="residence"><option value="">-เลือก-</option>
	<? while($rsS1=$db->fetch_array($resultS1)){?> <option value="<? echo $rsS1['id_residence'];?>" <? if($rs['id_residence']==$rsS1['id_residence']){?> selected="selected"<? }?>><? echo $rsS1['name_residence'];?></option><? }?>
	</select></span></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th16white">ชื่อ-นามสกุล</td>
    <td align="left" bgcolor="#99CC99" class="th11bred"><span id="sprytextfield3"><input name="name_personnel" type="text"  id="name_personnel" value="<? echo $rs['name_personnel'];?>" style="width:140px" /></span></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th16white">เบอร์โทร</td>
    <td align="left" bgcolor="#99CC99" class="th11bred"><span id="sprytextfield4"><input name="tel_personnel" type="text" id="tel_personnel" style="width:140px" onKeyPress="check_num1(event)" value="<? echo $rs['tel_personnel'];?>" maxlength="10"/>
      
    </span>ตย.0819999999</td>
  </tr>
  <tr>
    <td align="left" bgcolor="#FFFFFF" class="th16white"><a href="<? echo $REFERER; ?>" class="th_red12b"><<<กลับ</a></td>
    <td align="left" bgcolor="#FFFFFF" class="th11bred"><input type="submit" name="Submit" value="ตกลง"  id="Submit" onclick="checkPwd();"/>&nbsp;
      <input type="reset" name="Submit2" value="ยกเลิก" />
	  <input type="hidden" name="id_personnel" id="id_personnel" value="<? echo $rs['id_personnel'];?>" />
	  <input type="hidden" name="proc" id="proc" value="<? echo $proc;?>" />	  </td>
  </tr>
</table></td>
  </tr>
</table>
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:6});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {minChars:6});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "phone_number", {format:"phone_custom", pattern:"0800000000"});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");

</script>
<? }else{
echo "<script>	
					window.location = 'logout.php';
					</script>";

}?>