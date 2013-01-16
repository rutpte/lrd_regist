<?php session_start();
include "include/config.inc.php";
  $con=pg_connect("host=".$DB['host']." port=5432 dbname=".$DB['dbName']." user=".$DB['user']." password=".$DB['pass']);
 $l = isset($_GET["limit"]) ? $_GET["limit"] : '';
 $q=strtolower($_GET["q"]);
 $orgc_id=$_GET["orgc_id"];
if (!$q) return;
$sql = "select way.way_name
from
   way

where way.orgc_id='$orgc_id' and (way.active='t') and way.way_name LIKE '%$q%'


limit $l";   //select ไม่ถูกแน่ na_road    LEFT JOIN register_road_detail ON (way.way_id=register_road_detail.way_id) 

//echo $sql;exit;
$rsd = pg_query($con,$sql);

if($rsd){while($rs = pg_fetch_array($rsd)) {
	$cname = $rs['way_name'];
	echo "$cname\n";

} }
pg_close($con);
?>
