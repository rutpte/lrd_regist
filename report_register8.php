<?    session_start();
 include "check.php";

$part=$_GET['part'];
$id_residence=$_GET['id_residence'];
$list_year=$_GET['list_year'];
$show=$_GET['show'];
$s_date=$_GET['s_date'];
$e_date=$_GET['e_date'];
 if($show==""||$show==1){
	$con=""; 
	$show==1;
	$day="";
 }else if($show==2&&$s_date!=""&&$e_date!=""){
$show_date = date('Y-m-d',strtotime($s_date));
 $end_date = date('Y-m-d',strtotime($e_date));
 $con="and way.cre_date between '$show_date' and '$end_date'";
  $day=$disp->displaydateS($show_date)." ถึง วันที่ ".$disp->displaydateS1($end_date);
 }
$sqlN="select residence.name_residence from residence where id_residence='$id_residence'";
$resultN=$db->query($sqlN);
$rsN=$db->fetch_array($resultN); 
$sql="SELECT province.province_id,province.province_name
FROM
  province
  INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (org_comunity.amphur_id = amphur.amphur_id)

  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)

    where province.id_residence='$id_residence' and (way.active='t') and way.flag_reg_road='t' $con
  GROUP BY province.province_id,province.province_name,province.num_orders

 order by province.num_orders asc";       //เอา id อปท ออก ไม้งั้นออกมาเยอะ

 /*
 เก่า
 $sql="SELECT province.province_id,province.province_name,way.orgc_id
FROM
  province
  INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (org_comunity.amphur_id = amphur.amphur_id)

  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)
  INNER JOIN register_road_detail ON (way.way_id=register_road_detail.way_id)
    where  register_road_detail.id_regis_detail!=0  and province.id_residence='$id_residence' $con
  GROUP BY province.province_id
 order by province.num_orders asc";
 */
  $result=$db->query($sql);
$list_year=$_GET['list_year'];





  
 ?>

<link href="css/register.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="th_head_back14" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="87%" rowspan="2"  align="center" class="th_head_back16"> <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="th_head_back14" align="center"><table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td class="th_head_back16"  align="center">ตารางสรุปการลงทะเบียนทางหลวงท้องถิ่น (ทถ.8) </td>
      </tr>
	    <tr>
        <td class="th_head_back16"  align="center">ในเขตพื้นที่<? echo $rsN['name_residence'];?> กรมทางหลวงชนบท กระทรวงคมนาคม          </td>
      </tr>
	     <tr>
        <td class="th_head_back14"  align="center">รายงานเมื่อ <? echo $disp->displaydateS(date("Y-m-d"));?></td>
      </tr>
       <? if($day!=""){?>
       <tr>
        <td class="th_red12b"  align="center">ตั้งแต่ <? echo $day;?></td>
      </tr>
      <? }?>
    </table></td>
  </tr>
</table></td>
   
	     
      
    </table></td>
  </tr>
</table><br/><br/>
<table width="980" border="0" align="center" ><tr>
    <td align="center" class="th12bblue" height="30"><a href="charts/graph8.php?id_residence=<? echo $id_residence;?>&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th12red_love" target="_blank" >แผนภูมิความก้าวหน้า</a>&nbsp;&nbsp;<a href="charts/graph8.php?id_residence=<? echo $id_residence;?>&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th12red_love" target="_blank"><img src="image/Code_ArraySS.jpg" width="20" height="16" alt="แผนภูมิความก้าวหน้าของสทช." title="แผนภูมิความก้าวหน้าของสทช."  border="0"/></a></td>
  </tr></table>
