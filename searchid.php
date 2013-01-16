<?php session_start();
//header("Content-type: text/html; charset=UTF8");
 include "include/config.inc.php";
  $con=pg_connect("host=".$DB['host']." port=5432 dbname=".$DB['dbName']." user=".$DB['user']." password=".$DB['pass']);

$l = isset($_GET["limit"]) ? $_GET["limit"] : '';
$orgc_id=$_GET["orgc_id"];
//var_dump("$orgc_id");exit;
 $q=strtolower($_GET["q"]);
if (!$q) return;
$sql = "select way.way_code_tail
from
   way

where way.orgc_id='$orgc_id' and (way.active='t') and CAST(way.way_code_tail AS VARCHAR) LIKE '%$q%' limit $l";
//echo $sql;  // LEFT JOIN register_road_detail ON (way.way_id=register_road_detail.way_id) 
$rsd = pg_query($con,$sql);
    $num= pg_num_rows($rsd);
if($rsd){while($rs = pg_fetch_array($rsd)) {
	$cname = $rs['way_code_tail'];
	echo "$cname\n";

} }
 
pg_close($con);
?>
