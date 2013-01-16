<?php session_start();
 //  include "../header.php";
//We've included ../Includes/FusionCharts.php, which contains functions
//to help us easily embed the charts.
$id_residence=$_GET['id_residence'];
include("Includes/FusionCharts.php");
include("Includes/DBConn.php");
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
$link = connectToDB();
//$link = pg_connect("host=localhost port=5432 dbname=drr_cld_dbX user=postgres password=pgpteadmin");
//include "chksession.php"; //ถ้าไม่ได้อาจต้องปิดตัวนี้
$sqlI="SELECT province.province_id,province.province_name
FROM
  province
  INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (org_comunity.amphur_id = amphur.amphur_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)

  where  province.id_residence='$id_residence' and (way.active='t') and way.flag_reg_road='t' $con
  GROUP BY province.province_id,province.province_name,province.num_orders
 order by province.num_orders asc
 "; //เลือก อำเภอ และ ไอดี
 /*
 new
 SELECT province.province_id,province.province_name,way.orgc_id
FROM
  province
INNER JOIN amphur ON (amphur.province_id=province.province_id)
INNER JOIN org_comunity ON (org_comunity.amphur_id=amphur.amphur_id)
INNER JOIN way ON (org_comunity.orgc_id=way.orgc_id)
 INNER JOIN register_road_detail ON (way.way_id=register_road_detail.way_id)
  where  register_road_detail.id_regis_detail!=0 and province.id_residence='$id_residence' $con
   GROUP BY province.province_id,province.province_name,way.orgc_id,province.num_orders
  order by province.num_orders asc
 */

  //new  GROUP BY province.province_id,province.province_name,way.orgc_id,province.num_orders


     /////////////////////////////////
   /*
$sq="SELECTy province.province_id,province.province_name,way.orgc_id
FROM
  province
  INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (org_comunity.amphur_id = amphur.amphur_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)
  INNER JOIN register_road_detail ON (way.way_id=register_road_detail.way_id)
  where  register_road_detail.id_regis_detail!=0  and province.id_residence='$id_residence' $con
  GROUP BY province.province_id,province.province_name,way.orgc_id,province.num_orders
 order by province.num_orders asc ";
   $result2=$db->query($sq);
   */
   ///////////////////////////////////////////////////////////////
   $resultI= pg_query($link,$sqlI) or die(pg_last_error($link));  //pg_fetch_array
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML>
    

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="../css/register.css" rel="stylesheet" type="text/css" />
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
        <title>แผนภูมิความก้าวหน้า สรุปการลงทะเบียนทางหลวงท้องถิ่น (ทถ.8)</title>
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
<? if($_SESSION['LOGTYPE']!=5){?>
<div align="center">

<input name="pic_print" id="pic_print" type="image"   src="b_print.gif" onClick="javascript:window.print();"/>
  <input type="button" id="printButton" onClick="javascript:window.print();" value="พิมพ์กราฟ"  />
</div><? }?><br/><table width="680" border="0" cellpadding="0" align="center">
  <tr>
    <td align="center" class="th_head_back14">ตารางสรุปความก้าวหน้าการลงทะเบียนทางหลวงท้องถิ่นของ ทชจ. ปี พ.ศ.<? echo $list_year;?></td>
  </tr>
  <? if($show==2){?>
   <tr>
    <td align="center" class="th_red12b">ตั้งแต่วันที่ <? echo $dd1;?></td>
  </tr><? }?>
</table><br/>
<table width="787" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#6699FF">
 
    <td width="313" rowspan="3" class="th12bblue" align="center">ชื่อ ทชจ. </td>
  
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
while($rsI=pg_fetch_array($resultI)){
	   	    $sqlSa1="
  SELECT sum(amount_phase_way) as sum_amount_phase_ways
from
   annual_way
where annual_way.id_province='$rsI[province_id]'  and  list_year='$list_year'
";   //นี่คือค่า เป้าหมายระยะทาง ของปี และ อำเภอ ในเงื่อนใข

  $resultSa1= pg_query($link,$sqlSa1) or die(pg_last_error($link));

 $rsSa1=pg_fetch_array($resultSa1);
/////////////////////////////////////////////////////
 
$sqlSum="SELECT way.distance_total as sum_dis
FROM
  residence
  INNER JOIN province ON (residence.id_residence = province.id_residence)
  INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (org_comunity.amphur_id = amphur.amphur_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)

  where province.province_id='$rsI[province_id]' and (way.active='t') and way.flag_reg_road='t' $con
      GROUP BY way.way_id,distance_total
 ";     /*   GROUP BY way.way_id,distance_total
      old
     SELECT way.distance_total as sum_dis
FROM
  residence
  INNER JOIN province ON (residence.id_residence = province.id_residence)
  INNER JOIN org_comunity ON (province.province_id = org_comunity.province_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)
  where way.id_regis_detail!=0 and province.province_id='$rsI[province_id]' $con";

      */
      /*
      SELECT way.distance_total as sum_dis
FROM
  residence
  INNER JOIN province ON (residence.id_residence = province.id_residence)
  INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (org_comunity.amphur_id = org_comunity.amphur_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)
  INNER JOIN register_road_detail ON (way.way_id=register_road_detail.way_id)
  where register_road_detail.id_regis_detail!=0
 GROUP BY way.way_id,distance_total
      */
  $resultSum= pg_query($link,$sqlSum) or die(pg_last_error($link));
  $num_rowS=pg_num_rows($resultSum);
   $dis_sum=0;  
   while($rsSum=pg_fetch_array($resultSum)){

	 $dis_sum+=$rsSum['sum_dis'];   
	
  }
  // $sum_perC1=($num_rowS*100)/$rsSa1['sum_amount_wayS'];
  if($rsSa1['sum_amount_phase_ways']!=0){
 $sum_perC2=($dis_sum*100)/$rsSa1['sum_amount_phase_ways'];
  }
?>
<tr >
    <td class="th11bblack" align="left">&nbsp;<? echo $rsI['province_name'];?></td>
    <td align="center" class="th11bblack"><? echo number_format($rsSa1['sum_amount_phase_ways'],3,'.',',');?></td>
    <td class="th11bblack" align="center"><? echo number_format($num_rowS,0,'.',',');?></td>
    <td class="th11bblack" align="center"><? echo number_format($dis_sum,3,'.',',');?></td>
    <td align="center" class="th11bblack"><? echo number_format($sum_perC2,2,'.',',');?>%</td>
  </tr>
<?   $sum_perC2="";} //end while rsI


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

