<? include "check.php";
include "unset_regis.php";
$orgc_id=$_GET['orgc_id'];

$REFEREF=$_SERVER['HTTP_REFERER'];
$sql="SELECT province.province_id,province_name,drop_name,org_comunity.orgc_name,org_comunity_detail.num_orders,org_comunity_detail.pic_map,residence.name_residence
FROM
  org_comunity
  INNER JOIN org_comunity_detail ON (org_comunity.orgc_id=org_comunity_detail.orgc_id)
  INNER JOIN amphur ON (org_comunity.amphur_id=amphur.amphur_id)
  INNER JOIN province ON (amphur.province_id=province.province_id)
  INNER JOIN residence ON (province.id_residence = residence.id_residence)
  where org_comunity.orgc_id='$orgc_id' 
  ";
  // where org_comunity.orgc_id='$orgc_id'
  //   org_comunity  province  residence


  $result=$db->query($sql);
  $rs=$db->fetch_array($result); //เริ่มเอาไปใช้ไหน ค่าที่มี   7ค่า : province_id ,province_name ,drop_name ,orgc_name ,num_orders, pic_map, name_residence
  

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

      //and (way.active='t')
        //  INNER JOIN register_road_detail ON (way.way_id=register_road_detail.way_id)
       // new   GROUP BY way.way_id,distance_total ขอบคุณกรุ๊ปบาย
      //  ตกม้าตายอู่สองวันเต็ม แม่เจ้า sum ผิดคอลัมน์     new  INNER JOIN register_road_detail ON (way.way_id=register_road_detail.way_id)
  $resultSu0=$db->query($sqlSu0);
  while($rsSu0=$db->fetch_array($resultSu0)){
     $rsSu['sum_dis']+=$rsSu0['sum_dis0'];       //ที่แก้ sum_dis
  }  //#$sqlSu0=sum all way
 #----------------------------------------------------------------
  $resultSu1=$db->query($sqlSu1);
  while($rsSu1=$db->fetch_array($resultSu1)){
     $rsSu['sum_dis1']+=$rsSu1['sum_dis1'];       //ที่แก้ sum_dis
  }  //#$sqlSu1=sum all way register only


  // echo"sum_dis=";echo $rsSu['sum_dis']; echo"<br>";
  //echo"where orgc_id="; echo "$orgc_id";
 //  echo"<br>";echo"";
  // exit;                          ส่วนนี้เรียก อปท ที่่กำหนด
  $sqlS="SELECT way.way_id,way.cre_type,way.way_code_head,way.way_code_tail,way.way_name,way.type_road,way.layer_road,way.distance_total,way.cre_date,way.pic_map_mun,way.file_t2,
case when reg.way_id is not null then 't' else 'f' end as status_1,
case when reg.way_id is null then 't' else 'f' end as status_2,
case when way.way_code_head is null or way.way_code_tail is null then 't' else 'f' end as status_3,
case when (way.way_code_head is not null and way.way_code_head !='')  and (way.way_code_tail is not null and way.way_code_tail !='') then 't' else 'f' end as status_4,
case when way.way_code_head is null and way.way_code_tail is null then 't' else 'f' end as status_5,
case when way.way_code_head='' or way.way_code_tail='' then 't' else 'f' end as status_6
FROM way
left JOIN register_road_detail AS reg ON way.way_id = reg.way_id
          where way.orgc_id='$orgc_id' and (way.active='t') and way.flag_reg_road='t'
           GROUP BY way.way_id,way.cre_type,way.way_code_head,way.way_code_tail,way.way_name,way.type_road,way.layer_road,way.distance_total,way.cre_date,way.pic_map_mun,way.file_t2,reg.way_id
           order by way.way_id asc";
           //and (way.active='t')
           // INNER JOIN register_road_detail ON (way.way_id=register_road_detail.way_id)
           //where register_road.orgc_id   //select เป็น อปท.เพื่อหาจำนวน id ทั้งหมด
           //INNER JOIN register_road_detail ON (way.way_id=register_road_detail.way_id::BIGINT)
           //new  INNER JOIN register_road_detail ON (way.way_id=register_road_detail.way_id)
 $resultS=$db->query($sqlS);
 $numS=$db->num_rows($resultS);
 #-------------------------------------------------------
 $sqlS2="SELECT *
 FROM way where orgc_id='$orgc_id'
 and (active='t' or active is null)
 and way.flag_reg_road='t' ";
 $resultS2=$db->query($sqlS2);
 $numS2=$db->num_rows($resultS2);
     //$numS2=all register record
 #-------------------------------------------------------
 $i=1;
	 $Per_Page =50;
