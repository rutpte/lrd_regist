<? session_start();
include "header.php";
//header("Content-Encoding: None", true);

//include "chksession.php";
$orgc_id=$_GET['orgc_id'];
$list_year=$_GET['list_year'];
$search=$_GET['search'];
$dd = $disp->displaydateS(date("Y-m-d"));
if($search==""||$search==1){
$conT="";
$text_s="ทั้งหมด";
}
else if($search==2){
$conT="and file_t2!=''";	
$text_s="ที่ ผวจ. อนุมัติแล้ว";
}
else if($search==3){
$conT="and file_t2=''";	
$text_s="ที่ ผวจ. ยังไม่อนุมัติ";
}

	$show 		= $_GET['show'];
if($show==1){
$dd1 = "";
}else if($show==2){
 $show_date = date('Y-m-d',strtotime($_GET['s_date']));
 $end_date = date('Y-m-d',strtotime($_GET['e_date']));
 $con="and way.cre_date between '$show_date' and '$end_date'";
 $dd1=$disp->displaydateS($show_date)." ถึง วันที่ ".$disp->displaydateS1($end_date);
}
	
 
$sql="SELECT province.province_id,province_name,drop_name,org_comunity.orgc_name,org_comunity_detail.num_orders,count(way_id)as amount_way,sum(distance_total)as amount_phase_way,name_residence
FROM
  org_comunity
  INNER JOIN way ON (org_comunity.orgc_id=way.orgc_id)
  INNER JOIN org_comunity_detail ON (org_comunity.orgc_id=org_comunity_detail.orgc_id)
  INNER JOIN amphur ON (org_comunity.amphur_id=amphur.amphur_id)
  INNER JOIN province ON (amphur.province_id = province.province_id)
  INNER JOIN residence ON (province.id_residence = residence.id_residence) where org_comunity.orgc_id='$orgc_id'
   GROUP BY province.province_id,province.province_name,province.drop_name,org_comunity.orgc_name,org_comunity_detail.num_orders,residence.name_residence
  ";    //new GROUP BY province.province_id,province.province_name,province.drop_name,org_comunity.orgc_name,org_comunity_detail.num_orders,residence.name_residence
  $result=$db->query($sql);
  $rs=$db->fetch_array($result);
    $sqlSu="select sum(distance_total) as sum_dis FROM
 way where way.orgc_id='$orgc_id' $conT $con";
  $resultSu=$db->query($sqlSu);
  $rsSu=$db->fetch_array($resultSu);
  $sqlS="SELECT *
FROM
  way
 where way.orgc_id='$orgc_id' $conT $con order by way_code_tail asc";
 $resultS=$db->query($sqlS);
 $numS=$db->num_rows($resultS);
  $sqlS1="SELECT *
FROM
  way
 where way.orgc_id='$orgc_id' and cre_type='1' $conT $con ";
 $resultS1=$db->query($sqlS1);
 $numS1=$db->num_rows($resultS1);

if($numS1>0){
$alertN="        หมายเหตุ ถ้ามีเครื่องหมาย * หน้าลำดับที่ คือสายทางที่อปท. $rs[orgc_name]เลือกกำหนดมาตรฐานชั้นทางเอง";

}
 require('fpdf.php');

class PDF extends FPDF {
	function SetThaiFont() {
		$this->AddFont('AngsanaNew','','angsa.php');
		$this->AddFont('AngsanaNew','B','angsab.php');
		$this->AddFont('AngsanaNew','I','angsai.php');
		$this->AddFont('AngsanaNew','IB','angsaz.php');
		
	}
	
	function conv($string) {
		//return iconv('UTF-8', 'TIS-620', $string);   ///////////////////////////////////////////////////////////////
        return iconv('UTF-8', 'TIS-620', $string);
	}
	//Override คำสั่ง (เมธอด) Footer
	function Footer()	{
 
		//นับจากขอบกระดาษด้านล่างขึ้นมา 10 มม.
		$this->SetY( -10 );
 
		//กำหนดใช้ตัวอักษร Arial ตัวเอียง ขนาด 5
		$this->SetFont('AngsanaNew','I',7);
 
		$this->Cell(0,10,'Time '. date('d').'/'. date('m').'/'.(  date('Y')+543 ).' '. date('H:i:s') ,0,0,'L');
		$this->Cell(0,10, '' ,0,0,'L');
 
		//พิมพ์ หมายเลขหน้า ตรงมุมขวาล่าง
		$this->Cell(0,10, 'page '.$this->PageNo().' of  tp' ,0,0,'R');
 
	}
}


$pdf = new PDF( 'L' , 'mm' , 'A4' );

$pdf->SetThaiFont();


$pdf->SetMargins(5, 5);
$pdf->AliasNbPages( 'tp' );