</table>
<div align="center">
    <?php
				
              $sql="SELECT *
FROM
  residence   INNER JOIN province ON (residence.id_residence = province.id_residence)
where province.id_residence='$id_residence' 
  order by province.num_orders ASC  ";  //เลือก  ทั้งหมด residence,province ที่อำเภอมี่ค่า เท่ากับ id_residence ที่กำหนด
   $result = pg_query($link,$sql) or die(pg_last_error($link));
   $i=0;
  while($rs=pg_fetch_array($result)){    //แต่ละรอบของการ getch id_residence
  $name_residence=$rs['name_residence'];
                    $j=$i+1;         
						$arrData[$i][1] =$rs['province_name'];
					
$sqlSa="SELECT annual_way.amount_phase_way
FROM
   province
 INNER JOIN annual_way ON province.province_id = annual_way.id_province
 where province.province_id='$rs[province_id]' and  list_year='$list_year'
 order by province.num_orders ASC  ";

 $resultSa=pg_query($link,$sqlSa) or die(pg_last_error($link));
   while($rsSa=pg_fetch_array($resultSa)){

//$sum_amount_way+=$rsSa['amount_way'];
$sum_amount_phase_way+=$rsSa['amount_phase_way'];
}
  $sqlSum="SELECT way.distance_total as sum_dis
FROM
  residence
  INNER JOIN province ON (residence.id_residence = province.id_residence)
  INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (amphur.amphur_id = org_comunity.amphur_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)
  INNER JOIN register_road_detail ON (way.way_id=register_road_detail.way_id)
  where register_road_detail.id_regis_detail!=0 and province.province_id='$rs[province_id]' $con
   GROUP BY way.way_id,way.distance_total
   ";//พระเอก group by
  /*    new GROUP BY way.way_id,way.distance_total
  old
   SELECT way.distance_total as sum_dis
FROM
  residence
  INNER JOIN province ON (residence.id_residence = province.id_residence)
  INNER JOIN org_comunity ON (province.province_id = org_comunity.province_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)
  where way.id_regis_detail!=0 and province.province_id='$rs[province_id]' $con";
  */
  /*
  new
  SELECT way.distance_total as sum_dis
FROM
  residence
  INNER JOIN province ON (residence.id_residence = province.id_residence)
  INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (amphur.amphur_id = org_comunity.amphur_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)
  INNER JOIN register_road_detail ON (way.way_id=register_road_detail.way_id)
  where register_road_detail.id_regis_detail!=0 
  */

  $resultSum= pg_query($link,$sqlSum) or die(pg_last_error($link));
  $num_rowS=pg_num_rows($resultSum);
   $dis_sum=0;  
   while($rsSum=pg_fetch_array($resultSum)){

	 $dis_sum+=$rsSum['sum_dis'];  //ค่า ระยะทางรวม ของจังหวัดที่กำหนด 
	
  }
	 
	     if($sum_amount_phase_way!=""){
		//$sapw=$sum_amount_phase_way;
		 $per_dis= ($dis_sum*100)/$sum_amount_phase_way;
	   }else{
		$sapw="";   
		 $per_dis="";
	   }

           
            
	
  
                        //Store sales data for current year
                
			   
						$arrData[$i][2] =   $per_dis; 
                        
						  
                      //  $arrData[$i][3] =  $sapw;
                       
                      $i++; 
                 // $sum_amount_way="";   
				  $sum_amount_phase_way="";  
				      
  }

	$strXML = "<graph caption='แผนภูมิความก้าวหน้าการลงทะเบียนทางหลวงท้องถิ่นของ ทชจ. ปี พ.ศ.$list_year'     baseFontSize='14' baseFontColor='000000'   rotateNames='0' showNames='1' showValues='1'   formatNumberScale='0' anchorRadius='3' decimalSeparator='.' thousandSeparator=',' divLineAlpha='80' numdivlines='9' decimalPrecision='0' showLimits='1'    xaxisname='$name_residence'    numberSuffix='%'  yAxisMaxValue='100'>";
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = "<categories>";
	
	//Initiate <dataset> elements
						$strDataCurr="<dataset>";
						//$strDataPrev="<dataset seriesName='จำนวนระยะทางที่รับผิดชอบทั้งหมด(กม.)'  color='0033FF'>";
					
			
	
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
                       // $strDataPrev .= "</dataset>";
		
					
	
	//Assemble the entire XML now
	 $strXML .= $strCategories . $strDataCurr  .  "</graph>";

	//Create the chart - MS Column 3D Chart with data contained in strXML
	echo renderChart("FusionCharts/FCF_MSColumn3D.swf", "", $strXML, "graph8", 1024, 500);
?></div>


</BODY>
</HTML>