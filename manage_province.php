<? include "check.php";  
include "unset_regis.php"; 
$sql="select * from province where id_residence is not null order by id_residence,num_orders asc";
$result=$db->query($sql);
$i=1;
	 $Per_Page =50;
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
<table width="64%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td <? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4&&$_SESSION['LOGTYPE']!=5){?>colspan="4"<? }else{?>colspan="3"<? }?> class="th16white" bgcolor="#336699" align="center">ข้อมูลสำนักงานทางหลวงชนบทจังหวัด &nbsp;&nbsp;<? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4&&$_SESSION['LOGTYPE']!=5){?> <? }?></td>  <!--<a href="manage.php?page=add_province" class="th_red12b"><img src="image/add-icon.png" width="23" height="23" border="0"/> เพิ่ม</a>-->
  </tr>
  <tr bgcolor="#CC9933">
      <td width="8%" class="th_head_back14" align="center">ลำดับ</td>
    <td width="36%" class="th_head_back14" align="center">สำนักงานทางหลวงชนบทจังหวัด</td>
	<td width="40%" class="th_head_back14" align="center">สำนักทางหลวงชนบท</td>
    <? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4&&$_SESSION['LOGTYPE']!=5){?> <? }?>  <!-- <td width="16%" class="th_head_back14" align="center">&nbsp;</td>-->

  </tr>
  <? 
$a=1;  
$num=$Page_start;
  while($rs=$db->fetch_array($result)){
     $num++;
  $sqlS="select name_residence from residence where id_residence='$rs[id_residence]'";
  $resultS=$db->query($sqlS);
  $rsS=$db->fetch_array($resultS);
   if($a%2==1){
 $bg="CCFF99";
 
 }else if($a%2==0){
 $bg="99FFFF";
 
 }
  ?>
  <tr bgcolor="<?  echo $bg?>">
  <td class="th_head_back12" align="center">&nbsp; <? echo $num.".";?></td>
<td class="th_head_back12" align="left">&nbsp; <? echo $rs['province_name'];?></td>
	    <td class="th_head_back12" align="left">&nbsp; <? echo $rsS['name_residence'];?></td>
 <? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4&&$_SESSION['LOGTYPE']!=5){?> <? }?> <!--<td class="th_head_back12" align="center"><a href="manage.php?page=add_province&province_id=<? // echo $rs['province_id']?>&proc=edit">แก้ไข</a> / <a href="manage_pro_proc.php?province_id=<? //echo $rs['province_id']?>&proc=del"  onClick="if(!confirm('ยืนยันการลบหรือไม่?')) { return false; }">ลบ </a></td>-->   
  </tr><? $a++; $i++; } ?>
  		<? if($i==1){
		  	  ?>
                <tr>
                  <td height="30" <? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4&&$_SESSION['LOGTYPE']!=5){?>colspan="4"<? }else{?>colspan="3"<? }?> align="center"   class="th_head_back12">ไม่มีข้อมูล</td>
                </tr>
                <?php
				}
			/////////////////////////////////////////////////////////
			?>
			<? if($_SESSION['LOGTYPE']!=5){?>
  <tr>
                  <td <? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4&&$_SESSION['LOGTYPE']!=5){?>colspan="4"<? }else{?>colspan="3"<? }?> class="th_head_back12">					        <p class="Small">
<div align="center" class="th_head_back12">รวมทั้งหมด <b><?php echo $Num_Rows; ?></b> เรคคอร์ด <b><?php echo $Num_Pages; ?></b> หน้า: 

<?php //////////////////////////////////////////////////////////////////////////////
/* สร้างปุ่มย้อนกลับ */
if ( $Prev_Page )
		echo "<a href=\"$PHP_SELF?page=manage_province&num=$num++&Page=$Prev_Page\">&lt;&lt; ถอยหลัง </a>"; 
/* สร้างตัวเลขหน้า */
for ( $i=1; $i<=$Num_Pages; $i++ ) 
	{ 
		if ( $i != $Page ) 
				echo "[<a href=\"$PHP_SELF?page=manage_province&num=$num++&Page=$i\">$i</a>]";
		else 
				echo " <b>$i</b> "; 
	}
/* สร้างปุ่มเดินหน้า */
if ( $Page != $Num_Pages ) 
		echo "<a href=\"$PHP_SELF?page=manage_province&num=$num++&Page=$Next_Page\"> เดินหน้า &gt;&gt;</a>"; 
?>
		    </div>
			 </td>
                </tr><? }else{?>
                  <tr>
                  <td <? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4&&$_SESSION['LOGTYPE']!=5){?>colspan="4"<? }else{?>colspan="3"<? }?> class="th_head_back12">					        <p class="Small">
<div align="center" class="th_head_back12">รวมทั้งหมด <b><?php echo $Num_Rows; ?></b> เรคคอร์ด <b><?php echo $Num_Pages; ?></b> หน้า: 
<?php
/* สร้างปุ่มย้อนกลับ */
if ( $Prev_Page )
		echo "<a href=\"$PHP_SELF?page=province&num=$num++&Page=$Prev_Page\">&lt;&lt; ถอยหลัง </a>"; 
/* สร้างตัวเลขหน้า */
for ( $i=1; $i<=$Num_Pages; $i++ ) 
	{ 
		if ( $i != $Page ) 
				echo "[<a href=\"$PHP_SELF?page=province&num=$num++&Page=$i\">$i</a>]";
		else 
				echo " <b>$i</b> "; 
	}
/* สร้างปุ่มเดินหน้า */
if ( $Page != $Num_Pages ) 
		echo "<a href=\"$PHP_SELF?page=province&num=$num++&Page=$Next_Page\"> เดินหน้า &gt;&gt;</a>"; 
?>
		    </div>
			 </td>
                </tr>
                
                <? }?>
</table>

