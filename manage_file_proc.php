<? session_start();
include "header.php";
include "chksession.php";

$REFERER=$_SERVER['HTTP_REFERER']; //ย้อนกลับ หรือค่าพาทย์เดิม
$tb_name1="lrd_attachment";
$tb_name2="attachment";
$tb_name="way";
$way_id=$_REQUEST['way_id'];
$file_load=  $_FILES['file_load'];     //////////////////<<---  จาก from upload
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<?
// var_dump($file_load['name']);exit;
   


if($way_id==""){
       echo "<script>alert('รูปแบบไฟล์ไม่ถูกต้อง (way_id)');
				window.location = '$REFERER';</script>"; #
				exit();
}

    #--------------------------------------------------
if($file_load){
$file_upload = $file_load['name'];
$bytes = $file_load['size'];

$kbytes = $bytes / 1024;
 $mbytes = $kbytes / 1024;                //เอาขนาดภาพที่เป็น ไบต์มาหา กิโล แล้วมาหา เมกกะไต์ สรุปคือ เอาค่าไบต์แปลงเป็นเมกกะไบต์ (line 54)
$file_lname=explode(".",$file_upload);
$name_of_file = $file_lname[0];
$num_file_lname=count($file_lname)-1;
$file_lname=$file_lname[$num_file_lname];	
$file_lname=strtolower($file_lname);
if( $file_lname!='pdf'&&$file_lname !='jpg' && $file_lname !='jpeg' &&$file_lname !='png'  ){
				echo "<script>alert('รูปแบบไฟล์ไม่ถูกต้อง $file_lname');	
				window.location = '$REFERER';</script>";
				exit();

			}
}			
    #----------------------------------------------------
/*
//*********************   del ตอนกด แก้ไข *************************************#
	if ($_GET['chkdel']=="1") {                                                #
	$sql="select file_t2 from way where way_id='$way_id'";                     #
$result=$db->query($sql);                                                     #
$rs=$db->fetch_array($result);                                                #
		//unlink("$rs[file_t2]");   //ถ้าเกิดว่า ไฟล์อยู่เครื่องอื่นก็ ต้องใช้ ftp ในการลบแทน ftp_delete  //ต้องสร้างฟังชั่น unlink
   $file_del=$rs['file_t2'];     # new
  $app->del_file_ftp($file_del); # new
	$data1['file_t2']="";                                                      #
 	$where="where way_id='$way_id'";                                           #
			$db->update_data($tb_name,$data1,$funcs,$where) ;                    #
	                                                                           #
			echo "<script>
				window.location = '$REFERER';</script>";                          #
				exit();                                                           #
		}                                                                       #
//****************************************************************************#

//***************** if file is video ****************#
                                                     #
if($file_load['name']==null){                        #
           echo "<script>alert('รูปแบบไฟล์ไม่ถูกต้อง');
				window.location = '$REFERER';</script>"; #
				exit();                                  #
                                                     #
}                                                    #
//****************************************************

$sql="select file_t2 from way where way_id='$way_id'";
$result=$db->query($sql);
$rs=$db->fetch_array($result); 

$file_upload = $file_load['name'];   
$bytes = $file_load['size'];

$kbytes = $bytes / 1024;
 $mbytes = $kbytes / 1024;
$file_lname=explode(".",$file_upload);
$name_of_file = $file_lname[0];
$num_file_lname=count($file_lname)-1;
$file_lname=$file_lname[$num_file_lname];	
$file_lname=strtolower($file_lname);

	if($file_upload){

		$path="file_t2/"; //folder นี้ไม่มีอยู่ใน root ก่อนเอามาให้
			if( $file_lname!='pdf'&&$file_lname !='jpg' && $file_lname !='jpeg'   ){
				echo "<script>alert('รูปแบบไฟล์ไม่ถูกต้อง $file_lname');	
				window.location = '$REFERER';</script>";
				exit();

			}
				if($mbytes>2){     // หลังจากเปลี่ยนเป็น ftp จะยังกักไว้ที่ 2 MB อยู่ใหม
					echo "<script>alert('ไฟล์มีขนาดเกิน 2 Mb');	
				window.location = '$REFERER';</script>";
				exit();
				
			}
			$upload =$app->upload_file($file_load,$mainpath,$path);
		
			if($upload){
			//echo "$upload";exit;////////////////////////////////////
			$data['file_t2']	= $upload; //--> this is namefile
	
			}else{
			echo "<script>alert('ไม่สามารถ upload file ได้');	
				window.location = '$REFERER';</script>";
				exit();
			}	
		}
		 $where="where way_id='$way_id'";
					$update=$db->update_data($tb_name,$data,$funcs,$where) ;
				
				echo "<script>alert('เพิ่มไฟล์เรียบร้อยแล้ว');	
				window.location = '$REFERER';</script>
				";
				
				$db->close_db();     */
