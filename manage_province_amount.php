<? include "check.php"; 
include "unset_regis.php";  
$sql="select * from province order by id_residence,num_orders asc";
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
$sql .= " LIMIT $Page_start, $Per_Page"; 
$result = $db->query( $sql );
?>
<table width="64%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="4"  align="left"><a href="manage.php?page=manage_register" class="th_red12b"><<<กลับ</a></td>
  </tr>
  <tr>
    <td colspan="4" class="th16white" bgcolor="#336699" align="center">ข้อมูลรายชื่ออปท.เลือกจัดการตามจังหวัด</td>
  </tr>
  <tr bgcolor="#CC9933">
      <td width="8%" class="th_head_back14" align="center">ลำดับ</td>
    <td width="37%" class="th_head_back14" align="center">สำนักทางหลวงชนบท</td>
	<td width="42%" class="th_head_back14" align="center">สำนักงานทางหลวงชนบทจังหวัด</td>
     <td width="13%" class="th_head_back14" align="center">&nbsp;</td>
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
  <td class="th12black" align="center">&nbsp; <? echo $num.".";?></td>
    <td class="th12black" align="left">&nbsp; <? echo $rsS['name_residence'];?></td>
	    <td class="th12black" align="left">&nbsp; <? echo $rs['name_province'];?></td>
  <td class="th12black" align="center"><a href="manage.php?page=manage_mun_amount&id_province=<? echo $rs['id_province'];?>">เลือก</a></td>
  </tr><? $a++; $i++;} ?><? if($i==1){
		  	  ?>
                <tr>
                  <td height="30" colspan="4" align="center"   class="th12black">ไม่มีข้อมูล</td>
                </tr>
                <?php
				}
			?>
  <tr>
                  <td colspan="4" class="th12black">					        <p class="Small">
<div align="center">รวมทั้งหมด <b><?php echo $Num_Rows; ?></b> เรคคอร์ด <b><?php echo $Num_Pages; ?></b> หน้า: 
<?php
/* สร้างปุ่มย้อนกลับ */
if ( $Prev_Page )
		echo "<a href=\"$PHP_SELF?page=manage_province_mun&num=$num++&Page=$Prev_Page\">&lt;&lt; ถอยหลัง </a>"; 
/* สร้างตัวเลขหน้า */
for ( $i=1; $i<=$Num_Pages; $i++ ) 
	{ 
		if ( $i != $Page ) 
				echo "[<a href=\"$PHP_SELF?page=manage_province_mun&num=$num++&Page=$i\">$i</a>]";
		else 
				echo " <b>$i</b> "; 
	}
/* สร้างปุ่มเดินหน้า */
if ( $Page != $Num_Pages ) 
		echo "<a href=\"$PHP_SELF?page=manage_province_mun&num=$num++&Page=$Next_Page\"> เดินหน้า &gt;&gt;</a>"; 
?>
		    </div>			</td>
                </tr>
</table>

