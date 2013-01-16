<?  ob_start();
session_start();//echo"<pre>";print_r($_SESSION);echo"</pre>";     //exit;
include "header.php";   //สงสัยไปรับฟังชั่น add_data update delมา     ใช่
	
$REFERER=$_SERVER['HTTP_REFERER'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?          
$tb_name="way";               //ส่งเข้าฐานข้อมูล tableนี้
$tb_name1="lrd_attachment";
$tb_name2="attachment";
$tb_name_detail="register_road_detail"; //ส่งเข้าฐานข้อมูล tableนี้ด้วย รวมเป็นสอง table
$proc=$_REQUEST['proc'];                  //ค่าprocess ที่ถูกส่งมาว่าเป็นอะไร add update หรือว่า delete
$way_id=$_REQUEST['way_id'];           //ค่าที่ถูกส่งมา way_id ว่าเอามา add update delete
$orgc_id=$_REQUEST['orgc_id'];               //ค่าที่ถูกส่งมา id เทศบาล.อบต ว่าเอามา add update delete
$distance_total=$_POST['distance_total'];  //var_dump($_POST['distance_total']);echo"<br>";//ระยะทาง
//$type_ditch_road=$_POST['type_ditch_road'];  //ทางระบายน้ำ ว่า มี หรือ ไม่มี value 0 or 1
$type_road=$_POST['type_road'];              //ประเภทถนน .ในเขตชุมชน .นอกชุมขน.กำหนดมาตรฐานชั้นทางเอง
$file_load=  $_FILES['file_load'];           //ภาพอัปโหลดมา เฉพาะ addเท่านั้น  แผนที่สายทาง 
$file_load_t=  $_FILES['file_load_t'];        //  ??????????? ค้นหาจาก การอัปโหลดทั้งหมดไม่มี


/////////////////////////////////////////////////////////////////////////////////////////////
 if ($_GET['chkdel']=="1") {   // chkdel==1 คือ
	$sql="select pic_map_mun from way where way_id='$way_id'";
$result=$db->query($sql);
$rs=$db->fetch_array($result);
#----------------------------------------------------------------
		//unlink("$rs[pic_map_mun]"); //คำสั่ง unlink คือลบภาพตามพาทย์
		 $file_del=$rs['pic_map_mun'];# new
    $app->del_file_ftp($file_del); # new
#----------------------------------------------------------------    
	$data1['pic_map_mun']="";
 	$where="where way_id='$way_id'";  //ถ้าค่า$where มีค่าตรงกัน ก็จะให้ update แต่ค่า$where ไม่มีค่าก็จะเป็นการ insert แทน
			$db->update_data($tb_name,$data1,$funcs,$where) ;
	
			echo "<script>alert('ลบรูปภาพเรียบร้อยแล้ว');	
				window.location = '$REFERER';</script>";
				exit(); //ออกจากหน้านี้ alert deleted picture
		} 
/////////////////////////////////////////////////////////////////////////////////////////////		
		if ($_GET['chkdel']=="2") {
	$sql="select file_t2 from way where way_id='$way_id'";
$result=$db->query($sql);
$rs=$db->fetch_array($result);
#----------------------------------------------------
		//unlink("$rs[file_t2]");
		 $file_del=$rs['file_t2'];     # new
       $app->del_file_ftp($file_del); # new
#----------------------------------------------------       
	$data1['file_t2']="";
 	$where="where way_id='$way_id'";
			$db->update_data($tb_name,$data1,$funcs,$where) ;
	
			echo "<script>alert('deleted picture');	
				window.location = '$REFERER';</script>";
				exit();// alert deleted picture ลบรูปภาพเรียบร้อแล้ว
		} 
//////////////////////////////////////////////////////////////////////////////////////////////////////  
switch($_REQUEST['proc']) {
// ค่า proc ที่ถูกส่งมา ตรวจสอบตรงนี้เอง   เิริ่มตรวจสอบตรงนี้ ใครบ้างที่เรีกยใช้ เพจนี้ register_road_proc.php นอกจาก ลงทะเบียน
//manage_register หน้าแก้ไขก่อนส่งมา update ที่หน้านี่	
	
case 'add' :
$bytes = $file_load['size'];
$file_upload = $file_load['name'];
$file_lname=explode(".",$file_upload);   //แยกอาเรย์ ด้วย  . (ดอท)
$name_of_file = $file_lname[0];
$num_file_lname=count($file_lname)-1;
$file_lname=$file_lname[$num_file_lname];	
	$file_lname=strtolower($file_lname); //string to lower เป็นฟังชั่น แปลงแบบอักษรเป็นตัวเล็ก

	if($file_upload){
	
	#-------------------------------------lrd_attid
	$sqlmax_lrd_attid="SELECT max(lrd_attid)as max_lrd_attid FROM lrd_attachment";
$resultmax_lrd_attid=$db->query($sqlmax_lrd_attid);                                                                                   #
$rsmax_lrd_attid=$db->fetch_array($resultmax_lrd_attid);
$max_att_lrd_attid=$rsmax_lrd_attid['max_lrd_attid']+1;
	#-----------------------------------------
	$sqlmax="SELECT max(attach_id)as max_att
FROM attachment";
$resultmax=$db->query($sqlmax);                                                                                   #
$rsmax=$db->fetch_array($resultmax);
$max_att=$rsmax['max_att']+1;
//echo $max_att;exit;
#*******************************************
$sql_last="select max(way_id) as max_id from way";///////////// max_id =id ที่มีค่ามากสุด ก็คือ ไอดี ล่าสุดนั่นเอง
 $result_last=$db->query($sql_last);
 $rs_last=$db->fetch_array($result_last);
  $max_id1=$rs_last['max_id'];
 $way_max_id= $max_id1+1;
 //echo $way_max_id;exit;
   #----------------------------------------
		 $fir_dir="WAY";  //////////############################## ถึงนี้
			if($file_lname =='jpg'or $file_lname =='png' or $file_lname =='jpeg'){
              $data3['content_type']	= "image/jpeg";
               $path=$fir_dir."/".$way_max_id."/"."image";
                $data3['attach_type']	="image";
            }else if($file_lname =='pdf'){
              $data3['content_type']	= "application/octet-stream";
               $path=$fir_dir."/".$way_max_id."/"."doc";
                $data3['attach_type']	="doc";
            }else{
				echo "<script>alert('รูปแบบไฟล์ไม่ถูกต้อง $file_lname');
				window.location = '$REFERER';</script>";   //เก็บค่าฟอมอันโนมัติกลับคืน ค่าฟอร์มเก่ายังไม่ได้ลบ

				exit();//alert wrong format file
            }
			 
			//$name_file_ref =$app->upload_file($file_load,$mainpath,$path);
         $name_file_ref =$app->upload_file($file_load,$mainpath,$path,$fir_dir,$way_max_id);
		   $date=date("Y-m-d H:i:s");

			if($name_file_ref){
			$data3['filename_ref']	= $name_file_ref;
			$data3['proj_id']	= 1;
			//$data2['attach_type']	= $file_lname;
			$data3['create_date']=date("Y-m-d");
			//$data2['create_by']=$_SESSION['LOGNAME'];
         $data3['file_size']	= $bytes;
			$data3['record_ref_id']	=$way_max_id;
			$data3['filename_attach']	=$file_load['name'];
			$data3['create_by']	= $_SESSION['LOGNAME'];
			$data3['update_date']	=$date;
         $data3['attach_id']	=$max_att;

         $data2_1['lrd_attid'] =$max_att_lrd_attid;
         $data2_1['attach_id']	=$max_att;
         $data2_1['lrd_attach_type']	="P_M";


			 //$where="where way.way_id=$way_id";
			                $db->add_data($tb_name2,$data3,$funcs);
			                $db->add_data($tb_name1,$data2_1,$funcs); //exit;
                // echo "<script>alert('เพิ่มรูปภาพเรียบร้อยแลัว');window.location = '$REFERER';</script>";

			}else{
			echo "<script>alert('ไม่สามารถ upload file ได้');	
				window.location = '$REFERER';</script>";
				exit(); //alert can not upload file
			}	
		}
		
		
/*$file_upload_t = $file_load_t['name'];
$file_lname_t=explode(".",$file_upload_t);
$name_of_file_t = $file_lname_t[0];
$num_file_lname_t=count($file_lname_t)-1;
$file_lname_t=$file_lname_t[$num_file_lname_t];	

if($file_upload_t){
		$path="file_t2/";
			if($file_lname_t !='pdf'  ){
				echo "<script>alert('รูปแบบไฟล์ไม่ถูกต้อง');	
				window.location = '$REFERER';</script>";
				exit();

			}
			$upload =$app->upload_file($file_load_t,$mainpath,$path);
		
			if($upload){
			$data['file_t2']	= $upload;
	
			}else{
			echo "<script>alert('ไม่สามารถ upload file ได้');	
				window.location = '$REFERER';</script>";
				exit();
			}	
		}*/
		///////////////////////////////////////  test zone ////////////////////////////////////
         //echo"logname";var_dump($_SESSION['LOGNAME']);echo"<br>";
         //echo"divide_road";var_dump($_POST['divide_road']);echo"<br>";
         //echo"distance_total";var_dump($_POST['distance_total']);echo"<br>";
      //exit;


     /* $sql_last="select max(way_id) as max_id from way";///////////// max_id =id ที่มีค่ามากสุด ก็คือ ไอดี ล่าสุดนั่นเอง
 $result_last=$db->query($sql_last);
 $rs_last=$db->fetch_array($result_last);  */
////////////////////////////////////////////////////////////////////////////////////////////////

$data['way_active']="t";//--new      เข้าตอนนี้เลยใหมหรือว่ารออนุมติ ?
$data['way_code_full']=$_POST['way_code_head'].$_POST['way_code_tail'];//--new   way_code_full ไม่ได้ใช้ในappนี้ appอื่นได้ใช้ใหม?

$data['flag_reg_road']="t";//way.flag_reg_road='t' new 17/12/12
$data['way_id']=$rs_last['max_id']+1;  //////////// new 08/11/55
$data['orgc_id']=$_POST['orgc_id'];     
$data['user_key_in']=$_POST['user_key_in'];
$data['way_code_head']=$_POST['way_code_head'];
$data['way_name']=$_POST['way_name'];
$data['distance_total']=$_POST['distance_total'];
$data['tumbol_road']=$_POST['tumbol_road'];
$data['district_raod']=$_POST['district_road'];   //raod
//$data['province_road']=$_POST['province_road'];  echo"province_road";var_dump($_POST['province_road']);echo"<br>";
$data['start_road']=$_POST['start_road1']."+".$_POST['start_road2'].$_POST['start_road3'].$_POST['start_road4'];
$data['trariff_start_road_n']=$_POST['trariff_start_road_n'];
$data['trariff_start_road_e']=$_POST['trariff_start_road_e'];
$data['end_road']=$_POST['end_road1']."+".$_POST['end_road2'].$_POST['end_road3'].$_POST['end_road4'];
$data['trariff_end_road_n']=$_POST['trariff_end_road_n'];     //echo"trariff_end_road_n";var_dump($_POST['trariff_end_road_n']);echo"<br>";
$data['trariff_end_road_e']=$_POST['trariff_end_road_e'];   //echo"trariff_end_road_e";var_dump($_POST['trariff_end_road_e']);echo"<br>";
//$data['type_ditch_road']=$_POST['type_ditch_road'];   //ท่อระบายน้ำสองข้างทาง    //echo"type_ditch_road";var_dump($_POST['type_ditch_road']);echo"<br>";
//$data['ditch_road']=$_POST['ditch_road'];                    // var_dump($_POST['ditch_road']); exit; มันคือค่า null
//$data['year_road']=$_POST['year_road'];
//$data['divide_road']=$_POST['divide_road'];  echo"divide_road";var_dump($_POST['divide_road']);echo"<br>";
//$data['g_approve']=$_POST['g_approve'];

$data['cre_date']=date("Y-m-d"); // cre_date ->way
//$data['cre_time']=date("H:i:s");
//$data['update_date']=date("Y-m-d H:i:s");
$data['cre_by']=$_SESSION['LOGNAME'];    //ไม่ได้ใช้ create_by ใช้ตามตัวเก่ามัน //เปลี่ยนจาก logID เป้น $_SESSION['LOGNAME'];
//$data['user_key_in']=$_SESSION['LOGNAME'];   //echo"logname";var_dump($_SESSION['LOGNAME']);echo"<br>";
//cre_type ไม่เกี่ยว= สถานะการเลือกมาตรฐานเอง
  
$sqlId="select way_code_tail from way where orgc_id='$orgc_id' and way_code_tail='$_POST[way_code_tail]'";
$resultId=$db->query($sqlId);
$numId=$db->num_rows($resultId);

if($numId>0){
	$ali=1;
		 echo "<script>alert('รหัสสายทางทางทับซ้ำซ้อนรหัสสายทางเดิม');	
				</script>	";   //แจ้งว่าทับซ้อนกันแต่ ก็ให้แอดข้อมูลต่อไป  ถ้าไม่ให้ลงข้อมูลก็ควร exit; แล้วส่งกลับไปหน้ากรอกข้อมูล
			//alert id way duplicate id old way
	
}else{
	$data['way_code_tail']=$_POST['way_code_tail'];      // echo"way_code_tail"; var_dump($_POST['way_code_tail']);
}
$add_data = $db->add_data($tb_name,$data,$funcs); //เป็นคำสั่ง update UPDATE $tb_name SET $valuelist  $str_pk   // ส่งเข้า table  (way)
////////////////////////////////////////////////////////////////////////////////////////////////////////

 $sql="select max(way_id) as max_id from way";///////////// max_id =id ที่มีค่ามากสุด ก็คือ ไอดี ล่าสุดนั่นเอง
 $result=$db->query($sql);
 $rs=$db->fetch_array($result);
 
 $data1['way_id']=$rs['max_id'];  //หลังจากเก็บข้อมูลที่ตาราง way//เรียกค่า ล่าสุดที่บันทึกเพื่อ เอามาอัปเดทค่าลงไปอีก
 $max_id=$rs['max_id'];            //เก็บค่า max_id ไว้ใช้ด้วย
 //////////////////////////////////////////////////////////////////////////////////////////////////


                                           // add register_road_detail ต่อเลย//
 /////////////////////////////////  เพราะมีค่าไม่ว่างของ session ได้มีการเพิ่มค่า ที่ road_tran.php  ///////////////////////////

 $num=count($_SESSION['sess_period_regis']);
		for($i=0;$i<$num;$i++){
		if($_SESSION['sess_kate_regis'][$i]!=""&&$_SESSION['sess_distance_regis'][$i]!=""&&$_SESSION['sess_jarat_road'][$i]!=""&&$_SESSION['sess_width_ja'][$i]!=""){
	if(($type_road==0)&&($_SESSION['sess_type_ja'][$i]==3||$_SESSION['sess_type_sh'][$i]==3)){
	$type_road=1;
	break;
	}
	}
	}
	for($i=0;$i<$num;$i++){
	//ในเมือง
	$j=$i+1;
	

		if($_SESSION['sess_kate_regis'][$i]!=""&&$_SESSION['sess_distance_regis'][$i]!=""&&$_SESSION['sess_jarat_road'][$i]!=""&&$_SESSION['sess_width_ja'][$i]!=""){
	$w_road=($_SESSION['sess_width_ja'][$i]/($_SESSION['sess_jarat_road'][$i]*2));






if($type_road==0||$type_road==1){ //ถ้ามีการเลือกในเชตชุมชน หรือนอกชุมชน ของประเภทถนน


	if(($type_road==0&&$_SESSION['sess_type_ja'][$i]!=3
&&$_SESSION['sess_type_sh'][$i]!=3)
&&($_SESSION['sess_jarat_road'][$i]>=3&&$w_road>=3.25)
&&($_SESSION['sess_width_sh'][$i]>=2.5||$_SESSION['sess_width_fo'][$i]>=2.5)&&($type_ditch_road==0))
   {
	$type_road_detail=0;
	$layer_road_detail=0;
   $cre_type=0;
   }

	else if(($type_road==0&&$_SESSION['sess_type_ja'][$i]!=3
&&$_SESSION['sess_type_sh'][$i]!=3)&&($_SESSION['sess_jarat_road'][$i]>=2&&$w_road>=3.25)
	&&($_SESSION['sess_width_sh'][$i]>=2||$_SESSION['sess_width_fo'][$i]>=2)
	&&($type_ditch_road==0))
	{
	
	$type_road_detail=0;
	$layer_road_detail=1;
   $cre_type=0;
	}

    else if(($type_road==0&&$_SESSION['sess_type_ja'][$i]!=3
&&$_SESSION['sess_type_sh'][$i]!=3)&&($_SESSION['sess_jarat_road'][$i]>=2&&$w_road>=3.25)
	&&($_SESSION['sess_width_sh'][$i]>=1.5||$_SESSION['sess_width_fo'][$i]>=1.5)
	&&($type_ditch_road==0)){
	$type_road_detail=0;
	$layer_road_detail=2;
   $cre_type=0;
	}

    else if(($type_road==0&&$_SESSION['sess_type_ja'][$i]!=3
&&$_SESSION['sess_type_sh'][$i]!=3)&&($_SESSION['sess_jarat_road'][$i]>=1&&$w_road>=3)
	&&($_SESSION['sess_width_sh'][$i]>=1||$_SESSION['sess_width_fo'][$i]>=1)
	&&($type_ditch_road==0)){
	$type_road_detail=0;
	$layer_road_detail=3;
   $cre_type=0;

	}else if((($type_road==0&&$_SESSION['sess_type_ja'][$i]!=3
&&$_SESSION['sess_type_sh'][$i]!=3))&&(($_SESSION['sess_jarat_road'][$i]>=1&&$w_road<=3)
	&&($_SESSION['sess_width_sh'][$i]==""||$_SESSION['sess_width_sh'][$i]<1)
	&&($_SESSION['sess_width_fo'][$i]==""||$_SESSION['sess_width_fo'][$i]<1)))
	{
	$type_road_detail=0;
	$layer_road_detail=4;
   $cre_type=0;

	}
	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))&&(($_SESSION['sess_jarat_road'][$i]>=3&&$w_road>=3.25)
	&&($_SESSION['sess_width_sh'][$i]>=2.5||$_SESSION['sess_width_fo'][$i]>=2.5)))
	{
	
	$type_road_detail=1;
	$layer_road_detail=0;
	$cre_type=0;
	}
	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))
	&&(($_SESSION['sess_jarat_road'][$i]>=2&&$w_road>=3.25)
	&&($_SESSION['sess_width_sh'][$i]>=2||$_SESSION['sess_width_fo'][$i]>=2)
	&&($_SESSION['sess_kate_regis'][$i]>=30)))
	{
	
	$type_road_detail=1;
	$layer_road_detail=1;
	$cre_type=0;
	}
	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))
	&&(($_SESSION['sess_jarat_road'][$i]>=2&&$w_road>=3.25)
	&&($_SESSION['sess_width_sh'][$i]>=2||$_SESSION['sess_width_fo'][$i]>=2)))
	{
	
	$type_road_detail=1;
	$layer_road_detail=2;
	$cre_type=0;
	}
	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))&&(($_SESSION['sess_jarat_road'][$i]>=1&&$w_road>=3.25)
	&&($_SESSION['sess_width_sh'][$i]>=1.5||$_SESSION['sess_width_fo'][$i]>=1.5)))
	{
	
	$type_road_detail=1;
	$layer_road_detail=3;
	$cre_type=0;
	}
	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))&&(($_SESSION['sess_jarat_road'][$i]>=1&&$w_road>=3)
	&&($_SESSION['sess_width_sh'][$i]>=1||$_SESSION['sess_width_fo'][$i]>=1)))
	{
	
	$type_road_detail=1;
	$layer_road_detail=4;
	$cre_type=0;
	}
	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))&&(($_SESSION['sess_jarat_road'][$i]>=1&&$w_road>=3)
	&&($_SESSION['sess_width_sh'][$i]==""||$_SESSION['sess_width_sh'][$i]<1)
	&&($_SESSION['sess_width_fo'][$i]==""||$_SESSION['sess_width_fo'][$i]<1)))
	{

	$type_road_detail=1;
	$layer_road_detail=5;
   $cre_type=0;
	}
	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))&&(($_SESSION['sess_jarat_road'][$i]>=1&&$w_road<3)
&&($_SESSION['sess_width_sh'][$i]==""||$_SESSION['sess_width_sh'][$i]<1)
	&&($_SESSION['sess_width_fo'][$i]==""||$_SESSION['sess_width_fo'][$i]<1)))
	{
	$type_road_detail=1;
	$layer_road_detail=6;	
	$cre_type=0;

   }
               else  {//
                $type_road_detail=null;
            	 $layer_road_detail=null;

               $cre_type=2;
               $ct=1;
            ?>
            <script>alert('ข้อมูลช่วงที่ <? echo $j;?>ไม่มีในเงื่อนไขกรุณาตรวจสอบหรือกำหนดมาตรฐานชั้นทางเอง');//alert no have condition please check or  specify your class stand yourself
            				//alert no have condition please check or specity class standdard yourself
            				</script> 

            <?
                   } //

        }else if($type_road==2){ //    //ถ้ากด กำหนดเลือกมาตรฐานชั้นทางเอง

        $type_road_detail=2;
        $layer_road_detail=0;
        $cre_type=1;
                               } //
     echo"<h3>กำลังดำเนินการ.....</h3><img src='loading.gif'/>";
  /*                                                                  //rut
   echo "type_road_detail=$type_road_detail"; var_dump($type_road_detail);echo"<br>";
   echo "layer_road_detail=$layer_road_detail"; var_dump($layer_road_detail);
   echo"<br>";echo"<br>";echo"<br>";

    echo"type_sh=";var_dump($_SESSION['sess_type_sh']); echo"<br>";
    echo"type_fo=";var_dump($_SESSION['sess_type_fo']);echo"<br>";echo"<br>";echo"<br>";echo"<br>";

    echo"sess_width_sh="; var_dump($_SESSION['sess_width_sh']);   echo"<br>";
   echo"sess_width_fo="; var_dump($_SESSION['sess_width_fo']);   */
