<?  include "check.php";
include "unset_regis.php";
 if($_SESSION['LOGTYPE']==3){ //echo"logtype3=";var_dump($_SESSION['LOGTYPE']);     /////////
$con="and id_personnel='$_SESSION[LOGID]'";
}
   
$sql="select * from personnel where type_personnel='3' and status_personnel='0' $con order by id_personnel asc";
$result=$db->query($sql);
$i=1;
	 $Per_Page =38;
if ( !$Page ) 
	$Page = 1; 
$Prev_Page = $Page - 1; 
$Next_Page = $Page + 1; 
$result = $db->query($sql); 
$Page_start = ( $Per_Page * $Page ) - $Per_Page; 
$Num_Rows = $db->num_rows( $result ); 
if ( $Num_Rows <= $Per_Page ) $Num_Pages = 1; 
else if ( ( $Num_Rows % $Per_Page ) == 0 ) $Num_Pages = ( $Num_Rows / $Per_Page ); 
else $Num_Pages = ( $Num_Rows / $Per_Page ) + 1; 

$Num_Pages = ( int ) $Num_Pages; 
if ( ( $Page > $Num_Pages ) || ( $Page < 0 ) ) 
	print "จำนวน $Page มากกว่า $Num_Pages";
$sql .= " LIMIT $Per_Page offset $Page_start";
$result = $db->query( $sql );
?>
<!--<link href="css/register.css" rel="stylesheet" type="text/css" />-->
<table width="88%" border="0" cellspacing="2" cellpadding="2">
  <tr>      <!--1,2 can add user-->
    <td colspan="7" class="th16white" bgcolor="#336699" align="center">จัดการบุคลากร&nbsp;สทช.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <? if($_SESSION['LOGTYPE']==1||$_SESSION['LOGTYPE']==2){?><a href="manage.php?page=add_personnel_res" class="th_red12b"><img src="image/add-icon.png" width="23" height="23" border="0"/> เพิ่ม</a><? } ?></td>
  </tr>
  <tr bgcolor="#CC9933">
    <td width="13%" class="th_head_back14" align="center">ชื่อผู้ใช้ระบบ</td>
 
    <td width="20%" class="th_head_back14" align="center">ชื่อ-นามสกุล</td>
    <td width="15%" class="th_head_back14" align="center">เบอร์โทรศัพท์</td>
	
	 <td width="26%" class="th_head_back14" align="center">ประเภทเจ้าหน้าที่</td>
	<!-- <td width="18%" class="th_head_back14" align="center">วันที่เข้าใช้ล่าสุด</td>    -->
	 <td width="8%" class="th_head_back14">&nbsp;</td>
  </tr>
  <? 
$a=1;  
   $num=$Page_start;
  while($rs=$db->fetch_array($result)){
     $num++;
	  //$sqlIp="select date_time from log_login
 //where id_personnel='$rs[id_personnel]' order by id_login  desc";
 //$resultIp=$db->query($sqlIp);
 //$rsIp=$db->fetch_array($resultIp);
// $numIp=$db->num_rows($resultIp);
  if($rs['id_residence']==null){
     $sqlNs="select name_residence from residence where id_residence=null";       //เพิ่มใหม่แก้ค่า sql error ตอน ไม่มี id_residence
  } else{
 $sqlNs="select name_residence from residence where id_residence='$rs[id_residence]'";
 }
 $resultNs=$db->query($sqlNs);  
 $rsNs=$db->fetch_array($resultNs);     //echo"var_dump for name rs"; var_dump($rsNs['name_residence']); exit;

   if($a%2==1){
 $bg="CCFF99";
 
 }else if($a%2==0){
 $bg="99FFFF";
 
 }
 
  ?>
  <tr bgcolor="<?  echo $bg?>">
    <td class="th_head_back12" align="left">&nbsp; <? echo $rs['username_per'];?></td>
  
    <td class="th_head_back12" align="left">&nbsp; <? echo $rs['name_personnel'];?></td>
  <td class="th_head_back12" align="left">&nbsp; <? echo $rs['tel_personnel'];?></td>
    <td align="left" class="th_head_back12"><? echo $rsNs['name_residence'];?></td>
  <!--  <td align="center" class="th_head_back12"><? if($numIp!=0){echo  date('d-m-Y H:i:s',strtotime($rsIp['date_time']));}else {echo"รอพี่ปอยว่าเอาไว้ใหม ";}//echo "ยังไม่เคยเข้าใช้ระบบ";}?></td>   -->
      <!--1,2,3 can edit user-->                                                                                                                                                                                                                                  <!--1,2 can delete user-->
	  <td align="center" class="th_head_back12"><? if($_SESSION['LOGTYPE']==1||$_SESSION['LOGTYPE']==2||$_SESSION['LOGTYPE']==3){?><a href="manage.php?page=add_personnel_res&id_personnel=<? echo $rs['id_personnel']?>&proc=edit">แก้ไข</a> <? } if($_SESSION['LOGTYPE']==1||$_SESSION['LOGTYPE']==2){?>/ <a href="manage_per_res_proc.php?id_personnel=<? echo $rs['id_personnel']?>&proc=del" onClick="if(!confirm('ยืนยันการลบหรือไม่?')) { return false; }">ลบ </a><? } ?></td>
  </tr><? $a++; $i++;} ?><? if($i==1){
		  	  ?>
                <tr>
                  <td height="30" colspan="6" align="center"   class="th_head_back12">ไม่มีข้อมูล</td>
                </tr>
                <?php
				}
			?>
  <tr>
                  <td colspan="6" class="th12black">					        <p class="Small">
<div align="center" class="th_head_back12">รวมทั้งหมด <b><?php echo $Num_Rows; ?></b> เรคคอร์ด <b><?php echo $Num_Pages; ?></b> หน้า: 
<?php
/* สร้างปุ่มย้อนกลับ */
if ( $Prev_Page )
		echo "<a href=\"$PHP_SELF?page=manage_per_res&num=$num++&Page=$Prev_Page\">&lt;&lt; ถอยหลัง </a>"; 
/* สร้างตัวเลขหน้า */
for ( $i=1; $i<=$Num_Pages; $i++ ) 
	{ 
		if ( $i != $Page ) 
				echo "[<a href=\"$PHP_SELF?page=manage_per_res&num=$num++&Page=$i\">$i</a>]";
		else 
				echo " <b>$i</b> "; 
	}
/* สร้างปุ่มเดินหน้า */
if ( $Page != $Num_Pages ) 
		echo "<a href=\"$PHP_SELF?page=manage_per_res&num=$num++&Page=$Next_Page\"> เดินหน้า &gt;&gt;</a>"; 
?>
    </div>			</td>
  </tr>
</table>

