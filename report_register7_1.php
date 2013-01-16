<? //include "check.php"; 

$part=$_GET['part'];
$id_province=$_GET['id_province'];
$list_year=$_GET['list_year'];
$sqlN="select `province`.name_province,`residence`.`id_residence`,`residence`.`name_residence` FROM
  `residence`
  INNER JOIN `province` ON (`residence`.`id_residence` = `province`.`id_residence`) where id_province='$id_province'";
$resultN=$db->query($sqlN);
$rsN=$db->fetch_array($resultN); 
$sql="SELECT `municipality`.id_mun,`municipality`.name_mun
FROM
  `residence`
  INNER JOIN `province` ON (`residence`.`id_residence` = `province`.`id_residence`)
  INNER JOIN `municipality` ON (`province`.`id_province` = `municipality`.`id_province`)
  INNER JOIN `register_road` ON (`municipality`.`id_mun` = `register_road`.`id_mun`) where  `register_road`.id_regis_detail!=0  and `province`.id_province='$id_province' GROUP BY `municipality`.id_mun
 order by `municipality`.num_orders asc";
  $result=$db->query($sql);






  
 ?>
  <script type="text/javascript">
function popup(url,name,windowWidth,windowHeight){    
	myleft=(screen.width)?(screen.width-windowWidth)/2:100;	
	mytop=(screen.height)?(screen.height-windowHeight)/2:100;	
	properties = "width="+windowWidth+",height="+windowHeight;
	properties +=",scrollbars=no, top="+mytop+",left="+myleft;   
	window.open(url,name,properties);
}
</script>
<link href="css/register.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="th_head_back14" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="87%" rowspan="2"  align="center" class="th_head_back16"> <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="th_head_back14" align="center"><table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td class="th_head_back16"  align="center">ตารางสรุปการลงทะเบียนทางหลวงท้องถิ่น (ทถ.7) </td>
      </tr>
	    <tr>
        <td class="th_head_back16"  align="center">ในเขตพื้นที่สำนักงานทางหลวงชนบทจังหวัด<? echo $rsN['name_province'];?> <? echo $rsN['name_residence'];?></td>
      </tr>
	     <tr>
        <td class="th_head_back14"  align="center">รายงานเมื่อ <? echo $disp->displaydateS(date("Y-m-d"));?></td>
      </tr>
      
    </table></td>
  </tr>
</table></td>
   
	     
      
    </table></td>
  </tr>
</table><br/><br/><? if($part==""||$part==1){ 

?>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left"><? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']&&$_SESSION['LOGTYPE']){?><a href="manage.php?page=report_register8&id_residence=<? echo $rsN['id_residence'];?>&list_year=<? echo $list_year;?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.8</a><? }else{?><a href="main.php?page=report8&id_residence=<? echo $rsN['id_residence'];?>&list_year=<? echo $list_year;?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.8</a><? }?></td>
    <td align="right" class="th12bblue"><? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?><span class="th12ora">ในเขตชุมชน</span> / <a href="manage.php?page=report_register7&id_province=<? echo $id_province?>&part=2&list_year=<? echo $list_year;?>" class="th12red_love">นอกเขตชุมชน</a> / <a href="manage.php?page=report_register7&id_province=<? echo $id_province?>&part=3&list_year=<? echo $list_year;?>" class="th12red_love">รายงานความก้าวหน้า</a> / <a href="report/show_report7.php?list_year=<? echo $list_year;?>?id_province=<? echo $id_province?>" target="_blank" ><img src="image/pdf_icon.png" alt="แสดงรายงานในรูปแบบ pdf" width="20" align="absbottom" border="0" /></a><? }else{?><span class="th12ora">ในเขตชุมชน</span> / <a href="main.php?page=report7&id_province=<? echo $id_province?>&part=2&list_year=<? echo $list_year;?>" class="th12red_love">นอกเขตชุมชน</a> / <a href="main.php?page=report7&id_province=<? echo $id_province?>&part=3&list_year=<? echo $list_year;?>" class="th12red_love">รายงานความก้าวหน้า</a> / <a href="report/show_report7.php?list_year=<? echo $list_year;?>?id_province=<? echo $id_province?>" target="_blank" ><img src="image/pdf_icon.png" alt="แสดงรายงานในรูปแบบ pdf" width="20" align="absbottom" border="0" /></a> <? } ?></td>
  </tr>
