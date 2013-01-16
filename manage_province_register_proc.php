<? SESSION_START();
include "header.php";
include "chksession.php";
$REFERER=$_SERVER['HTTP_REFERER']; 

$tb_name="annual_way";
$province_id=$_POST['province_id'];  // 1.>    array
$list_year=$_POST['list_year1'];     // 2.>  มาจากselection listyear ข้างบน  1 hidden ,า
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<? 
	//$amount_way=$_POST['amount_way'];
	$amount_phase_way=$_POST['amount_phase_way']; // 3.> array ค่าที่เอามาอัปเดท
	/*foreach ($_POST['province_id'] as $k=>$v)
 {
      echo $k . '=>' . $v .'amount='.$_POST['amount_phase_way'][$k] ."<br>";
  }
exit;   */
 /* $num_a=count($province_id);
  for($i=0;$i<=$num_a;$i++){
    echo $province_id[$i];echo"<br>";
  }
exit;   */
	 $num_a=count($province_id);   //นับ เพื่อเอามาใส่ index ของอาเรย์
	// echo"รวม$num_a";//ค่า $num_a=80ตลอดเลย//echo "id_p:$id_province[7]<br>"; echo "ระยะ$amount_phase_way[7]<br>";echo"รวม$num_a";
	//$sql="select id_annual from annual_way where list_year='$list_year'";    //นับแยกปี
//$result=$db->query($sql);
//$num=$db->num_rows($result); //เอาไปตรวจว่ามันมีค่าใหม ถ้ามีค่าอยู่แล้วให้อัปเดท แต่ถ้าไม่มีให้ insert ใหม่
//echo"$num";
///////////////////////////////////////////////////////////////
 foreach ($_POST['province_id'] as $k=>$v)  
 {

 $sql="select id_annual from annual_way where id_province='$v' and list_year='$list_year'";    //นับแยกปี  //
$result=$db->query($sql);
$num=$db->num_rows($result);

   $sql_max="select max(id_annual)as max_id from annual_way";    //นับแยกปี
$result_max=$db->query($sql_max);
    $rs_max=$db->fetch_array($result_max);
    $rsZ=0;
	$where="where id_province='$v' and list_year='$list_year'";  //province_id ไม่มีใน annual_way  จึงัปเดตไม่ได้
	//$data['amount_way']=$amount_way[$j];
	$data['id_annual']=$rs_max['max_id']+1;
	$data['amount_phase_way']=$amount_phase_way[$k];
	$data['list_year']=$list_year; 
	$data['id_province']=$v;
   $data['cre_by']=$_SESSION['LOGNAME'];
	//$data['id_personnel']=$id_personnel;
    //$data['id_personnel']=$id_personnel;===========รอหาฟิวใส่=======สรุปไม่มีผลสร้างฟิวใหม่ให้เลย==>>>>
	$data['amount_way']=$rsZ;
      if($_POST['target']==""){
        $data['target']=0;
      } else{
		$data['target']=$_POST['target'];
         }
         
 if($num==0){ //มันไม่เข้าเงื่อนไขนี้สักที  เพราะค่า num ไม่เท่ากับ 0
		$data['cre_date']=date("Y-m-d H:i:s");  //var_dump($tb_name,$data,$funcs);
      // echo"add/////////////////////////////<br>";
	$db->add_data($tb_name,$data,$funcs) ;      //new add
}else if($num>0){
        //echo"update<br>";
     $data['update_by']=$_SESSION['LOGNAME'];    
	$data['update_date']=date("Y-m-d H:i:s");   //var_dump($tb_name,$data,$funcs);
 	$db->update_data($tb_name,$data,$funcs,$where) ;    //ถ้ามี where 4 ตัวแปร ก็แสดงว่า เป็นการ update
}
} //end loop foreach

///////////////////////////////////////////////////////////////////////////////
	 echo "<script>alert('จัดเก็บหรือแก้ไขข้อมูลเรียบร้อยแล้ว');	
				window.location = 'manage.php?page=manage_province_register_mun&list_year=$list_year';</script>
				";
				$db->close_db();
	?>
	 
</body>
</html>
