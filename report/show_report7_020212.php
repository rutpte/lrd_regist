<? session_start();
include "header.php";
//include "chksession.php";
$id_province=$_GET['id_province'];
$list_year=$_GET['list_year'];
$dd = $disp->displaydateS(date("Y-m-d"));

$sqlN="select `province`.name_province,`residence`.`id_residence`,`residence`.`name_residence` FROM
  `residence`
  INNER JOIN `province` ON (`residence`.`id_residence` = `province`.`id_residence`) where id_province='$id_province'";
$resultN=$db->query($sqlN);
$rsN=$db->fetch_array($resultN); 

require('fpdf.php');

class PDF extends FPDF {
	function SetThaiFont() {
		$this->AddFont('AngsanaNew','','angsa.php');
		$this->AddFont('AngsanaNew','B','angsab.php');
		$this->AddFont('AngsanaNew','I','angsai.php');
		$this->AddFont('AngsanaNew','IB','angsaz.php');
		
	}
	
	function conv($string) {
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
$txt = $pdf->conv("แบบ ทถ.7");
$pdf->Cell(20, 10, $txt, 1, 1, 'C');  

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("ตารางสรุปการลงทะเบียนทางหลวงท้องถิ่น");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("ในเขตพื้นที่ สำนักทางหลวงชนบทจังหวัด$rsN[name_province] $rsN[name_residence] กรมทางหลวงชนบท กระทรวงคมนาคม");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("รายงานเมื่อ $dd");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    

$pdf->Ln(10);




$pdf->SetFillColor(237,237,237);
$pdf->SetFont('AngsanaNew', 'B', 7);

$pdf->SetY(40); 
$pdf->SetX(5);
$txt = $pdf->conv("ชื่อ อปท.");
$pdf->Cell(24,20,$txt,1,0,'C',true);


$pdf->SetY(40); 
$pdf->SetX(29);
$txt = $pdf->conv("ถนนในเขตเมือง/ในเขตชุมชน");
$pdf->Cell(84,5,$txt,'1',0,'C',true);

$pdf->SetY(40); 
$pdf->SetX(113);
$txt = $pdf->conv("ถนนนอกเขตเมือง/นอกเขตชุมชน");
$pdf->Cell(112,5,$txt,'1',0,'C',true);


$pdf->SetY(40); 
$pdf->SetX(225);
$txt = $pdf->conv("ความก้าวหน้าของการลงทะเบียน");
$pdf->Cell(42,5,$txt,'1',0,'C',true);

$pdf->SetY(40); 
$pdf->SetX(267);
$txt = $pdf->conv("หมายเหตุ");
$pdf->Cell(23,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(29);
$txt = $pdf->conv("ชั้นพิเศษ");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(43);
$txt = $pdf->conv("ชั้นที่1");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(57);
$txt = $pdf->conv("ชั้นที่2");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(71);
$txt = $pdf->conv("ชั้นที่3");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(85);
$txt = $pdf->conv("ชั้นที่4");
$pdf->Cell(14,5,$txt,'1',0,'C',true);


$pdf->SetY(45); 
$pdf->SetX(99);
$txt = $pdf->conv("รวมในเขตชุมชน");
$pdf->Cell(14,5,$txt,'1',0,'C',true);


$pdf->SetY(45); 
$pdf->SetX(113);
$txt = $pdf->conv("ชั้นพิเศษ");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(127);
$txt = $pdf->conv("ชั้นที่1");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(141);
$txt = $pdf->conv("ชั้นที่2");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(155);
$txt = $pdf->conv("ชั้นที่3");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(169);
$txt = $pdf->conv("ชั้นที่4");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(183);
$txt = $pdf->conv("ชั้นที่5");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(197);
$txt = $pdf->conv("ชั้นที่6");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(211);
$txt = $pdf->conv("รวมนอกเขตชุมชน");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(225);
$txt = $pdf->conv("รวมทะเบียน");
$pdf->Cell(42,5,$txt,'1',0,'C',true);



$pdf->SetY(50); 
$pdf->SetX(29);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(36);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(43);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(50);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(57);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(64);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(71);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(78);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(85);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(92);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(99);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(106);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(113);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(120);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(127);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(134);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(141);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(148);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(155);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(162);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(169);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(176);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(183);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(190);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(197);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(204);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(211);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(218);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(225);
$txt = $pdf->conv("จำนวนสายทาง");
$pdf->Cell(21,10,$txt,'1',0,'C',true);



$pdf->SetY(50); 
$pdf->SetX(246);
$txt = $pdf->conv("ระยะทาง (กม.)");
$pdf->Cell(21,10,$txt,'1',0,'C',true);




$pdf->SetY(55); 
$pdf->SetX(29);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(36);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(43);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(50);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(57);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(64);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(71);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(78);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(85);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(92);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(99);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(106);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(113);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(120);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(127);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(134);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(141);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(148);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(155);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(162);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(169);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(176);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(183);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(190);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(197);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(204);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(211);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(218);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',1,'C',true);










$sql="SELECT `municipality`.id_mun,`municipality`.name_mun
FROM
  `residence`
  INNER JOIN `province` ON (`residence`.`id_residence` = `province`.`id_residence`)
  INNER JOIN `municipality` ON (`province`.`id_province` = `municipality`.`id_province`)
  INNER JOIN `register_road` ON (`municipality`.`id_mun` = `register_road`.`id_mun`) where  `register_road`.id_regis_detail!=0  and `province`.id_province='$id_province'  GROUP BY `municipality`.id_mun
 order by `municipality`.num_orders asc";
  $result=$db->query($sql);
$result=$db->query($sql);
  $num_r=$db->num_rows($result);


  
  $i=0; 
  $j=1;
     while($rs=$db->fetch_array($result)){

  $sqlSum="SELECT `register_road`.distance_road,`register_road`.type_road,`register_road`.layer_road
FROM
  `residence`
  INNER JOIN `province` ON (`residence`.`id_residence` = `province`.`id_residence`)
  INNER JOIN `municipality` ON (`province`.`id_province` = `municipality`.`id_province`)
  INNER JOIN `register_road` ON (`municipality`.`id_mun` = `register_road`.`id_mun`)
  where `register_road`.id_regis_detail!=0 and `municipality`.`id_mun`='$rs[id_mun]' ";

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
  else if($rsSum['type_road']==1&&$rsSum['layer_road']==0){
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
 
  

 
   $sumClassT1=$class0+$class1+$class2+$class3+$class4;
  $sumNumT1=$numP0+$numP1+$numP2+$numP3+$numP4;

  
    $sumClassT2=$class0_1+$class1_1+$class2_1+$class3_1+$class4_1+$class5_1+$class6_1;
  $sumNumT2=$numP0_1+$numP1_1+$numP2_1+$numP3_1+$numP4_1+$numP5_1+$numP6_1;
 
$sumClassT3=$sumClassT1+$sumClassT2;
$sumNumT3=$sumNumT1+$sumNumT2;
  //$perClass=($sumClassT3*100)/$sum_amount_way;
 // $perNum=($sumNumT3*100)/$sum_amount_phase_way;

  }

 //$sum_amount_wayS+=$sum_amount_way;
  //$sum_amount_phase_wayS+=$sum_amount_phase_way;

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

$sum_sumClassT3+=$sumClassT3;
$sum_sumNumT3+=$sumNumT3;

$pdf->SetFont('AngsanaNew', '', 6);
$txt = $pdf->conv("$rs[name_mun]");
$pdf->Cell(24,5,$txt,1,0,'L',false);
$pdf->SetFont('AngsanaNew', 'B', 7);



if($class0!=""){
$class0 = number_format($class0,0,'.',','); 
}else{
$class0 = "-";
}
$txt = $pdf->conv("$class0");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP0!=""){
$numP0 = number_format($numP0,3,'.',','); 
}else{
$numP0 = "-";
}
$txt = $pdf->conv("$numP0");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class1!=""){
$class1 = number_format($class1,0,'.',','); 
}else{
$class1 = "-";
}
$txt = $pdf->conv("$class1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP1!=""){
$numP1 = number_format($numP1,3,'.',','); 
}else{
$numP1 = "-";
}
$txt = $pdf->conv("$numP1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class2!=""){
$class2 = number_format($class2,0,'.',','); 
}else{
$class2 = "-";
}
$txt = $pdf->conv("$class2");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP2!=""){
$numP2 = number_format($numP2,3,'.',','); 
}else{
$numP2 = "-";
}
$txt = $pdf->conv("$numP2");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class3!=""){
$class3 = number_format($class3,0,'.',','); 
}else{
$class3 = "-";
}
$txt = $pdf->conv("$class3");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP3!=""){
$numP3 = number_format($numP3,3,'.',','); 
}else{
$numP3 = "-";
}
$txt = $pdf->conv("$numP3");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class4!=""){
$class4 = number_format($class4,0,'.',','); 
}else{
$class4 = "-";
}
$txt = $pdf->conv("$class4");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP4!=""){
$numP4 = number_format($numP4,3,'.',','); 
}else{
$numP4 = "-";
}
$txt = $pdf->conv("$numP4");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($sumClassT1!=""){
$sumClassT1 = number_format($sumClassT1,0,'.',','); 
}else{
$sumClassT1 = "-";
}
$txt = $pdf->conv("$sumClassT1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($sumNumT1!=""){
$sumNumT1 = number_format($sumNumT1,3,'.',','); 
}else{
$sumNumT1 = "-";
}
$txt = $pdf->conv("$sumNumT1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class0_1!=""){
$class0_1 = number_format($class0_1,0,'.',','); 
}else{
$class0_1 = "-";
}
$txt = $pdf->conv("$class0_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP0_1!=""){
$numP0_1 = number_format($numP0_1,3,'.',','); 
}else{
$numP0_1 = "-";
}
$txt = $pdf->conv("$numP0_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class1_1!=""){
$class1_1 = number_format($class1_1,0,'.',','); 
}else{
$class1_1 = "-";
}
$txt = $pdf->conv("$class1_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP1_1!=""){
$numP1_1 = number_format($numP1_1,3,'.',','); 
}else{
$numP1_1 = "-";
}
$txt = $pdf->conv("$numP1_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class2_1!=""){
$class2_1 = number_format($class2_1,0,'.',','); 
}else{
$class2_1 = "-";
}
$txt = $pdf->conv("$class2_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP2_1!=""){
$numP2_1 = number_format($numP2_1,3,'.',','); 
}else{
$numP2_1 = "-";
}
$txt = $pdf->conv("$numP2_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class3_1!=""){
$class3_1 = number_format($class3_1,0,'.',','); 
}else{
$class3_1 = "-";
}
$txt = $pdf->conv("$class3_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP3_1!=""){
$numP3_1 = number_format($numP3_1,3,'.',','); 
}else{
$numP3_1 = "-";
}
$txt = $pdf->conv("$numP3_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class4_1!=""){
$class4_1 = number_format($class4_1,0,'.',','); 
}else{
$class4_1 = "-";
}
$txt = $pdf->conv("$class4_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP4_1!=""){
$numP4_1 = number_format($numP4_1,3,'.',','); 
}else{
$numP4_1 = "-";
}
$txt = $pdf->conv("$numP4_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class5_1!=""){
$class5_1 = number_format($class5_1,0,'.',','); 
}else{
$class5_1 = "-";
}
$txt = $pdf->conv("$class5_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP5_1!=""){
$numP5_1 = number_format($numP5_1,3,'.',','); 
}else{
$numP5_1 = "-";
}
$txt = $pdf->conv("$numP5_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class6_1!=""){
$class6_1 = number_format($class6_1,0,'.',','); 
}else{
$class6_1 = "-";
}
$txt = $pdf->conv("$class6_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP6_1!=""){
$numP6_1 = number_format($numP6_1,3,'.',','); 
}else{
$numP6_1 = "-";
}
$txt = $pdf->conv("$numP6_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($sumClassT2!=""){
$sumClassT2 = number_format($sumClassT2,0,'.',','); 
}else{
$sumClassT2 = "-";
}
$txt = $pdf->conv("$sumClassT2");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($sumNumT2!=""){
$sumNumT2 = number_format($sumNumT2,3,'.',','); 
}else{
$sumNumT2 = "-";
}
$txt = $pdf->conv("$sumNumT2");
$pdf->Cell(7,5,$txt,1,0,'C',false);