</table>
<table width="980" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#6699FF">
    <td width="246" rowspan="3" class="th12bblue" align="center">ชื่อ อปท. </td>
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
 /*    $sqlSa1="SELECT  
sum(`municipality`.amount_way) as sum_amount_wayS,sum(`municipality`.amount_phase_way) as sum_amount_phase_wayS
FROM `municipality` where `municipality`.`id_province`='$id_province' 
";
 $resultSa1=$db->query($sqlSa1);
 $rsSa1=$db->fetch_array($resultSa1);

$sum_amount_wayS+=$rsSa1['sum_amount_wayS'];
$sum_amount_phase_wayS+=$rsSa1['sum_amount_phase_wayS'];*/
  while($rs=$db->fetch_array($result)){
/*   $sqlSa="SELECT  (
`municipality`.amount_way
), (
`municipality`.amount_phase_way
)
FROM `residence` 
INNER JOIN `province` ON ( `residence`.`id_residence` = `province`.`id_residence` ) 
INNER JOIN `municipality` ON ( `province`.`id_province` = `municipality`.`id_province` ) 

WHERE `municipality`.`id_mun`='$rs[id_mun]'
GROUP BY `municipality`.id_mun
ORDER BY `residence`.id_residence ASC ";
 $resultSa=$db->query($sqlSa);
   while($rsSa=$db->fetch_array($resultSa)){
  
$sum_amount_way+=$rsSa['amount_way'];
$sum_amount_phase_way+=$rsSa['amount_phase_way'];
}*/
  $sqlSum="SELECT `register_road`.distance_road,`register_road`.type_road,`register_road`.layer_road
FROM
  `residence`
  INNER JOIN `province` ON (`residence`.`id_residence` = `province`.`id_residence`)
  INNER JOIN `municipality` ON (`province`.`id_province` = `municipality`.`id_province`)
  INNER JOIN `register_road` ON (`municipality`.`id_mun` = `register_road`.`id_mun`)
  where `register_road`.id_regis_detail!=0 and `municipality`.`id_mun`='$rs[id_mun]'";

  $resultSum=$db->query($sqlSum);
  while($rsSum=$db->fetch_array($resultSum)){

  if($rsSum['type_road']==0&&$rsSum['layer_road']==0){

  $class0+=1;
  $numP0+=$rsSum['distance_road'];
  }
  else if($rsSum['type_road']==0&&$rsSum['layer_road']==1){
  $class1+=1;
  $numP1+=$rsSum['distance_road'];
  }
  else if($rsSum['type_road']==0&&$rsSum['layer_road']==2){
  $class2+=1;
  $numP2+=$rsSum['distance_road'];
  }
  else if($rsSum['type_road']==0&&$rsSum['layer_road']==3){
  $class3+=1;
  $numP3+=$rsSum['distance_road'];


 
  }
  else if($rsSum['type_road']==0&&$rsSum['layer_road']==4){
  $class4+=1;
  $numP4+=$rsSum['distance_road'];
  }
  
  

  $sumClassT1=$class0+$class1+$class2+$class3+$class4;
  $sumNumT1=$numP0+$numP1+$numP2+$numP3+$numP4;
  


  


}

  ?>
  <tr>
    <td align="left" class="th11bblue"><? if($rs['id_mun']!=""){?>
      <? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?>
      <a href="manage.php?page=report_register6&id_mun=<? echo $rs['id_mun']; ?>&list_year=<? echo $list_year;?>"><? echo $i+1?>.&nbsp; <? echo $rs['name_mun'];?></a>
      <? }else{ ?>
      <a href="main.php?page=report6&id_mun=<? echo $rs['id_mun']; ?>&list_year=<? echo $list_year;?>"><? echo $i+1?>.&nbsp; <? echo $rs['name_mun'];?></a>
      <? } }?></td>
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
  </tr>
  <? 
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
    <td align="center" class="th11bblack"><? if($sum_c0!=""){ ?>
      <span class="th11bblack_line">
        <?  echo number_format($sum_c0,0,'.',',');?>
      </span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_p0!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_p0,3,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_c1!=""){ ?>
      <span class="th11bblack_line">
        <?   echo number_format($sum_c1,0,'.',',')?>
      </span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_p1!=""){ ?>
      <span class="th11bblack_line">
        <?   echo number_format($sum_p1,3,'.',',');?>
      </span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_c2!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_c2,0,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_p2!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_p2,3,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_c3!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_c3,0,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_p3!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_p3,3,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_c4!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_c4,0,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_p4!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_p4,3,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_sumClassT1!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_sumClassT1,0,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_sumNumT1!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_sumNumT1,3,'.',','); ?></span>
      <? }else{ echo "-";}?></td>
  </tr>
  <? }?>
