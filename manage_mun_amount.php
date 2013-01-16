<? include "check.php";  
$id_province =$_GET['id_province'];
$sqlN="select id_residence,name_province from province where id_province='$id_province'";
$resultN=$db->query($sqlN);
$rsN=$db->fetch_array($resultN);
 $sqlS="select name_residence from residence where id_residence='$rsN[id_residence]'";
  $resultS=$db->query($sqlS);
  $rsS=$db->fetch_array($resultS);
$sql="select * from municipality where id_province='$id_province' order by num_orders,id_mun asc";
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
<table width="61%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="3" class="th14white"  align="left"><a href="manage.php?page=manage_province_amount" class="th_red12b"><<<กลับ</a></td>
  </tr>
  <tr>
    <td colspan="3" class="th14white" bgcolor="#336699" align="center">ข้อมูลรายชื่ออปท.จังหวัด<? echo $rsN['name_province']?>&nbsp;<? echo $rsS['name_residence']?></td>
  </tr>
  <tr bgcolor="#CC9933">
      <td width="11%" class="th_head_back14" align="center">ลำดับ</td>


	<td width="67%" class="th_head_back14" align="center">ชื่อหน่วยงานอปท.</td>
     <td width="22%" class="th12black" align="center"></td>
  </tr>
  <? 
$a=1;  
   $num=$Page_start;
  while($rs=$db->fetch_array($result)){
     $num++;
   
   if($a%2==1){
 $bg="CCFF99";
 
 }else if($a%2==0){
 $bg="99FFFF";
 
 }
  ?>
  <tr bgcolor="<?  echo $bg?>">
  <td class="th12black" align="center">&nbsp; <? echo  $num.".";?></td>
  
	
		<td class="th12black" align="left">&nbsp; <? echo $rs['name_mun'];?></td>
  <td class="th12black" align="center"><a href="manage.php?page=add_amount&id_mun=<? echo $rs['id_mun'];?>">เพิ่ม/แก้ไข</a></td>
  </tr><? $a++; $i++;} ?>
  <? if($i==1){
		  	  ?>
                <tr>
                  <td height="30" colspan="3" align="center"   class="th12black">ไม่มีข้อมูล</td>
                </tr>
                <?php
				}
			?>
  <tr>
                  <td colspan="3" class="th12black">					        <p class="Small">
<div align="center">รวมทั้งหมด <b><?php echo $Num_Rows; ?></b> เรคคอร์ด <b><?php echo $Num_Pages; ?></b> หน้า: 
<?php
/* สร้างปุ่มย้อนกลับ */
if ( $Prev_Page )
		echo "<a href=\"$PHP_SELF?page=manage_mun&id_province=$id_province&num=$num++&Page=$Prev_Page\">&lt;&lt; ถอยหลัง </a>"; 
/* สร้างตัวเลขหน้า */
for ( $i=1; $i<=$Num_Pages; $i++ ) 
	{ 
		if ( $i != $Page ) 
				echo "[<a href=\"$PHP_SELF?page=manage_mun&id_province=$id_province&num=$num++&Page=$i\">$i</a>]";
		else 
				echo " <b>$i</b> "; 
	}
/* สร้างปุ่มเดินหน้า */
if ( $Page != $Num_Pages ) 
		echo "<a href=\"$PHP_SELF?page=manage_mun&id_province=$id_province&num=$num++&Page=$Next_Page\"> เดินหน้า &gt;&gt;</a>"; 
?>
		    </div>
			</td>
  </tr>
</table>