<? if($part==""||$part==1){ 

?>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>
    <td align="left"><? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?><a href="manage.php?page=report_register9&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.9</a><? }else{?><a href="main.php?page=report9&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.9</a><? }?></td>
    <td align="right" class="th12bblue"><? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?><span class="th12ora">ในเขตชุมชน</span> / <a href="manage.php?page=report_register8&id_residence=<? echo $id_residence?>&part=2&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th12red_love">นอกเขตชุมชน</a> / <a href="manage.php?page=report_register8&id_residence=<? echo $id_residence?>&part=3&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th12red_love">รายงานความก้าวหน้า</a> / <a href="report/show_report8.php?list_year=<? echo $list_year;?>&id_residence=<? echo $id_residence?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" target="_blank" ><img src="image/pdf_icon.png" alt="แสดงรายงานในรูปแบบ pdf" width="20" align="absbottom" border="0" /></a><? }else{?><span class="th12ora">ในเขตชุมชน</span> / <a href="main.php?page=report8&id_residence=<? echo $id_residence?>&part=2&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th12red_love">นอกเขตชุมชน</a> / <a href="main.php?page=report8&id_residence=<? echo $id_residence?>&part=3&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th12red_love">รายงานความก้าวหน้า</a> / <a href="report/show_report8.php?list_year=<? echo $list_year;?>&id_residence=<? echo $id_residence?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" target="_blank" ><img src="image/pdf_icon.png" alt="แสดงรายงานในรูปแบบ pdf" width="20" align="absbottom" border="0" /></a> <? } ?></td>
  </tr>
</table>

