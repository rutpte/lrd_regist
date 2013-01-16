<? session_start();
 include "check.php";
 
$orgc_id=$_REQUEST['orgc_id'];
$search_way=$_POST['search_way'];    //if($search_way==2){$conT="and file_t2!=''}
$list_year=$_REQUEST['list_year'];
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

 //$conT="and filename_ref!='' and lrd_attach_type='F_T2'";
/*
if($search_way==""||$search_way==1){
$conT="";
}
else if($search_way==2){
$conT="and file_t2!=''";
}
else if($search_way==3){
	$conT="and (file_t2='' or file_t2 is null) ";
}
*/
if($search_way==""||$search_way==1){
$conT="";
$in_join="";
}
else if($search_way==2){
$in_join="LEFT JOIN attachment ON (way.way_id=attachment.record_ref_id)
LEFT JOIN lrd_attachment ON (attachment.attach_id=lrd_attachment.attach_id) ";
$conT="and filename_ref!='' and lrd_attach_type='F_T2'";
}
else if($search_way==3){
$in_join="LEFT JOIN (
	SELECT  att.record_ref_id,att.attach_id,att.filename_ref,la.lrd_attach_type
	FROM attachment AS att INNER JOIN lrd_attachment AS la ON la.attach_id = att.attach_id
	WHERE la.lrd_attach_type = 'F_T2'
) As ld  ON way.way_id = ld.record_ref_id";
//$conT="and (lrd_attach_type='F_T2' and lrd_attach_type is null) and (filename_ref='' or filename_ref is null)";
$conT="
and ld.filename_ref is  null";

/*  p' poy

SELECT
*,way.way_id,ld.filename_ref as ftf
,ld.lrd_attach_type as f_t2

FROM way 

LEFT JOIN (
	SELECT  att.record_ref_id,att.attach_id,att.filename_ref,la.lrd_attach_type
	FROM attachment AS att INNER JOIN lrd_attachment AS la ON la.attach_id = att.attach_id
	WHERE la.lrd_attach_type = 'F_T2'
) As ld  ON way.way_id = ld.record_ref_id

where way.orgc_id='130209' 
and (way.active='t')
and way.flag_reg_road='t'
and ld.filename_ref is  null
*/
}
$REFEREF=$_SERVER['HTTP_REFERER'];
 /*
  $sql_status="SELECT way.way_code_head,way.way_code_tail,
case when reg.way_id is not null then 't' else 'f' end as status_1,
case when reg.way_id is null then 't' else 'f' end as status_2,
case when way.way_code_head is null or way.way_code_tail is null then 't' else 'f' end as status_3,
case when (way.way_code_head is not null and way.way_code_head !='')  and (way.way_code_tail is not null and way.way_code_tail !='') then 't' else 'f' end as status_4,
case when way.way_code_head is null and way.way_code_tail is null then 't' else 'f' end as status_5,
case when way.way_code_head='' or way.way_code_tail='' then 't' else 'f' end as status_6
FROM way
left JOIN register_road_detail AS reg ON way.way_id = reg.way_id
          where way.orgc_id='$orgc_id' and (way.active='t')  order by way.way_id asc
         
          ";    // echo  $sql_status;exit;
    $result_status=$db->query($sql_status);

  */

$sql="
SELECT way.way_id,province.province_id,province_name,
drop_name,org_comunity.orgc_name,org_comunity_detail.num_orders,
COUNT(way.way_id)as amount_way,sum(way.distance_total)as amount_phase_way,
name_residence,org_comunity_detail.pic_map

