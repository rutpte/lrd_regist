<? //include "check.php";

$id_mun=$_REQUEST['id_mun'];
$search_way=$_POST['search_way'];
$list_year=$_REQUEST['list_year'];
if($search_way==""||$search_way==1){
$conT="";
}
else if($search_way==2){
$conT="and file_t2!=''";	
}
else if($search_way==3){
	$conT="and file_t2=''";	
}
$REFEREF=$_SERVER['HTTP_REFERER'];
$sql="SELECT `province`.id_province,name_province,drop_name,`municipality`.name_mun,`municipality`.num_orders,`municipality`.amount_way,`municipality`.amount_phase_way,name_residence,`municipality`.pic_map
FROM
  `municipality`
  INNER JOIN `province` ON (`municipality`.`id_province` = `province`.`id_province`)
  INNER JOIN `residence` ON (`province`.`id_residence` = `residence`.`id_residence`) where `municipality`.id_mun='$id_mun'";
  $result=$db->query($sql);
  $rs=$db->fetch_array($result);
    $sqlSu="select sum(distance_road) as sum_dis FROM
  `register_road` where `register_road`.id_mun='$id_mun' $conT";
  $resultSu=$db->query($sqlSu);
  $rsSu=$db->fetch_array($resultSu);
  $sqlS="SELECT *
FROM
  `register_road`
 where `register_road`.id_mun='$id_mun' $conT order by id_road asc";
 $resultS=$db->query($sqlS);
 $numS=$db->num_rows($resultS);
  $i=1;
	 $Per_Page =50;
if ( !$Page ) 
	$Page = 1; 
$Prev_Page = $Page - 1; 
$Next_Page = $Page + 1; 
$resultS = $db->query($sqlS); 
$Page_start = ( $Per_Page * $Page ) - $Per_Page; 
$Num_Rows = $db->num_rows( $resultS ); 
if ( $Num_Rows <= $Per_Page ) $Num_Pages = 1; 
else if ( ( $Num_Rows % $Per_Page ) == 0 ) $Num_Pages = ( $Num_Rows / $Per_Page ); 
else $Num_Pages = ( $Num_Rows / $Per_Page ) + 1; 

$Num_Pages = ( int ) $Num_Pages; 
if ( ( $Page > $Num_Pages ) || ( $Page < 0 ) ) 
	print "จำนวน $Page มากกว่า $Num_Pages";
$sqlS .= " LIMIT $Page_start, $Per_Page"; 
$resultS = $db->query( $sqlS );
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
</table><br/>
<form id="form1" name="form1" method="post" action="manage.php?page=report_register6&id_mun=<? echo $id_mun;?>">
  <table width="990" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center"><select name="search_way" id="search_way" onchange="javascript:this.form.submit();"><option value="1" <? if($search_way==1){ ?> selected="selected" <? }?>>สายทางทั้งหมด</option>
<option value="2" <? if($search_way==2){ ?> selected="selected" <? }?>>สายทางที่ ผวจ. อนุมัติแล้ว</option>
<option value="3" <? if($search_way==3){ ?> selected="selected" <? }?>>สายทางที่ ผวจ. ยังไม่อนุมัติ</option>
      </select></td>
      <input name="list_year" id="list_year" type="hidden" value="<? echo $list_year;?>"/>
    </tr>
  </table>
</form>
<br/><table width="990" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="0">
  <tr><td width="230" align="left"><? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?><a href="manage.php?page=report_register7&id_province=<? echo $rs['id_province'];?>&list_year=<? echo $list_year;?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.7</a><? }else{?><a href="main.php?page=report7&id_province=<? echo $rs['id_province'];?>&list_year=<? echo $list_year;?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.7</a> <? }?></td>
  <td width="760" align="right"><a href="report/show_report6.php?list_year=<? echo $list_year;?>?id_mun=<? echo $id_mun?>" target="_blank" ><img src="image/pdf_icon.png" alt="แสดงรายงานในรูปแบบ pdf" width="20" align="absbottom" border="0" /></a></td>
  </tr></table>


<table width="995" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
<tr bgcolor="#6699FF">
<td colspan="17" class="th12bblue" align="center">รวมสายทางลงทะเบียนจำนวน  <span class="th12bred"><? echo number_format($numS,0,'.',',');;?></span> เส้น รวมระยะทางลงทะเบียนจำนวน <!--จำนวนสายทาง&nbsp;<span class="th12bred"><? //echo number_format($rs['amount_way'],0,'.',',');?></span> เส้น--> <span class="th12bred"><? echo number_format($rsSu['sum_dis'],3,'.',',');?></span> (กม.) </td>
</tr>

<tr bgcolor="#6699FF"><td width="41" rowspan="2" align="center" class="th12bblue">ลำ<br/>
  ดับ<br/>ที่</td>
<td width="86" rowspan="2" align="center" class="th12bblue">รหัส<br/>
  สายทาง</td>
<td width="141" rowspan="2" align="center" class="th12bblue">ชื่อสายทาง</td>
<td width="39" rowspan="2" align="center" class="th12bblue">ชั้นทาง<br/>
  ใน<br/>เขต<br/>ชุมชน<br/>
  (ชั้น)</td>
<td width="39" rowspan="2" align="center" class="th12bblue">ชั้นทาง<br/>
  นอก<br/>เขต<br/>ชุมชน<br/>
  (ชั้น)</td>
