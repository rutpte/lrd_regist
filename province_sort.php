<? include "check.php";
include "unset_regis.php";
$id_residence=$_GET['id_residence'];
$sqlS="SELECT name_residence
FROM residence where id_residence='$id_residence'"; //select name_residence ชื่อสำนัก
$resultS=$db->query($sqlS);
$rsS=$db->fetch_array($resultS);
$sql="select province_name,num_orders from province where id_residence='$id_residence' order by num_orders,province_id asc";
$result=$db->query($sql);

?>
<form id="form1" name="form1" method="post" action="province_sort_proc.php">


<table width="44%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCC33">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="41%" align="left" bgcolor="#006699" class="th16white">ชื่อสำนัก</td>
    <td width="59%" align="left" bgcolor="#99CC99" class="th11bred"><input type="text" name="name_residence" id="name_residence" value="<? echo $rsS['name_residence'];?>" style="width:230px" readonly=""/></td>
  </tr>
  <?/////////////////////////////////////////////////////////////////////////////////////?>
  <? while($rs=$db->fetch_array($result)){?>
  <tr>
    <td align="left" bgcolor="#006699" class="th16white">ชื่อทชจ.ลำดับที่
      <input type="text" name="num_orders[]" id="num_orders[]" value="<? echo $rs['num_orders'];?>" style="width:20px"  onkeypress='if (event.keyCode<48||event.keyCode>57) event.returnValue=false'/></td>
    <td align="left" bgcolor="#99CC99" class="th11bred"><input type="text" name="name_province" id="name_province" value="<? echo $rs['province_name'];?>" style="width:140px"  readonly=""/>    <!--ด้านขวา โชว์ข้อมูลเฉยๆ-->
      </td> 
  </tr><? } //end fetch /////////////////////////////////////////////////////////////////////?>
  <tr>
    <td align="left" bgcolor="#FFFFFF" class="th16white"><a href="manage.php?page=manage_residence" class="th_red12b"><<<กลับ</a></td>
    <td align="left" bgcolor="#FFFFFF" class="th11bred"><input type="submit" name="Submit" value="เรียงลำดับใหม่" />&nbsp;

	  <input type="hidden" name="id_residence" id="id_residence" value="<? echo $id_residence;?>" />
	 	  </td>
  </tr>
</table></td>
  </tr>
</table>
</form>
