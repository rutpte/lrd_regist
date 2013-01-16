<? session_start();
include "check.php";
//--รอ name จากพี่โอ $id_personnel=$_SESSION['LOGID'];
if($_SESSION['LOGTYPE']=='4'){
    
    $province_id= $_SESSION['id_province'];
   /*
    $_SESSION['LOGTYPE']=='4'){
    $sql_4="select id_province from personnel where id_personnel='$id_personnel'";
    $result_4=$db->query($sql_4);
    $rs4=$db->fetch_array( $result_4);
    $province_id=$rs4['id_province'];
    //echo"logtype4="; echo"$province_id";  echo"id_personnel=";echo"$id_personnel";     exit;
    */ 
}else{
$province_id =$_GET['province_id'];
}
 //var_dump($province_id); //exit;

$sqlN="select id_residence,province_name from province where province_id='$province_id'";
$resultN=$db->query($sqlN);
$rsN=$db->fetch_array($resultN);
 $sqlS="select name_residence from residence where id_residence='$rsN[id_residence]'";
  $resultS=$db->query($sqlS);
  $rsS=$db->fetch_array($resultS);
$sql="select *
from org_comunity
inner join org_comunity_detail on org_comunity.orgc_id=org_comunity_detail.orgc_id
inner join amphur on org_comunity.amphur_id=amphur.amphur_id where province_id='$province_id' order by org_comunity_detail.num_orders,org_comunity_detail.orgc_id asc";
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
<table width="61%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="3" class="th14white"  align="left"><a href="manage.php?page=manage_province_register" class="th_red12b"><<<กลับ</a></td>
  </tr>
  <tr>
    <td colspan="3" class="th14white" bgcolor="#336699" align="center">ข้อมูลรายชื่ออปท.จังหวัด<? echo $rsN['province_name']?>&nbsp;<? echo $rsS['name_residence']?></td>
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
  <td class="th_head_back12" align="center">&nbsp; <? echo  $num.".";?></td>
  
	
		<td class="th_head_back12" align="left">&nbsp; <? echo $rs['orgc_name'];?></td>
  <td class="th_head_back12" align="center"><a href="manage.php?page=manage_register&orgc_id=<? echo $rs['orgc_id'];?>" >เลือก</a></td>
  </tr><? $a++; $i++;} ?>
  <? if($i==1){
		  	  ?>
                <tr>
                  <td height="30" colspan="3" align="center"   class="th_head_back12">ไม่มีข้อมูล</td>
                </tr>
                <?php
				}
			?>
  <tr>
                  <td colspan="3" class="th12black">					        <p class="Small">
<div align="center" class="th_head_back12">รวมทั้งหมด <b><?php echo $Num_Rows; ?></b> เรคคอร์ด <b><?php echo $Num_Pages; ?></b> หน้า: 
<?php
/* สร้างปุ่มย้อนกลับ */
if ( $Prev_Page )
		echo "<a href=\"$PHP_SELF?page=manage_mun_register&province_id=$province_id&num=$num++&Page=$Prev_Page\">&lt;&lt; ถอยหลัง </a>"; 
/* สร้างตัวเลขหน้า */
for ( $i=1; $i<=$Num_Pages; $i++ ) 
	{ 
		if ( $i != $Page ) 
				echo "[<a href=\"$PHP_SELF?page=manage_mun_register&province_id=$province_id&num=$num++&Page=$i\">$i</a>]";
		else 
				echo " <b>$i</b> "; 
	}
/* สร้างปุ่มเดินหน้า */
if ( $Page != $Num_Pages ) 
		echo "<a href=\"$PHP_SELF?page=manage_mun_register&province_id=$province_id&num=$num++&Page=$Next_Page\"> เดินหน้า &gt;&gt;</a>"; 
?>
		    </div>
			</td>
  </tr>
</table>

