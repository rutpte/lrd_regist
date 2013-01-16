<?php 

//We've included ../Includes/FusionCharts.php, which contains functions
//to help us easily embed the charts.
//$id_residence=$_GET['id_residence'];
include("Includes/FusionCharts.php");
include("Includes/DBConn.php");
$link = connectToDB();
//include "chksession.php";
$list_year=$_GET['list_year'];
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
        <title>แผนภูมิความก้าวหน้า สรุปการลงทะเบียนทางหลวงท้องถิ่นรายสำนักทางหลวงชนบท</title>
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
   <br/>

<table width="787" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#6699FF">
 
    <td width="313" rowspan="3" class="th12bblue" align="center">ชื่อสำนักทางหลวงชนบท</td>
  
    <td colspan="4" class="th12bblue" align="center">ความก้าวหน้าของการลงทะเบียน</td>
  </tr>
  <tr bgcolor="#6699FF">

  

   
    <td width="218" rowspan="2" align="center" class="th12bblue">จำนวนของระยะทางเป้าหมาย (กม.)</td>
	<td colspan="2" class="th12bblue" align="center">สายทางที่ลงทะเบียน</td>

		<td width="149" rowspan="2" align="center" class="th12bblue">คิดเป็นร้อยละของระยะทาง(กม.)</td>
  </tr>
  <tr bgcolor="#6699FF">
    <td width="116" class="th12bblue" align="center">จำนวนสายทาง(สาย)</td>
    <td width="92" class="th12bblue" align="center">ระยะทาง(กม.)</td>
  </tr>


 
<?  
$sqlR="select * from residence  order by `residence`.id_residence desc
";
$resultR=mysql_query($sqlR) or die(mysql_error());
	$sqlSa1="SELECT  
sum(annual_way.amount_phase_way) as sum_amount_phase_wayS
FROM `annual_way` where  id_annual!='' and list_year='$list_year' 
";
 $resultSa1=mysql_query($sqlSa1) or die(mysql_error());
   $rsSa1=mysql_fetch_array($resultSa1);

$sum_amount_phase_wayS=$rsSa1['sum_amount_phase_wayS'];
while($rsR=mysql_fetch_array($resultR)){
	  $sqlSa="SELECT
sum(annual_way.amount_phase_way) as sum_pw

FROM
annual_way
Inner Join province ON province.id_province = annual_way.id_province
Inner Join residence ON residence.id_residence = province.id_residence
WHERE  `residence`.`id_residence`='$rsR[id_residence]' and list_year='$list_year' 

ORDER BY `residence`.id_residence DESC ";
 $resultSa=mysql_query($sqlSa) or die(mysql_error());
   $rsSa=mysql_fetch_array($resultSa);
  
//$sum_amount_way+=$rsSa['amount_way'];
$sum_amount_phase_way+=$rsSa['sum_pw'];
$sqlSum="SELECT `register_road`.distance_road as sum_dis
FROM
  `residence`
  INNER JOIN `province` ON (`residence`.`id_residence` = `province`.`id_residence`)
  INNER JOIN `municipality` ON (`province`.`id_province` = `municipality`.`id_province`)
  INNER JOIN `register_road` ON (`municipality`.`id_mun` = `register_road`.`id_mun`)
  where `register_road`.id_regis_detail!=0 and `residence`.`id_residence`='$rsR[id_residence]'";

  $resultSum= mysql_query($sqlSum) or die(mysql_error());
  $num_rowS=mysql_num_rows($resultSum);
  
   $dis_sum=0;  
   while($rsSum=mysql_fetch_array($resultSum)){

	 $dis_sum+=$rsSum['sum_dis'];   
	
  }
	 if($rsSa['sum_pw']!=0){
 $sum_perC2=($dis_sum*100)/$rsSa['sum_pw'];
  }
	/*   

 

  // $sum_perC1=($num_rowS*100)/$rsSa1['sum_amount_wayS'];
  if($rsSa1['sum_amount_phase_wayS']!=0){
 $sum_perC2=($dis_sum*100)/$rsSa1['sum_amount_phase_wayS'];
  }*/
?>
<tr >
    <td class="th11bblack" align="left">&nbsp;<? echo $rsR['name_residence'];?></td>
    <td align="center" class="th11bblack"><? echo number_format($sum_amount_phase_way,3,'.',',');?></td>
    <td class="th11bblack" align="center"><? echo number_format($num_rowS,0,'.',',');?></td>
    <td class="th11bblack" align="center"><? echo number_format($dis_sum,3,'.',',');?></td>
    <td align="center" class="th11bblack"><? echo number_format($sum_perC2,2,'.',',');?>%</td>
  </tr>

<? 
$sum_num+=$num_rowS;
$sum_dis+=$dis_sum;
if($sum_amount_phase_wayS!=""){
  //$sum_perClass=($sum_sumClassT3*100)/$sum_amount_wayS;
  $sum_perNum=($sum_dis*100)/$sum_amount_phase_wayS;
	}

}?>
<tr >
  <td class="th11bblack" align="center">รวมทั้งหมด</td>
  <td align="center" class="th11bblack"><? echo number_format($sum_amount_phase_wayS,3,'.',',');?></td>
  <td class="th11bblack" align="center"><? echo number_format($sum_num,3,'.',',');?></td>
  <td class="th11bblack" align="center"><? echo number_format($sum_dis,3,'.',',');?></td>
  <td align="center" class="th11bblack"><? echo number_format($sum_perNum,2,'.',',');?></td>
