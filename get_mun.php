<?php session_start(); 
include "header.php";
header("Content-Type: text/plain; charset=utf-8");
?>




<?php
$id_province=$_GET['id']; 
$id_mun=$_GET['id2'];
 $sqlSp="select id_mun,name_mun from municipality
 where id_province = '$id_province'  order by num_orders asc ";

$resultSp=$db->query($sqlSp);
echo "- เลือก -,,/";
$i=1;
 while($rsSp=$db->fetch_array($resultSp)){
	if($_GET['id2']!=""){
	 if($rsSp['id_mun']==$id_mun){
		$con=true; 
		
	 }else{
		 $con=false;
	 }
	}else{
		 $con=false;
	}

echo"$i. $rsSp[name_mun],$rsSp[id_mun],$con/";
$i++;}
mysql_close();

?>