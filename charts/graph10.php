<?php 

//We've included ../Includes/FusionCharts.php, which contains functions
//to help us easily embed the charts.
//$id_residence=$_GET['id_residence'];
include("Includes/FusionCharts.php");
include("Includes/DBConn.php");
$link = connectToDB();
//$link = pg_connect("host=localhost port=5432 dbname=drr_cld_dbX user=postgres password=pgpteadmin");
//var_dump(pg_connect("host=localhost port=5432 dbname=drr_cld_dbX user=postgres password=pgpteadmin")); //exit;
//include "chksession.php";
$list_year=$_GET['list_year'];
$show 		= $_GET['show'];
if($show==1){
$dd1 = "";
}else if($show==2){
 $show_date = date('Y-m-d',strtotime($_GET['s_date']));
 $end_date = date('Y-m-d',strtotime($_GET['e_date']));
 $con="and way.cre_date between '$show_date' and '$end_date'";
$dd1=displaydateS($show_date)." ถึง วันที่ ".displaydateS($end_date);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML>
    
<link href="../css/register.css" rel="stylesheet" type="text/css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
@media print {
				input#printButton 
					{
						display: none;
					}
				input#pic_print 
					{
						display: none;
					}
			}
</style>
<script type ="text/javascript" language="javascript" >
function resize_(){
  window.resizeTo(screen.width,screen.availHeight);

	moveTo(0,0);
}
</script>
        <title>แผนภูมิความก้าวหน้า สรุปการลงทะเบียนทางหลวงท้องถิ่นทั้งประเทศ</title>
	<?php
	//You need to include the following JS file, if you intend to embed the chart using JavaScript.
	//Embedding using JavaScripts avoids the "Click to Activate..." issue in Internet Explorer
	//When you make your own charts, make sure that the path to this JS file is correct. Else, you would get JavaScript errors.
	?>	
	<SCRIPT LANGUAGE="Javascript" SRC="FusionCharts/FusionCharts.js"></SCRIPT>
	<style type="text/css">
	<!--
	body {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 14px; 
	}
	-->
	</style>
</HEAD>

<body onload="javascript:resize_();">

<div align="center">

<input name="pic_print" id="pic_print" type="image"   src="b_print.gif" onClick="javascript:window.print();"/>
  <input type="button" id="printButton" onClick="javascript:window.print();" value="พิมพ์กราฟ"  />
</div>
    <?
$sql="SELECT sum(amount_phase_way) as sum_apw
from annual_way where list_year='$list_year' ";
$result=pg_query($link,$sql) or die(pg_last_error($link));
 $rs=pg_fetch_array($result);

 //var_dump($rs['sum_apw']); exit;
 
 $sql1="SELECT way.distance_total
FROM
  residence
  INNER JOIN province ON (residence.id_residence = province.id_residence)
 INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (org_comunity.amphur_id = amphur.amphur_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)

  where (way.active='t') and way.flag_reg_road='t' $con";
$result1=pg_query($link,$sql1) or die(pg_last_error($link));
 
$numS1=pg_num_rows($result1);
 while($rs1=pg_fetch_array($result1)){
	$sum_d+=$rs1['distance_total'];
 }
 //$sum_perC1=($numS1*100)/$rs['sum_amount_way'];
 $sum_perC2=($sum_d*100)/$rs['sum_apw'];
 ?><br/><table width="680" border="0" cellpadding="0" align="center">
  <tr>
    <td align="center" class="th_head_back14">ตารางสรุปความก้าวหน้าการลงทะเบียนทางหลวงท้องถิ่นทั่วทั้งประเทศ ปี  พ.ศ.<? echo $list_year;?></td>
  </tr>
  <? if($show==2){?>
   <tr>
    <td align="center" class="th_red12b">ตั้งแต่วันที่ <? echo $dd1;?></td>
  </tr><? }?>
</table>
<br/>
 <table align="center" border="1" width="680" cellpadding="0" cellspacing="0">
<tr bgcolor="#6699FF">
  <td align="center" colspan="4" class="th12bblue">ความก้าวหน้าของการลงทะเบียนของปี พ.ศ.<? echo $list_year;?></td></tr>
 <tr bgcolor="#6699FF">
   <td width="190" rowspan="2" align="center" class="th12bblue">จำนวนของระยะทางเป้าหมาย (กม.)</td><td align="center" colspan="2" class="th12bblue">สายทางที่ลงทะเบียน</td><td width="174" rowspan="2" align="center" class="th12bblue">คิดเป็นร้อยละของระยะทาง(กม.)</td></tr>
 <tr bgcolor="#6699FF" ><td width="140" align="center" class="th12bblue">จำนวนสายทาง(สาย)</td><td width="166" align="center" class="th12bblue">ระยะทาง(กม.)</td></tr>
 <tr>
   <td align="center" class="th11bblack"><? echo number_format($rs['sum_apw'],3,'.',',');?></td>
   <td align="center" class="th11bblack"><? echo number_format($numS1,0,'.',',');?></td>
   <td align="center" class="th11bblack"><? echo number_format($sum_d,3,'.',',');?></td>
   <td align="center" class="th11bblack"><? echo number_format($sum_perC2,2,'.',',');?>%</td>
   </tr>
 </table>
 
 <?
	
						

	
  $sqlSa="SELECT
sum(annual_way.amount_phase_way) as sum_aw

FROM
annual_way

WHERE   list_year='$list_year' 

";
  $resultSa=pg_query($link,$sqlSa) or die(pg_last_error($link));
   $rsSa=pg_fetch_array($resultSa);

//$sum_amount_way+=$rsSa['amount_way'];
$sum_amount_phase_way=$rsSa['sum_aw'];



 
 


 $sqlSum="SELECT way.distance_total as sum_dis
FROM
  residence
  INNER JOIN province ON (residence.id_residence = province.id_residence)
   INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (org_comunity.amphur_id = amphur.amphur_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)

  where (way.active='t') and way.flag_reg_road='t' $con";

  $resultSum= pg_query($link,$sqlSum) or die(pg_last_error($link));   //pg_last_error($link)
 $num_rowS=pg_num_rows($resultSum);
       //pg_num_rows
    while($rsSum=pg_fetch_array($resultSum)){

	 $dis_sum+=$rsSum['sum_dis'];   
	}
 
    if($sum_amount_phase_way!=""){
$sapw=$sum_amount_phase_way-$dis_sum;
		 $per_dis=  $dis_sum;
	   }else{
		$sapw="";   
		 $per_dis="";
	   }
	   
	   	
              
   
  
  //divLineAlpha='80' numdivlines='5' decimalPrecision='0' numberPrefix='$' numberSuffix='M' 
	$strXML = "<graph caption='แผนภูมิความก้าวหน้า สรุปการลงทะเบียนทางหลวงท้องถิ่นทั้งประเทศ ปี พ.ศ.$list_year'   baseFontSize='14' baseFontColor='950C0C'   rotateNames='0' showNames='1' showValues='1'   formatNumberScale='0' anchorRadius='3' decimalSeparator='.' thousandSeparator=',' divLineAlpha='80' numdivlines='12' decimalPrecision='0' showLimits='0' showPercentageValues='0'  showPercentageInLabel ='1'  >";
	//Initialize <categories> element - necessary to generate a multi-series chart

	
	//Initiate <dataset> elements  $strXML .= "<set name='Salads' value='" . $intSalads . "' />";
   $strXML .= "<set name='จำนวนระยะทางเป้าหมายคงเหลือ' value='" . $sapw. "' color='0033FF' />";
   $strXML .= "<set name='จำนวนระยะทางที่ลงทะเบียน' value='" . $per_dis. "' color='CC0000'/>";

	/*				$strDataPrev="<set name='จำนวนระยะทางเป้าหมายคงเหลือ(กม.)'  color='CC0000'>";
					$strDataCurr ="<set name='จำนวนระยะทางที่ลงทะเบียน(กม.)'   color='0033FF'>";*/
						
			

					
					
	
	//Assemble the entire XML now
	 $strXML .=   "</graph>";
	
	//Create the chart - MS Column 3D Chart with data contained in strXML
	echo renderChart("FusionCharts/FCF_Pie3D.swf", "", $strXML, "graph10", 800, 400);
?></div>


</BODY>
</HTML>