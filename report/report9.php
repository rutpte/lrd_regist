<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>���͡�ʴ���§ҹ���ҧ��ػ���ŧ����¹�ҧ��ǧ��ͧ��� (��.9) </title>
<link href="../css/register.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="datetimepicker.js">
</script>
<script type ="text/javascript" language="javascript" >
function resize_(){
    window.resizeTo(500,350);

	moveTo(350,0);
}
</script>
<script language="javascript">
function show_table(id) {
if(id == 1) { // ������͡ radio button 1 ������ table 1 ��� ��͹ table 2 

document.getElementById("table_2").style.display = "none";
} else if(id == 2) { // ������͡ radio button 2 ������ table 2 ��� ��͹ table 1 

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

<form name="frm" method="post" 	action="show_report9.php" target="_blank" >
<table width="430" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td height="60" align="center" class="th_head_back14">���͡�ʴ���§ҹ���ҧ��ػ���ŧ����¹�ҧ��ǧ��ͧ��� (��.9) </td>
  </tr>
  <tr>
   <td align="center" class="th_head_back12"><label>
              <input type="radio" name="show" id="show" value="1"  onclick="show_table(this.value);"  checked="checked">������  &nbsp;<label>
              <input type="radio" name="show" id="show" value="2"  onclick="show_table(this.value);">
              ���͡�ҡ��ǧ�ѹ���
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
	  ?>�ҡ�ѹ���<input name='s_date' id='s_date' type='text' size='12' readonly="true" value="<? echo $dd; ?>" /> 
       <a href="#"><img src="cal_take.gif" width="36" height="44" border="0" align="absmiddle" onclick="javascript:NewCal('s_date','ddmmyyyy',false,24)"></a>&nbsp;&nbsp;
    �֧�ѹ���<input name='e_date' id='e_date' type='text' size='12' readonly="true" value="<? echo $dd; ?>" />    <a href="#"><img src="cal_take.gif" width="36" height="44" border="0" align="absmiddle" onclick="javascript:NewCal('e_date','ddmmyyyy',false,24)" /></a></td>
        </tr>
      </table>     </td>
  </tr>
  <tr>
    <td align="center" height="50" valign="bottom"><input type="submit" name="Submit" value="�ʴ�����§ҹ"    onclick="close_w();" /></td>
  </tr>
</table>
</form>
</body>
</html>
