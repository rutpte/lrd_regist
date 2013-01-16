<? include "header.php";
include "unset_regis.php";
?>
<script type="text/javaScript">

function check_num(e) 


{
var keyPressed; 
    
    if(window.event){ 
        keyPressed = window.event.keyCode; // IE 
if ( keyPressed != 46 & ( keyPressed < 48 || keyPressed > 57 ) ){ window.event.returnValue = false; }
    }else{ 
        keyPressed = e.which; // Firefox        
   if ( keyPressed != 46 & ( keyPressed < 48 || keyPressed > 57 ) ){ keyPressed = e.preventDefault(); }
 } 

};
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

</script>
  

<script src="SpryAssets/SpryValidationTextField1.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField1.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />

<?
     /////////////////////////////////

$sq="SELECTy province.province_id,province.province_name,way.orgc_id
FROM
  province
  INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (org_comunity.amphur_id = amphur.amphur_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)
  INNER JOIN register_road_detail ON (way.way_id=register_road_detail.way_id)
  where  register_road_detail.id_regis_detail!=0  and province.id_residence='$id_residence' $con
  GROUP BY province.province_id,province.province_name,way.orgc_id,province.num_orders
 order by province.num_orders asc ";
   $result2=$db->query($sq);
   ///////////////////////////////////////////////////////////////

$id_mun=$_GET['id_mun'];
$sql="SELECT name_residence,`province`.`id_province`,name_province,name_mun,amount_way,amount_phase_way
FROM
  `municipality`
  INNER JOIN `province` ON (`municipality`.`id_province` = `province`.`id_province`)
  INNER JOIN `residence` ON (`province`.`id_residence` = `residence`.`id_residence`) where `municipality`.`id_mun`='$id_mun'";
$result=$db->query($sql);
$rs=$db->fetch_array($result);

?>


<form id="form1" name="form1" method="post" action="manage_amount_proc.php">


<table width="64%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCC33">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="51%" align="left" bgcolor="#006699" class="th16white">ชื่อสำนัก</td>
    <td width="49%" align="left" bgcolor="#99CC99" class="th_red12b"><? echo $rs['name_residence'];?>       </td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th16white">ชื่อจังหวัด</td>
    <td align="left" bgcolor="#99CC99" class="th_red12b"><? echo $rs['name_province'];?>       </td>
  </tr>
 
    <tr>
    <td align="left" bgcolor="#006699" class="th16white">ชื่ออปท.</td>
    <td align="left" bgcolor="#99CC99" class="th_red12b"><? echo $rs['name_mun'];?></td>
  </tr>
  <!--   <tr>
    <td align="left" bgcolor="#006699" class="th16white">จำนวนสายทางในความรับผิดชอบ (สาย) </td>
    <td align="left" bgcolor="#99CC99" class="th11bred"><span id="sprytextfield1"><input type="text" name="amount_way" id="amount_way" value="<? echo $rs['amount_way'];?>" style="width:40px"  onKeyPress="check_num1(event)" readonly="readonly" />
    </span></td>
  </tr>-->
     <tr>
    <td align="left" bgcolor="#006699" class="th16white">ระยะทางในความรับผิดชอบ (กม.)</td>
    <td align="left" bgcolor="#99CC99" class="th11bred"><span id="sprytextfield2"><input type="text" name="amount_phase_way" id="amount_phase_way" value="<? if($rs['amount_phase_way']!=""){echo number_format($rs['amount_phase_way'],3,'.',',');} ?>" style="width:80px"  onkeypress="check_num(event)"  />
    </span></td>
  </tr>
  

  <tr>
    <td align="left" bgcolor="#FFFFFF" class="th16white"><a href="<? echo $REFERER; ?>" class="th_red12b"><<<กลับ</a></td>
    <td align="left" bgcolor="#FFFFFF" class="th11bred"><input type="submit" name="Submit" value="ตกลง" />&nbsp;
      <input type="reset" name="Submit2" value="ยกเลิก" />
	  <input type="hidden" name="id_province" id="id_province" value="<? echo $rs['id_province'];?>" />
	   <input type="hidden" name="id_mun" id="id_mun" value="<? echo $id_mun;?>" />
	  <input type="hidden" name="proc" id="proc" value="<? echo $proc;?>" />	  </td>
  </tr>
</table></td>
  </tr>
</table>
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