#*******************************************************************************************************************************				
				 $sql="select
$tb_name1.lrd_attach_type,
$tb_name1.attach_id,
$tb_name2.attach_type,
$tb_name2.proj_id,
$tb_name2.filename_ref
from $tb_name1
   INNER JOIN $tb_name2 ON($tb_name1.attach_id=$tb_name2.attach_id)
	 where $tb_name2.record_ref_id='$way_id' and $tb_name1.lrd_attach_type='F_T2'";   # ok de 55
$result=$db->query($sql);
$rs=$db->fetch_array($result);   
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

   #----------------------------------------
                       // del file
#############################################################################################################
//echo "$file_upload"; var_dump($file_load['name']);                                                        #
//exit;                                                                                                     #
	if ($_GET['chkdel']=="1") {                                                                              #
 $lrd_attach_type=$rs['lrd_attach_type'];	                                                                                                         #
 $file_del_id=$rs['attach_id'];                                                                             #
 $file_del_ftp=$rs['filename_ref'];
 $proj_id=$rs['proj_id'];
 $attach_type=$rs['attach_type'];                                                                           #
  #-----------------------------------                                                                                                          #
	$where="where attach_id='$file_del_id'";
	//ใช้ where เหมือนกันเพราะ attach_id เหมือนกัน		                                                                   #
	// $db->del_data($tb_name1,$where);
	 $data4['filename_ref']	="";
	 //$where="where $tb_name2.record_ref_id='$way_id' and lrd_attach_type='F_T2'";
	 $where="WHERE attachment.attach_id in (
SELECT  attachment.attach_id
FROM attachment
INNER JOIN lrd_attachment ON attachment.attach_id = lrd_attachment.attach_id
WHERE attachment.attach_id = lrd_attachment.attach_id
AND  attachment.record_ref_id='$way_id'
AND lrd_attachment.lrd_attach_type='F_T2')";
	 $db->update_data2($tb_name1,$tb_name2,$data4,$funcs,$where);                                                                       #
	// $db->del_data2($tb_name2,$where);    // ok ลบใช้ได้ exit;                                                                     #
  #-----------------------------------                                                                                                          #
	  if($proj_id==1){
       $link="WAY";
	  }else{
       $link="LRD_MAP_PIC";
	  } //del_file_ftp($link,$way_id,$attach_type,$file_for_del)                                                                                                   #
  $app->del_file_ftp($link,$way_id,$attach_type,$file_del_ftp); # ok de 55   ############################ #                          #                                                                                  #
     echo "<script>
				window.location = '$REFERER';</script>";                                                        #
				exit();                                                                                         #
		}                                                                                                   #
#############################################################################################################๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒
/////////////////////////////////////////////////////////////////////////////////////////////////////////////



                   // check if$file_load is null or is video
     ##########################################
	/*	if($file_load['name']==null){           
      echo"<script>alert('รูปแบบ file ไม่ถูกต้อง');window.location='$REFERER';</script>";
      exit();                   #
       }         */
     ##########################################
     
    /////////////////////////////////////////////////
  /*
    #--------------------------------------------------
$file_upload = $file_load['name'];
$bytes = $file_load['size'];

$kbytes = $bytes / 1024;
 $mbytes = $kbytes / 1024;                //เอาขนาดภาพที่เป็น ไบต์มาหา กิโล แล้วมาหา เมกกะไต์ สรุปคือ เอาค่าไบต์แปลงเป็นเมกกะไบต์ (line 54)
$file_lname=explode(".",$file_upload);
$name_of_file = $file_lname[0];
$num_file_lname=count($file_lname)-1;
$file_lname=$file_lname[$num_file_lname];	
$file_lname=strtolower($file_lname);      */
    #----------------------------------------------------
//////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////
                     // set path for paramiter