</tr>
</table>
 <div align="center">
 <?
	
						

		$sqlR="select id_residence,num_residence,name_residence from residence order by id_residence desc";
  $resultR=mysql_query($sqlR) or die(mysql_error());
 $sqlT="SELECT
target

FROM
annual_way where list_year='$list_year' ";
$resultT=mysql_query($sqlT) or die(mysql_error());
$rsT=mysql_fetch_array($resultT);
$target=$rsT['target'];

  $i=0;
  while($rsR=mysql_fetch_array($resultR)){  
 // $arrData[$i][1] = "สทช. ที่".$rsR['num_residence']; 
  $sqlSa="SELECT
annual_way.amount_phase_way

FROM
annual_way
Inner Join province ON province.id_province = annual_way.id_province
Inner Join residence ON residence.id_residence = province.id_residence
WHERE  `residence`.`id_residence`='$rsR[id_residence]' and  list_year='$list_year' 

ORDER BY `residence`.id_residence desc ";
  $resultSa=mysql_query($sqlSa) or die(mysql_error());
   while($rsSa=mysql_fetch_array($resultSa)){

//$sum_amount_way+=$rsSa['amount_way'];
$sum_amount_phase_way+=$rsSa['amount_phase_way'];
}

 $sqlSum="SELECT `register_road`.distance_road as sum_dis
FROM
  `residence`
  INNER JOIN `province` ON (`residence`.`id_residence` = `province`.`id_residence`)
  INNER JOIN `municipality` ON (`province`.`id_province` = `municipality`.`id_province`)
  INNER JOIN `register_road` ON (`municipality`.`id_mun` = `register_road`.`id_mun`)
  where `register_road`.id_regis_detail!=0 and `residence`.`id_residence`='$rsR[id_residence]'";

  $resultSum= mysql_query($sqlSum) or die(mysql_error());
  $num_rowS=mysql_num_rows($resultSum);
   $dis_sum=0;  
    while($rsSum=mysql_fetch_array($resultSum)){

	 $dis_sum+=$rsSum['sum_dis'];   
	
  }
    if($sum_amount_phase_way!=""){
$sapw="100";
		 $per_dis= ($dis_sum*100)/$sum_amount_phase_way;
	   }else{
		$sapw="";   
		 $per_dis="";
	   }
	   
	   		$arrData[$i][2] =  $per_dis; 
                          
                  $arrData[$i][3] =  $sapw;
                       
                      $i++; 
                 // $sum_amount_way="";   
				  $sum_amount_phase_way="";      
  }
  
  //divLineAlpha='80' numdivlines='5' decimalPrecision='0' numberPrefix='$' numberSuffix='M' 
	$strXML = "<graph caption='แผนภูมิความก้าวหน้า สรุปการลงทะเบียนทางหลวงท้องถิ่นรายสำนักทางหลวงชนบท ปี $list_year'  subCaption='กำหนดเป้าหมายไว้ที่ร้อยละ $target'  baseFontSize='14' baseFontColor='000000'   rotateNames='0' showNames='1' showValues='1'   formatNumberScale='0' anchorRadius='3' decimalSeparator='.' thousandSeparator=',' divLineAlpha='80' numdivlines='9' decimalPrecision='0' showLimits='1'   numberSuffix='%'  yAxisMaxValue='100' >";
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = "<categories>";
	
	//Initiate <dataset> elements
				
						//$strDataCurr ="<dataset seriesName='จำนวนระยะทางที่ลงทะเบียน(กม.)'   color='CC0000'>";
						$strDataCurr="<dataset seriesName='จำนวนระยะทางเป้าหมาย(กม.)'  color='CC0000'>";
			
	
	//Iterate through the data  
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= "<category name='" . $arSubData[1] . "'   />";
        //Add <set value='...' /> to both the datasets
        $strDataCurr .= "<set value='" . $arSubData[2] . "'  />";
       // $strDataPrev .= "<set value='" . $arSubData[3] . "' />";

	}
	
	//Close <categories> element
	$strCategories .= "</categories>";
	
	//Close <dataset> elements
 						$strDataCurr .= "</dataset>";
                        //$strDataPrev .= "</dataset>";
					
					
	
	//Assemble the entire XML now
	$ss= "<trendlines>        <line startValue='50' endValue='50' color='999999' displayValue='Target' thickness='2' alpha='100' showOnTop='1'/></trendlines>";
	 $strXML .= $strCategories . $strDataCurr .$ss. "</graph>";

	//Create the chart - MS Column 3D Chart with data contained in strXML
	echo renderChart("FusionCharts/FCF_MSBar2D.swf", "", $strXML, "graph10", 1024, 1024);
?></div>


</BODY>
</HTML>