//exit;

//if($_SESSION['sess_width_sh'][$i]==9){$_SESSION['sess_width_sh'][$i]=0;}  // 1 สงสัยหมดน่าที่แล้วสองตัวนี้
//if($_SESSION['sess_width_fo'][$i]==9){$_SESSION['sess_width_fo'][$i]=0;}  // 2
 //////////////// ส่วนนี้ คือส่วนลง ตาราง register_road_detail  /////////////////////////////////////////////////
  //zip
  $sql_max_regisdetail="select max(id_regis_detail) as maxid_regis_detail from register_road_detail";
   $result_max_regisdetail=$db->query($sql_max_regisdetail);
 $rs_max_regisdetail=$db->fetch_array($result_max_regisdetail);
$data1['id_regis_detail']=$rs_max_regisdetail['maxid_regis_detail']+1;

$data1['jarat_road']=number_format($_SESSION['sess_jarat_road'][$i],0,'.','');
$data1['period_regis']=$i;
$data1['kate_regis']=number_format($_SESSION['sess_kate_regis'][$i],2,'.','');
$data1['distance_regis']= number_format($_SESSION['sess_distance_regis'][$i],3,'.',''); 
$data1['type_ja']=$_SESSION['sess_type_ja'][$i];
$data1['width_ja']=number_format($_SESSION['sess_width_ja'][$i],2,'.',',');
$data1['type_sh']=$_SESSION['sess_type_sh'][$i];
$data1['width_sh']=number_format($_SESSION['sess_width_sh'][$i]?$_SESSION['sess_width_sh'][$i]:0,2,'.',''); ///////// ถ้าค่านี้ไม่กรอกมา ก็จะ error
$data1['type_fo']=$_SESSION['sess_type_fo'][$i];
$data1['width_fo']=number_format($_SESSION['sess_width_fo'][$i]?$_SESSION['sess_width_fo'][$i]:0,2,'.',''); ////////  ถ้าค่านี้ไม่กรอกมา ก็จะ error
$data1['type_road_detail']=$type_road_detail;
$data1['layer_road_detail']=$layer_road_detail;
$data1['note']=$_SESSION['sess_note'][$i];
$data1['cre_date']=date("Y-m-d");  // cre_date regis_road_detail ->type date
$data1['cre_time']=date("H:i:s");
$data1['update_date']=date("Y-m-d H:i:s");
//$data1['id_personnel']=$_SESSION['LOGID'];
$data1['create_by']=$_SESSION['LOGNAME'];//new  ใช้แทน id_personnel
$add_data_detail = $db->add_data($tb_name_detail,$data1,$funcs) ;  //add   เพราะค่าที่สี่เป็นค่าว่าง
//////////////// end  ตาราง register_road_detail  /////////////////////////////////////////////////
}
}//end for //line 184



	if($type_road==0||$type_road==1){
      	 if($_SESSION['sess_period_regis']!=""){
      	   $sqlS="select * from register_road_detail where way_id='$max_id' ORDER BY  type_road_detail DESC , layer_road_detail DESC,type_ja desc,width_ja asc,type_sh desc,width_sh asc,type_fo desc,width_fo asc,kate_regis asc  limit 1";
      		$resultS=$db->query($sqlS);
      		$rsS=$db->fetch_array($resultS);

            $where="where way_id='$max_id'";     //เรียกค่า ล่าสุดที่บันทึกเพื่อ เอามาอัปเดทค่าลงไปอีก

      	   $data2['type_road']=$rsS['type_road_detail'];
            $data2['layer_road']=$rsS['layer_road_detail'];
      	   $data2['cre_type']=$cre_type;
      	$db->update_data($tb_name,$data2,$funcs,$where) ;
      	                          }
	}else if($type_road==2){
            		if($_SESSION['sess_period_regis']!=""){
            	   $sqlS="select * from register_road_detail where way_id='$max_id'  ORDER BY  type_road_detail DESC , layer_road_detail DESC,type_ja desc,width_ja asc,type_sh desc,width_sh asc,type_fo desc,width_fo asc,kate_regis asc  limit 1";
            	   $resultS=$db->query($sqlS);
            	   $rsS=$db->fetch_array($resultS);
            	   $where="where way_id='$max_id'";
            	
                        	 switch ($_POST['class_standard']){
                        	 case '1':
                        	 $class_type_road=0;
                        	 $class_layer_road=0;
                        	 break;
                        	 case '2':
                        	  $class_type_road=0;
                        	 $class_layer_road=1;
                        	  break;
                        	  	 case '3':
                        	  $class_type_road=0;
                        	 $class_layer_road=2;
                        	  break;
                        	  	 case '4':
                        	  $class_type_road=0;
                        	 $class_layer_road=3;
                        	  break;
                        	  	 case '5':
                        	  $class_type_road=0;
                        	 $class_layer_road=4;
                        	  break;
                        	  	 case '6':
                        	  $class_type_road=1;
                        	 $class_layer_road=0;
                        	  break;
                        	  	 case '7':
                        	  $class_type_road=1;
                        	 $class_layer_road=1;
                        	  break;
                        	   	 case '8':
                        	  $class_type_road=1;
                        	 $class_layer_road=2;
                        	  break;
                        	   	 case '9':
                        	  $class_type_road=1;
                        	 $class_layer_road=3;
                        	  break;
                        	   	 case '10':
                        	  $class_type_road=1;
                        	 $class_layer_road=4;
                        	  break;
                        	   	 case '11':
                        	  $class_type_road=1;
                        	 $class_layer_road=5;
                        	  break;
                        	 case '12':
                        	  $class_type_road=1;
                        	 $class_layer_road=6;
                        	  break;
                        	 }
            	 $data2['type_road']=$class_type_road;
            	 //$data2['id_regis_detail']=$rsS['id_regis_detail'];

            	 $data2['layer_road']= $class_layer_road;
            	 $data2['cre_type']=$cre_type;           //เลือกมาตรฐานชั้นทางเอง
            	 $db->update_data($tb_name,$data2,$funcs,$where) ;
            		}
		
		
		}  //end if $type_road==2


		 if($ali==1){
	 echo "<script>
				window.location = 'manage.php?page=register_road&way_id=$max_id&proc=edit&orgc_id=$orgc_id';</script>";
					 $db->close_db(); 

		 		unset($_SESSION['sess_period_regis']);
		unset($_SESSION['sess_kate_regis']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_jarat_road']);
		unset($_SESSION['sess_type_ja']);
		unset($_SESSION['sess_width_ja']);
		unset($_SESSION['sess_type_sh']);
		unset($_SESSION['sess_width_sh']);
		unset($_SESSION['sess_type_fo']);
		unset($_SESSION['sess_width_fo']);
		unset($_SESSION['sess_note']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_sum_distance']);
		unset($_SESSION['check']);
		unset($_SESSION['sum_d2']);

				 exit();
}
	   if($ct==1){
	   $where="where way_id='$max_id'";
			 //$data2['id_regis_detail']="";      // ไม่มีใน way 
			 $data2['cre_type']=2;
		 $db->update_data($tb_name,$data2,$funcs,$where) ;
		  echo "<script>
				window.location = 'manage.php?page=register_road&way_id=$max_id&proc=edit&orgc_id=$orgc_id';</script>";
		 $db->close_db(); 
	
		unset($_SESSION['sess_period_regis']);
		unset($_SESSION['sess_kate_regis']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_jarat_road']);
		unset($_SESSION['sess_type_ja']);
		unset($_SESSION['sess_width_ja']);
		unset($_SESSION['sess_type_sh']);
		unset($_SESSION['sess_width_sh']);
		unset($_SESSION['sess_type_fo']);
		unset($_SESSION['sess_width_fo']);
		unset($_SESSION['sess_note']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_sum_distance']);
		unset($_SESSION['check']);
		unset($_SESSION['sum_d2']);
			 exit();
		}

		
		
?>

			<?
  /***************************************************************/
  $sql_ms="select max(state_id) as max_state from way_state";
 $result_ms=$db->query($sql_ms);
 $rs_ms=$db->fetch_array($result_ms);

 $sql_mw="select max(way_id) as max_id_way from way";
 $result_mw=$db->query($sql_mw);
 $rs_mw=$db->fetch_array($result_mw);
 

             $tb_action="way_state";
             $data_a['state_id']=$rs_ms['max_state']+1;
             $data_a['way_id']=$rs_mw['max_id_way'];
             $data_a['action']="add";
             $data_a['phase']=1;
             $data_a['create_date']=date("Y-m-d H:i:s");
             $data_a['create_by']=$_SESSION['LOGNAME'];
             $data_a['ref_proj']="lrd_regis";         //เต้ยบอก
              $db->add_data($tb_action,$data_a,$funcs);

  /*****************************************************************/

			 echo "<script>alert('ลงทะเบียนเรียบร้อยแล้ว');
				window.location = 'manage.php?page=manage_register&orgc_id=$orgc_id';</script>
				";    // alert register already


				//ส่วนที่แสดงว่าลงข้อมูลสายทางเรียบร้อยแล้ว ///////////////////////////////////////////
			$db->close_db(); 
		unset($_SESSION['sess_period_regis']);
		unset($_SESSION['sess_kate_regis']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_jarat_road']);
		unset($_SESSION['sess_type_ja']);
		unset($_SESSION['sess_width_ja']);
		unset($_SESSION['sess_type_sh']);
		unset($_SESSION['sess_width_sh']);
		unset($_SESSION['sess_type_fo']);
		unset($_SESSION['sess_width_fo']);
		unset($_SESSION['sess_note']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_sum_distance']);
		unset($_SESSION['check']);
		unset($_SESSION['sum_d2']);
			break;
#**************************************************************************************************************
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////                         ///////////////////////////////////////////////////
///////////////////////////////////       edit_2            ///////////////////////////////////////////////////
///////////////////////////////////                         ///////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 'edit2' : //ถ้า edit2 จะเป็นการแก้ไข way แต่เพิ่มใหม่ของ detail
//echo"edit2";    echo "width_sh=". $_SESSION['sess_width_sh'][0];  //exit;
               // rut edit2
      $num=count($_SESSION['sess_period_regis']);
		for($i=0;$i<$num;$i++){
		if($_SESSION['sess_kate_regis'][$i]!=""&&$_SESSION['sess_distance_regis'][$i]!=""&&$_SESSION['sess_jarat_road'][$i]!=""&&$_SESSION['sess_width_ja'][$i]!=""){
	if(($type_road==0)&&($_SESSION['sess_type_ja'][$i]==3||$_SESSION['sess_type_sh'][$i]==3)){
	$type_road=1;
	break;
	}
	}
	}
	for($i=0;$i<$num;$i++){
	//ในเมือง
	$j=$i+1;
	

		if($_SESSION['sess_kate_regis'][$i]!=""&&$_SESSION['sess_distance_regis'][$i]!=""&&$_SESSION['sess_jarat_road'][$i]!=""&&$_SESSION['sess_width_ja'][$i]!=""){
	$w_road=($_SESSION['sess_width_ja'][$i]/($_SESSION['sess_jarat_road'][$i]*2));






if($type_road==0||$type_road==1){ //ถ้ามีการเลือกในเชตชุมชน หรือนอกชุมชน ของประเภทถนน


	if(($type_road==0&&$_SESSION['sess_type_ja'][$i]!=3
&&$_SESSION['sess_type_sh'][$i]!=3)
&&($_SESSION['sess_jarat_road'][$i]>=3&&$w_road>=3.25)
&&($_SESSION['sess_width_sh'][$i]>=2.5||$_SESSION['sess_width_fo'][$i]>=2.5)&&($type_ditch_road==0))
   {
	$type_road_detail=0;
	$layer_road_detail=0;
   $cre_type=0;
   }

	else if(($type_road==0&&$_SESSION['sess_type_ja'][$i]!=3
&&$_SESSION['sess_type_sh'][$i]!=3)&&($_SESSION['sess_jarat_road'][$i]>=2&&$w_road>=3.25)
	&&($_SESSION['sess_width_sh'][$i]>=2||$_SESSION['sess_width_fo'][$i]>=2)
	&&($type_ditch_road==0))
	{
	
	$type_road_detail=0;
	$layer_road_detail=1;
   $cre_type=0;
	}

    else if(($type_road==0&&$_SESSION['sess_type_ja'][$i]!=3
&&$_SESSION['sess_type_sh'][$i]!=3)&&($_SESSION['sess_jarat_road'][$i]>=2&&$w_road>=3.25)
	&&($_SESSION['sess_width_sh'][$i]>=1.5||$_SESSION['sess_width_fo'][$i]>=1.5)
	&&($type_ditch_road==0)){
	$type_road_detail=0;
	$layer_road_detail=2;
   $cre_type=0;
	}

    else if(($type_road==0&&$_SESSION['sess_type_ja'][$i]!=3
&&$_SESSION['sess_type_sh'][$i]!=3)&&($_SESSION['sess_jarat_road'][$i]>=1&&$w_road>=3)
	&&($_SESSION['sess_width_sh'][$i]>=1||$_SESSION['sess_width_fo'][$i]>=1)
	&&($type_ditch_road==0)){
	$type_road_detail=0;
	$layer_road_detail=3;
   $cre_type=0;

	}else if((($type_road==0&&$_SESSION['sess_type_ja'][$i]!=3
&&$_SESSION['sess_type_sh'][$i]!=3))&&(($_SESSION['sess_jarat_road'][$i]>=1&&$w_road<=3)
	&&($_SESSION['sess_width_sh'][$i]==""||$_SESSION['sess_width_sh'][$i]<1)
	&&($_SESSION['sess_width_fo'][$i]==""||$_SESSION['sess_width_fo'][$i]<1)))
	{
	$type_road_detail=0;
	$layer_road_detail=4;
   $cre_type=0;

	}
	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))&&(($_SESSION['sess_jarat_road'][$i]>=3&&$w_road>=3.25)
	&&($_SESSION['sess_width_sh'][$i]>=2.5||$_SESSION['sess_width_fo'][$i]>=2.5)))
	{
	
	$type_road_detail=1;
	$layer_road_detail=0;
	$cre_type=0;
	}
	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))
	&&(($_SESSION['sess_jarat_road'][$i]>=2&&$w_road>=3.25)
	&&($_SESSION['sess_width_sh'][$i]>=2||$_SESSION['sess_width_fo'][$i]>=2)
	&&($_SESSION['sess_kate_regis'][$i]>=30)))
	{
	
	$type_road_detail=1;
	$layer_road_detail=1;
	$cre_type=0;
	}
	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))
	&&(($_SESSION['sess_jarat_road'][$i]>=2&&$w_road>=3.25)
	&&($_SESSION['sess_width_sh'][$i]>=2||$_SESSION['sess_width_fo'][$i]>=2)))
	{
	
	$type_road_detail=1;
	$layer_road_detail=2;
	$cre_type=0;
	}
	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))&&(($_SESSION['sess_jarat_road'][$i]>=1&&$w_road>=3.25)
	&&($_SESSION['sess_width_sh'][$i]>=1.5||$_SESSION['sess_width_fo'][$i]>=1.5)))
	{
	
	$type_road_detail=1;
	$layer_road_detail=3;
	$cre_type=0;
	}
	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))&&(($_SESSION['sess_jarat_road'][$i]>=1&&$w_road>=3)
	&&($_SESSION['sess_width_sh'][$i]>=1||$_SESSION['sess_width_fo'][$i]>=1)))
	{
	
	$type_road_detail=1;
	$layer_road_detail=4;
	$cre_type=0;
	}
	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))&&(($_SESSION['sess_jarat_road'][$i]>=1&&$w_road>=3)
	&&($_SESSION['sess_width_sh'][$i]==""||$_SESSION['sess_width_sh'][$i]<1)
	&&($_SESSION['sess_width_fo'][$i]==""||$_SESSION['sess_width_fo'][$i]<1)))
	{

	$type_road_detail=1;
	$layer_road_detail=5;
   $cre_type=0;
	}
	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))&&(($_SESSION['sess_jarat_road'][$i]>=1&&$w_road<3)
&&($_SESSION['sess_width_sh'][$i]==""||$_SESSION['sess_width_sh'][$i]<1)
	&&($_SESSION['sess_width_fo'][$i]==""||$_SESSION['sess_width_fo'][$i]<1)))
	{
	$type_road_detail=1;
	$layer_road_detail=6;	
	$cre_type=0;


    } else  {// ถ้าไม่เข้าเงื่อนไขก็ให้ไปกำหนดมาตรฐานชั้นทางเอง
                $type_road_detail=null;
            	 $layer_road_detail=null;

               $cre_type=2;
               $ct=1;
            ?>
            <script>alert('ข้อมูลช่วงที่ <? echo $j;?>ไม่มีในเงื่อนไขกรุณาตรวจสอบหรือกำหนดมาตรฐานชั้นทางเอง');
            			//alert no have codition please check or specify class standard yourself	
            				</script> 

            <?
                   } //

        }else if($type_road==2){ //    //ถ้ากด กำหนดเลือกมาตรฐานชั้นทางเอง

        $type_road_detail=2;
        $layer_road_detail=0;
        $cre_type=1;
                               } //
     echo"<h3>กำลังดำเนินการ.....</h3><img src='loading.gif'/>";


