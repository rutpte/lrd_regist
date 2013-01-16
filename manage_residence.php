<? include "check.php"; 
include "unset_regis.php";  
$sql="select * from residence order by id_residence asc"; //select สำนักงานทางหลวงชนบท ที่....
$result=$db->query($sql);

?>
<link href="css/register.css" rel="stylesheet" type="text/css" />
<table width="83%" border="0" cellspacing="2" cellpadding="2">
  <tr>                                                                                                          <? //cospan=3 อาจจะเป็นการตัดฟังชั่น เรียงลำดับออก สงานให้แต่ logtype 1-2?>
    <td <? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4&&$_SESSION['LOGTYPE']!=5){?>colspan="4"<? }else{?>colspan="3"<? }?> class="th16white" bgcolor="#336699" align="center">ข้อมูลสำนัก</td>
  </tr>
  <tr bgcolor="#CC9933">
      <td width="8%" class="th_head_back14" align="center">ลำดับ</td>
    <td width="31%" class="th_head_back14" align="center">สำนักทางหลวงชนบท</td>
     <td width="49%" class="th_head_back14" align="center">ประกอบด้วยสำนักงานทางหลวงชนบทจังหวัด</td>
	 <? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4&&$_SESSION['LOGTYPE']!=5){?><td width="12%" class="th_head_back14" align="center"></td><? }?>

  </tr>
  <!--/////////////////////////////////////////////////////////////////////////////////-->
  <? 
$a=1;  
  while($rs=$db->fetch_array($result)){
    $sqlS="select province_name from province where id_residence='$rs[id_residence]' order by num_orders";   //select ชื่อจังหวัด ที่มี id_residence ตรงกัน    (รอเฟสในtdนั้นเลย) num_orders ค่าที่กำหนดเรียงลำดับ ว่าใครเยอะกว่าได้อยู่หน้า หรือ หลัง
  $resultS=$db->query($sqlS);
  
   if($a%2==1){
 $bg="CCFF99";
 
 }else if($a%2==0){
 $bg="99FFFF";
 
 }
  ?>
  <tr bgcolor="<?  echo $bg?>">
  <td class="th12bgray" align="center">&nbsp; <? echo $a.".";?></td>   <!--เลขลำดับ-->
    <td class="th12bgray" align="left">&nbsp; <? echo $rs['name_residence'];?></td><!--สำนักงาน-->
  <td class="th12bgray" align="left">&nbsp;<? while($rsS=$db->fetch_array($resultS)){ echo $rsS['province_name'];?>&nbsp; <? }?> </td>

  <? if($_SESSION['LOGTYPE']!=3&&$_SESSION['LOGTYPE']!=4&&$_SESSION['LOGTYPE']!=5){//ถ้า logtype =1-2 ก็จะแสดงลิงค์ให้เรียงใหม่?>
  <td class="th12bgray" align="center"><a href="manage.php?page=province_sort&id_residence=<? echo $rs['id_residence']?>">เรียงลำดับใหม่</a></td><? }?>
  </tr><? $a++; }//ปีกกาปิด fetch แรก ?>
</table>

