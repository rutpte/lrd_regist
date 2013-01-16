<? include "check.php";
include "unset_regis.php";

?>

<script src="SpryAssets/SpryValidationTextField1.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField1.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />

<? 

$way_id=isset($_GET['way_id']) ? $_GET['way_id'] : '';
$sql="SELECT
way.orgc_id,
province.province_name,
residence.name_residence,
org_comunity.orgc_name,
way.way_code_head,
way.way_name,
way.file_t2,
org_comunity.orgc_id,
way.way_id
FROM
province
INNER JOIN residence ON residence.id_residence = province.id_residence
INNER JOIN amphur ON amphur.province_id=province.province_id
INNER JOIN org_comunity ON amphur.amphur_id = org_comunity.amphur_id
INNER JOIN way ON org_comunity.orgc_id = way.orgc_id where way.way_id='$way_id'";
$result=$db->query($sql);
$rs=$db->fetch_array($result);

 #-----------------------------------  for check upload pic pic map mun
            $sql_chek_filename_ref_s_m="select filename_ref
            from attachment t1
            inner join lrd_attachment t2 ON (t1.attach_id=t2.attach_id)
            where record_ref_id='$way_id' and lrd_attach_type='F_T2'
             ";    
           $result_filename_ref_s_m=$db->query($sql_chek_filename_ref_s_m);                                                                                   #
           $rs_filename_ref_s_m=$db->fetch_array($result_filename_ref_s_m);

           $filename_ref_s_m=$rs_filename_ref_s_m['filename_ref'];
           //var_dump( $filename_ref);
#----------------------------------

?>


<form id="form1" name="form1" method="post" action="manage_file_proc.php" enctype="multipart/form-data">


<table width="480" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCC33">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="25%" align="left" bgcolor="#006699" class="th16white">ชื่อสำนัก</td>
    <td width="75%" align="left" bgcolor="#99CC99" class="th_red12b"><? echo $rs['name_residence'];?>       </td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th16white">ชื่อจังหวัด</td>
    <td align="left" bgcolor="#99CC99" class="th_red12b"><? echo $rs['province_name'];?>       </td>
  </tr>
 
    <tr>
    <td align="left" bgcolor="#006699" class="th16white">ชื่ออปท.</td>
    <td align="left" bgcolor="#99CC99" class="th_red12b"><? echo $rs['orgc_name'];?></td>
  </tr>
      <tr>
      <td align="left" bgcolor="#006699" class="th16white">รหัสสายทาง</td>
      <td align="left" bgcolor="#99CC99" class="th_red12b"><? echo $rs['way_code_head'].$rs['way_id'];?></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#006699" class="th16white">ชื่อสายทาง</td>
      <td align="left" bgcolor="#99CC99" class="th_red12b"><? echo $rs['way_name'];?></td>
    </tr>
     <tr>                                                   <?php //$rs['file_t2']==""  ?>
    <td align="left" bgcolor="#006699" class="th16white">ไฟล์ ทถ.2</td>
    <td align="left" bgcolor="#99CC99" class="th11r_n"><? if($filename_ref_s_m==""){?><span id="sprytextfield1"><input name="file_load" type="file" id="file_load" size="0" style="width:180px"/>
    * นามสกุลไฟล์(pdf,jpg)<br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;อัพโหลดไฟล์ขนาดไม่เกิน 2 Mb
    </span><? }else{?><a href="show_file_regis.php?way_id=<? echo $way_id;?>" target="_blank">ดูทถ.2</a> / <a href="manage_file_proc.php?way_id=<? echo $way_id;?>&chkdel=1">แก้ไขทถ.2</a><? }?></td>
  </tr>
                                                                <?php
                                                               // if($rs['file_t2']!=""

                                                               //if($rs['pic_map']==""
                                                                ?>
  

  <tr>
    <td align="left" bgcolor="#FFFFFF" class="th16white"><? if($filename_ref_s_m!=""){?><a href="manage.php?page=manage_register&orgc_id=<? echo $rs['orgc_id'];?>" class="th_red12b"><<<กลับ</a><? }?></td>
    <td align="left" bgcolor="#FFFFFF" class="th11bred"><? if($filename_ref_s_m==""){?><input type="submit" name="Submit" value="ตกลง" />&nbsp;
      <input type="reset" name="Submit2" value="ยกเลิก" />
	  <input type="hidden" name="province_id" id="province_id" value="<? echo $rs['province_id'];?>" />
	   <input type="hidden" name="way_id" id="way_id" value="<? echo $way_id;?>" />
	  <? }?> </td>
  </tr>
</table></td>
  </tr>
</table>
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");

</script>
