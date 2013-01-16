<? include "check.php";

$id_mun=$_GET['id_mun'];

$REFEREF=$_SERVER['HTTP_REFERER'];
$sql="SELECT `province`.id_province,name_province,drop_name,`municipality`.name_mun,`municipality`.num_orders,`municipality`.amount_way,`municipality`.amount_phase_way,name_residence
FROM
  `municipality`
  INNER JOIN `province` ON (`municipality`.`id_province` = `province`.`id_province`)
  INNER JOIN `residence` ON (`province`.`id_residence` = `residence`.`id_residence`) where `municipality`.id_mun='$id_mun'";
  $result=$db->query($sql);
  $rs=$db->fetch_array($result);
  
  $sqlS="SELECT *
FROM
  `register_road`
 where `register_road`.id_mun='$id_mun' order by id_road asc";
 $resultS=$db->query($sqlS);
 $numS=$db->num_rows($resultS);
?>
<link href="css/register.css" rel="stylesheet" type="text/css" />
<table width="601" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="th_head_back14" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="th_head_back"  align="center"><p>สมุดลงทะเบียนคุมสายทางหลวงท้องถิ่น (ทถ.6) </p>
          </td>
      </tr>
	    <tr>
        <td class="th14bgray"  align="center">ทชจ.&nbsp;<? echo $rs['name_province'];?>&nbsp;&nbsp;<? echo $rs['name_residence']?>
          </td>
      </tr>
	     <tr>
        <td class="th14bgray_line"  align="center">หน่วยงาน&nbsp;<? echo $rs['name_mun'];?>  </td>
      </tr>
      
    </table></td>
  </tr>
</table>
<br/>
<br/><table width="990" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="0">
  <tr><td width="230" align="left"><? if($_SESSION['LOGTYPE']!=5){?><a href="manage.php?page=report_register7&id_province=<? echo $rs['id_province'];?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.7</a><? }else{?><a href="main.php?page=report7&id_province=<? echo $rs['id_province'];?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.7</a> <? }?></td>
  <td width="760" align="right"><a href="show_map.php?id_mun=<? echo $id_mun;?>" title="ดูแผนที่" target="_blank"  class="th12red_love">ดูแผนที่</a> / <a href="report/report6.php?id_mun=<? echo $id_mun?>" target="_blank" ><img src="image/pdf_icon.png" alt="แสดงรายงานในรูปแบบ pdf" width="20" align="absbottom" border="0" /></a></td>
  </tr></table>
<table width="1000" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
<tr bgcolor="#6699FF">
<td colspan="17" class="th12bblue" align="center">จำนวนสายทางและระยะทางที่ <span class="th12bblue"><? echo $rs['name_mun'];?></span> รับผิดชอบทั้งหมด จำนวนสายทาง&nbsp;<span class="th12bred"><? echo number_format($rs['amount_way'],0,'.',',');?></span> เส้น&nbsp;ระยะทาง&nbsp;<span class="th12bred"><? echo number_format($rs['amount_phase_way'],3,'.',',');?></span> (กม.) <? if($rs['amount_way']==0||$rs['amount_phase_way']==""){?><span class="th11bred">* กรุณาเพิ่มจำนวนสายทางและระยะทางที่รับผิดชอบ</span><? }?></td>
</tr>

<tr bgcolor="#6699FF"><td width="53" rowspan="2" align="center" class="th12bblue">ลำ<br/>
  ดับ<br/>ที่</td>
<td width="76" rowspan="2" align="center" class="th12bblue">รหัส<br/>
  สายทาง</td>
<td width="120" rowspan="2" align="center" class="th12bblue">ชื่อสายทาง</td>
<td width="39" rowspan="2" align="center" class="th12bblue">ชั้นทาง<br/>
  ใน<br/>เขต<br/>ชุมชน<br/>ชั้น</td>
<td width="39" rowspan="2" align="center" class="th12bblue">ชั้นทาง<br/>
  นอก<br/>เขต<br/>ชุมชน<br/>ชั้น</td>
<td width="45" rowspan="2" align="center" class="th12bblue">ระยะ<br/>
  ทาง<br/>
  (กม.)</td>