if($sumClassT3!=""){
$sumClassT3 = number_format($sumClassT3,0,'.',','); 
}else{
$sumClassT3 = "-";
}
$txt = $pdf->conv("$sumClassT3");
$pdf->Cell(21,5,$txt,1,0,'C',false);

if($sumNumT3!=""){
$sumNumT3 = number_format($sumNumT3,3,'.',','); 
}else{
$sumNumT3 = "-";
}
$txt = $pdf->conv("$sumNumT3");
$pdf->Cell(21,5,$txt,1,0,'C',false);



$pdf->Cell(23,5,'',1,1,'C',false);



$i++;
$j++;


 
  


  
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
	//$sum_amount_way="";


 
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
    




$sumClassT3="";
$sumNumT3="";

  $sum_amount_phase_way="";
 $perNum="";

 if($j == 26)
   {
     $j = 1;
	 $pdf->AliasNbPages( 'tp' );
    $pdf->AddPage();
	
	$pdf->Cell(255);
$pdf->SetFont('AngsanaNew', 'B', 10);
$txt = $pdf->conv("แบบ ทถ.7");
$pdf->Cell(20, 10, $txt, 1, 1, 'C');  

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("ตารางสรุปการลงทะเบียนทางหลวงท้องถิ่น");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("ในเขตพื้นที่ สำนักทางหลวงชนบทจังหวัด$rsN[name_province] $rsN[name_residence] กรมทางหลวงชนบท กระทรวงคมนาคม");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("รายงานเมื่อ $dd");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    

$pdf->Ln(10);




$pdf->SetFillColor(237,237,237);
$pdf->SetFont('AngsanaNew', 'B', 7);

$pdf->SetY(40); 
$pdf->SetX(5);
$txt = $pdf->conv("ชื่อ อปท.");
$pdf->Cell(24,20,$txt,1,0,'C',true);


$pdf->SetY(40); 
$pdf->SetX(29);
$txt = $pdf->conv("ถนนในเขตเมือง/ในเขตชุมชน");
$pdf->Cell(84,5,$txt,'1',0,'C',true);

$pdf->SetY(40); 
$pdf->SetX(113);
$txt = $pdf->conv("ถนนนอกเขตเมือง/นอกเขตชุมชน");
$pdf->Cell(112,5,$txt,'1',0,'C',true);


$pdf->SetY(40); 
$pdf->SetX(225);
$txt = $pdf->conv("ความก้าวหน้าของการลงทะเบียน");
$pdf->Cell(42,5,$txt,'1',0,'C',true);

$pdf->SetY(40); 
$pdf->SetX(267);
$txt = $pdf->conv("หมายเหตุ");
$pdf->Cell(23,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(29);
$txt = $pdf->conv("ชั้นพิเศษ");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(43);
$txt = $pdf->conv("ชั้นที่1");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(57);
$txt = $pdf->conv("ชั้นที่2");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(71);
$txt = $pdf->conv("ชั้นที่3");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(85);
$txt = $pdf->conv("ชั้นที่4");
$pdf->Cell(14,5,$txt,'1',0,'C',true);


$pdf->SetY(45); 
$pdf->SetX(99);
$txt = $pdf->conv("รวมในเขตชุมชน");
$pdf->Cell(14,5,$txt,'1',0,'C',true);


$pdf->SetY(45); 
$pdf->SetX(113);
$txt = $pdf->conv("ชั้นพิเศษ");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(127);
$txt = $pdf->conv("ชั้นที่1");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(141);
$txt = $pdf->conv("ชั้นที่2");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(155);
$txt = $pdf->conv("ชั้นที่3");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(169);
$txt = $pdf->conv("ชั้นที่4");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(183);
$txt = $pdf->conv("ชั้นที่5");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(197);
$txt = $pdf->conv("ชั้นที่6");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(211);
$txt = $pdf->conv("รวมนอกเขตชุมชน");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(225);
$txt = $pdf->conv("รวมทะเบียน");
$pdf->Cell(42,5,$txt,'1',0,'C',true);



$pdf->SetY(50); 
$pdf->SetX(29);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(36);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(43);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(50);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(57);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(64);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(71);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(78);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(85);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(92);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(99);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(106);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(113);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(120);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(127);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(134);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(141);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(148);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(155);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(162);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(169);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(176);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(183);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(190);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(197);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(204);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(211);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(218);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(225);
$txt = $pdf->conv("จำนวนสายทาง");
$pdf->Cell(21,10,$txt,'1',0,'C',true);



$pdf->SetY(50); 
$pdf->SetX(246);
$txt = $pdf->conv("ระยะทาง (กม.)");
$pdf->Cell(21,10,$txt,'1',0,'C',true);




$pdf->SetY(55); 
$pdf->SetX(29);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(36);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(43);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(50);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(57);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(64);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(71);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(78);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(85);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(92);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(99);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(106);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(113);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(120);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(127);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(134);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(141);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(148);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(155);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(162);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(169);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(176);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(183);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(190);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(197);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(204);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(211);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(218);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',1,'C',true);


   }
   }


    if($i>0){
	 // $sum_perClass=($sum_sumClassT3*100)/$sum_amount_wayS;
	 $pdf->SetFillColor(239,253,255);
	$pdf->SetFont('AngsanaNew', 'B', 7);


$txt = $pdf->conv("รวม");
$pdf->Cell(24,10,$txt,1,0,'C',true);


	
if($sum_c0!=""){

$sum_c0 = number_format($sum_c0,0,'.',','); 
}else{
$sum_c0 = "-";
}
$txt = $pdf->conv("$sum_c0");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p0!=""){
$sum_p0 = number_format($sum_p0,3,'.',','); 
}else{
$sum_p0 = "-";
}
$txt = $pdf->conv("$sum_p0");
$pdf->Cell(7,10,$txt,1,0,'C',true);
		
