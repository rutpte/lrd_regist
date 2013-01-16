<?php session_start();
include "include/config.inc.php";
  $con=pg_connect("host=".$DB['host']." port=5432 dbname=".$DB['dbName']." user=".$DB['user']." password=".$DB['pass']);

$orgc_id=$_GET["orgc_id"];
$way_name=$_GET["way_name"];

$sql = "select way.way_name,way.way_id
from
   way
   LEFT JOIN register_road_detail ON (way.way_id=register_road_detail.way_id) 
where way.orgc_id='$orgc_id' and (way.active='t') and way.way_name='$way_name'";
//echo $sql;
    $rsd = pg_query($con,$sql);
    $num= pg_num_rows($rsd);
    $rs=pg_fetch_array($rsd);
 echo $num.",".$rs['way_id'];
   //echo",";
  // echo $rs['way_id'];
 //echo $sql;
 //แล้วจะอ้างอิง id ไหนถ้ามี 2 ชื่อขึ้นไป ตอนจะ auto fill
pg_close($con);
?>