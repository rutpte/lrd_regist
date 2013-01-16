<? session_start();
include "header.php";
include "chksession.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/register.css" rel="stylesheet" type="text/css" />
<script type="text/javaScript">
function closeGreybox() {
    
	parent.parent.GB_hide();
 	window.top.location.reload();
	
}
//เติม , (คอมมา)
function dokeyup( obj )
{
var key 
   if(window.event){ 
        key = window.event.keyCode; // IE 
}else{
 keyPressed = e.which; // Firefox     
}
if( key != 37 & key != 39 & key != 110 )
{
var value = obj.value;
var svals = value.split( "." ); //แยกทศนิยมออก
var sval = svals[0]; //ตัวเลขจำนวนเต็ม

var n = 0;
var result = "";
var c = "";
for ( a = sval.length - 1; a >= 0 ; a-- )
{
c = sval.charAt(a);
if ( c != ',' )
{
n++;
if ( n == 4 )
{
result = "" + result;
n = 1;
};
result = c + result;
};
};

if ( svals[1] )
{
result = result + '.' + svals[1];
};

obj.value = result;
};
};

//ให้ text รับค่าเป็นตัวเลขอย่างเดียว
function check_num(e) 


{
var keyPressed; 
    
    if(window.event){ 
        keyPressed = window.event.keyCode; // IE 
     if ((keyPressed < 45) || (keyPressed > 57)) window.event.returnValue = false; 
    }else{ 
        keyPressed = e.which; // Firefox        
   if ((keyPressed < 45) || (keyPressed > 57)) keyPressed = e.preventDefault(); 
 } 

};

function ChangeStateRadio(caller,formobject,formobject1) {
 if (caller.value == "0") {
formobject.disabled = true;
 formobject.value = "N.A.";
 formobject1.disabled = false;
 } else {
  formobject.value = "0";
  formobject.disabled = false;
   formobject1.disabled = true;
  
 }
}

function ChangeStateRadioD(caller,formobject,formobject1) {

 if (caller.value == "0") {
formobject.disabled = true;
 formobject.value = "N.A.";
  formobject1.disabled = false;
 } else {
  formobject.value = "0";
  formobject.disabled = false;
  formobject1.disabled = true;
 }
}
</script>

<link href="css/register.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationTextField1.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField1.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>
<body>
<form id="form1" name="form1" method="post" action="add_register_proc.php">
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCC33">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td align="left" bgcolor="#006699" class="th14white">ช่วงที่</td>
    <td align="left" bgcolor="#99CCFF" class="th12bgray">&nbsp;    <input type="text" name="period_regis" id="period_regis"  style="width:20px"  value="<? echo count($_SESSION['sess_period_regis'])+1;?>"/></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th14white">เขตทางกว้าง</td>
    <td align="left" bgcolor="#99CCFF" >&nbsp;<span id="sprytextfield5">
      <input type="text" name="kate_regis" id="kate_regis"  style="width:140px"  onkeypress="check_num(event)" />
    </span> 
    <span class="th11bred">*</span> <span class="th11black">(ม.)</span></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th14white">ระยะทาง</td>
    <td align="left" bgcolor="#99CCFF" >&nbsp;<span id="sprytextfield1">
      <input type="text" name="distance_regis" id="distance_regis"  style="width:140px"  onkeypress="check_num(event)" /></span> 
    <span class="th11bred">*</span> <span class="th11black">(กม.)</span></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th14white">จำนวนช่องการจราจรต่อทิศทาง</td>
    <td align="left" bgcolor="#99CCFF" >&nbsp;<span id="sprytextfield5">
      <input type="text" name="jarat_road" id="jarat_road" style="width:140px"   onkeypress="check_num(event)"/></span> 
       <span class="th11bred">*</span> </td>
  </tr>
  <tr>
    <td width="36%" align="left" bgcolor="#006699" class="th14white">ผิวจราจรประเภท</td>
    <td width="64%" align="left" bgcolor="#99CCFF" >&nbsp;
      <select name="type_ja" id="type_ja"><option value="1" selected="selected">- คอนกรีต -</option>
 <option value="2" >- ลาดยาง -</option>
 <option value="3" >- ลูกรัง- </option>
	</select> 
       <span class="th11bred">*</span></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th14white">ผิวจราจรกว้าง</td>
    <td align="left" bgcolor="#99CCFF" >&nbsp;<span id="sprytextfield2">
      <input type="text" name="width_ja" id="width_ja"  style="width:140px"    onkeypress="check_num(event)" />
    </span> 
       <span class="th11bred">*</span> <span class="th11black">(เมตร) </span></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th14white">ไหล่ทางประเภท</td>
    <td align="left" bgcolor="#99CCFF" >&nbsp;
      <select name="type_sh" id="type_sh" onchange="ChangeStateRadio(this,width_sh,type_fo);" ><option value="0" selected="selected">- ไม่มี -</option>
	  <option value="1" >- คอนกรีต- </option>
 <option value="2" >- ลาดยาง -</option>
 <option value="3" >- ลูกรัง -</option>
	</select> 
       <span class="th11bred">*</span> </td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th14white">ไหล่ทางกว้าง</td>
    <td align="left" bgcolor="#99CCFF" >&nbsp;<span id="sprytextfield3">
      <input type="text" name="width_sh" id="width_sh"  style="width:140px"  onkeypress="check_num(event)" value="N.A." disabled="disabled" />
    </span>
       <span class="th11bred">*</span><span class="th11black"> (เมตร) </span></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th14white">ทางเท้าประเภท</td>
    <td align="left" bgcolor="#99CCFF" >&nbsp;
      <select name="type_fo" id="type_fo" onchange="ChangeStateRadioD(this,width_fo,type_sh);">
	  <option value="0" selected="selected">- ไม่มี -</option>
	  <option value="1" >- คอนกรีต -</option>
 		<option value="2" >- ลาดยาง -</option>
 		<option value="3" >- ลูกรัง -</option>
	</select> 
       <span class="th11bred">*</span> </td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th14white">ทางเท้ากว้าง</td>
    <td align="left" bgcolor="#99CCFF" >&nbsp;<span id="sprytextfield4">
      <input type="text" name="width_fo" id="width_fo" style="width:140px"  onkeypress="check_num(event)" value="N.A." disabled="disabled" />
    </span>
      <span class="th11bred">*</span><span class="th11black"> (เมตร) </span></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th14white">หมายเหตุ</td>
    <td align="left" bgcolor="#99CCFF" >&nbsp;
      <textarea name="note" id="note" cols="30" rows="5"></textarea></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#FFFFFF" class="th16white"></td>
    <td align="left" bgcolor="#FFFFFF" class="th11bred"><input type="submit" id="Submit" name="Submit" value="ตกลง"  />&nbsp;
      <input type="reset" name="Submit2" value="ยกเลิก" />	  </td>
  </tr>
</table></td>
  </tr>
</table>
</form>

</body>
</html>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");

var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9");
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10");
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11");
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect5 = new Spry.Widget.ValidationSelect("spryselect5");

var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");



</script>