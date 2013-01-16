<? include "check.php";
include "unset_regis.php";
$proc=$_GET['proc'];
$orgc_id=$_GET['orgc_id'];

$num_add=$_POST['num_add'];
 //var_dump($_REQUEST['province_id'], $proc); exit;
 $province_id=$_REQUEST['province_id'];          //เอาค่านี้ออกมาข้างนอกด้วย เพื่อใช้ในการส่งกลับของเมนูแก้ไข
if($proc==""){
$province_id=$_REQUEST['province_id'];
if($num_add==""){
$num_add=1;
}
else {
$num_add=$_POST['num_add'];
}
$proc="add";
$sqlN="select id_residence,province_name from province where province_id='$province_id'";
$resultN=$db->query($sqlN);
$rsN=$db->fetch_array($resultN);
$sqlS="select name_residence from residence where id_residence='$rsN[id_residence]'";
$resultS=$db->query($sqlS);
$rsS=$db->fetch_array($resultS);
 $sqlNu="select orgc_id from org_comunity  INNER JOIN amphur ON org_comunity.amphur_id=amphur.amphur_id where province_id='$province_id'";   //org_comunity  INNER JOIN amphur ON org_comunity.amphur_id=amphur.amphur_id
$resultNu=$db->query($sqlNu);
 $numNu=$db->num_rows($resultNu);
$numU=$numNu+1;
}else if($proc=="edit"){  
$sql="select * from org_comunity INNER JOIN amphur ON org_comunity.amphur_id=amphur.amphur_id where orgc_id='$orgc_id' ";      //org_comunity  INNER JOIN amphur ON org_comunity.amphur_id=amphur.amphur_id
$result=$db->query($sql);
$rs=$db->fetch_array($result);
$sqlN="select id_residence,province_name from province where province_id='$rs[province_id]'";
$resultN=$db->query($sqlN);
$rsN=$db->fetch_array($resultN);
$sqlS="select name_residence from residence where id_residence='$rsN[id_residence]'";
$resultS=$db->query($sqlS);
$rsS=$db->fetch_array($resultS);
//$province_id=$rs['province_id'];   ///////// เอามาทับกันเหรอ  เอามาใส่อำเภอแน่ๆ 
}
?><link href="css/register.css" rel="stylesheet" type="text/css" />
<? if($proc=="add"){

 //$sql_amphur="select amphur_name from amphur where province_id=$province_id";
 //$result_amphur->query($sql_amphur);
 //while($rs_amphur=$db->fetch_array($result_amphur)){
 //  $amphur_name=$rs_amphur['amphur_name'];
 //}

?>

<form id="form1" name="form1" method="post" action="manage.php?page=add_mun&province_id=<? echo $province_id;?>">
  <p class="th_11menu">เลือกกรอกจำนวนช่้องอทป.ช่องที่ต้องการ 
    <input name="num_add" id="num_add" type="text" style="width:20px" value="<? echo $num_add;?>" onkeypress='if (event.keyCode<48||event.keyCode>59) event.returnValue=false'/>
    <input type="submit" name="Submit3" value="ตกลง" />
  </p>
</form><? }?>

<form id="form1" name="form1" method="post" action="manage_mun_proc.php">


<table width="48%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCC33">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="36%" align="left" bgcolor="#006699" class="th16white">ชื่อสำนัก</td>
    <td width="64%" align="left" bgcolor="#99CC99" class="th_red12b"><? echo $rsS['name_residence'];?></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th16white">ชื่อทชจ.</td>
    <td align="left" bgcolor="#99CC99" class="th_red12b"><? echo $rsN['province_name'];?>
       </td>
  </tr>
  
  <? if($proc=="add"){ for($j=1;$j<=$num_add;$j++){?>
  <tr>
    <td align="left" bgcolor="#006699" class="th16white">ชื่อ อำเภอ</td>
    <td align="left" bgcolor="#99CC99" class="th_red12b">
        <select name="amphur[]">
  <?php
  ////////////////////////////////////////////////////// seclect ////////////////////////////////////
     //var_dump($province_id);
   $sql_amphur="select amphur_id,amphur_name from amphur where province_id=$province_id";
    $result_amphur=$db->query($sql_amphur);
  while($rs_amphur=$db->fetch_array($result_amphur)){
   $amphur_name=$rs_amphur['amphur_name'];
   $amphur_id=$rs_amphur['amphur_id'];
 ?>

    <option value=<?php echo"$amphur_id"; ?>><?php echo"$amphur_name";?></option>         <!--fecth amphur-->

    <?php } //////////////////////////////////////////////////////////////////////////////?>
          </select>

       </td>
  </tr>
  <tr>
    <td align="left" bgcolor="#006699" class="th16white">ชื่ออปท.ลำดับที่<? if($numNu==0){echo $j;}else if($numNu>0){ echo $numU; } ?> </td>
    <td align="left" bgcolor="#99CC99" class="th11bred"><input type="text" name="orgc_name[]" id="orgc_name[]"  style="width:140px" /></td>
  </tr><? $numU++;} }
////////////////////////////////////////////////////////////// edit //////////////////////////////
  else if($proc=="edit"){?>
    <tr>
    <td align="left" bgcolor="#006699" class="th16white">ชื่ออปท. </td>
    <td align="left" bgcolor="#99CC99" class="th11bred"><input type="text" name="orgc_name" id="orgc_name" value="<? echo $rs['orgc_name'];?>" style="width:140px" /></td>
  </tr>
  
  <? }?>
  <tr>
    <td align="left" bgcolor="#FFFFFF" class="th16white"><? if($proc=="add"){?><a href="manage.php?page=manage_mun&province_id=<? echo $province_id;?>" class="th_red12b"><<<กลับ</a><? }else if($proc=="edit"){?><a href="<? echo $REFERER; ?>" class="th_red12b"><<<กลับ</a><?} ?></td>
    <td align="left" bgcolor="#FFFFFF" class="th11bred"><input type="submit" name="Submit" value="ตกลง" />&nbsp;
      <input type="reset" name="Submit2" value="ยกเลิก" />
	  <input type="hidden" name="province_id" id="province_id" value="<? echo $province_id;?>" />
	   <input type="hidden" name="orgc_id" id="orgc_id" value="<? echo $orgc_id;?>" />
	  <input type="hidden" name="proc" id="proc" value="<? echo $proc;?>" />	  </td>
  </tr>
</table></td>
  </tr>
</table>
</form>