</table>
<? }else if($part==2){


?>
<table width="995" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>   <td align="left"><? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?><a href="manage.php?page=report_register8&id_residence=<? echo $rsN['id_residence'];?>&part=2&list_year=<? echo $list_year;?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.8</a><? }else{?><a href="main.php?page=report8&id_residence=<? echo $rsN['id_residence'];?>&part=2&list_year=<? echo $list_year;?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.8</a> <? }?></td>
    <td align="right" class="th12bblue"><? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?><a href="manage.php?page=report_register7&id_province=<? echo $id_province?>&part=1&list_year=<? echo $list_year;?>" class="th12red_love">ในเขตชุมชน</a> / <span class="th12ora">นอกเขตชุมชน</span> / <a href="manage.php?page=report_register7&id_province=<? echo $id_province?>&part=3&list_year=<? echo $list_year;?>" class="th12red_love">รายงานความก้าวหน้า</a>/ <a href="report/show_report7.php?list_year=<? echo $list_year;?>?id_province=<? echo $id_province?>" target="_blank" ><img src="image/pdf_icon.png" alt="แสดงรายงานในรูปแบบ pdf" width="20" align="absbottom" border="0" /></a><? }else{?><a href="main.php?page=report7&id_province=<? echo $id_province?>&part=1&list_year=<? echo $list_year;?>" class="th12red_love">ในเขตชุมชน</a> / <span class="th12ora">นอกเขตชุมชน</span> / <a href="main.php?page=report7&id_province=<? echo $id_province?>&part=3&list_year=<? echo $list_year;?>" class="th12red_love">รายงานความก้าวหน้า</a>/ <a href="report/show_report7.php?list_year=<? echo $list_year;?>?id_province=<? echo $id_province?>" target="_blank" ><img src="image/pdf_icon.png" alt="แสดงรายงานในรูปแบบ pdf" width="20" align="absbottom" border="0" /></a> <? }?></td>
  </tr>
