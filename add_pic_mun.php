<? include "check.php";
include "unset_regis.php";

?>

<script src="SpryAssets/SpryValidationTextField1.js" type="text/javascript"></script>      <? //นำเข้าคำสั่งตรวจสอบfrom พร้อม css?>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField1.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />

<? 

$orgc_id=$_GET['orgc_id'];
$sql="SELECT name_residence,province.province_id,province_name,orgc_name,org_comunity_detail.pic_map
FROM
  org_comunity
  INNER JOIN org_comunity_detail ON (org_comunity.orgc_id=org_comunity_detail.orgc_id)
  INNER JOIN amphur ON (amphur.amphur_id=org_comunity.amphur_id)
  INNER JOIN province ON (amphur.province_id = province.province_id)
  INNER JOIN residence ON (province.id_residence = residence.id_residence) where org_comunity.orgc_id='$orgc_id'";
$result=$db->query($sql);
$rs=$db->fetch_array($result);

 #-----------------------------------  for check upload pic  pic map
                                    $sql_chek_filename_ref_sp_m="select filename_ref
            from attachment t1
            inner join lrd_attachment t2 ON (t1.attach_id=t2.attach_id)
            where record_ref_id=$orgc_id and lrd_attach_type='SP_M'
             ";
           $result_filename_ref_sp_m=$db->query($sql_chek_filename_ref_sp_m);                                                                                   #
           $rs_filename_ref_sp_m=$db->fetch_array($result_filename_ref_sp_m);

           $filename_ref_sp_m=$rs_filename_ref_sp_m['filename_ref'];
           //var_dump( $filename_ref);
#----------------------------------
?>


<form id="form1" name="form1" method="post" action="manage_pic_proc.php" enctype="multipart/form-data">


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
    <td align="left" bgcolor="#006699" class="th16white">รูปภาพแผนที่</td>
    <td align="left" bgcolor="#99CC99" class="th11r_n">
   <? ///////////////////////////////////////////////////////////////////////////////////////?>
     <!--//////////////////////// ส่วนนี้คือ ตรวจสอบในฐานข้อมูลว่ามีลิ้งภาพอยู่ใหม ถ้าไม่มีให้โชว์ปุ่มอัปโหลดภาพ แ่ต่ถ้ามีภาพ ก็ให้แสดงลิ้งโชว์ภาพ พร้อมลิ้งแก้ไข เปลี่ยนภาพใหม่-->
    <?

    //if($rs['pic_map']=="image/no_image.jpg"){
    if($filename_ref_sp_m==""){
         ?><span id="sprytextfield1"><input name="file_load" type="file" id="file_load" size="0" style="width:180px"/>
         * นามสกุลไฟล์(jpg,jpeg,png,pdf)<br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;อัพโหลดไฟล์ขนาดไม่เกิน 6 Mb
         </span>
         <?
    }else{
         ?>
         <a href="show_map.php?orgc_id=<? echo $orgc_id;?>" target="_blank">ดูแผนที่</a> / <a href="manage_pic_proc.php?orgc_id=<? echo $orgc_id;?>&chkdel=1">แก้ไขแผนที่</a><?
         }
         ?></td>
  </tr>

   <? ///////////////////////////////////////////////////////////////////////////////////////
                                                                   //  if($rs['pic_map']!="image/no_image.jpg"){
                                                                   //if($rs['pic_map']=="image/no_image.jpg"){  ?>
 <tr>
    <td align="left" bgcolor="#FFFFFF" class="th16white"><? if($filename_ref_sp_m!=""){?><a href="manage.php?page=manage_register&orgc_id=<? echo $orgc_id;?>" class="th_red12b"><<<กลับ</a><? }?></td>
    <td align="left" bgcolor="#FFFFFF" class="th11bred"><? if($filename_ref_sp_m==""){?><input type="submit" name="Submit" value="ตกลง" />&nbsp;
      <input type="reset" name="Submit2" value="ยกเลิก" />
	  <input type="hidden" name="province_id" id="province_id" value="<? echo $rs['province_id'];?>" />
	   <input type="hidden" name="orgc_id" id="orgc_id" value="<? echo $orgc_id;?>" />
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
