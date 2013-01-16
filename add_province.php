<? include "check.php";
include "unset_regis.php";
 $proc=$_GET['proc'];
$province_id=$_GET['province_id'];
$sqlS="select id_residence,name_residence from residence";
$resultS=$db->query($sqlS);

if($proc==""){
$proc="add";


}else if($proc=="edit"){
$sql="select * from province where province_id='$province_id' ";
$result=$db->query($sql);
$rs=$db->fetch_array($result);

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
<form id="form1" name="form1" method="post" action="manage_pro_proc.php">


<table width="44%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCC33">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="31%" align="left" bgcolor="#006699" class="th16white">เลือกสำนัก</td>
    <td width="69%" align="left" bgcolor="#99CC99" class="th11bred"><span id="spryselect1"><select name="id_residence" id="residence"><option value="">-เลือก-</option>
	<? while($rsS=$db->fetch_array($resultS)){?> <option value="<? echo $rsS['id_residence'];?>" <? if($rs['id_residence']==$rsS['id_residence']){?> selected="selected"<? }?>><? echo $rsS['name_residence'];?></option><? }?>
	</select></span></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th16white">ชื่อจังหวัด</td>
    <td align="left" bgcolor="#99CC99" class="th11bred"><span id="sprytextfield1"><input type="text" name="province_name" id="province_name" value="<? echo $rs['province_name'];?>" style="width:140px" /></span></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th16white">ชื่อย่อจังหวัด</td>
    <td align="left" bgcolor="#99CC99" class="th11bred"><span id="sprytextfield2"><input type="text" name="drop_name" id="drop_name" value="<? echo $rs['drop_name'];?>" style="width:140px" /></span></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#FFFFFF" class="th16white"><a href="<? echo $REFERER; ?>" class="th_red12b"><<<กลับ</a></td>
    <td align="left" bgcolor="#FFFFFF" class="th11bred"><input type="submit" name="Submit" value="ตกลง" />&nbsp;
      <input type="reset" name="Submit2" value="ยกเลิก" />
	  <input type="hidden" name="province_id" id="province_id" value="<? echo $rs['province_id'];?>" />
	  <input type="hidden" name="proc" id="proc" value="<? echo $proc;?>" />	  </td>
  </tr>
</table></td>
  </tr>
</table>
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");

</script>