FROM
  org_comunity
  INNER JOIN way ON (org_comunity.orgc_id=way.orgc_id)

  INNER JOIN org_comunity_detail ON (org_comunity.orgc_id=org_comunity_detail.orgc_id)
  INNER JOIN amphur ON (org_comunity.amphur_id=amphur.amphur_id)
  INNER JOIN province ON (amphur.province_id = province.province_id)
  INNER JOIN residence ON (province.id_residence = residence.id_residence)
 where org_comunity.orgc_id='$orgc_id' and (way.active='t') and way.flag_reg_road='t'

 GROUP BY province.province_id,province.province_name,province.drop_name,org_comunity.orgc_name,
 org_comunity_detail.num_orders,residence.name_residence,org_comunity_detail.pic_map,way.way_id
  order by way.way_id asc
 ";       //where way.orgc_id='$orgc_id' and (way.active='t') and way.flag_reg_road='t'
        //echo $sql;
  //echo"<pre>"; echo $sql;exit;
  /*  new-->>
  SELECT province.province_id,province_name,drop_name,org_comunity.orgc_name,org_comunity_detail.num_orders,COUNT(way.way_id)as amount_way,sum(way.distance_total)as amount_phase_way,name_residence,org_comunity_detail.pic_map
FROM
  org_comunity
  INNER JOIN way ON (org_comunity.orgc_id=way.orgc_id)
  INNER JOIN org_comunity_detail ON (org_comunity.orgc_id=org_comunity_detail.orgc_id)
  INNER JOIN amphur ON (org_comunity.amphur_id=amphur.amphur_id)
  INNER JOIN province ON (amphur.province_id = province.province_id)
  INNER JOIN residence ON (province.id_residence = residence.id_residence)
 where org_comunity.orgc_id='$orgc_id'
 GROUP BY province.province_id,province.province_name,province.drop_name,org_comunity.orgc_name,org_comunity_detail.num_orders,residence.name_residence,org_comunity_detail.pic_map
  */
  /* old
  SELECT province.province_id,province_name,drop_name,org_comunity.orgc_name,org_comunity_detail.num_orders,org_comunity.amount_way,org_comunity.amount_phase_way,name_residence,org_comunity.pic_map
FROM
  org_comunity
  INNER JOIN province ON (org_comunity.province_id = province.province_id)
  INNER JOIN residence ON (province.id_residence = residence.id_residence) where org_comunity.orgc_id='$orgc_id'

  */


  $result=$db->query($sql);
  $rs=$db->fetch_array($result);
  /*  $sqlSu="select sum(distance_total) as sum_dis FROM
  way where way.orgc_id='$orgc_id' and (way.active='t') $conT $con";       //ชน sumdis
  $resultSu=$db->query($sqlSu);
  $rsSu=$db->fetch_array($resultSu);   */
############################################################################################

  $sqlS="SELECT *
FROM
  way
$in_join
 where way.orgc_id='$orgc_id' $conT $con  and (way.active='t') and way.flag_reg_road='t' order by way_code_tail asc";  //echo $sqlS; exit;
 /*
 new
 INNER JOIN attachment ON (way.way_id=attachment.record_ref_id)
  INNER JOIN lrd_attachment ON (attachment.attach_id=lrd_attachment.attach_id)
 */
 $resultS=$db->query($sqlS);
 $numS=$db->num_rows($resultS);

 ###########################################################################################
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
$sqlS .= " LIMIT $Per_Page offset $Page_start"; 
$resultS = $db->query( $sqlS );
                 #$sqlSu0=sum all way
                #$sqlSu1=sum all way register only
 #-----------------------------------------------------------------------------------
  $sqlSu0="select distance_total as sum_dis0
  FROM
      way

      where way.orgc_id='$orgc_id' and (way.active='t')
      GROUP BY way.way_id,distance_total
      "; //show all
#---------------------------------------------------------------------------------------
      $sqlSu1="select distance_total as sum_dis1
  FROM
      way
      where way.orgc_id='$orgc_id' and (way.active='t') and way.flag_reg_road='t'
      GROUP BY way.way_id,distance_total
      ";  //show only registered
