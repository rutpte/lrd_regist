<?php
require('fpdf.php');
class PDF extends FPDF {
	
	
	function conv($string) {
		return iconv('UTF-8', 'windows-874', $string);
	}
 }
$pdf2=new PDF();
$pdf2->AddPage();
$pdf2->SetFont('Arial','B',16);
$pdf2->Text( 10 , 10 , 'Hello World!');

$txt = $pdf2->conv("ชั้นที่4");
$pdf2->Cell(14,5,$txt,'1',0,'C',true);

$txt = "ชั้นพิเศษ";
$pdf2->Cell(14,5,$txt,'1',0,'C',true);
$pdf2->Output();
?>