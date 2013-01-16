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
 $rs=pg_fetch_row($result);
 
 $sql1="SELECT distance_total
 from way
 INNER JOIN register_road_detail ON (way.way_id=register_road_detail.way_id)
 where id_regis_detail!=0 ";
$result1=pg_query($link,$sql1) or die(pg_last_error($link));
 //pg_num_rows
$numS1=pg_num_rows($result1);
 while($rs1=pg_fetch_row($result1)){
	$sum_d+=$rs1['distance_total'];
 }
 //$sum_perC1=($numS1*100)/$rs['sum_amount_way'];
 $sum_perC2=($sum_d*100)/$rs['sum_apw'];
 ?><br/>
 <table align="center" border="1" width="680" cellpadding="0" cellspacing="0">
<tr bgcolor="#6699FF">
  <td align="center" colspan="4" class="th12bblue">ความก้าวหน้าของการลงทะเบียนของปี พ.ศ. <? echo $list_year;?></td></tr>
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
	
						

		$sqlR="select id_residence,num_residence from residence order by id_residence desc";
  $resultR=pg_query($link,$sqlR) or die(pg_last_error($link));


  $i=0;
  while($rsR=pg_fetch_row($resultR)){
  $arrData[$i][1] = "สทช. ที่";    //ต่อจาก ที่.$rsR['num_residence']
  $sqlSa="SELECT
annual_way.amount_phase_way

FROM
annual_way
Inner Join province ON province.province_id = annual_way.id_province
Inner Join residence ON residence.id_residence = province.id_residence
WHERE  residence.id_residence='$rsR[id_residence]' and  list_year='$list_year' 

ORDER BY residence.id_residence desc ";
  $resultSa=pg_query($link,$sqlSa) or die(pg_last_error($link));
   while($rsSa=pg_fetch_row($resultSa)){

//$sum_amount_way+=$rsSa['amount_way'];
$sum_amount_phase_way+=$rsSa['amount_phase_way'];
}

 $sqlSum="SELECT way.distance_total as sum_dis
FROM
  residence
  INNER JOIN province ON (residence.id_residence = province.id_residence)
   INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (org_comunity.amphur_id = amphur.amphur_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)
  INNER JOIN register_road_detail ON (register_road_detail.way_id=way.way_id)
  where register_road_detail.id_regis_detail!=0 and residence.id_residence='$rsR[id_residence]'";

  $resultSum= pg_query($link,$sqlSum) or die(pg_last_error($link));
  $num_rowS=pg_num_rows($resultSum);
   $dis_sum=0;  
    while($rsSum=pg_fetch_row($resultSum)){
     //pg_fetch_row($result)
	 $dis_sum+=$rsSum['sum_dis'];   
	
  }
    if($sum_amount_phase_way!=""){
$sapw=$sum_amount_phase_way;  
		 $per_dis=$dis_sum;
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
	$strXML = "<graph caption='แผนภูมิความก้าวหน้า สรุปการลงทะเบียนทางหลวงท้องถิ่นทั้งประเทศ'   baseFontSize='14' baseFontColor='000000'   rotateNames='0' showNames='1' showValues='1'   formatNumberScale='0' anchorRadius='3' decimalSeparator='.' thousandSeparator=',' divLineAlpha='80' numdivlines='12' decimalPrecision='0' showLimits='0'   >";
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = "<categories>";
	
	//Initiate <dataset> elements
				
						$strDataCurr ="<dataset seriesName='จำนวนระยะทางที่ลงทะเบียน(กม.)'   color='CC0000'>";
						$strDataPrev="<dataset seriesName='จำนวนระยะทางเป้าหมาย(กม.)'  color='0033FF'>";
			
	
	//Iterate through the data  
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= "<category name='" . $arSubData[1] . "'   />";
        //Add <set value='...' /> to both the datasets
        $strDataCurr .= "<set value='" . $arSubData[2] . "'  />";
        $strDataPrev .= "<set value='" . $arSubData[3] . "' />";

	}
	
	//Close <categories> element
	$strCategories .= "</categories>";
	
	//Close <dataset> elements
 						$strDataCurr .= "</dataset>";
                        $strDataPrev .= "</dataset>";
					
					
	
	//Assemble the entire XML now
	 $strXML .= $strCategories . $strDataCurr . $strDataPrev .  "</graph>";
	
	//Create the chart - MS Column 3D Chart with data contained in strXML
	echo renderChart("FusionCharts/FCF_MSBar2D.swf", "", $strXML, "graph10", 1024, 1024);
?></div>


</BODY>
</HTML>