<?php session_start();
include "check.php";
include "unset_regis.php";
if($_SESSION['LOGTYPE']==4){   //รอเอา id_province ของตัวเอง
 
$con="where province_id='$_SESSION[id_province]' and id_residence is not null";
echo "<script>window.location = 'manage.php?page=manage_mun_register&province_id= $_SESSION[id_province]';</script>";
/* old   รอพี่โอม   *********************************************
$sqlI="select id_province from personnel where id_personnel='$_SESSION[LOGID]'";
	$resultI=$db->query($sqlI);
	$rsI=$db->fetch_array($resultI);
$con="where province_id='$rsI[id_province]' and id_residence is not null";
echo "<script>window.location = 'manage.php?page=manage_mun_register&province_id=$rsI[province_id]';</script>";
*/         //*************************************************
}
else { $con="where id_residence is not null";}
$sql="select * from province $con  order by id_residence,num_orders asc";
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
    <td colspan="4" class="th16white" bgcolor="#336699" align="center">เลือกจัดการข้อมูลลงทะเบียนมาตรฐานชั้นทาง</td>
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
  <td class="th_head_back12" align="center">&nbsp; <? echo $num.".";?></td>
<td class="th_head_back12" align="left">&nbsp; <? echo $rsS['name_residence'];?></td>
	    <td class="th_head_back12" align="left">&nbsp; <? echo $rs['province_name'];?></td>
  <td class="th_head_back12" align="center"><a href="manage.php?page=manage_mun_register&province_id=<? echo $rs['province_id'];?>" >เลือก</a></td>
  </tr><? $a++; $i++;} ?><? if($i==1){
		  	  ?>
                <tr>
                  <td height="30" colspan="4" align="center"   class="th_head_back12">ไม่มีข้อมูล</td>
                </tr>
                <?php
				}
			?>
  <tr>
                  <td colspan="4" class="th12black">					        <p class="Small">
<div align="center" class="th_head_back12">รวมทั้งหมด <b><?php echo $Num_Rows; ?></b> เรคคอร์ด <b><?php echo $Num_Pages; ?></b> หน้า: 
<?php
/* สร้างปุ่มย้อนกลับ */
if ( $Prev_Page )
		echo "<a href=\"$PHP_SELF?page=manage_province_register&num=$num++&Page=$Prev_Page\">&lt;&lt; ถอยหลัง </a>"; 
/* สร้างตัวเลขหน้า */
for ( $i=1; $i<=$Num_Pages; $i++ ) 
	{ 
		if ( $i != $Page ) 
				echo "[<a href=\"$PHP_SELF?page=manage_province_register&num=$num++&Page=$i\">$i</a>]";
		else 
				echo " <b>$i</b> "; 
	}
/* สร้างปุ่มเดินหน้า */
if ( $Page != $Num_Pages ) 
		echo "<a href=\"$PHP_SELF?page=manage_province_register&num=$num++&Page=$Next_Page\"> เดินหน้า &gt;&gt;</a>"; 
?>
		    </div>
			</td>
                </tr>
</table>