</table>
<table width="995" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#6699FF">
    <td width="191" rowspan="3" class="th12bblue" align="center">ชื่อ อปท. </td>
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
  </tr>
  <? $j=0; while($rs=$db->fetch_array($result)){
	
	 $sqlSum="SELECT `register_road`.distance_road,`register_road`.type_road,`register_road`.layer_road
FROM
  `residence`
  INNER JOIN `province` ON (`residence`.`id_residence` = `province`.`id_residence`)
  INNER JOIN `municipality` ON (`province`.`id_province` = `municipality`.`id_province`)
  INNER JOIN `register_road` ON (`municipality`.`id_mun` = `register_road`.`id_mun`)
  where `register_road`.id_regis_detail!=0 and `municipality`.`id_mun`='$rs[id_mun]'";

  $resultSum=$db->query($sqlSum);
  while($rsSum=$db->fetch_array($resultSum)){
 if($rsSum['type_road']==1&&$rsSum['layer_road']==0){
  $class0_1+=1;
  $numP0_1+=$rsSum['distance_road'];
  }
  else if($rsSum['type_road']==1&&$rsSum['layer_road']==1){
  $class1_1+=1;
  $numP1_1+=$rsSum['distance_road'];
  }
  else if($rsSum['type_road']==1&&$rsSum['layer_road']==2){
  $class2_1+=1;
  $numP2_1+=$rsSum['distance_road'];
  }
  else if($rsSum['type_road']==1&&$rsSum['layer_road']==3){
  $class3_1+=1;
  $numP3_1+=$rsSum['distance_road'];
  }
  else if($rsSum['type_road']==1&&$rsSum['layer_road']==4){
  $class4_1+=1;
  $numP4_1+=$rsSum['distance_road'];
  }
   else if($rsSum['type_road']==1&&$rsSum['layer_road']==5){
  $class5_1+=1;
  $numP5_1+=$rsSum['distance_road'];
  }
   else if($rsSum['type_road']==1&&$rsSum['layer_road']==6){
  $class6_1+=1;
  $numP6_1+=$rsSum['distance_road'];
  } 
  
    $sumClassT2=$class0_1+$class1_1+$class2_1+$class3_1+$class4_1+$class5_1+$class6_1;
  $sumNumT2=$numP0_1+$numP1_1+$numP2_1+$numP3_1+$numP4_1+$numP5_1+$numP6_1;
  

  }
	?>
  <tr>
    <td align="left" class="th11bblue"><? if($rs['id_mun']!=""){?>
      <? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?>
      <a href="manage.php?page=report_register6&id_mun=<? echo $rs['id_mun']; ?>&list_year=<? echo $list_year;?>"><? echo $j+1?>.&nbsp; <? echo $rs['name_mun'];?></a>
      <? }else{ ?>
      <a href="main.php?page=report6&id_mun=<? echo $rs['id_mun']; ?>&list_year=<? echo $list_year;?>"><? echo $j+1?>.&nbsp; <? echo $rs['name_mun'];?></a>
      <? } }?></td>
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
  </tr>
  <? 
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
    <td align="center" class="th11bblack"><? if($sum_c0_1!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_c0_1,0,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_p0_1!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_p0_1,3,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_c1_1!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_c1_1,0,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_p1_1!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_p1_1,3,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_c2_1!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_c2_1,0,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_p2_1!=""){echo number_format($sum_p2_1,3,'.',',');?>
      </span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_c3_1!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_c3_1,0,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_p3_1!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_p3_1,3,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_c4_1!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_c4_1,0,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_p4_1!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_p4_1,3,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_c5_1!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_c5_1,0,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_p5_1!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_p5_1,3,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_c6_1!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_c6_1,0,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_p6_1!=""){?>
      <span class="th11bblack_line"><? echo number_format($sum_p6_1,3,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_sumClassT2!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_sumClassT2,0,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_sumNumT2!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_sumNumT2,3,'.',',');?></span>
      <? }else{ echo "-";}?></td>
  </tr>
  <? }?>
