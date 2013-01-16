<?php	 session_start(); 
	
include("header.php");
	include "chksession.php";
	#-------------------------------
   global $FTP;
   $ftp=array();
  $ftp = $FTP;
 $server=$ftp['server'];

  $way_id=$_GET['way_id'];
  #------------------------------------------------------------------------
    $sql="select *
            from attachment t1
            inner join lrd_attachment t2 ON (t1.attach_id=t2.attach_id)
            where record_ref_id='$way_id' and lrd_attach_type='P_M'
             ";  //echo $sql;exit;
              $result=$db->query($sql);
             $rs=$db->fetch_array($result);
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
#--------------------

$rootpath="http://".$server; 
//$main=$rootpath."/"."_cld_attach";
//$path_server=$main."/".$link."/".$folder_way_id."/".$folder_file_type;
#-----------------------------------------------------------------------------

  //$server=$ftp['server']."/";
  // $server="http://".$ftp['server']."/".$link."/".$folder_way_id."/".$folder_file_type;
    $server="/_cld_attach/".$link."/".$folder_way_id."/".$folder_file_type;

//echo "$server";exit;


#-------------------------------
//$way_id=$_GET['way_id'];
//$sql="SELECT way_name,pic_map_mun from
//way
 //where way.way_id='$way_id'";

 


//$show_file=$rs['way_name']; 
$filename = $rs['filename_ref'];


$filename = $rootpath.$server.'/'.$filename;  //echo $filename;exit;            //../ jump out 1 step form page code
//$filename = realpath($filename);
//echo $filename ;exit;
//$file_extension = strtolower(substr(strrchr($filename,"."),1));
/*
$file_extension = explode(".",$filename); //echo $file_extension ;exit;
$file_extension=$file_extension[1];//echo $file_extension;exit;
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
	 echo $filename;exit;
	       //if (!file_exists($filename)) { die("NO FILE HERE");           }
		      header("Pragma: public");           
			   header("Expires: 0");          
			   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");     
			   header("Cache-Control: private",false);          
			   header("Content-Type: $ctype");
	         header("Content-Disposition: attachment; filename=\"".basename($filename)."\";"); 
	         header("Content-Transfer-Encoding: binary");
		    	header("Content-Length: ".@filesize($filename));         
			  set_time_limit(0);
			   $a=get_data($filename);
			 @readfile("$a") or die("File not found.");
              //exit;
			  #-------------------------------------------------------
              echo $filename;

}
$returned_content = get_data($filename);
      echo "<br><br>".$returned_content;


	   function file_get_contents_curl($url) {
        curl_setopt($ch=curl_init(), CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;


                                            */


                 function save_image($inPath,$outPath)
{ //Download images from remote server
$in= fopen($inPath, "rb");
$out= fopen($outPath, "wb");
while ($chunk = fread($in,8192))
{
fwrite($out, $chunk, 8192);
}
fclose($in);
fclose($out);
}
save_image('http://www.warf.com/download/45_4800_pic-io-a-sch.gif','image.gif');

 
			  ?>
