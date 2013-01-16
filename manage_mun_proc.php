<? session_start();
include "header.php";
include "chksession.php";
                            //echo"province_id=";           echo $_POST['province_id']; exit;
$proc=$_REQUEST['proc'];// ค่านี้ เป็นได้หลายค่า คือ add edite del 
$province_id_del=$_GET['province_id_del'];   //ค่านี้เป็นค่า จังหวัดของปุ่ม ลบ ส่งมา เพื่อจะส่งกลับคืนเมื่อลบเสร็จ จะได้รู้ว่า จะquery จังหวัดไหน
$tb_name="org_comunity";
$province_id=$_POST['province_id'];   //เรีบกมาใ้ช้เพื่อเพิ่มลำดับของอปท.แต่ละจังหวัด เพราะ จะมีการเลือก อปท.ทีละจังหวัด แล้วอปท.ก็จะมีการเรียงorder ตามที่ให้แต้มไป (line36)
$amphur_name=$_POST['amphur_name'];   // new zero
$orgc_id=$_REQUEST['orgc_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<?            //var_dump($proc);
	 //$data['province_id']=$_POST['province_id']; //ส่ง อำเภอเข้าไปแทน
	 
	 $data['create_by']=$_SESSION['LOGID'];

	 ///////////////////////////////////////// proc->add //////////////////////////////////////////
  /* if($proc=="add"){            // อ้นนี้เพิ่ม อปท.
      $orgc_name=$_POST['orgc_name'];
      //$amphur=$_POST['amphur'];                  //รอ อนุมัติ จากพี่ ปอย ถ้าเอาใส่มันถึงจะ select ได้ ถ้าไม่ใส่ก็ selectได้ เฉพาะ ข้อมูลที่มีอยู่แล้ว
      $num_mun=count($orgc_name);
     // var_dump($_POST['orgc_name']);
      for($j=0;$j<$num_mun;$j++){
         if($orgc_name[$j]!=""){
            $data['orgc_name']=$orgc_name[$j];
            //$data['amphur_id']=$amphur[$j];
            $add_data = $db->add_data($tb_name,$data,$funcs) ;
         }
      }

      $sqlS="select orgc_id from org_comunity INNER JOIN amphur ON org_comunity.amphur_id=amphur.amphur_id where amphur.province_id='$province_id' order by orgc_id";
      $resultS=$db->query($sqlS);
      $i=1;
      while( $rsS=$db->fetch_array($resultS)){
         $where="where orgc_id='$rsS[orgc_id]'";
         $data1['num_orders']=$i;

         $db->update_data($tb_name,$data1,$funcs,$where) ; $i++;
      }

      $i=1;
      echo "<script>alert('บันทึกเรียบร้อยแล้ว');
      window.location = 'manage.php?page=manage_mun&province_id=$province_id';</script>
      ";
      $db->close_db();          */

////////////////////////////////////////////////////////////////////////////////// up date //////////////

   //} else
   if($proc=="edit"){
	 $data['orgc_name']=$_POST['orgc_name']; 
	 $where="where orgc_id='$orgc_id'";
	 
	$db->update_data($tb_name,$data,$funcs,$where) ;
	 echo "<script>alert('แก้ไขเรียบร้อยแล้ว');	
				window.location = 'manage.php?page=manage_mun&province_id=$province_id';</script>
				";
				$db->close_db();
//		//////////////////////////////////////////////////////////////////////////// del
	 }
	 else if($proc=="del"){
	 $where="where orgc_id='$orgc_id'";
	// $sql="select orgc_id from $tb_name $where";     //ส่วนนี้แต่ก่อน ต้องเรียก province_id แต่ไม่ได้เรียกแล้วก็ไม่ใช้
	 //$result=$db->query($sql);
	// $rs=$db->fetch_array($result);
     //   echo"del<br>"; var_dump($province_id_del);
		$db->del_data($tb_name,$where) ;
	 echo "<script>alert('ลบเรียบร้อยแล้ว');
				window.location = 'manage.php?page=manage_mun&province_id=$province_id_del';
				</script>"; //ส่ง จังหวัดกลับไปเพราะต้องเอาไป select อปท เป็นจังหวัดนั้นๆ ตามที่ส่งไป
				$db->close_db();
	 }
	 ?>
</body>
</html>
