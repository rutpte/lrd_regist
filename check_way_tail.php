<?php session_start();
include "include/config.inc.php";
  $con=pg_connect("host=".$DB['host']." port=5432 dbname=".$DB['dbName']." user=".$DB['user']." password=".$DB['pass']);

$orgc_id=$_GET["orgc_id"];
$way_code_tail=$_GET["way_code_tail"];
if($way_code_tail==""){
    exit;
}
$sql = "select way.way_code_tail,way.way_id
from
   way
   LEFT JOIN register_road_detail ON (way.way_id=register_road_detail.way_id) 
where way.orgc_id='$orgc_id' and (way.active='t') and way.way_code_tail='$way_code_tail'";
//echo $sql;

    $rsd = pg_query($con,$sql);
     $rs=pg_fetch_array($rsd);
    $num= pg_num_rows($rsd);
  echo $num.",".$rs['way_id'];
 //echo $sql;
pg_close($con);
?>