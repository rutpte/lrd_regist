<? session_start();
include "header.php";
include "chksession.php";
$id_mun=$_GET['id_mun'];
$sql="SELECT `province`.id_province,name_province,drop_name,`municipality`.name_mun,`municipality`.num_orders,`municipality`.amount_way,`municipality`.amount_phase_way,name_residence
FROM
  `municipality`
  INNER JOIN `province` ON (`municipality`.`id_province` = `province`.`id_province`)
  INNER JOIN `residence` ON (`province`.`id_residence` = `residence`.`id_residence`) where `municipality`.id_mun='$id_mun'";
  $result=$db->query($sql);
  $rs=$db->fetch_array($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>เลือกแสดงรายงานตารางสรุปการลงทะเบียนทางหลวงท้องถิ่น (ทถ.6)</title>
<link href="../css/register.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="datetimepicker.js">
</script>
<script type ="text/javascript" language="javascript" >
function resize_(){
    window.resizeTo(600,380);

	moveTo(350,0);
}
</script>
<script language="javascript">
function show_table(id) {
if(id == 1) { // ถ้าเลือก radio button 1 ให้โชว์ table 1 และ ซ่อน table 2 

document.getElementById("table_2").style.display = "none";
} else if(id == 2) { // ถ้าเลือก radio button 2 ให้โชว์ table 2 และ ซ่อน table 1 

document.getElementById("table_2").style.display = "";
}
}
</script>
<script language="JavaScript">
function close_w() {
window.open('','_self');
window.close() ;}
</script> 
</head>

<body onload="javascript:resize_();">

<form name="frm" method="post" 	action="show_report6.php" target="_blank" >
<table width="550" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center" height="60" class="th_head_back14">เลือกแสดงรายงานตารางสรุปสมุดลงทะเบียนคุมสายทางหลวงท้องถิ่น (ทถ.6)<br />
      ทชจ.&nbsp;<? echo $rs['name_province'];?>&nbsp;&nbsp;<? echo $rs['name_residence']?> <br />
หน่วยงาน&nbsp;<? echo $rs['name_mun'];?> <br />
      กรมทางหลวงชนบท กระทรวงคมนาคม  <br />
      <br /></td>
  </tr>
  <tr>
    <td align="center" class="th_head_back12"><label>
              <input type="radio" name="show" id="show" value="1"  onclick="show_table(this.value);"  checked="checked">ทั้งหมด  &nbsp;<label>
              <input type="radio" name="show" id="show" value="2"  onclick="show_table(this.value);">
              เลือกจากช่วงวันที่
    </label>
     </label></td> 
  </tr>
  <tr>
    <td>

       <table width="100%" border="0" cellspacing="0" cellpadding="0"  id="table_2" align="center" style="display:none" >
        <tr>
          <td height="60" align="center"  valign="middle" class="th_head_back12">
      <?php
	  		$dd = date('d-m-Y');
	  ?>จากวันที่<input name='s_date' id='s_date' type='text' size='12' readonly="true" value="<? echo $dd; ?>" /> 
       <a href="#"><img src="cal_take.gif" width="36" height="44" border="0" align="absmiddle" onclick="javascript:NewCal('s_date','ddmmyyyy',false,24)"></a>&nbsp;&nbsp;
    ถึงวันที่<input name='e_date' id='e_date' type='text' size='12' readonly="true" value="<? echo $dd; ?>" />    <a href="#"><img src="cal_take.gif" width="36" height="44" border="0" align="absmiddle" onclick="javascript:NewCal('e_date','ddmmyyyy',false,24)" /></a></td>
        </tr>
      </table>     </td>
  </tr>
  <tr>
    <td align="center" height="50" valign="bottom"><input type="submit" name="Submit" value="แสดงผลรายงาน"    onclick="close_w();" /><input type="hidden" name="id_mun" value="<? echo $id_mun;?>" /></td>
  </tr>
</table>
</form>
</body>
</html>
