
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Untitled Document</title>
<script language="javascript" type="text/javascript" src="datetimepicker.js">
</script>
<script language="javascript">
function show_table(id) {
if(id == 1) { // ถ้าเลือก radio button 1 ให้โชว์ table 1 และ ซ่อน table 2 
document.getElementById("table_1").style.display = "";
document.getElementById("table_2").style.display = "none";
} else if(id == 2) { // ถ้าเลือก radio button 2 ให้โชว์ table 2 และ ซ่อน table 1 
document.getElementById("table_1").style.display = "none";
document.getElementById("table_2").style.display = "";
}
}
</script>
</head>

<body>

<form name="frm" method="post" 	action="show_report.php">
<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center" height="60">เลือกแสดงรายงาน &nbsp;แบบ ทถ.9</td>
  </tr>
  <tr>
    <td align="center"><label>
              <input type="radio" name="show" id="show" value="1"  onclick="show_table(this.value);"  checked="checked">ทั้งหมด  &nbsp;<label>
              <input type="radio" name="show" id="show" value="2"  onclick="show_table(this.value);">
              เลือกจากช่วงวันที่
    </label>
     </label></td>
  </tr>
  <tr>
    <td>
	 <table width="500" border="0" cellspacing="0" cellpadding="0"  id="table_1" style="display:none" align="center">
        <tr>
          <td height="50">&nbsp;</td>
        </tr>
      </table>
      <table width="500" border="0" cellspacing="0" cellpadding="0"  id="table_2" style="display:none" align="center">
        <tr>
          <td height="50">
      <?php
	  		$dd = date('d-m-Y');
	  ?>จากวันที่<input name='s_date' id='s_date' type='text' size='12' readonly="true" value="<? echo $dd; ?>" /> 		<a href="javascript:NewCal('s_date','ddmmyyyy',false,24)"><img src="cal_take.gif" width="24" height="24" border="0" align="absmiddle"></a>&nbsp;&nbsp;
    ถึงวันที่<input name='e_date' id='e_date' type='text' size='12' readonly="true" value="<? echo $dd; ?>" /> 		<a href="javascript:NewCal('e_date','ddmmyyyy',false,24)"><img src="cal_take.gif" width="24" height="24" border="0" align="absmiddle"></a></td>
        </tr>
      </table>     </td>
  </tr>
  <tr>
    <td align="center" height="50" valign="bottom"><input type="submit" name="Submit" value="แสดง" onClick="return chknull(this.form);"  style="width:100px;height:30px; font:14px tahoma;" /></td>
  </tr>
</table>
</form>
</body>
</html>