<td colspan="5" class="th12bblue" align="center">ผิวจราจรกว้าง<br/>(ม.)</td>
<td width="61" rowspan="2" align="center" class="th12bblue">เขตทาง<br/>
  กว้าง<br/>(ม.)</td>

<td width="49" rowspan="2" align="center" class="th12bblue">ปีที่<br/>
  ก่อสร้าง<br/>
  (พ.ศ.)</td>
<td width="74" rowspan="2" align="center" class="th12bblue">ลงทะเบียน<br/>
  เมื่อ<br/>
  วัน/เดือน/ปี</td>

<td width="101" rowspan="2" align="center" class="th12bblue">เจ้าหน้าที่ผู้<br/>
  ผู้รับผิดชอบ</td>
<td width="85" rowspan="2" align="center" class="th12bblue">&nbsp;</td>
</tr>
<tr bgcolor="#6699FF">
  <td width="46" class="th12bblue" align="center">คสล.</td>
<td width="45" class="th12bblue" align="center">ลาดยาง</td>
<td width="33" class="th12bblue" align="center">ลูกรัง</td>
<td width="49" class="th12bblue" align="center">ไหล่ทาง</td>
<td width="51" class="th12bblue" align="center">ทางเท้า</td>
</tr>
<? $i=1; while($rsS=$db->fetch_array($resultS)){
$sum_disT1+=$rsS['distance_road'];
$sql1="select id_regis_detail,type_ja,width_ja,type_sh,width_sh,type_fo,width_fo,kate_regis from register_road_detail where id_regis='$rsS[id_regis]' order by type_ja asc,width_ja asc,type_sh asc,width_sh asc,type_fo asc,width_fo asc,kate_regis asc";
$result1=$db->query($sql1);

while($rs1=$db->fetch_array($result1)){
$ks[]=$rs1['kate_regis'];
sort($ks);
if($rs1['type_sh']!=0){
$lt[]=$rs1['width_sh'];
sort($lt);
}
else if($rs1['type_fo']!=0){
$tt[]=$rs1['width_fo'];
sort($tt);
}
if($rs1['type_ja']==1){
$wt1[]=$rs1['width_ja'];
sort($wt1);
}else if($rs1['type_ja']==2){
$wt2[]=$rs1['width_ja'];
sort($wt2);
}
else if($rs1['type_ja']==3){
$wt3[]=$rs1['width_ja'];
sort($wt3);
}

}
  ?>
 
<tr><td align="center" class="th_black11b"><? if($rsS['cre_type']==1){ $Scre_type=1;

?><span class="th11bred">*</span><? }?><? echo $i;?>.</td>
<td align="center" class="th_black11b"><? echo $rsS['na_road'].$rsS['id_road'];?></td>
<td align="left" class="th_black11b"><? echo $rsS['name_road'];?></td>
<td align="center" class="th_black11b"><? if($rsS['id_regis_detail']!=0&&$rsS['type_road']==0&&$rsS['cre_type']!=2 ){ if($rsS['layer_road']==0){ echo "พิเศษ";}else{echo $rsS['layer_road']; }}else{ echo "-";}?></td>
<td align="center" class="th_black11b"><? if($rsS['id_regis_detail']!=0&&$rsS['type_road']==1&&$rsS['cre_type']!=2 ){ if($rsS['layer_road']==0){ echo "พิเศษ";}else{echo $rsS['layer_road']; }}else { echo "-";}?></td>
<td align="center" class="th_black11b"><? echo number_format($rsS['distance_road'],3,'.',',');?></td>
<td align="center" class="th_black11b"><? $cw1=count($wt1);  if($cw1!=0 ){ if($cw1>0&&$wt1[0]!=$wt1[$cw1-1]){echo number_format($wt1[0],2,'.',',')."-".number_format($wt1[$cw1-1],2,'.',','); }else if($wt1[0]==$wt1[$cw1-1]) {echo number_format($wt1[0],2,'.',',');} }else{ echo "-";}?></td>
<td align="center" class="th_black11b"><? $cw2=count($wt2); if($cw2!=0 ){ if($cw2>0&&$wt2[0]!=$wt2[$cw2-1]){echo number_format($wt2[0],2,'.',',')."-".number_format($wt2[$cw2-1],2,'.',','); }else if($wt2[0]==$wt2[$cw2-1]) {echo $wt2[0];} }else{ echo "-";}?></td>
<td align="center" class="th_black11b"><? $cw3=count($wt3); if($cw3!=0 ){ if($cw3>0&&$wt3[0]!=$wt3[$cw3-1]){echo number_format($wt3[0],2,'.',',')."-".number_format($wt3[$cw3-1],2,'.',','); }else if($wt3[0]==$wt3[$cw3-1]) {echo $wt3[0];} }else{ echo "-";}?></td>
<td align="center" class="th_black11b"><? $clt=count($lt); if($clt!=0 ){ if($clt>0&&$lt[0]!=$lt[$clt-1]){
echo number_format($lt[0],2,'.',',')."-".number_format($lt[$clt-1],2,'.',',');}
else if($lt[0]==$lt[$clt-1]) {echo number_format($lt[0],2,'.',',');}}
else{ echo "-";}?></td>
<td align="center" class="th_black11b"><? $ctt=count($tt); if($ctt!=0 ){ if($ctt>0&&$tt[0]!=$tt[$ctt-1]){
echo number_format($tt[0],2,'.',',')."-".number_format($tt[$clt-1],2,'.',',');}
else if($tt[0]==$tt[$ctt-1]) {echo number_format($tt[0],2,'.',',');}}
else{ echo "-";}?></td>
<td align="center" class="th_black11b"><?  $cks=count($ks); if($cks!=0 ){ if($cks>0&&$ks[0]!=$ks[$cks-1]){
echo number_format($ks[0],2,'.',',')."-".number_format($ks[$cks-1],2,'.',',');}
else if($ks[0]==$ks[$cks-1]) {echo number_format($ks[0],2,'.',',');}} else{ echo "-";}?></td>

<td align="center" class="th_black11b"><? if($rsS['year_road']!=""){echo $rsS['year_road'];}else{
echo "-";
} ?></td>
<td align="center" class="th_black11b"><?  echo $disp->displaydateY($rsS['cre_date']); ?></td>

<td  class="th_black11b"><? if($rsS['name_per']!=""){?><div align="left"><? echo $rsS['name_per'];?></div><? }else{ ?><div align="center" ><?
echo "-"; ?> </div><?
} ?></td>
<td  class="th_black11b" align="center" >&nbsp; <? if($rsS['pic_map_mun']!=""){?> <a href="show_map_mun.php?id_regis=<? echo $rsS['id_regis'];?>" target="_blank"><img src="image/map.jpg" width="20" height="20" border="0" /></a>&nbsp; <? }?><? if($rsS['file_t2']!=""){?><a <a href="<? echo $rsS['file_t2'];?>" target="_blank"><img src="image/pdf_icon.png" width="20" height="20"  border="0"/></a>&nbsp; <? }?><? if($rsS['g_approve']==1){?><img src="image/true.jpg" width="20" height="20" border="0" />  <? }else{?> <img src="image/pid.bmp" width="20" height="20" border="0" />  <? }?></td>
</tr>

<? $i++; unset($wt1);
unset($wt2);
unset($wt3);
unset($lt);
unset($tt);
unset($ks);
}?><tr>
  <td align="center" class="th11bblack" colspan="2">รวมทั้งหมด</td>

  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th11bblack_line"><? echo number_format($sum_disT1,3,'.',',');?></td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
  <td  align="center" class="th_black11b">-</td>
  <td  align="center" class="th_black11b">&nbsp;</td>
</tr>
<? if( $Scre_type==1){?>
<tr>
  <td align="center" class="th11black" colspan="16"><span class="th11bred">หมายเหตุ เครื่องหมาย * หน้าลำดับที่ คือสายทางที่อปท. <? echo $rs['name_mun'];?>เลือกกำหนดมาตรฐานชั้นทางเอง</span></td>
</tr><? }?>
</table>