</table>
<? }else if($part==3){


?>
<table width="995" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>   <td width="222" align="left"><? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?><a href="manage.php?page=report_register8&id_residence=<? echo $rsN['id_residence'];?>&part=3&list_year=<? echo $list_year;?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.8</a><? }else{?><a href="main.php?page=report8&id_residence=<? echo $rsN['id_residence'];?>&part=3&list_year=<? echo $list_year;?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.8</a> <? }?></td>
    <td width="773" align="right" class="th12bblue"><? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?><a href="manage.php?page=report_register7&id_province=<? echo $id_province?>&part=1&list_year=<? echo $list_year;?>" class="th12red_love">ในเขตชุมชน</a> / <a href="manage.php?page=report_register7&id_province=<? echo $id_province?>&part=2&list_year=<? echo $list_year;?>" class="th12red_love">นอกเขตชุมชน</a> / <span class="th12ora">รายงานความก้าวหน้า</span> / <a href="report/show_report7.php?list_year=<? echo $list_year;?>?id_province=<? echo $id_province?>" target="_blank" ><img src="image/pdf_icon.png" alt="แสดงรายงานในรูปแบบ pdf" width="20" align="absbottom" border="0" /></a><? }else{?><a href="main.php?page=report7&id_province=<? echo $id_province?>&part=1&list_year=<? echo $list_year;?>" class="th12red_love">ในเขตชุมชน</a> / <a href="main.php?page=report7&id_province=<? echo $id_province?>&part=2&list_year=<? echo $list_year;?>" class="th12red_love">นอกเขตชุมชน</a> / <span class="th12ora">รายงานความก้าวหน้า</span> / <a href="report/show_report7.php?list_year=<? echo $list_year;?>?id_province=<? echo $id_province?>" target="_blank" ><img src="image/pdf_icon.png" alt="แสดงรายงานในรูปแบบ pdf" width="20" align="absbottom" border="0" /></a> <? }?></td>
  </tr>