//if($_SESSION['sess_width_sh'][$i]==9){$_SESSION['sess_width_sh'][$i]=0;}  // 1 สงสัยหมดน่าที่แล้วสองตัวนี้
//if($_SESSION['sess_width_fo'][$i]==9){$_SESSION['sess_width_fo'][$i]=0;}  // 2
 //////////////// ส่วนนี้ คือส่วนลง ตาราง register_road_detail  /////////////////////////////////////////////////
   //zip id_regis_detail
   $sql_max_regisdetail="select max(id_regis_detail) as maxid_regis_detail from register_road_detail";
   $result_max_regisdetail=$db->query($sql_max_regisdetail);
   $rs_max_regisdetail=$db->fetch_array($result_max_regisdetail);
   $data1['id_regis_detail']=$rs_max_regisdetail['maxid_regis_detail']+1;

$data1['jarat_road']=number_format($_SESSION['sess_jarat_road'][$i],0,'.','');
$data1['period_regis']=$i;
$data1['kate_regis']=number_format($_SESSION['sess_kate_regis'][$i],2,'.','');
$data1['distance_regis']= number_format($_SESSION['sess_distance_regis'][$i],3,'.',''); 
$data1['type_ja']=$_SESSION['sess_type_ja'][$i];
$data1['width_ja']=number_format($_SESSION['sess_width_ja'][$i],2,'.',',');
$data1['type_sh']=$_SESSION['sess_type_sh'][$i];
$data1['width_sh']=number_format($_SESSION['sess_width_sh'][$i]?$_SESSION['sess_width_sh'][$i]:0,2,'.','');//echo $_SESSION['sess_width_sh'][$i]."<br>"; var_dump($_SESSION['sess_width_sh'],$i); exit;///////// ถ้าค่านี้ไม่กรอกมา ก็จะ error
$data1['type_fo']=$_SESSION['sess_type_fo'][$i];
$data1['width_fo']=number_format($_SESSION['sess_width_fo'][$i]?$_SESSION['sess_width_fo'][$i]:0,2,'.',''); ////////  ถ้าค่านี้ไม่กรอกมา ก็จะ error
$data1['type_road_detail']=$type_road_detail;
$data1['layer_road_detail']=$layer_road_detail;
$data1['note']=$_SESSION['sess_note'][$i];
$data1['cre_date']=date("Y-m-d");  // cre_date regis_road_detail ->type date
$data1['cre_time']=date("H:i:s");
$data1['update_date']=date("Y-m-d H:i:s");
//$data1['id_personnel']=$_SESSION['LOGID'];
$data1['create_by']=$_SESSION['LOGNAME'];    //แก้จากด้านบน LOGID เปลี่ยนเป็น LOGNAME
$data1['way_id']=$way_id;
$add_data_detail = $db->add_data($tb_name_detail,$data1,$funcs) ;  //add