<td width="30" rowspan="2" align="center" class="th12bblue">ระยะ<br/>
  ทาง<br/>
  (กม.)</td>
<td colspan="5" class="th12bblue" align="center">ผิวจราจรกว้าง<br/>(ม.)</td>
<td width="76" rowspan="2" align="center" class="th12bblue">เขตทาง<br/>
  กว้าง<br/>(ม.)</td>

<td width="64" rowspan="2" align="center" class="th12bblue">ลงทะเบียน<br/>
  เมื่อ<br/>
  วัน/เดือน/ปี</td>



<td colspan="3" class="th12bblue" align="center">ดำเนินการ</td>
</tr>
<tr bgcolor="#6699FF">
  <td width="50" height="44" align="center" class="th12bblue">คสล.</td>
<td width="49" class="th12bblue" align="center">ลาดยาง</td>
<td width="47" class="th12bblue" align="center">ลูกรัง</td>
<td width="50" class="th12bblue" align="center">ไหล่ทาง</td>
<td width="57" class="th12bblue" align="center">ทางเท้า</td>

<td width="64" class="th12bblue" align="center">แผนที่<br/>สาย<br/>ทาง</td>
<td width="64" class="th12bblue" align="center">ทถ.2<br/>ที่ผจว.<br/>อนุมัติ</td>
<td width="64" class="th12bblue" align="center">แผนที่<br/>
รวม<br/>สาย<br/>ทาง</td>

</tr>
<? $i=1; 
   $num=$Page_start;
while($rsS=$db->fetch_array($resultS)){
$num++;
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

?><span class="th11bred">*</span><? }?><? echo $num;?>.</td>
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

<td align="center" class="th_black11b"><?  echo $disp->displaydateY($rsS['cre_date']); ?></td>


<td align="center" class="th_black11b"><? if($rsS['pic_map_mun']!=""){?><a href="show_map_regis.php?id_regis=<? echo $rsS['id_regis'];?>" target="_blank"><img src="image/wolrd1.jpg" width="30" height="30" border="0" /></a>&nbsp; <? }else{?><img src="image/wolrdX.jpg" width="30" height="30" border="0" /></a><? }?></td>
<td align="center" class="th_black11b"><? if($rsS['file_t2']!=""){?><a href="show_file_regis.php?id_regis=<? echo $rsS['id_regis'];?>" target="_blank"><img src="image/true.jpg" width="30" height="30" border="0" /></a>&nbsp; <? }else{?><img src="image/trueX.jpg" width="30" height="30" border="0" /><? }?></td>
<? if($i==1){ ?>
<td align="center" class="th_black11b"  rowspan="<? echo  $numS;?>"><? if($rs['pic_map']!=""){?><a href="show_map.php?id_mun=<? echo $id_mun;?>" title="ดูแผนที่" target="_blank"  class="th12red_love"><img src="image/wolrd1.jpg" width="30" height="30" border="0" /></a>&nbsp; <? }else if($rs['pic_map']==""){?><img src="image/wolrdX.jpg" width="30" height="30" border="0" /><? }?></td> <? }?>
</tr>


<? $i++; unset($wt1);
unset($wt2);
unset($wt3);
unset($lt);
unset($tt);
unset($ks);
}?>

<tr>
  <td colspan="2" align="center" class="th_black11b">รวมทั้งหมด</td>
  <td align="left" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b"><? echo number_format($sum_disT1,3,'.',',');?></td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>

  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
  <td align="center" class="th_black11b">-</td>
</tr>
<? if( $Scre_type==1){?>
<tr>
  <td align="center" class="th11black" colspan="17"><span class="th11bred">หมายเหตุ เครื่องหมาย * หน้าลำดับที่ คือสายทางที่กำหนดมาตรฐานชั้นทางเอง</span></td>

</tr><? }?>
 <? if($i==1){
		  	  ?>
                <tr>
                  <td height="30" colspan="3" align="center"   class="th_head_back12">ไม่มีข้อมูล</td>
                </tr>
                <?php
				}
			?>
 <tr>
                  <td colspan="17" class="th12black">					        <p class="Small">
<div align="center" class="th_head_back12">รวมทั้งหมด <b><?php echo $Num_Rows; ?></b> เรคคอร์ด <b><?php echo $Num_Pages; ?></b> หน้า: 
<?php
/* สร้างปุ่มย้อนกลับ */
if ( $Prev_Page )
		echo "<a href=\"$PHP_SELF?page=report_register6&id_mun=$id_mun&search_way=$search_way&list_year=$list_year&num=$num++&Page=$Prev_Page\">&lt;&lt; ถอยหลัง </a>"; 
/* สร้างตัวเลขหน้า */
for ( $i=1; $i<=$Num_Pages; $i++ ) 
	{ 
		if ( $i != $Page ) 
				echo "[<a href=\"$PHP_SELF?page=report_register6&search_way=$search_way&list_year=$list_year&id_mun=$id_mun&num=$num++&Page=$i\">$i</a>]";
		else 
				echo " <b>$i</b> "; 
	}
/* สร้างปุ่มเดินหน้า */
if ( $Page != $Num_Pages ) 
		echo "<a href=\"$PHP_SELF?page=report_register6&search_way=$search_way&list_year=$list_year&id_mun=$id_mun&num=$num++&Page=$Next_Page\"> เดินหน้า &gt;&gt;</a>"; 
?>
		    </div>
			</td>
  </tr>
</table>