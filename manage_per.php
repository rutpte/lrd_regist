<?   session_start();
include "check.php";    // หน้านี้จะมีสิทธิ์เข้าได้ 1-2 เ่ท่านัี้น
include "unset_regis.php";   //ลบค่าในตัวแปร session 
 if($_SESSION['LOGTYPE']==2){
//-->>old...$con="and id_personnel='$_SESSION[LOGID]'"; //แต่ logtype เป็นสอง ก็จะเห็นแค่ตัวเองเท่้านั้น จะเห็นหมดจะต้องเป็น 1
 $con="and id_personnel='$_SESSION[LOGID]'";
}
$sql="select * from personnel where type_personnel='2' and status_personnel='0' $con order by id_personnel asc";
//and status_personnel='0' ถ้าคนที่โดน ลบออกจะมีสถานะเป็น 1

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
if ( $Num_Rows <= $Per_Page ) $Num_Pages = 1;       // หา นัมเพจไปทำลิงค์
else if ( ( $Num_Rows % $Per_Page ) == 0 ) $Num_Pages = ( $Num_Rows / $Per_Page ); 
else $Num_Pages = ( $Num_Rows / $Per_Page ) + 1; 

$Num_Pages = ( int ) $Num_Pages; 
if ( ( $Page > $Num_Pages ) || ( $Page < 0 ) )
	print "จำนวน $Page มากกว่า $Num_Pages";
$sql .=" limit $Per_Page offset $Page_start";//เอาไปต่อท้ายอีกหลังจากคำนวน หาจำนวนเพจเรียบร้อยแล้ว 
$result = $db->query( $sql );          //สั่งให้ทำงานอีกครั้ง
//$Page_start=1;
//$Per_Page=2;
//echo "limit=".$Page_start."offset".$Per_Page."<br>";var_dump( $Page_start,$Per_Page);  //debug
//คำสั่ง limit ของ postgresql สลับกัน ระหว่าง ค่าเริ่มต้น กับ ค่าสุดท้าย
?>
<!--<link href="css/register.css" rel="stylesheet" type="text/css" />-->
<table width="80%" border="0" cellspacing="2" cellpadding="2">
  <tr> <!--1 can add user-->
    <td colspan="7" class="th16white" bgcolor="#336699" align="center">จัดการบุคลากร สสท.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <? if($_SESSION['LOGTYPE']==1){?><a href="manage.php?page=add_personnel" class="th_red12b"><img src="image/add-icon.png" width="23" height="23" border="0"/> เพิ่ม</a><? } ?></td>
  </tr>
  <tr bgcolor="#CC9933">
    <td width="18%" class="th_head_back14" align="center">ชื่อผู้ใช้ระบบ</td>
 
    <td width="18%" class="th_head_back14" align="center">ชื่อ-นามสกุล</td>
    <td width="16%" class="th_head_back14" align="center">เบอร์โทรศัพท์</td>
	
	 <td width="19%" class="th_head_back14" align="center">ประเภทเจ้าหน้าที่</td>
	 <!--<td width="19%" class="th_head_back14" align="center">วันที่เข้าใช้ล่าสุด</td>-->
	 <td width="10%" class="th_head_back14">&nbsp;</td>
  </tr>
  <? 
$a=1;  
   $num=$Page_start;
  while($rs=$db->fetch_array($result)){ /////////////////
     $num++;
         // $sqlIp="select date_time from log_login             //เข้า log_login เพื่อเอาเวลาligin ล่าสุดมาโชว์ด้วย
         // where id_personnel='$rs[id_personnel]' order by id_login  desc";    ///
         //$resultIp=$db->query($sqlIp);
         //$rsIp=$db->fetch_array($resultIp);
         // $numIp=$db->num_rows($resultIp);
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
    <td align="center" class="th_head_back12">เจ้าหน้าที่ สสท.</td>
<!--    <td align="center" class="th_head_back12"><? if($numIp!=0){echo  date('d-m-Y H:i:s',strtotime($rsIp['date_time']));}else { echo "ยังไม่เคยเข้าใช้ระบบ";}?></td>     -->
           <!--1,2 can edit user-->                                                                                                                                                                                      <!--1 can delete user-->
	  <td align="center" class="th_head_back12"><? if($_SESSION['LOGTYPE']==1||$_SESSION['LOGTYPE']==2){?><a href="manage.php?page=add_personnel&id_personnel=<? echo $rs['id_personnel']?>&proc=edit">แก้ไข</a> <? } if($_SESSION['LOGTYPE']==1){?>/ <a href="manage_per_proc.php?id_personnel=<? echo $rs['id_personnel']?>&proc=del" onClick="if(!confirm('ยืนยันการลบหรือไม่?')) { return false; }">ลบ </a><? } ?></td>
  </tr><? $a++; $i++;}//end while ?> <? if($i==1){
		  	  ?>
                <tr>
                  <td height="30" colspan="6" align="center"   class="th_head_back12">ไม่มีข้อมูล</td>
                </tr>
                <?php
				}
			?>
  <tr>
                  <td colspan="6" class="th_head_back12">					        <p class="Small">
<div align="center">รวมทั้งหมด <b><?php echo $Num_Rows; ?></b> เรคคอร์ด <b><?php echo $Num_Pages; ?></b> หน้า: 
<?php
/* สร้างปุ่มย้อนกลับ */
if ( $Prev_Page )   //if ขึ้นมาเฉยๆ เพื่อจะสร้างปุ่มได้เหรอ ทำไมไม่ i!=0 ค่อยให้แสดง
		echo "<a href=\"$PHP_SELF?page=manage_per&num=$num++&Page=$Prev_Page\">&lt;&lt; ถอยหลัง </a>"; 
/* สร้างตัวเลขหน้า */
for ( $i=1; $i<=$Num_Pages; $i++ )   //ตัวแปร i สร้างมาใหม่ไม่เกี่ยวกับตัวข้างบน  แต่จะเกี่ยวกับตัวแปร $page ว่าถ้าตรงกันก็จะไม่ให้ทำเป็นลิงค์แต่จะแสดงเฉยๆ
	{ 
		if ( $i != $Page ) 
				echo "[<a href=\"$PHP_SELF?page=manage_per&num=$num++&Page=$i\">$i</a>]";
		else 
				echo " <b>$i</b> "; 
	}
/* สร้างปุ่มเดินหน้า */
if ( $Page != $Num_Pages ) 
		echo "<a href=\"$PHP_SELF?page=manage_per&num=$num++&Page=$Next_Page\"> เดินหน้า &gt;&gt;</a>"; 
?>
		    </div>			</td>
                </tr>
</table>