//////////////// end  ตาราง register_road_detail  /////////////////////////////////////////////////
}  //line 551
}//end for //line 184

//exit;

	if($type_road==0||$type_road==1){
      	 if($_SESSION['sess_period_regis']!=""){
      	   $sqlS="select * from register_road_detail where way_id='$way_id' ORDER BY  type_road_detail DESC , layer_road_detail DESC,type_ja desc,width_ja asc,type_sh desc,width_sh asc,type_fo desc,width_fo asc,kate_regis asc  limit 1";
      		$resultS=$db->query($sqlS);
      		$rsS=$db->fetch_array($resultS);

            $where="where way_id='$way_id'";     //เรียกค่า ล่าสุดที่บันทึกเพื่อ เอามาอัปเดทค่าลงไปอีก

      	   $data2['type_road']=$rsS['type_road_detail'];
            $data2['layer_road']=$rsS['layer_road_detail'];
      	   $data2['cre_type']=$cre_type;
      	$db->update_data($tb_name,$data2,$funcs,$where) ;
      	                          }
	}else if($type_road==2){
            		if($_SESSION['sess_period_regis']!=""){
            	   $sqlS="select * from register_road_detail where way_id='$way_id'  ORDER BY  type_road_detail DESC , layer_road_detail DESC,type_ja desc,width_ja asc,type_sh desc,width_sh asc,type_fo desc,width_fo asc,kate_regis asc  limit 1";
            	   $resultS=$db->query($sqlS);
            	   $rsS=$db->fetch_array($resultS);
            	   $where="where way_id='$way_id'";
            	
                        	 switch ($_POST['class_standard']){
                        	 case '1':
                        	 $class_type_road=0;
                        	 $class_layer_road=0;
                        	 break;
                        	 case '2':
                        	  $class_type_road=0;
                        	 $class_layer_road=1;
                        	  break;
                        	  	 case '3':
                        	  $class_type_road=0;
                        	 $class_layer_road=2;
                        	  break;
                        	  	 case '4':
                        	  $class_type_road=0;
                        	 $class_layer_road=3;
                        	  break;
                        	  	 case '5':
                        	  $class_type_road=0;
                        	 $class_layer_road=4;
                        	  break;
                        	  	 case '6':
                        	  $class_type_road=1;
                        	 $class_layer_road=0;
                        	  break;
                        	  	 case '7':
                        	  $class_type_road=1;
                        	 $class_layer_road=1;
                        	  break;
                        	   	 case '8':
                        	  $class_type_road=1;
                        	 $class_layer_road=2;
                        	  break;
                        	   	 case '9':
                        	  $class_type_road=1;
                        	 $class_layer_road=3;
                        	  break;
                        	   	 case '10':
                        	  $class_type_road=1;
                        	 $class_layer_road=4;
                        	  break;
                        	   	 case '11':
                        	  $class_type_road=1;
                        	 $class_layer_road=5;
                        	  break;
                        	 case '12':
                        	  $class_type_road=1;
                        	 $class_layer_road=6;
                        	  break;
                        	 }
            	 $data2['type_road']=$class_type_road;
            	 //$data2['id_regis_detail']=$rsS['id_regis_detail'];

            	 $data2['layer_road']= $class_layer_road;
            	 $data2['cre_type']=$cre_type;           //เลือกมาตรฐานชั้นทางเอง
            	 $db->update_data($tb_name,$data2,$funcs,$where) ;
            		}
		
		
		}  //end if $type_road==2

   

		
		
