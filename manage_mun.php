<? include "check.php";  
$province_id =$_GET['province_id'];
$sqlN="select id_residence,province_name from province where province_id='$province_id'";
$resultN=$db->query($sqlN);
$rsN=$db->fetch_array($resultN);
 $sqlS="select name_residence from residence where id_residence='$rsN[id_residence]'";
  $resultS=$db->query($sqlS);
  $rsS=$db->fetch_array($resultS);
 //echo"province_id=";var_dump($province_id );
$sql="select *
from org_comunity
INNER JOIN org_comunity_detail ON  org_comunity.orgc_id=org_comunity_detail.orgc_id
INNER JOIN amphur ON org_comunity.amphur_id=amphur.amphur_id

where amphur.province_id='$province_id' order by org_comunity_detail.num_orders,org_comunity_detail.orgc_id asc";
//INNER JOIN amphur ON org_comunity.amphur_id=amphur.amphur_id where amphur.province_id='$province_id' order by num_orders,orgc_id asc";  //colum_num_order ไม่มีในตาราง org_comunity //
//SELECT * FROM table1 INNER JOIN table2 ON table1.primary_key = table2.foreign_key ;
 //where province_id='$id_province'
//ไม่ ฟิว province_id นี้ในตาราง org_comunity
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
//echo"province_id=";var_dump($province_id);
?>
<table width="61%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td <? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4){?>colspan="3"<? }else{?>colspan="2"<? }?> class="th14white"  align="left"><? if($_SESSION['LOGTYPE']!=5){?><a href="manage.php?page=manage_province_mun" class="th_red12b"><<<กลับ</a><? }else{ ?><a href="main.php?page=province_mun" class="th_red12b"><<<กลับ</a><? }?></td>
  </tr>
  <tr>
    <td <? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4&&$_SESSION['LOGTYPE']!=5){?>colspan="4"<? }else{?>colspan="3"<? }?> class="th14white" bgcolor="#336699" align="center">ข้อมูลรายชื่ออปท.จังหวัด<? echo $rsN['province_name']?>&nbsp;<? echo $rsS['name_residence']?>&nbsp;&nbsp;<? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4&&$_SESSION['LOGTYPE']!=5){?><a href="manage.php?page=add_mun&province_id=<? echo $province_id;?>" class="th_red12b"><img src="image/add-icon_disab.png" width="23" height="23" border="0"/  onclick="JavaScript:return false;"> </a><? }?></td>
  </tr>
  <tr bgcolor="#CC9933">
      <td width="11%" class="th_head_back14" align="center">ลำดับ</td>


	<td width="50%" class="th_head_back14" align="center">ชื่อหน่วยงานอปท.</td>
    
	<td width="15%" class="th_head_back14" align="center">ลำดับที่อปท.</td>
     <? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4&&$_SESSION['LOGTYPE']!=5){?><td width="22%" class="th12black" align="center"><a href="manage.php?page=mun_sort&province_id=<? echo $province_id;?>">เรียงลำดับใหม่</a></td><? }?>
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
  
	
		<td class="th12black" align="left">&nbsp; <? echo $rs['orgc_name'];?></td>
        <td class="th12black" align="center">&nbsp; <? echo $rs['num_orders'];?></td>
  <? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4&&$_SESSION['LOGTYPE']!=5){?><td class="th12black" align="center"><a href="manage.php?page=add_mun&province_id=<? echo $province_id; ?>&orgc_id=<? echo $rs['orgc_id'];?>&proc=edit">แก้ไข</a>  <a style="color:#696969" href="#" onClick="JavaScript:: return false;">ลบ </a></td><? } ?> <!--//manage_mun_proc.php?province_id_del=<? echo $province_id; ?>&orgc_id=<? echo $rs['orgc_id'];?>&proc=del"onClick="if(!confirm('ยืนยันการลบหรือไม่?')) { return false; }"-->
  </tr><? $a++; $i++;} ?>
  <? if($i==1){
		  	  ?>
                <tr>
                  <td height="30" <? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4&&$_SESSION['LOGTYPE']!=5){?>colspan="4"<? }else{?>colspan="3"<? }?> align="center"   class="th12black">ไม่มีข้อมูล</td>
                </tr>
                <?php
				}
			?>
            <? if($_SESSION['LOGTYPE']!=5){?>
  <tr>
                  <td <? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4&&$_SESSION['LOGTYPE']!=5){?>colspan="4"<? }else{?>colspan="3"<? }?> class="th12black">					        <p class="Small">
<div align="center">รวมทั้งหมด <b><?php echo $Num_Rows; ?></b> เรคคอร์ด <b><?php echo $Num_Pages; ?></b> หน้า: 
<?php
/* สร้างปุ่มย้อนกลับ */
if ( $Prev_Page )
		echo "<a href=\"$PHP_SELF?page=manage_mun&province_id=$province_id&num=$num++&Page=$Prev_Page\">&lt;&lt; ถอยหลัง </a>";
/* สร้างตัวเลขหน้า */
for ( $i=1; $i<=$Num_Pages; $i++ ) 
	{ 
		if ( $i != $Page ) 
				echo "[<a href=\"$PHP_SELF?page=manage_mun&province_id=$province_id&num=$num++&Page=$i\">$i</a>]";
		else 
				echo " <b>$i</b> "; 
	}
/* สร้างปุ่มเดินหน้า */
if ( $Page != $Num_Pages ) 
		echo "<a href=\"$PHP_SELF?page=manage_mun&province_id=$province_id&num=$num++&Page=$Next_Page\"> เดินหน้า &gt;&gt;</a>";
?>
		    </div>
			</td>
  </tr>
  <? }else{?>
  
  <tr>
                  <td <? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4&&$_SESSION['LOGTYPE']!=5){?>colspan="3"<? }else{?>colspan="2"<? }?> class="th12black">					        <p class="Small">
<div align="center">รวมทั้งหมด <b><?php echo $Num_Rows; ?></b> เรคคอร์ด <b><?php echo $Num_Pages; ?></b> หน้า: 
<?php
/* สร้างปุ่มย้อนกลับ */
if ( $Prev_Page )
		echo "<a href=\"$PHP_SELF?page=mun&province_id=$province_id&num=$num++&Page=$Prev_Page\">&lt;&lt; ถอยหลัง </a>";
/* สร้างตัวเลขหน้า */
for ( $i=1; $i<=$Num_Pages; $i++ ) 
	{ 
		if ( $i != $Page ) 
				echo "[<a href=\"$PHP_SELF?page=mun&province_id=$province_id&num=$num++&Page=$i\">$i</a>]";
		else 
				echo " <b>$i</b> "; 
	}
/* สร้างปุ่มเดินหน้า */
if ( $Page != $Num_Pages ) 
		echo "<a href=\"$PHP_SELF?page=mun&province_id=$province_id&num=$num++&Page=$Next_Page\"> เดินหน้า &gt;&gt;</a>"; 
?>
		    </div>
			</td>
  </tr>
  <? }?>
</table>