if ( !$Page ) 
	$Page = 1; 
$Prev_Page = $Page - 1; 
$Next_Page = $Page + 1; 
$resultS = $db->query($sqlS); // หลังจากนัม //query ก่อน line 84
$Page_start = ( $Per_Page * $Page ) - $Per_Page; 
$Num_Rows = $db->num_rows( $resultS );  //นับอีกรอบ
if ( $Num_Rows <= $Per_Page ) $Num_Pages = 1; 
else if ( ( $Num_Rows % $Per_Page ) == 0 ) $Num_Pages = ( $Num_Rows / $Per_Page ); 
else $Num_Pages = ( $Num_Rows / $Per_Page ) + 1; 

$Num_Pages = ( int ) $Num_Pages; 
if ( ( $Page > $Num_Pages ) || ( $Page < 0 ) ) 
	print "จำนวน $Page มากกว่า $Num_Pages";
$sqlS .= " LIMIT $Per_Page offset $Page_start"; 
$resultS = $db->query( $sqlS ); //หลัง limit ก่อนหน้านี้ก็มีการ query ตัวนี้   SELECT *   FROM way
 
?>
<?
//$rsS=$db->fetch_array($resultS)
 //var_dump($rsS['way_name']);
 //exit;
 ?>
<link href="css/register.css" rel="stylesheet" type="text/css" />
<table width="601" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="th_head_back14" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="th_head_back"  align="center"><p>สมุดลงทะเบียนคุมสายทางหลวงท้องถิ่น</p>
          </td>
      </tr>
	    <tr>
        <td class="th14bgray"  align="center">ทชจ.&nbsp;<? echo $rs['province_name'];?>&nbsp;&nbsp;<? echo $rs['name_residence']?>
          </td>
      </tr>
	     <tr>
        <td class="th14bgray_line"  align="center">หน่วยงาน&nbsp;<? echo $rs['orgc_name'];?>  </td>
      </tr>
      
    </table></td>
  </tr>
</table>

<br/><table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="0">
  <tr><td width="211" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <!--td width="46%" align="center"><? //if($_SESSION['LOGTYPE']==1/*||$_SESSION['LOGTYPE']==4*/||$_SESSION['LOGTYPE']==2){?><!--<a href="manage.php?page=add_amount&orgc_id=<? echo $orgc_id?>" class="th_red12bbb_line"><img src="image/way.jpg" width="127" height="95" border="0" /></a>--><?  //}?></td-->
    <td width="46%" align="center"></td>
    <td width="8%" align="center"><a href="manage.php?page=register_road&orgc_id=<? echo $orgc_id?>" class="th_red12bbb_line"><img src="image/register.jpg" width="80" height="80" border="0" /></a></td>
    <td width="46%" align="center"></td>
  </tr>
  <tr>
    <td align="center"><!--<a href="manage.php?page=add_amount&orgc_id=<? echo $orgc_id?>" class="th_red12bbb_line">เพิ่ม/แก้ไขจำนวนสายทางและระยะทาง</a>--></td>
    <td align="center"><a href="manage.php?page=register_road&orgc_id=<? echo $orgc_id?>" class="th_red12bbb_line">ลงทะเบียน</a></td>
    <td align="center"><!--<a href="manage.php?page=register_road&orgc_id=<? echo $orgc_id?>" class="th_red12bbb_line">ลงทะเบียน</a>--></td>
  </tr>
  <tr>
    <td align="left"><br/><a href="manage.php?page=manage_mun_register&province_id=<? echo $rs['province_id'];?>" class="th_red12b"><<<กลับ</a></td>
    <td align="center">&nbsp;</td>
    <td align="center"><!--img id="describe" src="image/describe.png" border="0" /--></td>
  </tr>
  </table>
</td>
  </tr></table>
<table width="1000" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
<tr bgcolor="#6699FF">
<td colspan="17" class="th12bblue" align="center"><!--รวมสายทางทั้งหมดจำนวน  <span class="th12bred"><? echo number_format($numS,0,'.',',');;?></span> เส้น |-->รวมสายทางที่ลงทะเบียนแล้วจำนวน  <span class="th12bred"><? echo number_format($numS2,0,'.',',');;?></span><!-- เส้น |รวมระยะทางจำนวน <span class="th12bred"><? echo number_format($rsSu['sum_dis'],3,'.',',');?></span> (กม.)| -->| จำนวนที่ลงทะเบียนแล้ว<span class="th12bred"><? echo number_format($rsSu['sum_dis1'],3,'.',',');?></span>(กม.) </td>
</tr>                                                                                                           <? // ค่าจำนวนสายทางที่ลงทะเบียน?>