?>

			<?				  //ส่วนที่แสดงว่าลงข้อมูลสายทางเรียบร้อยแล้ว ///////////////////////////////////////////

         ///////// update way ///////            //////////////////////////////////     //////////   ////////   ///
         $data['flag_reg_road']="t";
         $data['orgc_id']=$_POST['orgc_id'];
         $data['user_key_in']=$_POST['user_key_in'];
         $data['way_code_head']=$_POST['way_code_head'];
         $data['way_name']=$_POST['way_name'];
         $data['distance_total']=$_POST['distance_total'];
         $data['tumbol_road']=$_POST['tumbol_road'];
         $data['district_raod']=$_POST['district_road'];  //raod

         $data['start_road']=$_POST['start_road1']."+".$_POST['start_road2'].$_POST['start_road3'].$_POST['start_road4'];
         $data['trariff_start_road_n']=$_POST['trariff_start_road_n'];
         $data['trariff_start_road_e']=$_POST['trariff_start_road_e'];
         $data['end_road']=$_POST['end_road1']."+".$_POST['end_road2'].$_POST['end_road3'].$_POST['end_road4'];
         $data['trariff_end_road_n']=$_POST['trariff_end_road_n'];
         $data['trariff_end_road_e']=$_POST['trariff_end_road_e'];
         $data['cre_date']=date("Y-m-d H:i:s");//เอาไว้บันทึกวันลงทะเบียน
         $data['cre_type']=$cre_type;
         $data['update_date']=date("Y-m-d H:i:s");
         //$data['update_by']=$_SESSION['LOGID'];  ///////////id_personnel เก่า//////////////// ใช้ update_by แทน หรือป่าว
         $data['update_by']=$_SESSION['LOGNAME'];  //new

   $sqlSid="select way_code_tail from way where way_id=$way_id";
   $resultSid=$db->query($sqlSid);
   $rsSid=$db->fetch_array($resultSid);

   $sqlId="select way_code_tail from way where orgc_id='$orgc_id' and way_code_tail='$_POST[way_code_tail]' and way_code_tail!='$rsSid[way_code_tail]'";
   $resultId=$db->query($sqlId);
   $numId=$db->num_rows($resultId);

   if($numId>0){
   	$ali=1;
   		 echo "<script>alert('รหัสสายทางทางทับซ้ำซ้อนรหัสสายทางเดิม');	
   				</script>	";   //alert id way duplicate old id way
   			
   	
   }else{
   	$data['way_code_tail']=$_POST['way_code_tail'];
   }

   
$file_upload = $file_load['name'];
$file_lname=explode(".",$file_upload);
$name_of_file = $file_lname[0];
$num_file_lname=count($file_lname)-1;
$file_lname=$file_lname[$num_file_lname];	
	$file_lname=strtolower($file_lname);
   /*   //old_rut
	if($file_upload){
		$path="pic_map_mun/";
			if($file_lname !='jpg'&& $file_lname !='png' && $file_lname !='jpeg' && $file_lname !='pdf'  ){
				echo "<script>alert('รูปแบบไฟล์ไม่ถูกต้อง $file_lname');	
				window.location = '$REFERER';</script>";   //alert wrong fotmat file
				exit();

			}
			$upload =$app->upload_file($file_load,$mainpath,$path);
		
			if($upload){
			$data['pic_map_mun']	= $upload;
	
			}else{
			echo "<script>alert('ไม่สามารถ upload file ได้');	
				window.location = '$REFERER';</script>";   //alert can not upload file
				exit();
			}	
		}
  */
$where="where way_id='$way_id'";

$db->update_data($tb_name,$data,$funcs,$where);  //update

  #-------------------------------------lrd_attid *********************************************************************************

	$sqlmax_lrd_attid="SELECT max(lrd_attid)as max_lrd_attid
FROM lrd_attachment";
$resultmax_lrd_attid=$db->query($sqlmax_lrd_attid);                                                                                   #
$rsmax_lrd_attid=$db->fetch_array($resultmax_lrd_attid);
$max_att_lrd_attid=$rsmax_lrd_attid['max_lrd_attid']+1;
	#-----------------------------------------
	$sqlmax="SELECT max(attach_id)as max_att
FROM attachment";
$resultmax=$db->query($sqlmax);                                                                                   #
$rsmax=$db->fetch_array($resultmax);
$max_att=$rsmax['max_att']+1;
//echo $max_att;exit;
#*******************************************

 $way_max_id= $way_id;
 //echo $way_max_id;exit;
   #----------------------------------------
		 $fir_dir="WAY";  //////////############################## ถึงนี้
			if($file_lname =='jpg'or $file_lname =='png' or $file_lname =='jpeg'){
              $data3['content_type']	= "image/jpeg";
               $path=$fir_dir."/".$way_max_id."/"."image";
                $data3['attach_type']	="image";
            }else if($file_lname =='pdf'){
              $data3['content_type']	= "application/octet-stream";
               $path=$fir_dir."/".$way_max_id."/"."doc";
                $data3['attach_type']	="doc";
            }else{
				echo "<script>alert('รูปแบบไฟล์ไม่ถูกต้อง $file_lname');
				window.location = '$REFERER';</script>";   //เก็บค่าฟอมอันโนมัติกลับคืน ค่าฟอร์มเก่ายังไม่ได้ลบ

				exit();//alert wrong format file
            }
			 
			//$name_file_ref =$app->upload_file($file_load,$mainpath,$path);
         $name_file_ref =$app->upload_file($file_load,$mainpath,$path,$fir_dir,$way_max_id);
		   $date=date("Y-m-d H:i:s");

			if($name_file_ref){
			$data3['filename_ref']	= $name_file_ref;
			$data3['proj_id']	= 1;
			//$data2['attach_type']	= $file_lname;
			$data3['create_date']=date("Y-m-d");
			//$data2['create_by']=$_SESSION['LOGNAME'];
         $data3['file_size']	= $bytes;
			$data3['record_ref_id']	=$way_max_id;
			$data3['filename_attach']	=$file_load['name'];
			$data3['create_by']	= $_SESSION['LOGNAME'];
			$data3['update_date']	=$date;
         $data3['attach_id']	=$max_att;

         $data2_1['lrd_attid'] =$max_att_lrd_attid;
         $data2_1['attach_id']	=$max_att;
         $data2_1['lrd_attach_type']	="P_M";


			 //$where="where way.way_id=$way_id";
			                $db->add_data($tb_name2,$data3,$funcs);
			                $db->add_data($tb_name1,$data2_1,$funcs); //exit;
              }


                     
			               // $where="where record_ref_id='$way_id'";

                       // $db->update_data($tb_name,$data,$funcs,$where);  //update
