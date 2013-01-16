<?php
require('fpdf.php');
class PDF extends FPDF {
	
	
	function conv($string) {
		return iconv('UTF-8', 'windows-874', $string);
	}
 }
$pdf2= new PDF( 'L' , 'mm' , 'A4' );

$pdf2->AddPage();
$pdf2->SetFont('Arial','B',16);
$pdf2->Text( 10 , 10 , 'Hello World!');

$txt = $pdf2->conv("1234");
$pdf2->Cell(14,5,$txt,'1',0,'C',true);

$txt = "123456789";
$pdf2->Cell(14,5,$txt,'1',0,'C',true);


$sum_perNum = number_format(123.900,2,'.',',');
$txt = $pdf2->conv("$sum_perNum%");
$pdf2->Cell(25,10,$txt,1,1,'C',true);

$pdf2->Output();
?>