<tr bgcolor="#6699FF"><td width="52" rowspan="2" align="center" class="th12bblue">ลำ<br/>
  ดับ<br/>ที่</td>
<td width="77" rowspan="2" align="center" class="th12bblue">รหัส<br/>
  สายทาง</td>
<td width="81" rowspan="2" align="center" class="th12bblue">ชื่อสายทาง</td>
<td width="27" rowspan="2" align="center" class="th12bblue">ชั้น<br/>ทาง<br/>
  ใน<br/>เขต<br/>ชุม<br/>ชน<br/>
  (ชั้น)</td>
<td width="33" rowspan="2" align="center" class="th12bblue">ชั้น<br/>ทาง<br/>
  นอก<br/>เขต<br/>ชุม<br/>ชน<br/>
  (ชั้น)</td>
<td width="33" rowspan="2" align="center" class="th12bblue">ระยะ<br/>
  ทาง<br/>
  (กม.)</td>
<td colspan="5" class="th12bblue" align="center">ผิวจราจรกว้าง<br/>(ม.)</td>
<td width="65" rowspan="2" align="center" class="th12bblue">เขตทาง<br/>
  กว้าง<br/>(ม.)</td>

<td width="82" rowspan="2" align="center" class="th12bblue">ลงทะเบียน<br/>
  เมื่อ<br/>
  วัน/เดือน/ปี</td>

<td width="56" rowspan="2" align="center" class="th12bblue">จัดการ</td>
<td colspan="3" class="th12bblue" align="center">ดำเนินการ</td>
</tr>
<tr bgcolor="#6699FF">
  <td width="45" height="44" align="center" class="th12bblue">คสล.</td>
<td width="50" class="th12bblue" align="center">ลาดยาง</td>
<td width="52" class="th12bblue" align="center">ลูกรัง</td>
<td width="60" class="th12bblue" align="center">ไหล่ทาง</td>
<td width="59" class="th12bblue" align="center">ทางเท้า</td>

<td width="64" class="th12bblue" align="center">แผนที่<br/>สาย<br/>ทาง</td>
<td width="64" class="th12bblue" align="center">ทถ.2<br/>ที่ผจว.<br/>อนุมัติ</td>
<td width="64" class="th12bblue" align="center">แผนที่<br/>
รวม<br/>สาย<br/>ทาง</td>