if($sum_c1!=""){

$sum_c1 = number_format($sum_c1,0,'.',','); 
}else{
$sum_c1 = "-";
}
$txt = $pdf->conv("$sum_c1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p1!=""){

$sum_p1 = number_format($sum_p1,3,'.',','); 
}else{
$sum_p1 = "-";
}
$txt = $pdf->conv("$sum_p1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_c2!=""){

$sum_c2 = number_format($sum_c2,0,'.',','); 
}else{
$sum_c2 = "-";
}
$txt = $pdf->conv("$sum_c2");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p2!=""){

$sum_p2 = number_format($sum_p2,3,'.',','); 
}else{
$sum_p2 = "-";
}
$txt = $pdf->conv("$sum_p2");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_c3!=""){

$sum_c3 = number_format($sum_c3,0,'.',','); 
}else{
$sum_c3 = "-";
}
$txt = $pdf->conv("$sum_c3");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p3!=""){

$sum_p3 = number_format($sum_p3,3,'.',','); 
}else{
$sum_p3 = "-";
}
$txt = $pdf->conv("$sum_p3");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_c4!=""){

$sum_c4 = number_format($sum_c4,0,'.',','); 
}else{
$sum_c4 = "-";
}
$txt = $pdf->conv("$sum_c4");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p4!=""){

$sum_p4 = number_format($sum_p4,3,'.',','); 
}else{
$sum_p4 = "-";
}
$txt = $pdf->conv("$sum_p4");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_sumClassT1!=""){

$sum_sumClassT1 = number_format($sum_sumClassT1,0,'.',','); 
}else{
$sum_sumClassT1 = "-";
}
$txt = $pdf->conv("$sum_sumClassT1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_sumNumT1!=""){

$sum_sumNumT1 = number_format($sum_sumNumT1,3,'.',','); 
}else{
$sum_sumNumT1 = "-";
}
$txt = $pdf->conv("$sum_sumNumT1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_c0_1!=""){

$sum_c0_1 = number_format($sum_c0_1,0,'.',','); 
}else{
$sum_c0_1 = "-";
}
$txt = $pdf->conv("$sum_c0_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p0_1!=""){

$sum_p0_1 = number_format($sum_p0_1,3,'.',','); 
}else{
$sum_p0_1 = "-";
}
$txt = $pdf->conv("$sum_p0_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_c1_1!=""){

$sum_c1_1 = number_format($sum_c1_1,0,'.',','); 
}else{
$sum_c1_1 = "-";
}
$txt = $pdf->conv("$sum_c1_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p1_1!=""){

$sum_p1_1 = number_format($sum_p1_1,3,'.',','); 
}else{
$sum_p1_1 = "-";
}
$txt = $pdf->conv("$sum_p1_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);


if($sum_c2_1!=""){

$sum_c2_1 = number_format($sum_c2_1,0,'.',','); 
}else{
$sum_c2_1 = "-";
}
$txt = $pdf->conv("$sum_c2_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p2_1!=""){

$sum_p2_1 = number_format($sum_p2_1,3,'.',','); 
}else{
$sum_p2_1 = "-";
}
$txt = $pdf->conv("$sum_p2_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);


if($sum_c3_1!=""){

$sum_c3_1 = number_format($sum_c3_1,0,'.',','); 
}else{
$sum_c3_1 = "-";
}
$txt = $pdf->conv("$sum_c3_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p3_1!=""){

$sum_p3_1 = number_format($sum_p3_1,3,'.',','); 
}else{
$sum_p3_1 = "-";
}
$txt = $pdf->conv("$sum_p3_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);


if($sum_c4_1!=""){

$sum_c4_1 = number_format($sum_c4_1,0,'.',','); 
}else{
$sum_c4_1 = "-";
}
$txt = $pdf->conv("$sum_c4_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p4_1!=""){

$sum_p4_1 = number_format($sum_p4_1,3,'.',','); 
}else{
$sum_p4_1 = "-";
}
$txt = $pdf->conv("$sum_p4_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);


if($sum_c5_1!=""){

$sum_c5_1 = number_format($sum_c5_1,0,'.',','); 
}else{
$sum_c5_1 = "-";
}
$txt = $pdf->conv("$sum_c5_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p5_1!=""){

$sum_p5_1 = number_format($sum_p5_1,3,'.',','); 
}else{
$sum_p5_1 = "-";
}
$txt = $pdf->conv("$sum_p5_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);


if($sum_c6_1!=""){

$sum_c6_1 = number_format($sum_c6_1,0,'.',','); 
}else{
$sum_c6_1 = "-";
}
$txt = $pdf->conv("$sum_c6_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p6_1!=""){

$sum_p6_1 = number_format($sum_p6_1,3,'.',','); 
}else{
$sum_p6_1 = "-";
}
$txt = $pdf->conv("$sum_p6_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_sumClassT2!=""){

$sum_sumClassT2 = number_format($sum_sumClassT2,0,'.',','); 
}else{
$sum_sumClassT2 = "-";
}
$txt = $pdf->conv("$sum_sumClassT2");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_sumNumT2!=""){

$sum_sumNumT2 = number_format($sum_sumNumT2,3,'.',','); 
}else{
$sum_sumNumT2 = "-";
}
$txt = $pdf->conv("$sum_sumNumT2");
$pdf->Cell(7,10,$txt,1,0,'C',true);



if($sum_sumClassT3!=""){

$sum_sumClassT3 = number_format($sum_sumClassT3,0,'.',','); 
}else{
$sum_sumClassT3 = "-";
}
$txt = $pdf->conv("$sum_sumClassT3");
$pdf->Cell(21,10,$txt,1,0,'C',true);

if($sum_sumNumT3!=""){

$sum_sumNumT3 = number_format($sum_sumNumT3,3,'.',','); 
}else{
$sum_sumNumT3 = "-";
}
$txt = $pdf->conv("$sum_sumNumT3");
$pdf->Cell(21,10,$txt,1,0,'C',true);

}


$pdf->Cell(23,10,'',1,1,'C',false);




$pdf->Output();
//}
 
	?>

	






