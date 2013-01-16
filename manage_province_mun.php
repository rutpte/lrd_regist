<? include "check.php";
include "unset_regis.php";   
$sql="select * from province where id_residence is not null order by id_residence,num_orders asc";  // ถ้าตัวไหนไม่ id_residence มันก็จะทำให้เออเร่อ จึงแก้ด้วยวิธีนี้ where id_residence is not null
$result=$db->query($sql);   //where id_residence is not null
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
$sql .= " LIMIT $Per_Page offset $Page_start";   ////////////////////////////////// อาจเกิดจากนี่
$result = $db->query( $sql );
?>
<table width="64%" border="0" cellspacing="2" cellpadding="2">
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
  $num=$Page_start; ////
  while($rs=$db->fetch_array($result)){////
     $num++;
  $sqlS="select name_residence from residence where id_residence='$rs[id_residence]'"; //echo"$num";var_dump($rs[id_residence]);
  $resultS=$db->query($sqlS);
  $rsS=$db->fetch_array($resultS);  /////
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
  <td class="th_head_back12" align="center"><? if($_SESSION['LOGTYPE']!=5){?><a href="manage.php?page=manage_mun&province_id=<? echo $rs['province_id'];?>">เลือก</a><? }else{?><a href="main.php?page=mun&id_province=<? echo $rs['id_province'];?>" >เลือก</a><? }?></td> <?//ถ้า logtype=5 จะเป็นการเรียกหาหน้าเพจ main.php(หน้าแรกนั่นเอง)?>
  </tr><?

       $a++; $i++;

         }  //end while

   if($i==1){

   ?>

                <tr>
                  <td height="30" colspan="4" align="center"   class="th_head_back12">ไม่มีข้อมูล</td>
                </tr>
                <?php
				}
			?>
            <?
////////////////////////////////////////////////////////////////////////////////////////////
            if($_SESSION['LOGTYPE']!=5){?>
  <tr>
                  <td colspan="4" class="th12black">					        <p class="Small">
<div align="center" class="th_head_back12">รวมทั้งหมด <b><?php echo $Num_Rows; ?></b> เรคคอร์ด <b><?php echo $Num_Pages; ?></b> หน้า: 
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
		    </div>
			</td>
                </tr><? // ปิดปีกกา if logtype != 5
//////////////////////////////////////////////////////////////////////////////////////////////////////
                }else{?>
 <tr>
                  <td colspan="4" class="th12black">					        <p class="Small">
<div align="center" class="th_head_back12">รวมทั้งหมด <b><?php echo $Num_Rows; ?></b> เรคคอร์ด <b><?php echo $Num_Pages; ?></b> หน้า: 
<?php
/* สร้างปุ่มย้อนกลับ */
if ( $Prev_Page )
		echo "<a href=\"$PHP_SELF?page=province_mun&num=$num++&Page=$Prev_Page\">&lt;&lt; ถอยหลัง </a>"; 
/* สร้างตัวเลขหน้า */
for ( $i=1; $i<=$Num_Pages; $i++ ) 
	{ 
		if ( $i != $Page ) 
				echo "[<a href=\"$PHP_SELF?page=province_mun&num=$num++&Page=$i\">$i</a>]";
		else 
				echo " <b>$i</b> "; 
	}
/* สร้างปุ่มเดินหน้า */
if ( $Page != $Num_Pages ) 
		echo "<a href=\"$PHP_SELF?page=province_mun&num=$num++&Page=$Next_Page\"> เดินหน้า &gt;&gt;</a>"; 
?>
		    </div>
			</td>
                </tr>
<? }?>
</table>