</table>
<table width="995" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#6699FF">
    <td width="302" rowspan="3" class="th12bblue" align="center">ชื่อ อปท. </td>
    <td colspan="6" class="th12bblue" align="center">ความก้าวหน้าของการลงทะเบียน</td>
  </tr>
  <tr bgcolor="#6699FF">
    <td colspan="2" class="th12bblue" align="center">รวมทะเบียน<br/>ในเขตชุมชน</td>
    <td colspan="2" class="th12bblue" align="center">รวมทะเบียน<br/>นอกเขตชุมชน</td>
    <td colspan="2" class="th12bblue" align="center">รวมทะเบียน</td>
    
  </tr>
  <tr bgcolor="#6699FF">
    <td width="61" class="th12bblue" align="center">จำนวน<br/>
      สายทาง</td>
    <td width="65" class="th12bblue" align="center">ระยะทาง <br/>
      (กม.)</td>
    <td width="62" class="th12bblue" align="center">จำนวน<br/>
      สายทาง</td>
    <td width="70" class="th12bblue" align="center">ระยะทาง <br/>
      (กม.)</td>
    <td width="64" class="th12bblue" align="center">จำนวน<br/>
      สายทาง</td>
    <td width="66" class="th12bblue" align="center">ระยะทาง <br/>
      (กม.)</td>
    
  </tr>
  <? $k=0;
    /*  $sqlSa1="SELECT  
sum(`municipality`.amount_way) as sum_amount_wayS,sum(`municipality`.amount_phase_way) as sum_amount_phase_wayS
FROM `municipality` where `municipality`.`id_province`='$id_province' 
";
 $resultSa1=$db->query($sqlSa1);
 $rsSa1=$db->fetch_array($resultSa1);

$sum_amount_wayS+=$rsSa1['sum_amount_wayS'];
$sum_amount_phase_wayS+=$rsSa1['sum_amount_phase_wayS'];*/
   while($rs=$db->fetch_array($result)){
/*$sqlSa="SELECT  (
`municipality`.amount_way
), (
`municipality`.amount_phase_way
)
FROM `residence` 
INNER JOIN `province` ON ( `residence`.`id_residence` = `province`.`id_residence` ) 
INNER JOIN `municipality` ON ( `province`.`id_province` = `municipality`.`id_province` ) 

WHERE `municipality`.`id_mun`='$rs[id_mun]'
GROUP BY `municipality`.id_mun
ORDER BY `residence`.id_residence ASC ";
 $resultSa=$db->query($sqlSa);
   while($rsSa=$db->fetch_array($resultSa)){
  
$sum_amount_way+=$rsSa['amount_way'];
$sum_amount_phase_way+=$rsSa['amount_phase_way'];
}*/
  $sqlSum="SELECT `register_road`.distance_road,`register_road`.type_road
FROM
  `residence`
  INNER JOIN `province` ON (`residence`.`id_residence` = `province`.`id_residence`)
  INNER JOIN `municipality` ON (`province`.`id_province` = `municipality`.`id_province`)
  INNER JOIN `register_road` ON (`municipality`.`id_mun` = `register_road`.`id_mun`)
  where `register_road`.id_regis_detail!=0 and `municipality`.`id_mun`='$rs[id_mun]'";
    $resultSum=$db->query($sqlSum);
	
  while($rsSum=$db->fetch_array($resultSum)){
if($rsSum['type_road']==0){
$sumClassN1+=1;
$sumD1+=$rsSum['distance_road'];
}
else if($rsSum['type_road']==1){
$sumClassN2+=1;
$sumD2+=$rsSum['distance_road'];
}
  
  
  }
$sumClassT3=$sumClassN1+$sumClassN2;
$sumNumT3=$sumD1+$sumD2;
  //$perClass=($sumClassT3*100)/$sum_amount_way;
  //$perNum=($sumNumT3*100)/$sum_amount_phase_way;




  ?>
  <tr>
    <td align="left" class="th11bblue"><? if($rs['id_mun']!=""){?>
      <? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?>
      <a href="manage.php?page=report_register6&id_mun=<? echo $rs['id_mun']; ?>&list_year=<? echo $list_year;?>"><? echo $k+1?>.&nbsp; <? echo $rs['name_mun'];?></a>
      <? }else{ ?>
      <a href="main.php?page=report6&id_mun=<? echo $rs['id_mun']; ?>&list_year=<? echo $list_year;?>"><? echo $k+1?>.&nbsp; <? echo $rs['name_mun'];?></a>
      <? } }?></td>
    <td align="center" class="th11bblack"><? if($sumClassN1!=""){ echo number_format($sumClassN1,0,'.',',');}else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sumD1!=""){echo number_format($sumD1,3,'.',',');}else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sumClassN2!=""){echo number_format($sumClassN2,0,'.',',');}else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sumD2!=""){ echo number_format($sumD2,3,'.',',');}else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sumClassT3!=""){ echo number_format($sumClassT3,0,'.',',');}else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sumNumT3!=""){ echo number_format($sumNumT3,3,'.',',');}else{ echo "-";}?></td>
    
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
} if($k>0){
 /* $sum_perClass=($sum_sumClassT3*100)/$sum_amount_wayS;
  $sum_perNum=($sum_sumNumT3*100)/$sum_amount_phase_wayS;
*/
?>
  <tr>
    <td align="center" class="th11bblack">รวมทั้งหมด</td>
    <td align="center" class="th11bblack"><? if($sum_sumClassT1!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_sumClassT1,0,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_sumNumT1!=""){?>
      <span class="th11bblack_line"><? echo number_format($sum_sumNumT1,3,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_sumClassT2!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_sumClassT2,0,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_sumNumT2!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_sumNumT2,3,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_sumClassT3!=""){ ?>
      <span class="th11bblack_line"><? echo number_format($sum_sumClassT3,0,'.',',');?></span>
      <? }else{ echo "-";}?></td>
    <td align="center" class="th11bblack"><? if($sum_sumNumT3!=""){?>
      <span class="th11bblack_line">
        <?  echo number_format($sum_sumNumT3,3,'.',',');?>
      </span>
      <? }else{ echo "-";}?></td>
    
  </tr>
  <? } ?>
</table>
<? }?>  <tr>

 