#------------------------------------------------------------------------------------
  
 // $rsSu['sum_dis']=0;
  $resultSu0=$db->query($sqlSu0);   //var_dump( $rsSu['sum_dis']); echo "<br>";
  while($rsSu0=$db->fetch_array($resultSu0)){
     $rsSu['sum_dis']+=$rsSu0['sum_dis0'];      // var_dump($rsSu0['sum_dis0']); echo "<br>"; // $rsSu['sum_dis']  เป็นชื่อตัวแปรเฉยๆ ไม่ได้เฟสมาจากไหน
  }  //#$sqlSu0=sum all way
  //var_dump($sqlSu0);echo "<br>";
  //var_dump( $rsSu['sum_dis']);// exit;
 #----------------------------------------------------------------
  $resultSu1=$db->query($sqlSu1);
  while($rsSu1=$db->fetch_array($resultSu1)){
     $rsSu['sum_dis1']+=$rsSu1['sum_dis1'];
  }  //#$sqlSu1=sum all way register only
     // echo number_format($rsSu['sum_dis1'],3,'.',','); 
      //var_dump($rsSu['sum_dis1']);exit;

 #-------------------------------------------------------
 $sqlS2="SELECT *
 FROM way where orgc_id='$orgc_id'
 and (active='t' or active is null)
 and way.flag_reg_road='t' ";
 $resultS2=$db->query($sqlS2);
 $numS2=$db->num_rows($resultS2);
     //$numS2=all register record
 #-------------------------------------------------------
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
        <td class="th14bgray"  align="center">ทชจ.&nbsp;<? echo $rs['province_name'];?>&nbsp;&nbsp;<? echo $rs['name_residence']?>
          </td>
      </tr>
	     <tr>
        <td class="th14bgray_line"  align="center">หน่วยงาน&nbsp;<? echo $rs['orgc_name'];?>  </td>
      </tr>
       <? if($day!=""){?>
       <tr>
        <td class="th_red12b"  align="center">ตั้งแต่ <? echo $day;?></td>
      </tr>
      <? }?>
    </table></td>
  </tr>