</tr>
<? $i=1; 
   $num=$Page_start;
                     while($rsS=$db->fetch_array($resultS)){


                     $num++;
                     $sql1="select id_regis_detail,type_ja,width_ja,type_sh,width_sh,type_fo,width_fo,kate_regis from register_road_detail where way_id='$rsS[way_id]' order by type_ja asc,width_ja asc,type_sh asc,width_sh asc,type_fo asc,width_fo asc,kate_regis asc";
                     $result1=$db->query($sql1);

                     while($rs1=$db->fetch_array($result1)){
                     
                           $ks[]=$rs1['kate_regis'];
                           sort($ks); //sort คือฟังชั่นเรียง จากน้อยไปมาก a-z (ก-ฮ ด้วยหรือป่าว)
                                       if($rs1['type_sh']!=0){  //// ถ้าค่าเป็น 0 ก็แสดงว่าไม่ได้กรอก ทางเท้า
                                       $lt[]=$rs1['width_sh'];
                                       sort($lt);
                                       }
                                       else if($rs1['type_fo']!=0){     // ถ้าค่าเป็น 0 ก็แสดงว่าไม่ได้กรอก ทางเท้า
                                       $tt[]=$rs1['width_fo'];
                                       sort($tt);
                                       }
                                       if($rs1['type_ja']==1){
                                       $wt1[]=$rs1['width_ja'];
                                       sort($wt1);
                                       }else if($rs1['type_ja']==2){
                                       $wt2[]=$rs1['width_ja'];            //$bg="background-color:rgba(255,255,0,.3)"; $pic_bg="image/fall_heart.png";$alt="ข้อมูลไม่ครบ";
                                       sort($wt2);                         //$bg="background-color:rgba(255,0,0,.4)"; $pic_bg="image/no_complete.png";$alt="ยังไม่ลงทะเบียน";
                                       }                                   //$bg="background-color:rgba(0,255,0,.2)"; $pic_bg="image/complete.png"; $alt="ลงทะเบียนแล้ว";
                                       else if($rs1['type_ja']==3){
                                       $wt3[]=$rs1['width_ja'];
                                       sort($wt3);
                                 }

                        $id_regis_detail=$rs1['id_regis_detail']  ;  //ช่วยชีวิตแล้ว
                     } //end while rs1
                     /*
    if($rsS['status_1']=="t"and $rsS['status_4']=="t")     //green
    {
       $bg="background-color:rgba(0,255,0,.2)"; $pic_bg="image/complete.png"; $alt="ลงทะเบียนแล้ว";
         }else if($rsS['status_2']=="t"and $rsS['status_5']=="t"){   //red
      $bg="background-color:rgba(255,0,0,.4)"; $pic_bg="image/no_complete.png";$alt="ยังไม่ลงทะเบียน";
         } else{ $bg="background-color:rgba(255,255,0,.3)"; $pic_bg="image/fall_heart.png";$alt="ข้อมูลไม่ครบ";} //$("td").first().addClass('bg');
     */
  ?>

<tr><td  style="<? echo $bg ?>";align="center" class="th_black11b"><? if($rsS['cre_type']==1){ $Scre_type=1;
?><span class="th11bred">*</span><? }?><? echo $num;?>.&nbsp;&nbsp;<img src="<?echo $pic_bg;?>" alt="<? echo $alt; ?>"></td>    <? //ลำดับ?>
<td align="center" class="th_black11b"><? echo $rsS['way_code_head'].$rsS['way_code_tail'];?></td><?// รหัสสายทาง+id สายทาง way->way_code_full?>
<td align="left" class="th_black11b"><? echo $rsS['way_name'];?></td> <?// name_road = ชื่อสายทาง way->way_name?>
<td align="center" class="th_black11b"><? if( $id_regis_detail!=0&&$rsS['type_road']==0&&$rsS['cre_type']!=2 ){ if($rsS['layer_road']==0){ echo "พิเศษ";}else{echo $rsS['layer_road']; }}else{ echo "-";}?></td><?//ชั้นทางในเขตชุมชน แต่ต้องไปfetcho เอาในตารางใหม่ ตารางเก่าไม่มี?>
<td align="center" class="th_black11b"><? if( $id_regis_detail!=0&&$rsS['type_road']==1&&$rsS['cre_type']!=2 ){ if($rsS['layer_road']==0){ echo "พิเศษ";}else{echo $rsS['layer_road']; }}else { echo "-";}?></td>       <?// ใช้ตัวแปรเหมือนเดิม?>
<td align="center" class="th_black11b"><? echo number_format($rsS['distance_total'],3,'.',',');?></td><?// distance_road=way->distanve_total?>
<td align="center" class="th_black11b"><? $cw1=count($wt1);  if($cw1!=0 ){ if($cw1>0&&$wt1[0]!=$wt1[$cw1-1]){echo number_format($wt1[0],2,'.',',')."-".number_format($wt1[$cw1-1],2,'.',','); }else if($wt1[0]==$wt1[$cw1-1]) {echo number_format($wt1[0],2,'.',',');} }else{ echo "-";}?></td>
<td align="center" class="th_black11b"><? $cw2=count($wt2); if($cw2!=0 ){ if($cw2>0&&$wt2[0]!=$wt2[$cw2-1]){echo number_format($wt2[0],2,'.',',')."-".number_format($wt2[$cw2-1],2,'.',','); }else if($wt2[0]==$wt2[$cw2-1]) {echo $wt2[0];} }else{ echo "-";}?></td>
<td align="center" class="th_black11b"><? $cw3=count($wt3); if($cw3!=0 ){ if($cw3>0&&$wt3[0]!=$wt3[$cw3-1]){echo number_format($wt3[0],2,'.',',')."-".number_format($wt3[$cw3-1],2,'.',','); }else if($wt3[0]==$wt3[$cw3-1]) {echo $wt3[0];} }else{ echo "-";}?></td>
<td align="center" class="th_black11b"><? $clt=count($lt); if($clt!=0 ){ if($clt>0&&$lt[0]!=$lt[$clt-1]){
echo number_format($lt[0],2,'.',',')."-".number_format($lt[$clt-1],2,'.',',');}
else if($lt[0]==$lt[$clt-1]) {echo number_format($lt[0],2,'.',',');}}
else{ echo "-";}?></td>
<td align="center" class="th_black11b"><?

$ctt=count($tt);
   if($ctt!=0 ){
        if($ctt>0&&$tt[0]!=$tt[$ctt-1]){
             echo number_format($tt[0],2,'.',',')."-".number_format($tt[$ctt-1],2,'.',',');
}
else if($tt[0]==$tt[$ctt-1]) {
        echo number_format($tt[0],2,'.',',');
     }
   }

else{ echo "-";}

?></td>
<td align="center" class="th_black11b"><?  $cks=count($ks); if($cks!=0 ){ if($cks>0&&$ks[0]!=$ks[$cks-1]){
echo number_format($ks[0],2,'.',',')."-".number_format($ks[$cks-1],2,'.',',');}
else if($ks[0]==$ks[$cks-1]) {echo number_format($ks[0],2,'.',',');}} else{ echo "-";}?></td>

<td align="center" class="th_black11b"><?  echo $disp->displaydateY($rsS['cre_date']);//$disp->displaydateY($rsS['cre_date']) //ใช้cre_date ในตาราง way  ?></td>

<td align="center" class="th_black11b"><a href="manage.php?page=register_road&way_id=<? echo $rsS['way_id'];?>&proc=edit&orgc_id=<? echo $orgc_id?>">แก้ไข </a> / <a href="register_road_proc.php?way_id=<? echo $rsS['way_id'];?>&proc=del&orgc_id=<? echo $orgc_id?>" >ลบ</a></td>
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
 <td align="center" class="th_black11b"><? if($filename_ref_s_m !=""){?> <a href="manage.php?page=add_pic_map_mun&way_id=<? echo $rsS['way_id'];?>" ><img src="image/wolrd1.jpg" width="30" height="30" border="0" /></a>&nbsp; <? }else{?><a href="manage.php?page=add_pic_map_mun&way_id=<? echo $rsS['way_id'];?>" ><img src="image/wolrdX.jpg" width="30" height="30" border="0" /></a><? }?></td>
<td align="center" class="th_black11b"><? if($filename_ref_f_t2 !=""){?> <a href="manage.php?page=add_file_mun&way_id=<? echo $rsS['way_id'];?>" ><img src="image/true.jpg" width="30" height="30" border="0" /></a>&nbsp; <? }else{?><a href="manage.php?page=add_file_mun&way_id=<? echo $rsS['way_id'];?>" ><img src="image/trueX.jpg" width="30" height="30" border="0" /></a><? }?></td>
<? if($i==1){ ?>
<td align="center" class="th_black11b"  rowspan="<? echo  $numS;?>"><? if($filename_ref_sp_m!=""){?><a href="manage.php?page=add_pic_mun&orgc_id=<? echo $orgc_id; ?>" ><img src="image/wolrd1.jpg" width="30" height="30" border="0" /></a>&nbsp; <? }else /*if($rs['pic_map']=="")*/{?><a href="manage.php?page=add_pic_mun&orgc_id=<? echo $orgc_id; ?>" ><img src="image/wolrdX.jpg" width="30" height="30" border="0" /></a><? }?></td> <? }?>
</tr>                                                                     <?// $rs['pic_map']!="" $filename_ref_sp_m!=""?>

<? $i++; unset($wt1);
unset($wt2);
unset($wt3);
unset($lt);
unset($tt);
unset($ks);


}  //end while line 164  ตาราง way *  $rsS


?><? if( $Scre_type==1){?>
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
		echo "<a href=\"$PHP_SELF?page=manage_register&orgc_id=$orgc_id&num=$num&Page=$Prev_Page\">&lt;&lt; ถอยหลัง </a>";
/* สร้างตัวเลขหน้า */
for ( $i=1; $i<=$Num_Pages; $i++ ) 
	{ 
		if ( $i != $Page ) 
				echo "[<a href=\"$PHP_SELF?page=manage_register&orgc_id=$orgc_id&num=$num&Page=$i\">$i</a>]";
		else 
				echo " <b>$i</b> "; 
	}
/* สร้างปุ่มเดินหน้า */
if ( $Page != $Num_Pages ) 
		echo "<a href=\"$PHP_SELF?page=manage_register&orgc_id=$orgc_id&num=$num&Page=$Next_Page\"> เดินหน้า &gt;&gt;</a>";
?>
		    </div>
			</td>
  </tr>
</table>

<!--<div id="describe"><img id="describe2" src="image/describe.png" border="0" /></div>

<script src="http://code.jquery.com/jquery-latest.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
		$('#describe').css({
			position:"absolute"
			});
			$('#describe').animate({
					left:940,
					top:300
				});
   });
</script>     -->