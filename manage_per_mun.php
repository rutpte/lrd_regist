<?  include "check.php";  
include "unset_regis.php";?>
<link href="css/register.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">

var xmlHttp;
function createXMLHttpRequest() {
if (window.ActiveXObject) {
xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
} 
else if (window.XMLHttpRequest) {
xmlHttp = new XMLHttpRequest();
}
}
function list_namesub(id,id2) {
var obj = document.getElementById("id_mun");
var obj_default = '- เลือก -';

if(id ==""){
while(obj.childNodes.length>0){obj.removeChild(obj.childNodes[0]);}
obj[0] = new Option(obj_default,'','',false);
obj.style.width=80;
}else{
	obj.style.width="";
var url = "get_mun.php?id=" + id+"&id2="+id2;
createXMLHttpRequest();
xmlHttp.onreadystatechange = handleStateChange;
xmlHttp.open("GET", url, true);
xmlHttp.send(null);
function handleStateChange() {
if(xmlHttp.readyState == 4) {
if(xmlHttp.status == 200) {
var results = xmlHttp.responseText;
while(obj.childNodes.length>0){obj.removeChild(obj.childNodes[0]);}
arr_list=results.split("/");
if(arr_list.length-1!=0){
for (var i=0; i < eval(arr_list.length-1); i++) {
shop_arr=arr_list[i].split(",");
obj.options[i] = new Option(shop_arr[0],shop_arr[1],'',shop_arr[2]);


}}else{
while(obj.childNodes.length>0){obj.removeChild(obj.childNodes[0]);}
obj[0] = new Option(obj_default,'','',false);

}
}
}}
}}

</script><?
$id_province=$_POST['id_province'];
$id_mun=$_POST['id_mun'];
$name_search=$_POST['name_search'];
if($id_province!=""&&$id_mun==""){
$cond="and id_province='$id_province'";	
}else if($id_province!=""&&$id_mun!=""){
$cond="and id_province='$id_province' and id_mun='$id_mun'";		
}
if($name_search!=""){
$cond1="and name_personnel LIKE '%$name_search%'";
}
 if($_SESSION['LOGTYPE']==5){
$con="and id_personnel='$_SESSION[LOGID]'";
}
$sql="select * from personnel where type_personnel='5' and status_personnel='0' $con $cond $cond1 order by id_personnel asc";
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
$sql .= " LIMIT $Page_start, $Per_Page"; 
$result = $db->query( $sql );
	$sqlS1="select id_province,name_province from province";
$resultS1=$db->query($sqlS1);
?>
<? if($id_province!=""){?>
<body onLoad="list_namesub(<? echo $id_province;?>,<? echo $id_mun;?>);"><? }?>
<? if($_SESSION['LOGTYPE']==1||$_SESSION['LOGTYPE']==2){?>
  <form action="" name="form2" id="form2" method="post">
<table width="442" border="0" align="center">
  <tr>
    <td class="th_head_back12" align="right" width="149">ค้นหาจากชื่อ- นามสกุล</td>
    <td width="283" align="left" class="th_head_back12"><input type="text" name="name_search" id="name_search" value="<? echo $name_search;?>"  style="width:140px"/> <input type="submit" name="button1" id="button1" value="ค้นหา" /></td>

  </tr>
</table>
</form>
<br/><? }?>
<table width="70%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="5" class="th16white" bgcolor="#336699" align="center">จัดการบุคลากร&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <? if($_SESSION['LOGTYPE']==1||$_SESSION['LOGTYPE']==2){?><a href="manage.php?page=add_personnel_mun" class="th_red12b"><img src="image/add-icon.png" width="23" height="23" border="0"/> เพิ่ม</a><? } ?></td>
  </tr>
  <tr bgcolor="#CC9933">
    <td width="19%" class="th_head_back14" align="center">ชื่อผู้ใช้ระบบ</td>
 
    <td width="31%" class="th_head_back14" align="center">ชื่อ-นามสกุล</td>
    <td width="18%" class="th_head_back14" align="center">เบอร์โทรศัพท์</td>

	 <td width="22%" class="th_head_back14" align="center">วันที่เข้าใช้ล่าสุด</td>
	 <td width="10%" class="th_head_back14">&nbsp;</td>
  </tr>
  <? 
$a=1;  
   $num=$Page_start;
  while($rs=$db->fetch_array($result)){
     $num++;
	 	 $sqlIp="select date_time from log_login
 where id_personnel='$rs[id_personnel]' order by id_login  desc";
 $resultIp=$db->query($sqlIp);
 $rsIp=$db->fetch_array($resultIp);
 $numIp=$db->num_rows($resultIp);


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

	  <td align="center" class="th_head_back12"><? if($numIp!=0){echo  date('d-m-Y H:i:s',strtotime($rsIp['date_time']));}else { echo "ยังไม่เคยเข้าใช้ระบบ";}?></td>
	  <td align="center" class="th_head_back12"><? if($_SESSION['LOGTYPE']==1||$_SESSION['LOGTYPE']==2){?><a href="manage.php?page=add_personnel_mun&id_personnel=<? echo $rs['id_personnel']?>&proc=edit">แก้ไข</a> <? }else if($_SESSION['LOGTYPE']==5){?><a href="main.php?page=edit_register&id_personnel=<? echo $rs['id_personnel']?>&proc=edit">แก้ไข</a> <? } if($_SESSION['LOGTYPE']==1||$_SESSION['LOGTYPE']==2){?>/ <a href="manage_per_mun_proc.php?id_personnel=<? echo $rs['id_personnel']?>&proc=del" onClick="if(!confirm('ยืนยันการลบหรือไม่?')) { return false; }">ลบ </a><? } ?></td>
  </tr><? $a++; $i++;} ?><? if($i==1){
		  	  ?>
                <tr>
                  <td height="30" colspan="5" align="center"   class="th_head_back12">ไม่มีข้อมูล</td>
  </tr>
                <?php
				}
			?>
  <tr>
                  <td colspan="5" class="th12black">					        <p class="Small">
<div align="center" class="th_head_back12">รวมทั้งหมด <b><?php echo $Num_Rows; ?></b> เรคคอร์ด <b><?php echo $Num_Pages; ?></b> หน้า: 
<?php
/* สร้างปุ่มย้อนกลับ */
if ( $Prev_Page )
		echo "<a href=\"$PHP_SELF?page=manage_per_mun&num=$num++&Page=$Prev_Page\">&lt;&lt; ถอยหลัง </a>"; 
/* สร้างตัวเลขหน้า */
for ( $i=1; $i<=$Num_Pages; $i++ ) 
	{ 
		if ( $i != $Page ) 
				echo "[<a href=\"$PHP_SELF?page=manage_per_mun&num=$num++&Page=$i\">$i</a>]";
		else 
				echo " <b>$i</b> "; 
	}
/* สร้างปุ่มเดินหน้า */
if ( $Page != $Num_Pages ) 
		echo "<a href=\"$PHP_SELF?page=manage_per_mun&num=$num++&Page=$Next_Page\"> เดินหน้า &gt;&gt;</a>"; 
?>
		    </div>			</td>
  </tr>
</table>