//////////////////////////////////////////////////////////////////////////////////////////*******************************************

	if($type_road==0||$type_road==1){
         	if($_SESSION['sess_period_regis']!=""){
               	$sqlS="select * from register_road_detail where way_id='$way_id'  ORDER BY  type_road_detail DESC , layer_road_detail DESC,type_ja desc,width_ja asc,type_sh desc,width_sh asc,type_fo desc,width_fo asc,kate_regis asc  limit 1";
               	$resultS=$db->query($sqlS);
               	$rsS=$db->fetch_array($resultS);
               	 $where="where way_id='$way_id'";
               	 $data2['type_road']=$rsS['type_road_detail'];

               	 $data2['layer_road']=$rsS['layer_road_detail'];
               	 $db->update_data($tb_name,$data2,$funcs,$where) ;
         		}
   }else if($type_road==2){
		if($_SESSION['sess_period_regis']!=""){
         	$sqlS="select * from register_road_detail where way_id='$way_id'  ORDER BY  type_road_detail DESC , layer_road_detail DESC,type_ja desc,width_ja asc,type_sh desc,width_sh asc,type_fo desc,width_fo asc,kate_regis asc  limit 1";
         	$resultS=$db->query($sqlS);
         	$rsS=$db->fetch_array($resultS);
         	 $where="where way_id='$way_id'";

                  	 switch ($_POST['class_standard']){
                  	 case '1':
                  	 $class_type_road=0;
                  	 $class_layer_road=0;
                  	 break;
                  	 case '2':
                  	  $class_type_road=0;
                  	 $class_layer_road=1;
                  	  break;
                  	  	 case '3':
                  	  $class_type_road=0;
                  	 $class_layer_road=2;
                  	  break;
                  	  	 case '4':
                  	  $class_type_road=0;
                  	 $class_layer_road=3;
                  	  break;
                  	  	 case '5':
                  	  $class_type_road=0;
                  	 $class_layer_road=4;
                  	  break;
                  	  	 case '6':
                  	  $class_type_road=1;
                  	 $class_layer_road=0;
                  	  break;
                  	  	 case '7':
                  	  $class_type_road=1;
                  	 $class_layer_road=1;
                  	  break;
                  	   	 case '8':
                  	  $class_type_road=1;
                  	 $class_layer_road=2;
                  	  break;
                  	   	 case '9':
                  	  $class_type_road=1;
                  	 $class_layer_road=3;
                  	  break;
                  	   	 case '10':
                  	  $class_type_road=1;
                  	 $class_layer_road=4;
                  	  break;
                  	   	 case '11':
                  	  $class_type_road=1;
                  	 $class_layer_road=5;
                  	  break;
                  	 case '12':
                  	  $class_type_road=1;
                  	 $class_layer_road=6;
                  	  break;
                  	 }
	 $data2['type_road']=$class_type_road;
	 //$data2['id_regis_detail']=$rsS['id_regis_detail'];       //คอลัมน์นี้ไม่มีใน way
	 $data2['layer_road']= $class_layer_road;
	 $db->update_data($tb_name,$data2,$funcs,$where) ;
		}
		
		
		}
		 if($ali==1){     //echo "รหัสสายทางซ้ำ";
	 echo "<script>
					window.location = 'manage.php?page=register_road&way_id=$way_id&proc=edit&orgc_id=$orgc_id';</script>";
					 $db->close_db(); 
		
		 		unset($_SESSION['sess_period_regis']);
		unset($_SESSION['sess_kate_regis']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_jarat_road']);
		unset($_SESSION['sess_type_ja']);
		unset($_SESSION['sess_width_ja']);
		unset($_SESSION['sess_type_sh']);
		unset($_SESSION['sess_width_sh']);
		unset($_SESSION['sess_type_fo']);
		unset($_SESSION['sess_width_fo']);
		unset($_SESSION['sess_note']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_sum_distance']);
		unset($_SESSION['check']);
		unset($_SESSION['sum_d2']);
		 exit();
}
		   if($ct==1){      //echo "มาตรฐานไม่มีในกำหนด";
	   $where="where way_id='$way_id'";
	   			 //$data2['id_regis_detail']="";     // ไม่มีใน way
			 $data2['cre_type']=2;
		 $db->update_data($tb_name,$data2,$funcs,$where) ;
		  echo "<script>
				window.location = 'manage.php?page=register_road&way_id=$way_id&proc=edit&orgc_id=$orgc_id';</script>";
		 $db->close_db(); 

		 		unset($_SESSION['sess_period_regis']);
		unset($_SESSION['sess_kate_regis']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_jarat_road']);
		unset($_SESSION['sess_type_ja']);
		unset($_SESSION['sess_width_ja']);
		unset($_SESSION['sess_type_sh']);
		unset($_SESSION['sess_width_sh']);
		unset($_SESSION['sess_type_fo']);
		unset($_SESSION['sess_width_fo']);
		unset($_SESSION['sess_note']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_sum_distance']);
		unset($_SESSION['check']);
		unset($_SESSION['sum_d2']);
		 exit();
		 
		}

		
		
		
		//echo"<h3>กำลังดำเนินการ.....1098</h3>";
         #

		/***************************************************************/
		 $sql_ms="select max(state_id) as max_state from way_state";
 $result_ms=$db->query($sql_ms);
 $rs_ms=$db->fetch_array($result_ms);
 

             $tb_action="way_state";
             $data_a['state_id']=$rs_ms['max_state']+1;
             
             $data_a['way_id']=$way_id;
             $data_a['action']="edit";
             $data_a['phase']=1;
             $data_a['create_date']=date("Y-m-d H:i:s");
             $data_a['create_by']=$_SESSION['LOGNAME'];
             $data_a['ref_proj']="lrd_regis";
              $db->add_data($tb_action,$data_a,$funcs);
  /*****************************************************************/
		
		echo "<script>alert('แก้ไขการลงทะเบียนเรียบร้อยแล้ว');window.location = 'manage.php?page=manage_register&orgc_id=$orgc_id';</script>
				";    //alert edited the register 
	

			$db->close_db();
				unset($_SESSION['sess_period_regis']);
		unset($_SESSION['sess_kate_regis']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_jarat_road']);
		unset($_SESSION['sess_type_ja']);
		unset($_SESSION['sess_width_ja']);
		unset($_SESSION['sess_type_sh']);
		unset($_SESSION['sess_width_sh']);
		unset($_SESSION['sess_type_fo']);
		unset($_SESSION['sess_width_fo']);
		unset($_SESSION['sess_note']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_sum_distance']);
			unset($_SESSION['check']);
			unset($_SESSION['sum_d2']);
			 break;
#**************************************************************************************************************
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////                         ///////////////////////////////////////////////////
///////////////////////////////////       edit              ///////////////////////////////////////////////////
///////////////////////////////////                         ///////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
		case 'edit':                // rut edit

$where="where way_id='$way_id'";
$db->del_data($tb_name_detail,$where) ;     //ตรงนี้มันลบข้อมูลเก่าออกก่อน
//count(จำนวน)
$num=count($_SESSION['sess_period_regis']);
	for($i=0;$i<$num;$i++){
		
      		if($_SESSION['sess_kate_regis'][$i]!=""&&$_SESSION['sess_distance_regis'][$i]!=""&&$_SESSION['sess_jarat_road'][$i]!=""&&$_SESSION['sess_width_ja'][$i]!=""){
               	if(($type_road==0)&&($_SESSION['sess_type_ja'][$i]==3||$_SESSION['sess_type_sh'][$i]==3)){
               	$type_road=1;
               	break;
               	}
         	}
	}//for
for($i=0;$i<$num;$i++){
$j=$i+1;
//ในเมือง
           	if($_SESSION['sess_kate_regis'][$i]!=""&&$_SESSION['sess_distance_regis'][$i]!=""&&$_SESSION['sess_jarat_road'][$i]!=""&&$_SESSION['sess_width_ja'][$i]!=""){
            $w_road=($_SESSION['sess_width_ja'][$i]/($_SESSION['sess_jarat_road'][$i]*2));

                        if($type_road==0||$type_road==1){



                                 if(($type_road==0&&$_SESSION['sess_type_ja'][$i]!=3
                                &&$_SESSION['sess_type_sh'][$i]!=3)
                                &&($_SESSION['sess_jarat_road'][$i]>=3&&$w_road>=3.25)
                                &&($_SESSION['sess_width_sh'][$i]>=2.5||$_SESSION['sess_width_fo'][$i]>=2.5)&&($type_ditch_road==0)){
                                	
                                 	$type_road_detail=0;
                                 	$layer_road_detail=0;
                                 	$cre_type=0;	

                                	
                                	}
                                	else if(($type_road==0&&$_SESSION['sess_type_ja'][$i]!=3
                                &&$_SESSION['sess_type_sh'][$i]!=3)&&($_SESSION['sess_jarat_road'][$i]>=2&&$w_road>=3.25)
                                	&&($_SESSION['sess_width_sh'][$i]>=2||$_SESSION['sess_width_fo'][$i]>=2)
                                	&&($type_ditch_road==0))
                                	{
                                	
                                 	$type_road_detail=0;
                                 	$layer_road_detail=1;
                                    $cre_type=0;
                                	}
                                    else if(($type_road==0&&$_SESSION['sess_type_ja'][$i]!=3
                                &&$_SESSION['sess_type_sh'][$i]!=3)&&($_SESSION['sess_jarat_road'][$i]>=2&&$w_road>=3.25)
                                	&&($_SESSION['sess_width_sh'][$i]>=1.5||$_SESSION['sess_width_fo'][$i]>=1.5)
                                	&&($type_ditch_road==0))
                                	{
                                 	$type_road_detail=0;
                                 	$layer_road_detail=2;

                                	}
                                	 else if(($type_road==0&&$_SESSION['sess_type_ja'][$i]!=3
                                &&$_SESSION['sess_type_sh'][$i]!=3)&&($_SESSION['sess_jarat_road'][$i]>=1&&$w_road>=3)
                                	&&($_SESSION['sess_width_sh'][$i]>=1||$_SESSION['sess_width_fo'][$i]>=1)
                                	&&($type_ditch_road==0))
                                	{
                                 	$type_road_detail=0;
                                 	$layer_road_detail=3;
                                    $cre_type=0;

                                	}else if((($type_road==0&&$_SESSION['sess_type_ja'][$i]!=3
                                &&$_SESSION['sess_type_sh'][$i]!=3))&&(($_SESSION['sess_jarat_road'][$i]>=1&&$w_road<=3)
                                	&&($_SESSION['sess_width_sh'][$i]==""||$_SESSION['sess_width_sh'][$i]<1)
                                	&&($_SESSION['sess_width_fo'][$i]==""||$_SESSION['sess_width_fo'][$i]<1)))
                                	{
                                    	$type_road_detail=0;
                                    	$layer_road_detail=4;
                                       $cre_type=0;


                                	}
                                	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))&&(($_SESSION['sess_jarat_road'][$i]>=3&&$w_road>=3.25)
                                	&&($_SESSION['sess_width_sh'][$i]>=2.5||$_SESSION['sess_width_fo'][$i]>=2.5)))
                                	{
                                	
                                    	$type_road_detail=1;
                                    	$layer_road_detail=0;
                                    	$cre_type=0;
                                	}
                                	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))
                                	&&(($_SESSION['sess_jarat_road'][$i]>=2&&$w_road>=3.25)
                                	&&($_SESSION['sess_width_sh'][$i]>=2||$_SESSION['sess_width_fo'][$i]>=2)
                                	&&($_SESSION['sess_kate_regis'][$i]>=30)))
                                	{
                                	
                                    	$type_road_detail=1;
                                    	$layer_road_detail=1;
                                    	$cre_type=0;
                                	}
                                	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))
                                	&&(($_SESSION['sess_jarat_road'][$i]>=2&&$w_road>=3.25)
                                	&&($_SESSION['sess_width_sh'][$i]>=2||$_SESSION['sess_width_fo'][$i]>=2)))
                                	{
                                    	
                                    	$type_road_detail=1;
                                    	$layer_road_detail=2;
                                    	$cre_type=0;
                                	}
                                	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))&&(($_SESSION['sess_jarat_road'][$i]>=1&&$w_road>=3.25)
                                	&&($_SESSION['sess_width_sh'][$i]>=1.5||$_SESSION['sess_width_fo'][$i]>=1.5)))
                                	{
                                    	
                                    	$type_road_detail=1;
                                    	$layer_road_detail=3;
                                       $cre_type=0;
                                	}
                                	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))&&(($_SESSION['sess_jarat_road'][$i]>=1&&$w_road>=3)
                                	&&($_SESSION['sess_width_sh'][$i]>=1||$_SESSION['sess_width_fo'][$i]>=1)))
                                	{
                                    	
                                    	$type_road_detail=1;
                                    	$layer_road_detail=4;
                                    	$cre_type=0;
                                	}
                                	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))&&(($_SESSION['sess_jarat_road'][$i]>=1&&$w_road>=3)
                                	&&($_SESSION['sess_width_sh'][$i]==""||$_SESSION['sess_width_sh'][$i]<1)
                                	&&($_SESSION['sess_width_fo'][$i]==""||$_SESSION['sess_width_fo'][$i]<1)))
                                	{

                                      	$type_road_detail=1;
                                      	$layer_road_detail=5;
                                       $cre_type=0;

                                	}
                                	else if((($type_road==1)||($type_road==0&&$_SESSION['sess_type_ja'][$i]==3))&&(($_SESSION['sess_jarat_road'][$i]>=1&&$w_road<3)
                                &&($_SESSION['sess_width_sh'][$i]==""||$_SESSION['sess_width_sh'][$i]<1)
                                	&&($_SESSION['sess_width_fo'][$i]==""||$_SESSION['sess_width_fo'][$i]<1)))
                                	{
                                    	$type_road_detail=1;
                                    	$layer_road_detail=6;	
                                    	$cre_type=0;
                                   }
                                   else  {
                                        $type_road_detail=null;     //ถ้าไม่เข้าเงื่อนไขของชั้นทาง ก็จะรีหน้ากลับมาให้เลือกมารตฐานชั้นทางเอง
                                    	 $layer_road_detail=null;

                                        $cre_type=2;
                                        $ct=1;
                                ?>
                                <script>alert('ข้อมูลช่วงที่ <? echo $j;?>ไม่มีในเงื่อนไขกรุณาตรวจสอบหรือกำหนดมาตรฐานชั้นทางเอง ');		
                                		
                                				</script> 
                                <?
                                	 }


                        }else if($type_road==2){

                                 $type_road_detail=2;
                                 $layer_road_detail=0;
                                 $cre_type=1;
                        }

 
            //zip id_regis_detail
            $sql_max_regisdetail="select max(id_regis_detail) as maxid_regis_detail from register_road_detail";
            $result_max_regisdetail=$db->query($sql_max_regisdetail);
            $rs_max_regisdetail=$db->fetch_array($result_max_regisdetail);
            $data1['id_regis_detail']=$rs_max_regisdetail['maxid_regis_detail']+1;

            $data1['way_id']=$way_id;
            $data1['jarat_road']=number_format($_SESSION['sess_jarat_road'][$i],0,'.','');
            $data1['period_regis']=$i;
            $data1['kate_regis']=number_format($_SESSION['sess_kate_regis'][$i],2,'.','');
            $data1['distance_regis']= number_format($_SESSION['sess_distance_regis'][$i],3,'.',''); 
            $data1['type_ja']=$_SESSION['sess_type_ja'][$i];
            $data1['width_ja']=number_format($_SESSION['sess_width_ja'][$i],2,'.',',');
            $data1['type_sh']=$_SESSION['sess_type_sh'][$i];
            $data1['width_sh']=number_format($_SESSION['sess_width_sh'][$i]?$_SESSION['sess_width_sh'][$i]:0,2,'.','');
            $data1['type_fo']=$_SESSION['sess_type_fo'][$i];
            $data1['width_fo']=number_format($_SESSION['sess_width_fo'][$i]?$_SESSION['sess_width_fo'][$i]:0,2,'.','');
            $data1['type_road_detail']=$type_road_detail;
            $data1['layer_road_detail']=$layer_road_detail;
            $data1['note']=$_SESSION['sess_note'][$i];
            $data1['update_date']=date("Y-m-d H:i:s");
           // $data1['id_personnel']=$_SESSION['LOGID'];
             $data1['update_by']=$_SESSION['LOGNAME'];
            
            //$where="where way_id='$way_id'";
            $add_data_detail = $db->add_data($tb_name_detail,$data1,$funcs) ;   //update  regis_road_detail
            }
} //end for
 /*
$sql_credateT="select cre_date,cre_time from register_road_detail where way_id='$way_id'";  //// แก้ไข วัน เดือน ปี และ เวลา
     $result_credateT=$db->query($sql_credateT);
      $rs_credateT=$db->fetch_array($result_credateT);
 $data1['cre_date']=$rs_credateT['cre_date'];   echo"cre_date";var_dump($rs_credateT['cre_date']);echo"<br>";
 $data1['cre_time']=$rs_credateT['cre_time'];   echo"cre_time";var_dump($rs_credateT['cre_time']);echo"<br>";
    $where="where way_id='$way_id'";
    $db->add_data($tb_name_detail,$data1,$funcs,$where) ;    */

         ///////// update way ///////
         $data['flag_reg_road']="t";
         $data['orgc_id']=$_POST['orgc_id'];
         $data['user_key_in']=$_POST['user_key_in'];
         $data['way_code_head']=$_POST['way_code_head'];
         $data['way_name']=$_POST['way_name'];
         $data['distance_total']=$_POST['distance_total'];
         $data['tumbol_road']=$_POST['tumbol_road'];
         $data['district_raod']=$_POST['district_road'];  //raod
         //$data['province_road']=$_POST['province_road'];  //var_dump($_POST['province_road']); exit;
         $data['start_road']=$_POST['start_road1']."+".$_POST['start_road2'].$_POST['start_road3'].$_POST['start_road4'];
         $data['trariff_start_road_n']=$_POST['trariff_start_road_n'];
         $data['trariff_start_road_e']=$_POST['trariff_start_road_e'];
         $data['end_road']=$_POST['end_road1']."+".$_POST['end_road2'].$_POST['end_road3'].$_POST['end_road4'];
         $data['trariff_end_road_n']=$_POST['trariff_end_road_n'];
         $data['trariff_end_road_e']=$_POST['trariff_end_road_e'];
         //$data['type_ditch_road']=$_POST['type_ditch_road'];
         //$data['ditch_road']=$_POST['ditch_road'];  //เขาแจ้งมาว่าไม่ได้ใช้แล้ว
         //$data['year_road']=$_POST['year_road'];
         //$data['divide_road']=$_POST['divide_road'];  //คือ อะไร ??????????????
         //$data['g_approve']=$_POST['g_approve'];
         $data['cre_type']=$cre_type;
         $data['update_date']=date("Y-m-d H:i:s");
        // $data['update_by']=$_SESSION['LOGID'];  ///////////id_personnel เก่า//////////////// ใช้ update_by แทน หรือป่าว
             $data['update_by']=$_SESSION['LOGNAME']; //new

   $sqlSid="select way_code_tail from way where way_id=$way_id";
   $resultSid=$db->query($sqlSid);
   $rsSid=$db->fetch_array($resultSid);

   $sqlId="select way_code_tail from way where orgc_id='$orgc_id' and way_code_tail='$_POST[way_code_tail]' and way_code_tail!='$rsSid[way_code_tail]'";
   $resultId=$db->query($sqlId);
   $numId=$db->num_rows($resultId);

   if($numId>0){
   	$ali=1;
   		 echo "<script>alert('รหัสสายทางทางทับซ้ำซ้อนรหัสสายทางเดิม');	
   				</script>	";
   			
   	
   }else{
   	$data['way_code_tail']=$_POST['way_code_tail'];
   }

    //  rut
    /*
$file_upload = $file_load['name'];
$file_lname=explode(".",$file_upload);
$name_of_file = $file_lname[0];
$num_file_lname=count($file_lname)-1;
$file_lname=$file_lname[$num_file_lname];	
	$file_lname=strtolower($file_lname);

	if($file_upload){
		$path="pic_map_mun/";
			if($file_lname !='jpg'&& $file_lname !='png' && $file_lname !='jpeg' && $file_lname !='pdf'  ){
				echo "<script>alert('รูปแบบไฟล์ไม่ถูกต้อง $file_lname');	
				window.location = '$REFERER';</script>";
				exit();

			}
			$upload =$app->upload_file($file_load,$mainpath,$path);
		
			if($upload){
			$data['pic_map_mun']	= $upload;
	
			}else{
			echo "<script>alert('ไม่สามารถ upload file ได้');	
				window.location = '$REFERER';</script>";
				exit();
			}	
		}
          */
		
