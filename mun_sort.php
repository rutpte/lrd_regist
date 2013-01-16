<? include "check.php";   
$province_id=$_GET['province_id'];
$sqlS="SELECT province_name FROM  province where province_id='$province_id'";   //เพื่อเอาชื่อไปโชว์ read_only
$resultS=$db->query($sqlS);
$rsS=$db->fetch_array($resultS);
$sql="select org_comunity.orgc_name,num_orders
from org_comunity
inner join org_comunity_detail on org_comunity.orgc_id=org_comunity_detail.orgc_id
inner join amphur on org_comunity.amphur_id=amphur.amphur_id where amphur.province_id='$province_id' order by num_orders,org_comunity_detail.orgc_id asc";
$result=$db->query($sql);

?>
<form id="form1" name="form1" method="post" action="mun_sort_proc.php">


<table width="44%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCC33">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="41%" align="left" bgcolor="#006699" class="th16white">ชื่อจังหวัด</td>
    <td width="59%" align="left" bgcolor="#99CC99" class="th11bred"><input type="text" name="province_name" id="province_name" value="<? echo $rsS['province_name'];?>" style="width:230px" readonly=""/></td>
  </tr>
  <? while($rs=$db->fetch_array($result)){?>
  <tr>
    <td align="left" bgcolor="#006699" class="th16white">ชื่ออปท.ลำดับที่
      <input type="text" name="num_orders[]" id="num_orders[]" value="<? echo $rs['num_orders'];?>" style="width:20px"  onkeypress='if (event.keyCode<48||event.keyCode>59) event.returnValue=false'/></td>
    <td align="left" bgcolor="#99CC99" class="th11bred"><input type="text" name="name_province" id="name_province" value="<? echo $rs['orgc_name'];?>" style="width:140px"  readonly=""/> 
      </td> 
  </tr><? } ?>
  <tr>
    <td align="left" bgcolor="#FFFFFF" class="th16white"><a href="manage.php?page=manage_mun&province_id=<? echo $province_id;?>" class="th_red12b"><<<กลับ</a></td>
    <td align="left" bgcolor="#FFFFFF" class="th11bred"><input type="submit" name="Submit" value="เรียงลำดับใหม่" />&nbsp;

	  <input type="hidden" name="province_id" id="province_id" value="<? echo $province_id;?>" />
	 	  </td>
  </tr>
</table></td>
  </tr>
</table>
</form>