</table><br/>
<form id="form1" name="form1" method="post" action="manage.php?page=report_register6&orgc_id=<? echo $orgc_id;?>">
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
  <tr><td width="230" align="left"><? if($_SESSION['LOGTYPE']!=5&&$_SESSION['LOGTYPE']){?><a href="manage.php?page=report_register7&province_id=<? echo $rs['province_id'];?>&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.7</a><? }else{?><a href="main.php?page=report7&province_id=<? echo $rs['province_id'];?>&list_year=<? echo $list_year;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" class="th_red12b"><<<กลับหน้าตารางสรุปทถ.7</a> <? }?></td>
  <td width="760" align="right"><a href="report/show_report6.php?list_year=<? echo $list_year;?>&orgc_id=<? echo $orgc_id?>&search=<? echo $search_way;?>&show=<? echo $show;?>&s_date=<? echo $s_date;?>&e_date=<? echo $e_date;?>" target="_blank" ><img src="image/pdf_icon.png" alt="แสดงรายงานในรูปแบบ pdf" width="20" align="absbottom" border="0" /></a></td>
  </tr></table>


<table width="995" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
<tr bgcolor="#6699FF">
<!--<td colspan="17" class="th12bblue" align="center">รวมสายทางลงทะเบียนจำนวน  <span class="th12bred"><? echo number_format($numS,0,'.',',');;?></span> เส้น รวมระยะทางลงทะเบียนจำนวน <!--จำนวนสายทาง&nbsp;<span class="th12bred"><? //echo number_format($rs['amount_way'],0,'.',',');?></span> เส้น <span class="th12bred"><? echo number_format($rsSu['sum_dis'],3,'.',',');?></span> (กม.) </td>   -->
<!--td colspan="17" class="th12bblue" align="center">รวมสายทางทั้งหมดจำนวน  <span class="th12bred"><? echo number_format($numS,0,'.',',');;?></span> เส้น |รวมสายทางที่ลงทะเบียนแล้วจำนวน  <span class="th12bred"><? echo number_format($numS2,0,'.',',');;?></span> เส้น |รวมระยะทางจำนวน <span class="th12bred"><? echo number_format($rsSu['sum_dis'],3,'.',',');?></span> (กม.)| จำนวนที่ลงทะเบียนแล้ว<span class="th12bred"><? echo number_format($rsSu['sum_dis1'],3,'.',',');?></span>(กม.) </td-->
<td colspan="17" class="th12bblue" align="center"><!--รวมสายทางทั้งหมดจำนวน  <span class="th12bred"><? echo number_format($numS,0,'.',',');;?></span> เส้น |-->รวมสายทางที่ลงทะเบียนแล้วจำนวน  <span class="th12bred"><? echo number_format($numS2,0,'.',',');;?></span> เส้น <!--|รวมระยะทางจำนวน <span class="th12bred"><? echo number_format($rsSu['sum_dis'],3,'.',',');?></span> (กม.)-->| จำนวนที่ลงทะเบียนแล้ว<span class="th12bred"><? echo number_format($rsSu['sum_dis1'],3,'.',',');?></span>(กม.) </td>
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
<?



 $i=1;
   $num=$Page_start;
while($rsS=$db->fetch_array($resultS)){      //and $rsS2=$db->fetch_array($result_status)
$num++;
//ถ้าเกิดว่าอยากหาผลรวมก็น่าจะมารวมใส่ตัวแปรตรงนี้
$sum_disT1+=$rsS['distance_total'];
$sql1="select id_regis_detail,type_ja,width_ja,type_sh,width_sh,type_fo,width_fo,kate_regis from register_road_detail where way_id='$rsS[way_id]' order by type_ja asc,width_ja asc,type_sh asc,width_sh asc,type_fo asc,width_fo asc,kate_regis asc";
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
 $id_regis_detail=$rs1['id_regis_detail']  ;
} //while end

############################################################################################################
    //echo "<pre>"; print_r($rsS2); echo "</pre>";
  
############################################
 /*
 if($rsS2['status_1']=="t"and $rsS2['status_4']=="t")     //green
    {
       $bg="background-color:rgba(0,255,0,.2)"; $pic_bg="image/complete.png"; $alt="ลงทะเบียนแล้ว";  ##
       
}else if($rsS2['status_2']=="t"and $rsS2['status_5']=="t"){   //red

       $bg="background-color:rgba(255,0,0,.4)"; $pic_bg="image/no_complete.png";$alt="ยังไม่ลงทะเบียน"; ##

 } else{                                                     //yellow
       $bg="background-color:rgba(255,255,0,.3)"; $pic_bg="image/fall_heart.png";$alt="ข้อมูลไม่ครบ";  ##
 }
     */    
############################################################################################################         
  ?>
 
<tr><td style="<? echo $bg ?>" align="center" class="th_black11b"><? if($rsS['cre_type']==1){ $Scre_type=1;

?><span class="th11bred">*</span><? }?><? echo $num;?>.&nbsp;&nbsp;<img src="<?echo $pic_bg;?>"</td>
<td align="center" class="th_black11b"><? echo $rsS['way_code_head'].$rsS['way_code_tail'];?></td>
<td align="left" class="th_black11b"><? echo $rsS['way_name'];?></td>
<td align="center" class="th_black11b"><? if($id_regis_detail!=0&&$rsS['type_road']==0&&$rsS['cre_type']!=2 ){ if($rsS['layer_road']==0){ echo "พิเศษ";}else{echo $rsS['layer_road']; }}else{ echo "-";}?></td>
<td align="center" class="th_black11b"><? if($id_regis_detail!=0&&$rsS['type_road']==1&&$rsS['cre_type']!=2 ){ if($rsS['layer_road']==0){ echo "พิเศษ";}else{echo $rsS['layer_road']; }}else { echo "-";}?></td>
<td align="center" class="th_black11b"><? echo number_format($rsS['distance_total'],3,'.',',');?></td>
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
<?php

  #-----------------------------------  for check upload pic pic map mun
                                    $sql_s_m="select filename_ref
            from attachment t1
            inner join lrd_attachment t2 ON (t1.attach_id=t2.attach_id)
            where record_ref_id=$rsS[way_id] and lrd_attach_type='P_M'
             ";
           $result_s_m=$db->query($sql_s_m);                                                                                   #
           $rs_filename_ref_s_m=$db->fetch_array($result_s_m);

           $filename_ref_s_m=$rs_filename_ref_s_m['filename_ref'];
           //var_dump( $filename_ref);
#----------------------------------
#-----------------------------------  for check upload pic file t2
                                    $sql_t2="select filename_ref
            from attachment t1
            inner join lrd_attachment t2 ON (t1.attach_id=t2.attach_id)
            where record_ref_id=$rsS[way_id] and lrd_attach_type='F_T2'
             ";         //echo $sql_t2;exit;
           $result_t2=$db->query($sql_t2);                                                                                   #
           $rs_filename_ref_f_t2=$db->fetch_array($result_t2);

           $filename_ref_f_t2=$rs_filename_ref_f_t2['filename_ref'];
           //var_dump( $filename_ref);
#----------------------------------
#-----------------------------------  for check upload pic  pic map
                                    $sql_sp_m="select filename_ref
            from attachment t1
            inner join lrd_attachment t2 ON (t1.attach_id=t2.attach_id)
            where record_ref_id=$orgc_id and lrd_attach_type='SP_M'
             ";
           $result_sp_m=$db->query($sql_sp_m);                                                                                   #
           $rs_filename_ref_sp_m=$db->fetch_array($result_sp_m);

           $filename_ref_sp_m=$rs_filename_ref_sp_m['filename_ref'];
           //var_dump( $filename_ref);
#----------------------------------
?>
<td align="center" class="th_black11b"><? if($filename_ref_s_m !=""){?><a href="show_map_regis.php?way_id=<? echo $rsS['way_id'];?>" target="_blank"><img src="image/wolrd1.jpg" width="30" height="30" border="0" /></a>&nbsp; <? }else{?><img src="image/wolrdX.jpg" width="30" height="30" border="0" /></a><? }?></td>
<td align="center" class="th_black11b"><? if($filename_ref_f_t2 !=""){?><a href="show_file_regis.php?way_id=<? echo $rsS['way_id'];?>" target="_blank"><img src="image/true.jpg" width="30" height="30" border="0" /></a>&nbsp; <? }else{?><img src="image/trueX.jpg" width="30" height="30" border="0" /><? }?></td>
<? if($i==1){ ?>                                                       <!-- <a href="download_file.php?way_id=<? echo $rsS['way_id'];?>  -->
<td align="center" class="th_black11b"  rowspan="<? echo  $numS;?>"><? if($filename_ref_sp_m!=""){?><a href="show_map.php?orgc_id=<? echo $orgc_id;?>" title="ดูแผนที่" target="_blank"  class="th12red_love"><img src="image/wolrd1.jpg" width="30" height="30" border="0" /></a>&nbsp; <? }else{?><img src="image/wolrdX.jpg" width="30" height="30" border="0" /><? }?></td> <? }?>
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
                  <td height="30" colspan="17" align="center"   class="th_head_back12">ไม่มีข้อมูล</td>
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
		echo "<a href=\"$PHP_SELF?page=report_register6&orgc_id=$orgc_id&search_way=$search_way&list_year=$list_year&show=$show&s_date=$s_date&e_date=$e_date&num=$num++&Page=$Prev_Page\">&lt;&lt; ถอยหลัง </a>";
/* สร้างตัวเลขหน้า */
for ( $i=1; $i<=$Num_Pages; $i++ ) 
	{ 
		if ( $i != $Page ) 
				echo "[<a href=\"$PHP_SELF?page=report_register6&search_way=$search_way&list_year=$list_year&show=$show&s_date=$s_date&e_date=$e_date&orgc_id=$orgc_id&num=$num++&Page=$i\">$i</a>]";
		else 
				echo " <b>$i</b> "; 
	}
/* สร้างปุ่มเดินหน้า */
if ( $Page != $Num_Pages ) 
		echo "<a href=\"$PHP_SELF?page=report_register6&search_way=$search_way&list_year=$list_year&show=$show&s_date=$s_date&e_date=$e_date&orgc_id=$orgc_id&num=$num++&Page=$Next_Page\"> เดินหน้า &gt;&gt;</a>"; 
?>
		    </div>
			</td>
  </tr>
</table>
<!--
<div id="describe"><img id="describe2" src="image/describe.png" border="0" /></div>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
      $(document).ready(function(){
		$('#describe').css({
			position:"absolute"
			});
			$('#describe').animate({
					left:940,
					top:190
				});
   });
</script>             -->