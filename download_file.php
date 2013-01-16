<?php	 session_start(); 
	
include("header.php");
	include "chksession.php";
	#-------------------------------
   global $FTP;
   $ftp=array();
  $ftp = $FTP;
  $server=$ftp['server'];

  //echo "$server";
 // exit;
  $way_id=$_GET['way_id'];
  #------------------------------------------------------------------------
    $sql="select *
            from attachment t1
            inner join lrd_attachment t2 ON (t1.attach_id=t2.attach_id)
            where record_ref_id='$way_id' and lrd_attach_type='F_T2'
             ";  //echo $sql;exit;
              $result=$db->query($sql);
             $rs=$db->fetch_array($result);
  #----------------------------------------------------------------------------
    #----------------------------------------------------------------------------
  //_cld_attach
$proj_id=$rs['proj_id'];
if($proj_id==1){
    $link="WAY";
}else if($proj_id==10){
    $link="LRD_MAP_PIC";
}else{
echo"no have:$proj_ida";exit;
}
#----------------------------------------------------------------------------
$folder_way_id=$rs['record_ref_id'];
$folder_file_type=$rs['attach_type']; ###########
$filename2=$rs['filename_attach'];
#--------------------

$rootpath="http://".$server;
$realpath_ondrive="D:/ms4w/apps";
//$main=$rootpath."/"."_cld_attach";
//$path_server=$main."/".$link."/".$folder_way_id."/".$folder_file_type;
#-----------------------------------------------------------------------------
 $server="/_cld_attach/".$link."/".$folder_way_id."/".$folder_file_type;
$filename = $rs['filename_ref'];


$filename = $rootpath."/".$realpath_ondrive.$server.'/'.$filename; //echo $filename;exit; //http://127.0.0.1/_cld_attach/WAY/106530/image/1356577872_Koala.jpg
$file_extension = explode(".",$filename); //echo $file_extension ;exit;
$file_extension=$file_extension[1];//echo $file_extension;exit;
#-------------------------------
/*
$way_id=$_GET['way_id']; //ค่าที่ส่งมาจาก ทถ.2 ที่ผจว.อนุมัติ
$sql="SELECT way_name,file_t2 from
way where way.way_id='$way_id'";
  $result=$db->query($sql);
  $rs=$db->fetch_array($result);

$show_file=$rs['way_name'];
$filename = $rs['file_t2'];         
//$filename = realpath($filename);   //ถ้าเราใช้ ftp ล่ะ
 $filename =  $server.'../'.$filename;
?>
   <? //var_dump($filename);exit;?>
    <script type="text/javascript">
    //alert("<?=$filename?>");
    </script>

  <?

$file_extension = strtolower(substr(strrchr($filename,"."),1));    */
  if(mb_check_encoding($filename2, "UTF-8")) {
            $filename_encoding = iconv("UTF-8", "TIS-620", $filename2);  }

 switch ($file_extension) {               
 case "pdf": $ctype="application/pdf"; break;               
 case "exe": $ctype="application/octet-stream"; break;               
 case "zip": $ctype="application/zip"; break;    
 case "rar": $ctype="application/rar"; break;            
 case "doc": case "docx":  $ctype="application/msword"; break;               
 case "xls": $ctype="application/vnd.ms-excel"; break;               
 case "ppt": $ctype="application/vnd.ms-powerpoint"; break;             
 case "gif": $ctype="image/gif"; break;              
 case "png": $ctype="image/png"; break;              
 case "jpe": case "jpeg":              
 case "jpg": $ctype="image/jpg"; break;              
	  default: $ctype="application/force-download";           }      
	 /*   if (!file_exists($filename)) { die("NO FILE HERE");           }
		      header("Pragma: public");           
			   header("Expires: 0");
			   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");     
			   header("Cache-Control: private",false);
			   header("Content-Type: $ctype");
	         header("Content-Disposition: attachment; filename=\"".basename($filename)."\";");
	             header("Content-Transfer-Encoding: binary");
			   header("Content-Length: ".@filesize($filename));
			   set_time_limit(0);           
			  @readfile("$filename") or die("File not found.");

              */
			  function get_data($url) {
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}
//$data = get_data($filename);
$data = file_get_contents($filename);
           /* header("Pragma: public");
			   header("Expires: 0");
			   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");     
			   header("Cache-Control: private",false);
			   header("Content-Type: $ctype");
	         header("Content-Disposition: attachment; filename=\"".basename($returned_content)."\";");
	             header("Content-Transfer-Encoding: binary");
			   header("Content-Length: ".@filesize($returned_content));
			   set_time_limit(0);  */
			   if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE"))
		{
			header('Content-Type: "'.$ctype.'"');
			header('Content-Disposition: attachment; filename="'.$filename_encoding.'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header("Content-Transfer-Encoding: binary");
			header('Pragma: public');
			header("Content-Length: ".strlen($data));
		}
		else
		{
			header('Content-Type: "'.$ctype.'"');
			header('Content-Disposition: attachment; filename="'.$filename_encoding.'"');
			header("Content-Transfer-Encoding: binary");
			header('Expires: 0');
			header('Pragma: no-cache');
			header("Content-Length: ".strlen($data));
		}
			  ?>