<table width="980" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#6699FF">
 
    <td width="246" rowspan="3" class="th12bblue" align="center">ชื่อ ทชจ. </td>
    <td colspan="12" class="th12bblue" align="center">ถนนในเขตเมือง/ในเขตชุมชน</td>
  </tr>
  <tr bgcolor="#6699FF">
    <td colspan="2" class="th12bblue" align="center">ชั้นพิเศษ</td>
    <td colspan="2" class="th12bblue" align="center">ชั้นที่ 1 </td>
    <td colspan="2" class="th12bblue" align="center">ชั้นที่ 2 </td>
    <td colspan="2" class="th12bblue" align="center">ชั้นที่ 3 </td>
    <td colspan="2" class="th12bblue" align="center">ชั้นที่ 4 </td>
    <td colspan="2" class="th12bblue" align="center">รวมทะเบียน<br/>ในเขตชุมชน</td>
  </tr>
  <tr bgcolor="#6699FF">
    <td width="44" class="th12bblue" align="center">จำนวน<br/>
    สายทาง</td>
    <td width="52" class="th12bblue" align="center">ระยะทาง <br/>
    (กม.)</td>
    <td width="44" class="th12bblue" align="center">จำนวน<br/>
    สายทาง</td>
    <td width="52" class="th12bblue" align="center">ระยะทาง <br/>
    (กม.)</td>
    <td width="44" class="th12bblue" align="center">จำนวน<br/>
    สายทาง</td>
    <td width="52" class="th12bblue" align="center">ระยะทาง <br/>
    (กม.)</td>
    <td width="44" class="th12bblue" align="center">จำนวน<br/>
    สายทาง</td>
    <td width="52" class="th12bblue" align="center">ระยะทาง <br/>
    (กม.)</td>
    <td width="44" class="th12bblue" align="center">จำนวน<br/>
    สายทาง</td>
    <td width="52" class="th12bblue" align="center">ระยะทาง <br/>
    (กม.)</td>
    <td width="44" class="th12bblue" align="center">จำนวน<br/>
    สายทาง</td>
    <td width="59" class="th12bblue" align="center">ระยะทาง<br/>
    (กม.)</td>
  </tr>
  <? $i=0; 

  while($rs=$db->fetch_array($result)){

  $sqlSum="SELECT way.distance_total,way.type_road,way.layer_road
FROM
  residence
  INNER JOIN province ON (province.id_residence=residence.id_residence)
  INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (org_comunity.amphur_id = amphur.amphur_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)


  where province.province_id='$rs[province_id]' and (way.active='t') and way.flag_reg_road='t' $con";
    /*

    SELECT province.province_id,province.province_name
FROM
  province
  INNER JOIN amphur ON (amphur.province_id=province.province_id) 
  INNER JOIN org_comunity ON (org_comunity.amphur_id = amphur.amphur_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)
    
  GROUP BY province.province_id,province.num_orders,province.province_name
 order by province.num_orders asc*/
  $resultSum=$db->query($sqlSum);
  while($rsSum=$db->fetch_array($resultSum)){

  if($rsSum['type_road']==0&&$rsSum['layer_road']==0){

  $class0+=1;
  $numP0+=$rsSum['distance_total'];
  }
  else if($rsSum['type_road']==0&&$rsSum['layer_road']==1){
  $class1+=1;
  $numP1+=$rsSum['distance_total'];
  }
  else if($rsSum['type_road']==0&&$rsSum['layer_road']==2){
  $class2+=1;
  $numP2+=$rsSum['distance_total'];
  }
  else if($rsSum['type_road']==0&&$rsSum['layer_road']==3){
  $class3+=1;
  $numP3+=$rsSum['distance_total'];


 
  }
  else if($rsSum['type_road']==0&&$rsSum['layer_road']==4){
  $class4+=1;
  $numP4+=$rsSum['distance_total'];
  }
  
  

  $sumClassT1=$class0+$class1+$class2+$class3+$class4;
  $sumNumT1=$numP0+$numP1+$numP2+$numP3+$numP4;
  


  


}

  ?>
  <tr>

  <td align="left" class="th11bblue"><? if($rs['province_id']!=""){?><? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?><a href="manage.php?page=report_register7&province_id=<? echo $rs['province_id']; ?>&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>"><? echo $i+1?>.&nbsp;<? echo $rs['province_name'];?></a><? } else{ ?><a href="main.php?page=report7&province_id=<? echo $rs['province_id']; ?>&list_year=<? echo $list_year;?>"><? echo $i+1?>.&nbsp;<? echo $rs['province_name'];?></a><? }}?></td>
  <td align="center" class="th11bblack"><? if($class0!=""){ echo number_format($class0,0,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($numP0!=""){echo number_format($numP0,3,'.',',');}else{ echo "-";}?></td>
   <td align="center" class="th11bblack"><? if($class1!=""){  echo number_format($class1,0,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($numP1!=""){  echo number_format($numP1,3,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($class2!=""){echo number_format($class2,0,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($numP2!=""){echo number_format($numP2,3,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($class3!=""){echo number_format($class3,0,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($numP3!=""){echo number_format($numP3,3,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($class4!=""){echo number_format($class4,0,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($numP4!=""){echo number_format($numP4,3,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sumClassT1!=""){echo number_format($sumClassT1,0,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sumNumT1!=""){echo number_format($sumNumT1,3,'.',',');}else{ echo "-";}?></td>
  </tr> <? 
  $i++;


  $sum_c0+=$class0;
  $sum_p0+=$numP0;
  $sum_c1+=$class1;
  $sum_p1+=$numP1;
  $sum_c2+=$class2;
  $sum_p2+=$numP2;
  $sum_c3+=$class3;
  $sum_p3+=$numP3;
  $sum_c4+=$class4;
  $sum_p4+=$numP4;
  

  $sum_sumClassT1+=$sumClassT1;
  $sum_sumNumT1+=$sumNumT1;
 $class0="";
$class1="";
$class2="";
$class3="";
$class4="";
 $numP0="";
 $numP1="";
 $numP2="";
 $numP3="";
 $numP4="";  
   $sumClassT1="";
    $sumNumT1="";
	  $sum_amount_way="";
  $sum_amount_phase_way="";
  }  
  
   if($i>0){?>
    <tr>

  <td align="center" class="th11bblack">รวมทั้งหมด</td>
  <td align="center" class="th11bblack"><? if($sum_c0!=""){ ?><span class="th11bblack_line"><?  echo number_format($sum_c0,0,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_p0!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_p0,3,'.',',');?></span><? }else{ echo "-";}?></td>
   <td align="center" class="th11bblack"><? if($sum_c1!=""){ ?><span class="th11bblack_line"><?   echo number_format($sum_c1,0,'.',',')?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_p1!=""){ ?><span class="th11bblack_line"><?   echo number_format($sum_p1,3,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_c2!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_c2,0,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_p2!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_p2,3,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_c3!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_c3,0,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_p3!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_p3,3,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_c4!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_c4,0,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_p4!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_p4,3,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_sumClassT1!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_sumClassT1,0,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_sumNumT1!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_sumNumT1,3,'.',','); ?></span><? }else{ echo "-";}?></td>
  </tr>
  <? }?>
</table>
<? }else if($part==2){


?>
<table width="995" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>   <td align="left"><? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?><a href="manage.php?page=report_register9&part=2&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.9</a><? }else{?><a href="main.php?page=report9&part=2&list_year=<? echo $list_year;?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.9</a><? }?></td>
    <td align="right" class="th12bblue"><? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?><a href="manage.php?page=report_register8&id_residence=<? echo $id_residence?>&part=1&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th12red_love">ในเขตชุมชน</a> / <span class="th12ora">นอกเขตชุมชน</span> / <a href="manage.php?page=report_register8&id_residence=<? echo $id_residence?>&part=3&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th12red_love">รายงานความก้าวหน้า</a> / <a href="report/show_report8.php?list_year=<? echo $list_year;?>&id_residence=<? echo $id_residence?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" target="_blank" ><img src="image/pdf_icon.png" alt="แสดงรายงานในรูปแบบ pdf" width="20" align="absbottom" border="0" /></a><? }else{?> 
	<a href="main.php?page=report8&id_residence=<? echo $id_residence?>&part=1&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th12red_love">ในเขตชุมชน</a> / <span class="th12ora">นอกเขตชุมชน</span> / <a href="main.php?page=report8&id_residence=<? echo $id_residence?>&part=3&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th12red_love">รายงานความก้าวหน้า</a> / <a href="report/show_report8.php?list_year=<? echo $list_year;?>&id_residence=<? echo $id_residence?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" target="_blank" ><img src="image/pdf_icon.png" alt="แสดงรายงานในรูปแบบ pdf" width="20" align="absbottom" border="0" /></a><? }?></td>
  </tr>
</table>

<table width="995" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#6699FF">
  
    <td width="142" rowspan="3" class="th12bblue" align="center">ชื่อ ทชจ. </td>

    <td colspan="16" class="th12bblue" align="center">ถนนนอกเขตเมือง/นอกเขตชุมชน</td>
  </tr>
  <tr bgcolor="#6699FF">
  
    <td colspan="2" class="th12bblue" align="center">ชั้นพิเศษ</td>
    <td colspan="2" class="th12bblue" align="center">ชั้นที่ 1 </td>
    <td colspan="2" class="th12bblue" align="center">ชั้นที่ 2 </td>
    <td colspan="2" class="th12bblue" align="center">ชั้นที่ 3 </td>
    <td colspan="2" class="th12bblue" align="center">ชั้นที่ 4 </td>
	<td colspan="2" class="th12bblue" align="center">ชั้นที่ 5 </td>
    <td colspan="2" class="th12bblue" align="center">ชั้นที่ 6 </td>
    <td colspan="2" class="th12bblue" align="center">รวมทะเบียน<br/>นอกเขตชุมชน</td>
  </tr>
  <tr bgcolor="#6699FF">
    <td width="51" class="th12bblue" align="center">จำนวน<br/>
    สายทาง</td>
    <td width="52" class="th12bblue" align="center">ระยะทาง <br/>
    (กม.)</td>
    <td width="51" class="th12bblue" align="center">จำนวน<br/>
    สายทาง</td>
    <td width="52" class="th12bblue" align="center">ระยะทาง <br/>
    (กม.)</td>
    <td width="51" class="th12bblue" align="center">จำนวน<br/>
    สายทาง</td>
    <td width="52" class="th12bblue" align="center">ระยะทาง <br/>
    (กม.)</td>
    <td width="51" class="th12bblue" align="center">จำนวน<br/>
    สายทาง</td>
    <td width="52" class="th12bblue" align="center">ระยะทาง <br/>
    (กม.)</td>
    <td width="51" class="th12bblue" align="center">จำนวน<br/>
    สายทาง</td>
    <td width="52" class="th12bblue" align="center">ระยะทาง <br/>
    (กม.)</td>
    <td width="51" class="th12bblue" align="center">จำนวน<br/>
    สายทาง</td>
    <td width="52" class="th12bblue" align="center">ระยะทาง <br/>
    (กม.)</td>
	   <td width="44" class="th12bblue" align="center">จำนวน<br/>
    สายทาง</td>
    <td width="52" class="th12bblue" align="center">ระยะทาง <br/>
    (กม.)</td>
	   <td width="51" class="th12bblue" align="center">จำนวน<br/>
    สายทาง</td>
    <td width="52" class="th12bblue" align="center">ระยะทาง <br/>
    (กม.)</td>
  </tr>
    <? $j=0; while($rs=$db->fetch_array($result)){
	
	 $sqlSum="SELECT way.distance_total,way.type_road,way.layer_road
FROM
  residence
  INNER JOIN province ON (residence.id_residence = province.id_residence)
   INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (org_comunity.amphur_id = amphur.amphur_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)

  where province.province_id='$rs[province_id]' and (way.active='t') and way.flag_reg_road='t' $con";

  $resultSum=$db->query($sqlSum);
  while($rsSum=$db->fetch_array($resultSum)){
 if($rsSum['type_road']==1&&$rsSum['layer_road']==0){
  $class0_1+=1;
  $numP0_1+=$rsSum['distance_total'];
  }
  else if($rsSum['type_road']==1&&$rsSum['layer_road']==1){
  $class1_1+=1;
  $numP1_1+=$rsSum['distance_total'];
  }
  else if($rsSum['type_road']==1&&$rsSum['layer_road']==2){
  $class2_1+=1;
  $numP2_1+=$rsSum['distance_total'];
  }
  else if($rsSum['type_road']==1&&$rsSum['layer_road']==3){
  $class3_1+=1;
  $numP3_1+=$rsSum['distance_total'];
  }
  else if($rsSum['type_road']==1&&$rsSum['layer_road']==4){
  $class4_1+=1;
  $numP4_1+=$rsSum['distance_total'];
  }
   else if($rsSum['type_road']==1&&$rsSum['layer_road']==5){
  $class5_1+=1;
  $numP5_1+=$rsSum['distance_total'];
  }
   else if($rsSum['type_road']==1&&$rsSum['layer_road']==6){
  $class6_1+=1;
  $numP6_1+=$rsSum['distance_total'];
  } 
  
    $sumClassT2=$class0_1+$class1_1+$class2_1+$class3_1+$class4_1+$class5_1+$class6_1;
  $sumNumT2=$numP0_1+$numP1_1+$numP2_1+$numP3_1+$numP4_1+$numP5_1+$numP6_1;
  

  }
	?>
	  <tr>

  <td align="left" class="th11bblue"><? if($rs['province_id']!=""){?><? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?><a href="manage.php?page=report_register7&province_id=<? echo $rs['province_id']; ?>&part=2&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>"><? echo $j+1?>.&nbsp;<? echo $rs['province_name'];?></a><? } else{ ?><a href="main.php?page=report7&province_id=<? echo $rs['province_id']; ?>&part=2&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>"><? echo $j+1?>.&nbsp;<? echo $rs['province_name'];?></a><? }}?></td>
  
  <td align="center" class="th11bblack"><? if($class0_1!=""){ echo number_format($class0_1,0,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($numP0_1!=""){ echo number_format($numP0_1,3,'.',',');}else{ echo "-";}?></td>
   <td align="center" class="th11bblack"><? if($class1_1!=""){echo number_format($class1_1,0,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($numP1_1!=""){echo number_format($numP1_1,3,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($class2_1!=""){echo number_format($class2_1,0,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($numP2_1!=""){echo number_format($numP2_1,3,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($class3_1!=""){echo number_format($class3_1,0,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($numP3_1!=""){echo number_format($numP3_1,3,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($class4_1!=""){echo number_format($class4_1,0,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($numP4_1!=""){echo number_format($numP4_1,3,'.',',');}else{ echo "-";}?></td>
   <td align="center" class="th11bblack"><? if($class5_1!=""){echo number_format($class5_1,0,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($numP5_1!=""){echo number_format($numP5_1,3,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($class6_1!=""){echo number_format($class6_1,0,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($numP6_1!=""){echo number_format($numP6_1,3,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sumClassT2!=""){echo number_format($sumClassT2,0,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sumNumT2!=""){echo number_format($sumNumT2,3,'.',',');}else{ echo "-";}?></td>
  </tr><? 
  $j++;
  
  $sum_c0_1+=$class0_1;
  $sum_p0_1+=$numP0_1;
  $sum_c1_1+=$class1_1;
  $sum_p1_1+=$numP1_1;
  $sum_c2_1+=$class2_1;
  $sum_p2_1+=$numP2_1;
  $sum_c3_1+=$class3_1;
  $sum_p3_1+=$numP3_1;
  $sum_c4_1+=$class4_1;
  $sum_p4_1+=$numP4_1;
  $sum_c5_1+=$class5_1;
  $sum_p5_1+=$numP5_1;
  $sum_c6_1+=$class6_1;
  $sum_p6_1+=$numP6_1;
  $sum_sumClassT2+=$sumClassT2;
  $sum_sumNumT2+=$sumNumT2;
   $class0_1="";
$class1_1="";
$class2_1="";
$class3_1="";
$class4_1="";
$class5_1="";
$class6_1="";
 $numP0_1="";
 $numP1_1="";
 $numP2_1="";
 $numP3_1="";
 $numP4_1=""; 
 $numP5_1="";
 $numP6_1=""; 
   $sumClassT2="";
  $sumNumT2="";
  }
  
   if($j>0){?>
     <tr>

  <td align="center" class="th11bblack">รวมทั้งหมด</td>
  
  <td align="center" class="th11bblack"><? if($sum_c0_1!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_c0_1,0,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_p0_1!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_p0_1,3,'.',',');?></span><? }else{ echo "-";}?></td>
   <td align="center" class="th11bblack"><? if($sum_c1_1!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_c1_1,0,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_p1_1!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_p1_1,3,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_c2_1!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_c2_1,0,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_p2_1!=""){echo number_format($sum_p2_1,3,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_c3_1!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_c3_1,0,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_p3_1!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_p3_1,3,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_c4_1!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_c4_1,0,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_p4_1!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_p4_1,3,'.',',');?></span><? }else{ echo "-";}?></td>
   <td align="center" class="th11bblack"><? if($sum_c5_1!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_c5_1,0,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_p5_1!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_p5_1,3,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_c6_1!=""){ ?> <span class="th11bblack_line"><? echo number_format($sum_c6_1,0,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_p6_1!=""){?><span class="th11bblack_line"><? echo number_format($sum_p6_1,3,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_sumClassT2!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_sumClassT2,0,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_sumNumT2!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_sumNumT2,3,'.',',');?></span><? }else{ echo "-";}?></td>
  </tr>
  <? }?>
</table>
<? }else if($part==3){


?>
<table width="995" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>   <td width="243" align="left"><? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?><a href="manage.php?page=report_register9&part=3&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.9</a><? }else{?><a href="main.php?page=report9&part=3&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.9</a><? }?></td>
    <td width="752" align="right" class="th12bblue"><? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?>
    <a href="manage.php?page=report_register8&id_residence=<? echo $id_residence?>&part=1&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th12red_love">ในเขตชุมชน</a> / <a href="manage.php?page=report_register8&id_residence=<? echo $id_residence?>&part=2&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th12red_love">นอกเขตชุมชน</a> / <span class="th12ora">รายงานความก้าวหน้า</span>  / <a href="report/show_report8.php?list_year=<? echo $list_year;?>&id_residence=<? echo $id_residence;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" target="_blank" ><img src="image/pdf_icon.png" alt="แสดงรายงานในรูปแบบ pdf" width="20" align="absbottom" border="0" /></a><? }else{?>
       <a href="main.php?page=report8&id_residence=<? echo $id_residence?>&part=1&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th12red_love">ในเขตชุมชน</a> / <a href="main.php?page=report8&id_residence=<? echo $id_residence?>&part=2&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th12red_love">นอกเขตชุมชน</a> / <span class="th12ora">รายงานความก้าวหน้า</span> / <a href="report/show_report8.php?list_year=<? echo $list_year;?>&id_residence=<? echo $id_residence;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" target="_blank" ><img src="image/pdf_icon.png" alt="แสดงรายงานในรูปแบบ pdf" width="20" align="absbottom" border="0" /></a><? }?> </td>
  </tr>
</table>
<table width="995" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#6699FF">
 
    <td width="302" rowspan="3" class="th12bblue" align="center">ชื่อ ทชจ. </td>
    <td width="145" align="center" class="th12bblue">จำนวนระยะทางในความ<br/>รับผิดชอบทั้งหมด</td>
    <td colspan="11" class="th12bblue" align="center">ความก้าวหน้าของการลงทะเบียน</td>
  </tr>
  <tr bgcolor="#6699FF">
    <td rowspan="2" align="center" class="th12bblue">ระยะทาง
    (กม.)</td>
    <td colspan="2" class="th12bblue" align="center">รวมทะเบียน<br/>ในเขตชุมชน</td>
	<td colspan="2" class="th12bblue" align="center">รวมทะเบียน<br/>นอกเขตชุมชน</td>
	<td colspan="2" class="th12bblue" align="center">รวมทะเบียน<br/></td>
		<td width="104" rowspan="2" align="center" class="th12bblue">คิดเป็นร้อยละของ<br/>ระยะทาง
    (กม.)</td>
  </tr>
  <tr bgcolor="#6699FF">
    <td width="84" class="th12bblue" align="center">จำนวน<br/>
    สายทาง</td>
    <td width="76" class="th12bblue" align="center">ระยะทาง <br/>
    (กม.)</td>
    <td width="73" class="th12bblue" align="center">จำนวน<br/>
    สายทาง</td>
    <td width="63" class="th12bblue" align="center">ระยะทาง <br/>
    (กม.)</td>
    <td width="71" class="th12bblue" align="center">จำนวน<br/>
    สายทาง</td>
    <td width="57" class="th12bblue" align="center">ระยะทาง <br/>
    (กม.)</td>
    
  </tr>
  <? $k=0;
  #------------------------  while ----------------------------------
   while($rs=$db->fetch_array($result)){
	   	    $sqlSa1="SELECT  
annual_way.amount_phase_way
FROM annual_way where annual_way.id_province='$rs[province_id]'  and list_year='$list_year'
";
 $resultSa1=$db->query($sqlSa1);
 $rsSa1=$db->fetch_array($resultSa1);

//$sum_amount_wayS+=$rsSa1['sum_amount_wayS'];
$sum_amount_phase_wayS+=$rsSa1['amount_phase_way'];     //for $sum_perNum
#-----#
$sqlSa="SELECT
annual_way.amount_phase_way,province.province_name
FROM residence 
INNER JOIN province ON ( residence.id_residence = province.id_residence ) 
INNER JOIN annual_way ON ( province.province_id = annual_way.id_province )

where province.province_id='$rs[province_id]' and list_year='$list_year'

ORDER BY residence.id_residence ASC ";
 $resultSa=$db->query($sqlSa);   
  $rsSa=$db->fetch_array($resultSa);

//$sum_amount_way+=$rsSa['amount_way'];
$sum_amount_phase_way+=$rsSa['amount_phase_way'];


  $sqlSum="SELECT way.distance_total,way.type_road
FROM
  residence
  INNER JOIN province ON (residence.id_residence = province.id_residence)
  INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (org_comunity.amphur_id = amphur.amphur_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)

  where province.province_id='$rs[province_id]' and (way.active='t') and way.flag_reg_road='t' $con";
    $resultSum=$db->query($sqlSum);
	
  while($rsSum=$db->fetch_array($resultSum)){
if($rsSum['type_road']==0){
$sumClassN1+=1;
$sumD1+=$rsSum['distance_total'];
}
else if($rsSum['type_road']==1){
$sumClassN2+=1;
$sumD2+=$rsSum['distance_total'];
}
  
  
  }
$sumClassT3=$sumClassN1+$sumClassN2;
$sumNumT3=$sumD1+$sumD2;
if($sum_amount_phase_way!=""){
 // $perClass=($sumClassT3*100)/$sum_amount_way;
  $perNum=($sumNumT3*100)/$sum_amount_phase_way;

}


  ?>   <tr>

  <td align="left" class="th11bblack"><? if($rs['province_id']!=""){?><? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?><a href="manage.php?page=report_register7&province_id=<? echo $rs['province_id']; ?>&part=3&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>"><? echo $k+1?>.&nbsp;<? echo $rs['province_name'];?></a><? } else{ ?><a href="main.php?page=report7&province_id=<? echo $rs['province_id']; ?>&part=3&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>"><? echo $k+1?>.&nbsp;<? echo $rs['province_name'];?></a><? }}?></td>
  <td align="center" class="th11bblack"><? if($sum_amount_phase_way!=""){?><? echo number_format($sum_amount_phase_way,3,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sumClassN1!=""){ echo number_format($sumClassN1,0,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sumD1!=""){echo number_format($sumD1,3,'.',',');}else{ echo "-";}?></td>
  
  <td align="center" class="th11bblack"><? if($sumClassN2!=""){echo number_format($sumClassN2,0,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sumD2!=""){ echo number_format($sumD2,3,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sumClassT3!=""){ echo number_format($sumClassT3,0,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sumNumT3!=""){ echo number_format($sumNumT3,3,'.',',');}else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? echo number_format($perNum,2,'.','');?> %</td>
  </tr>
<? $k++; 

  $sum_sumClassT1+=$sumClassN1;
$sum_sumNumT1+=$sumD1;
$sum_sumClassT2+=$sumClassN2;
$sum_sumNumT2+=$sumD2;
$sum_sumClassT3+=$sumClassT3;
$sum_sumNumT3+=$sumNumT3;

$sumClassN1="";
$sumD1="";
$sumClassN2="";
$sumD2="";
$sumClassT3="";
$sumNumT3="";
  $perClass="";
  $perNum="";
  $sum_amount_way="";
  $sum_amount_phase_way="";
}
#------------------------ end while ----------------------------------

if($k>0){
	if($sum_amount_phase_wayS!=""){
  //$sum_perClass=($sum_sumClassT3*100)/$sum_amount_wayS;
  $sum_perNum=($sum_sumNumT3*100)/$sum_amount_phase_wayS;
	}
?>
 
  <td align="center" class="th11bblack">รวมทั้งหมด</td>
  <td align="center" class="th11bblack_line"><? echo number_format($sum_amount_phase_wayS,3,'.',',');?></td>
  <td align="center" class="th11bblack"><? if($sum_sumClassT1!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_sumClassT1,0,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_sumNumT1!=""){?><span class="th11bblack_line"><? echo number_format($sum_sumNumT1,3,'.',',');?></span><? }else{ echo "-";}?></td>
  
  <td align="center" class="th11bblack"><? if($sum_sumClassT2!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_sumClassT2,0,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_sumNumT2!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_sumNumT2,3,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_sumClassT3!=""){ ?><span class="th11bblack_line"><? echo number_format($sum_sumClassT3,0,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack"><? if($sum_sumNumT3!=""){?><span class="th11bblack_line"><?  echo number_format($sum_sumNumT3,3,'.',',');?></span><? }else{ echo "-";}?></td>
  <td align="center" class="th11bblack_line"><? echo number_format($sum_perNum,2,'.','');?> %</td>
  </tr>
  <? } ?>
</table>
<? }?>  <tr>

 