<? $proc=$_GET['proc'];
$id_residence=$_GET['id_residence'];
$sqlS="SELECT *
FROM
  `residence`
  where id_residence='$id_residence'";
$resultS=$db->query($sqlS);
$rsS=$db->fetch_array($resultS);
$sql="select name_province,num_orders from province where id_residence='$id_residence'";
$result=$db->query($sql);

?>
<form id="form1" name="form1" method="post" action="soft_province_proc.php">


<table width="44%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCC33">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="41%" align="left" bgcolor="#006699" class="th16white">เลือกสำนัก</td>
    <td width="59%" align="left" bgcolor="#99CC99" class="th11bred"><input type="text" name="name_residence" id="name_residence" value="<? echo $rsS['name_residence'];?>" style="width:140px" readonly=""/></td>
  </tr>
  <? while($rs=$db->fetch_array($result)){?>
  <tr>
    <td align="left" bgcolor="#006699" class="th16white">ชื่อทชจ.ลำดับที่
      <input type="text" name="num_orders[]" id="num_orders[]" value="<? echo $rs['num_orders'];?>" style="width:20px"  readonly=""/></td>
    <td align="left" bgcolor="#99CC99" class="th11bred"><input type="text" name="name_province" id="name_province" value="<? echo $rs['name_province'];?>" style="width:140px"  readonly=""/> 
      </td> 
  </tr><? } ?>
  <tr>
    <td align="left" bgcolor="#FFFFFF" class="th16white"><a href="<? echo $REFERER; ?>" class="th_red12b"><<<กลับ</a></td>
    <td align="left" bgcolor="#FFFFFF" class="th11bred"><input type="submit" name="Submit" value="เรียงลำดับ" />&nbsp;

	  <input type="hidden" name="id_residence" id="id_residence" value="<? echo $rs['id_residence'];?>" />
	 	  </td>
  </tr>
</table></td>
  </tr>
</table>
</form>