###################################################################################
     // $path="/_cld_attach"; #-->//for viwe only                                 #
      $fir_dir="WAY";                                                             #
      //$fir_dir="/LRD_MAP_PIC";                                                  #
	if($file_upload){                                                              #
         if($file_lname =='jpg'or $file_lname =='png' or $file_lname =='jpeg'){   #
             $path=$fir_dir."/".$way_id."/"."image";
             $attach_type="image";
             $content_type="image/jpeg";                                          #
         }else{                                                                   #
            $path=$fir_dir."/".$way_id."/"."doc";
            $attach_type= "doc";
            $content_type="application/octet-stream";                             #
				}                                                                     #
###################################################################################
		//$path="pic_map_mun/"; //มี folder นี้เท่านั้นที่มี ไว้เก็บภาพใน root นี้เ่ท่านั้น
			if($file_lname !='jpg'&& $file_lname !='png' && $file_lname !='jpeg' && $file_lname !='pdf'  ){
				echo "<script>alert('รูปแบบไฟล์ไม่ถูกต้อง');	
				window.location = '$REFERER';</script>";
				exit();

			}
				if($mbytes>2){           //ถ้าขนาดภาพเกิน6 เมกก็จะ ไม่อัปโหลดให้ (exit)แล้วกับไปหน้าเดิม
					echo "<script>alert('ไฟล์มีขนาดเกิน์ 2 Mb');	window.location = '$REFERER';</script>";
				exit();    //<<---
				
			}
			$name_file_ref =$app->upload_file($file_load,$mainpath,$path,$fir_dir,$way_id);      ////>>>> upload ok

			if($name_file_ref){
			$data['filename_ref']	= $name_file_ref;    

			}else{ 
			echo "<script>alert('ไม่สามารถ upload file ได้');window.location = '$REFERER';</script>";
				exit();
			}	
		}
		$date=date("Y-m-d H:i:s");
		//////////////////////////////////////////////////////    update only แต่ต้องมีการ upload ภาพมาก่อน ต้องบังคับให้อัปโหลด  ถ้าไม่บังคับ ต้องต้องตรวขสอบการอัปเดทว่าผ่านใหม-
		//  ถ้าไม่ผ่านก็ให้ เปลี่ยนโปรเซส ให้ add ใหม่ แทน
###############################################################################################	
		$data['proj_id']	=1;      // 1 WAY  10 แผนที่รวมสายทาง
		//$data['record_ref_id']	=$way_id;
		//$data['attach_type']	= ""; // 
		$data['filename_attach']	=$file_load['name'];
		//$data['create_by']	= $_SESSION['LOGNAME'];
		$data['update_by']	= $_SESSION['LOGNAME'];
		//$data['create_date']	=;
		$data['update_date']	=$date;
		//$data['update_by']	=;
		$data['content_type']	="$content_type";
		$data['file_size']	=$bytes;
		//$data['filename_ref']	=;
      $data['attach_type']	=$attach_type;
  #-----------------------------------------------------------
		#############----data foradd-------##############
		#................................................#
         $data3['filename_ref']	= $name_file_ref;
			$data3['proj_id']	= 1;
			//$data2['attach_type']	= $file_lname;
			$data3['create_date']=date("Y-m-d");
			//$data2['create_by']=$_SESSION['LOGNAME'];
         $data3['file_size']	= $bytes;
			$data3['record_ref_id']	=$way_id;
			$data3['filename_attach']	=$file_load['name'];
			$data3['create_by']	= $_SESSION['LOGNAME'];
			$data3['update_date']	=$date;
         $data3['attach_id']	=$max_att;
         $data3['content_type']	=$content_type;
         $data3['attach_type']	=$attach_type;

         $data2_1['lrd_attid'] =$max_att_lrd_attid;
         $data2_1['attach_id']	=$max_att;
         $data2_1['lrd_attach_type']	="F_T2";


			 //$where="where way.way_id=$way_id";



  ############################################################################################
		 //$where="where attach_id=' $rs[attach_id]'";
		// $where="where $tb_name2.record_ref_id='$way_id' and lrd_attach_type='F_T2'";
		 $where="WHERE attachment.attach_id in (
SELECT  attachment.attach_id
FROM attachment
INNER JOIN lrd_attachment ON attachment.attach_id = lrd_attachment.attach_id
WHERE attachment.attach_id = lrd_attachment.attach_id
AND  attachment.record_ref_id='$way_id'
AND lrd_attachment.lrd_attach_type='F_T2')";
	
		// echo "to_this_here_line_134";
		// exit;
		         if($rs['attach_id']==""){


                  $db->add_data($tb_name2,$data3,$funcs);
			         $db->add_data($tb_name1,$data2_1,$funcs);
			         echo "<script>alert('เพิ่มรูปภาพเรียบร้อยแลัว');
				window.location = '$REFERER';</script>
				";
			         }else{
					   $db->update_data2($tb_name1,$tb_name2,$data,$funcs,$where);
					   echo "<script>alert('แก้ไขรูปภาพเรียบร้อยแลัว');
				window.location = '$REFERER';</script>
				";
					   }

				$db->close_db();

	 ?>
</body>
</html>