/*$file_upload_t = $file_load_t['name'];
$file_lname_t=explode(".",$file_upload_t);
$name_of_file_t = $file_lname_t[0];
$num_file_lname_t=count($file_lname_t)-1;
$file_lname_t=$file_lname_t[$num_file_lname_t];	

if($file_upload_t){
		$path="file_t2/";
			if($file_lname_t !='pdf'  ){
				echo "<script>alert('รูปแบบไฟล์ไม่ถูกต้อง');	
				window.location = '$REFERER';</script>";
				exit();

			}
			$upload =$app->upload_file($file_load_t,$mainpath,$path);
		
			if($upload){
			$data['file_t2']	= $upload;
	
			}else{
			echo "<script>alert('ไม่สามารถ upload file ได้');	
				window.location = '$REFERER';</script>";
				exit();
			}	
		}*/
		//rut 24 de 55
$where="where way_id='$way_id'";

$db->update_data($tb_name,$data,$funcs,$where); //update
///////////////////////////////////////////////////////////////////////////////////////////  update cre_date and update cre_time

//$where="where way_id='$way_id'";
/*
$sql_credateT="select cre_date,cre_time from register_road_detail where way_id='$way_id'";  //// แก้ไข วัน เดือน ปี และ เวลา
$result_credateT=$db->query($sql_credateT);
$rs_credateT=$db->fetch_array($result_credateT);
 $data_dt['cre_date']=$rs_credateT['cre_date'];   echo"cre_date";var_dump($rs_credateT['cre_date']);echo"<br>";
 $data_dt['cre_time']=$rs_credateT['cre_time'];   echo"cre_time";var_dump($rs_credateT['cre_time']);echo"<br>";
//$db->update_data($tb_name_detail,$data_dt,$funcs,$where2);
*/
//////////////////////////////////////////////////////////////////////////////////////////

	if($type_road==0||$type_road==1){
         	if($_SESSION['sess_period_regis']!=""){
               	$sqlS="select * from register_road_detail where way_id='$way_id'  ORDER BY  type_road_detail DESC , layer_road_detail DESC,type_ja desc,width_ja asc,type_sh desc,width_sh asc,type_fo desc,width_fo asc,kate_regis asc  limit 1";
               	$resultS=$db->query($sqlS);
               	$rsS=$db->fetch_array($resultS);
               	 $where="where way_id='$way_id'";
               	 $data2['type_road']=$rsS['type_road_detail'];
               	 //$data2['id_regis_detail']=$rsS['id_regis_detail'];
               	 $data2['layer_road']=$rsS['layer_road_detail'];
               	 $db->update_data($tb_name,$data2,$funcs,$where) ;
         		}
   }else if($type_road==2){
		if($_SESSION['sess_period_regis']!=""){
         	$sqlS="select * from register_road_detail where way_id='$way_id'  ORDER BY  type_road_detail DESC , layer_road_detail DESC,type_ja desc,width_ja asc,type_sh desc,width_sh asc,type_fo desc,width_fo asc,kate_regis asc  limit 1";
         	$resultS=$db->query($sqlS);
         	$rsS=$db->fetch_array($resultS);
         	 $where="where way_id='$way_id'";

                  	 switch ($_POST['class_standard']){
                  	 case '1':
                  	 $class_type_road=0;
                  	 $class_layer_road=0;
                  	 break;
                  	 case '2':
                  	  $class_type_road=0;
                  	 $class_layer_road=1;
                  	  break;
                  	  	 case '3':
                  	  $class_type_road=0;
                  	 $class_layer_road=2;
                  	  break;
                  	  	 case '4':
                  	  $class_type_road=0;
                  	 $class_layer_road=3;
                  	  break;
                  	  	 case '5':
                  	  $class_type_road=0;
                  	 $class_layer_road=4;
                  	  break;
                  	  	 case '6':
                  	  $class_type_road=1;
                  	 $class_layer_road=0;
                  	  break;
                  	  	 case '7':
                  	  $class_type_road=1;
                  	 $class_layer_road=1;
                  	  break;
                  	   	 case '8':
                  	  $class_type_road=1;
                  	 $class_layer_road=2;
                  	  break;
                  	   	 case '9':
                  	  $class_type_road=1;
                  	 $class_layer_road=3;
                  	  break;
                  	   	 case '10':
                  	  $class_type_road=1;
                  	 $class_layer_road=4;
                  	  break;
                  	   	 case '11':
                  	  $class_type_road=1;
                  	 $class_layer_road=5;
                  	  break;
                  	 case '12':
                  	  $class_type_road=1;
                  	 $class_layer_road=6;
                  	  break;
                  	 }
	 $data2['type_road']=$class_type_road;
	 //$data2['id_regis_detail']=$rsS['id_regis_detail'];       //คอลัมน์นี้ไม่มีใน way
	 $data2['layer_road']= $class_layer_road;
	 $db->update_data($tb_name,$data2,$funcs,$where) ;
		}
		
		
		}
		 if($ali==1){ // echo"edit:ali==1:1522";//exit;
	 echo "<script>
					window.location = 'manage.php?page=register_road&way_id=$way_id&proc=edit&orgc_id=$orgc_id';</script>";
					 $db->close_db(); 
		
		 		unset($_SESSION['sess_period_regis']);
		unset($_SESSION['sess_kate_regis']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_jarat_road']);
		unset($_SESSION['sess_type_ja']);
		unset($_SESSION['sess_width_ja']);
		unset($_SESSION['sess_type_sh']);
		unset($_SESSION['sess_width_sh']);
		unset($_SESSION['sess_type_fo']);
		unset($_SESSION['sess_width_fo']);
		unset($_SESSION['sess_note']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_sum_distance']);
		unset($_SESSION['check']);
		unset($_SESSION['sum_d2']);
		 exit();
}
		   if($ct==1){    //echo"edit:ct==1:1544";//exit;
	   $where="where way_id='$way_id'";
	   			 //$data2['id_regis_detail']="";     // ไม่มีใน way
			 $data2['cre_type']=2;
		 $db->update_data($tb_name,$data2,$funcs,$where) ;
		  echo "<script>
				window.location = 'manage.php?page=register_road&way_id=$way_id&proc=edit&orgc_id=$orgc_id';</script>";
		 $db->close_db(); 

		 		unset($_SESSION['sess_period_regis']);
		unset($_SESSION['sess_kate_regis']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_jarat_road']);
		unset($_SESSION['sess_type_ja']);
		unset($_SESSION['sess_width_ja']);
		unset($_SESSION['sess_type_sh']);
		unset($_SESSION['sess_width_sh']);
		unset($_SESSION['sess_type_fo']);
		unset($_SESSION['sess_width_fo']);
		unset($_SESSION['sess_note']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_sum_distance']);
		unset($_SESSION['check']);
		unset($_SESSION['sum_d2']);
		 exit();
		 
		}

		
		
		
		echo"<h3>กำลังดำเนินการ.....edit</h3>";
		/********************* add data logfile ************************************/
		 $sql_ms="select max(state_id) as max_state from way_state";
 $result_ms=$db->query($sql_ms);
 $rs_ms=$db->fetch_array($result_ms);
 

             $tb_action="way_state";
             $data_a['state_id']=$rs_ms['max_state']+1;
             
             $data_a['way_id']=$way_id;
             $data_a['action']="edit";
             $data_a['phase']=1;
             $data_a['create_date']=date("Y-m-d H:i:s");
             $data_a['create_by']=$_SESSION['LOGNAME'];
             $data_a['ref_proj']="lrd_regis";
              $db->add_data($tb_action,$data_a,$funcs);
  /*****************************************************************/
		
		echo "<script>alert('แก้ไขการลงทะเบียนเรียบร้อยแล้ว');	
				window.location = 'manage.php?page=manage_register&orgc_id=$orgc_id';</script>
				";
	

			$db->close_db();
				unset($_SESSION['sess_period_regis']);
		unset($_SESSION['sess_kate_regis']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_jarat_road']);
		unset($_SESSION['sess_type_ja']);
		unset($_SESSION['sess_width_ja']);
		unset($_SESSION['sess_type_sh']);
		unset($_SESSION['sess_width_sh']);
		unset($_SESSION['sess_type_fo']);
		unset($_SESSION['sess_width_fo']);
		unset($_SESSION['sess_note']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_sum_distance']);
			unset($_SESSION['check']);
			unset($_SESSION['sum_d2']);
			 break;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////  del  //////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				case 'del':
$sql="select pic_map_mun,file_t2 from way where way_id='$way_id'";
$result=$db->query($sql);
$rs=$db->fetch_array($result); 
if($rs['pic_map_mun']){
		//unlink("$rs[pic_map_mun]"); //มาถึงก็ unlink เลย
}
if($rs['file_t2']){
		//unlink("$rs[file_t2]");    //ถ้ามี file link
}
		 $where="where way_id='$way_id'";
    $data_del['active']="f";
	$db->update_data ($tb_name,$data_del,$funcs,$where);

	//tb_name ก็คือ ตาราง way
//$db->del_data($tb_name,$where) ;
//$db->del_data($tb_name_detail,$where) ;

           /***************************************************************/
            $sql_ms="select max(state_id) as max_state from way_state";
 $result_ms=$db->query($sql_ms);
 $rs_ms=$db->fetch_array($result_ms);
 

             $tb_action="way_state";
             $data_a['state_id']=$rs_ms['max_state']+1;
             
             $data_a['way_id']=$way_id;
             $data_a['action']="del";
             $data_a['phase']=1;
             $data_a['create_date']=date("Y-m-d H:i:s");
             $data_a['create_by']=$_SESSION['LOGNAME'];
             $data_a['ref_proj']="lrd_regis";
              $db->add_data($tb_action,$data_a,$funcs);
  /*****************************************************************/
	 	echo "<script>alert('ลบรายการเรียบร้อยแล้ว');	////////<<----  กดลบโดยไม่ถามก่อน
				window.location = 'manage.php?page=manage_register&orgc_id=$orgc_id';</script>
				";
				$db->close_db();
		unset($_SESSION['sess_period_regis']);
		unset($_SESSION['sess_kate_regis']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_jarat_road']);
		unset($_SESSION['sess_type_ja']);
		unset($_SESSION['sess_width_ja']);
		unset($_SESSION['sess_type_sh']);
		unset($_SESSION['sess_width_sh']);
		unset($_SESSION['sess_type_fo']);
		unset($_SESSION['sess_width_fo']);
		unset($_SESSION['sess_note']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_sum_distance']);
		unset($_SESSION['check']);
		unset($_SESSION['sum_d2']);
		break;
	

   }//end break
		?>
</body>
</html>