$pdf->AddPage();

$pdf->Cell(255);
$pdf->SetFont('AngsanaNew', 'B', 10);
$txt = $pdf->conv("แบบ ทถ.6");
$pdf->Cell(20, 10, $txt, 1, 1, 'C');  

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("สมุดลงทะเบียนคุมสายทางหลวงท้องถิ่น");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("ทชจ.$rs[province_name] $rs[name_residence]");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("หน่วยงาน $rs[orgc_name]");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("รายงานเมื่อ $dd");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    

if($show==2){
$pdf->Ln(4);
$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("ตั้งแต่วันที่ $dd1");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
}
$pdf->Ln(6);







$pdf->SetFillColor(237,237,237);
$pdf->SetFont('AngsanaNew', 'B', 9);

$pdf->SetY(40); 
$pdf->SetX(5);
$numS_a = number_format($numS,0,'.',',');
$amount_phase_way = number_format($rsSu['sum_dis'],3,'.',',');
$txt = $pdf->conv("รวมสายทางลงทะเบียน$text_s จำนวน $numS_a เส้น รวมระยะทางลงทะเบียนจำนวน $amount_phase_way (กม.) $alertN" );
$pdf->Cell(285,5,$txt,1,1,'C',true);

$pdf->SetY(45); 
$pdf->SetX(5);
$txt = $pdf->conv("ลำดับ");
$pdf->Cell(6,20,$txt,1,0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(11);
$txt = $pdf->conv("รหัสสายทาง");
$pdf->Cell(18,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(29);
$txt = $pdf->conv("ชื่อสายทาง");
$pdf->Cell(38,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(67);
$txt = $pdf->conv("ชั้นทางในเขตเมือง");
$pdf->Cell(22,10,$txt,'LTR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(67);
$txt = $pdf->conv("หรือในเขตชุมชน (ชั้น)");
$pdf->Cell(22,10,$txt,'LBR',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(89);
$txt = $pdf->conv("ชั้นทางนอกเขตเมือง");
$pdf->Cell(22,10,$txt,'LTR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(89);
$txt = $pdf->conv("หรือนอกเขตชุมชน (ชั้น)");
$pdf->Cell(22,10,$txt,'LBR',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(111);
$txt = $pdf->conv("ระยะทาง (กม.)");
$pdf->Cell(18,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(129);
$txt = $pdf->conv("ผิวจราจรกว้าง (ม.)");
$pdf->Cell(55,15,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(129);
$txt = $pdf->conv("คสล.");
$pdf->Cell(11,5,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(140);
$txt = $pdf->conv("ลาดยาง");
$pdf->Cell(11,5,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(151);
$txt = $pdf->conv("ลูกรัง");
$pdf->Cell(11,5,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(162);
$txt = $pdf->conv("ไหล่ทาง");
$pdf->Cell(11,5,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(173);
$txt = $pdf->conv("ทางเท้า");
$pdf->Cell(11,5,$txt,'1',0,'C',true);


$pdf->SetY(45); 
$pdf->SetX(184);
$txt = $pdf->conv("เขตทางกว้าง (ม.)");
$pdf->Cell(17,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(201);
$txt = $pdf->conv("ปีที่สร้าง (พ.ศ.)");
$pdf->Cell(17,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(218);
$txt = $pdf->conv("ลงทะเบียนเมื่อ");
$pdf->Cell(17,10,$txt,'LTR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(218);
$txt = $pdf->conv("(วัน / เดือน / ปี)");
$pdf->Cell(17,10,$txt,'LBR',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(235);
$txt = $pdf->conv("เจ้าหน้าที่รับผิดชอบ");
$pdf->Cell(25,20,$txt,'LTR',0,'C',true);


$pdf->SetY(45); 
$pdf->SetX(260);
$txt = $pdf->conv("หมายเหตุ");
$pdf->Cell(30,20,$txt,'1',1,'C',true);


 
 $i=1;
 $j=1;
  while($rsS=$db->fetch_array($resultS)){
if($rsS['cre_type']==1){
$an="*";	
}else {
$an="";	
}
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

}


 
  
				   
$pdf->SetFont('AngsanaNew', 'B', 10);

$txt = $pdf->conv("$an$i");
$pdf->Cell(6,7,$txt,1,0,'C',false);

$txt = $pdf->conv("$rsS[way_code_head]$rsS[way_code_tail]");
$pdf->Cell(18,7,$txt,1,0,'C',false);

$txt = $pdf->conv("$rsS[way_name]");
$pdf->Cell(38,7,$txt,1,0,'C',false);


if($rsS['id_regis_detail']!=0&&$rsS['type_road']==0&&$rsS['cre_type']!=2 ){ if($rsS['layer_road']==0){ 
$layer_road = "พิเศษ"; 
}else{
$layer_road = $rsS['layer_road']; 
}}else{ 
$layer_road = "-";
}
$txt = $pdf->conv("$layer_road");
$pdf->Cell(22,7,$txt,1,0,'C',false);


if($rsS['id_regis_detail']!=0&&$rsS['type_road']==1&&$rsS['cre_type']!=2 ){ if($rsS['layer_road']==0){ 
$layer_road = "พิเศษ"; 
}else{
$layer_road = $rsS['layer_road']; 
}}else{ 
$layer_road = "-";
}
$txt = $pdf->conv("$layer_road");
$pdf->Cell(22,7,$txt,1,0,'C',false);

$distance_total = number_format($rsS['distance_total'],3,'.',',');
$txt = $pdf->conv("$distance_total");
$pdf->Cell(18,7,$txt,1,0,'C',false);


$cw1=count($wt1);  if($cw1!=0 ){ if($cw1>0&&$wt1[0]!=$wt1[$cw1-1]){
$aa = number_format($wt1[0],2,'.',',')."-".number_format($wt1[$cw1-1],2,'.',','); 
}else if($wt1[0]==$wt1[$cw1-1]) {
$aa = number_format($wt1[0],2,'.',',');} }else{ 
$aa = "-";}
$txt = $pdf->conv("$aa");
$pdf->Cell(11,7,$txt,1,0,'C',false);

$cw2=count($wt2); if($cw2!=0 ){ if($cw2>0&&$wt2[0]!=$wt2[$cw2-1]){
$bb = number_format($wt2[0],2,'.',',')."-".number_format($wt2[$cw2-1],2,'.',','); }else if($wt2[0]==$wt2[$cw2-1]) {
$bb = $wt2[0];} }else{ 
$bb = "-";}
$txt = $pdf->conv("$bb");
$pdf->Cell(11,7,$txt,1,0,'C',false);

$cw3=count($wt3); if($cw3!=0 ){ if($cw3>0&&$wt3[0]!=$wt3[$cw3-1]){
$cc = number_format($wt3[0],2,'.',',')."-".number_format($wt3[$cw3-1],2,'.',','); }else if($wt3[0]==$wt3[$cw3-1]) {
$cc = $wt3[0];} }else{ 
$cc = "-";}
$txt = $pdf->conv("$cc");
$pdf->Cell(11,7,$txt,1,0,'C',false);

$clt=count($lt); if($clt!=0 ){ if($clt>0&&$lt[0]!=$lt[$clt-1]){
$dd = number_format($lt[0],2,'.',',')."-".number_format($lt[$clt-1],2,'.',',');}
else if($lt[0]==$lt[$clt-1]) {
$dd = number_format($lt[0],2,'.',',');}}
else{ 
$dd = "-";}
$txt = $pdf->conv("$dd");
$pdf->Cell(11,7,$txt,1,0,'C',false);

$ctt=count($tt); if($ctt!=0 ){ if($ctt>0&&$tt[0]!=$tt[$ctt-1]){
$ee = number_format($tt[0],2,'.',',')."-".number_format($tt[$clt-1],2,'.',',');}
else if($tt[0]==$tt[$ctt-1]) {$ee = number_format($tt[0],2,'.',',');}}
else{ $ee = "-";}
$txt = $pdf->conv("$ee");
$pdf->Cell(11,7,$txt,1,0,'C',false);

$cks=count($ks); if($cks!=0 ){ if($cks>0&&$ks[0]!=$ks[$cks-1]){
$ff = number_format($ks[0],2,'.',',')."-".number_format($ks[$cks-1],2,'.',',');}
else if($ks[0]==$ks[$cks-1]) {$ff = number_format($ks[0],2,'.',',');}} else{ $ff = "-";}
$txt = $pdf->conv("$ee");
$pdf->Cell(17,7,$txt,1,0,'C',false);

if($rsS['year_road']!=""){$yr = $rsS['year_road'];}else{
$yr = "-";}
$txt = $pdf->conv("$yr");
$pdf->Cell(17,7,$txt,1,0,'C',false);

$cre_date = $disp->displaydateY($rsS['cre_date']);
$txt = $pdf->conv("$cre_date");
$pdf->Cell(17,7,$txt,1,0,'C',false);

if($rsS['name_per']!=""){ $name_per = $rsS['name_per']; }else{ $name_per = "-";} 
$txt = $pdf->conv("$name_per");
$pdf->Cell(25,7,$txt,1,0,'C',false);

$pdf->Cell(30,7,'',1,1,'C',false);

$i++;
$j++;
  $distance_totalS+=$distance_total;
unset($wt1);
unset($wt2);
unset($wt3);
unset($lt);
unset($tt);
unset($ks);
$distance_total="";
 if($j == 15)
   {
     $j = 1;
	 $pdf->AliasNbPages( 'tp' );
    $pdf->AddPage();
	
	$pdf->Cell(255);
$pdf->SetFont('AngsanaNew', 'B', 10);
$txt = $pdf->conv("แบบ ทถ.6");
$pdf->Cell(20, 10, $txt, 1, 1, 'C');  

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("สมุดลงทะเบียนคุมสายทางหลวงท้องถิ่น");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("ทชจ.$rs[province_name] $rs[name_residence]");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("หน่วยงาน $rs[orgc_name]");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("รายงานเมื่อ $ddd");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    

if($show==2){
$pdf->Ln(4);
$pdf->SetFont('AngsanaNew', 'B', 10);
$txt = $pdf->conv("ตั้งแต่วันที่ $dd1");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
}
$pdf->Ln(6);




$pdf->SetFillColor(237,237,237);
$pdf->SetFont('AngsanaNew', 'B', 9);

$pdf->SetY(40); 
$pdf->SetX(5);
$numS_a = number_format($numS,0,'.',',');
$amount_phase_way = number_format($rsSu['sum_dis'],3,'.',',');
$txt = $pdf->conv("รวมสายทางลงทะเบียน$text_s จำนวน $numS_a เส้น รวมระยะทางลงทะเบียนจำนวน $amount_phase_way (กม.) $alertN" );
$pdf->Cell(285,5,$txt,1,1,'C',true);

$pdf->SetY(45); 
$pdf->SetX(5);
$txt = $pdf->conv("ลำดับ");
$pdf->Cell(6,20,$txt,1,0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(11);
$txt = $pdf->conv("รหัสสายทาง");
$pdf->Cell(18,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(29);
$txt = $pdf->conv("ชื่อสายทาง");
$pdf->Cell(38,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(67);
$txt = $pdf->conv("ชั้นทางในเขตเมือง");
$pdf->Cell(22,10,$txt,'LTR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(67);
$txt = $pdf->conv("หรือในเขตชุมชน (ชั้น)");
$pdf->Cell(22,10,$txt,'LBR',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(89);
$txt = $pdf->conv("ชั้นทางนอกเขตเมือง");
$pdf->Cell(22,10,$txt,'LTR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(89);
$txt = $pdf->conv("หรือนอกเขตชุมชน (ชั้น)");
$pdf->Cell(22,10,$txt,'LBR',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(111);
$txt = $pdf->conv("ระยะทาง (กม.)");
$pdf->Cell(18,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(129);
$txt = $pdf->conv("ผิวจราจรกว้าง (ม.)");
$pdf->Cell(55,15,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(129);
$txt = $pdf->conv("คสล.");
$pdf->Cell(11,5,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(140);
$txt = $pdf->conv("ลาดยาง");
$pdf->Cell(11,5,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(151);
$txt = $pdf->conv("ลูกรัง");
$pdf->Cell(11,5,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(162);
$txt = $pdf->conv("ไหล่ทาง");
$pdf->Cell(11,5,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(173);
$txt = $pdf->conv("ทางเท้า");
$pdf->Cell(11,5,$txt,'1',0,'C',true);


$pdf->SetY(45); 
$pdf->SetX(184);
$txt = $pdf->conv("เขตทางกว้าง (ม.)");
$pdf->Cell(17,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(201);
$txt = $pdf->conv("ปีที่สร้าง (พ.ศ.)");
$pdf->Cell(17,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(218);
$txt = $pdf->conv("ลงทะเบียนเมื่อ");
$pdf->Cell(17,10,$txt,'LTR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(218);
$txt = $pdf->conv("(วัน / เดือน / ปี)");
$pdf->Cell(17,10,$txt,'LBR',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(235);
$txt = $pdf->conv("เจ้าหน้าที่รับผิดชอบ");
$pdf->Cell(25,20,$txt,'LTR',0,'C',true);


$pdf->SetY(45); 
$pdf->SetX(260);
$txt = $pdf->conv("หมายเหตุ");
$pdf->Cell(30,20,$txt,'1',1,'C',true);

   }
   }


$pdf->SetFillColor(239,253,255);
	$pdf->SetFont('AngsanaNew', 'B', 11);

$txt = $pdf->conv("รวม");
$pdf->Cell(24,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(38,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(22,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(22,10,$txt,1,0,'C',true);

$distance_totalS = number_format($distance_totalS,3,'.',',');
$txt = $pdf->conv("$distance_totalS");
$pdf->Cell(18,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(11,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(11,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(11,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(11,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(11,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(17,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(17,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(17,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(25,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(30,10,$txt,1,1,'C',true);


$pdf->Output();
   

	?>


	


