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
 	$orgc_id=$_GET['orgc_id'];
 	$domain_data=$ftp['domain_data'];
#-------------------------------
  /* 
	$orgc_id=$_GET['orgc_id'];
$sql="SELECT org_comunity_detail.pic_map
FROM
  org_comunity_detail
where org_comunity_detail.orgc_id='$orgc_id'";
  $result=$db->query($sql);
  $rs=$db->fetch_array($result);

$show_file=$rs['pic_map']; 
$filename = $rs['pic_map'];

//$filename = realpath($filename);
  $filename =  $server.'../'.$filename; //ไม่ต้องกลัวว่ามันจะทับกันเพราะว่า รับค่าชื่อโฟนเดอร์ มาคนละชื่อ
$file_extension = strtolower(substr(strrchr($filename,"."),1));   */
#------------------------------------------------------------------------
    $sql="select *
            from attachment t1
            inner join lrd_attachment t2 ON (t1.attach_id=t2.attach_id)
            where record_ref_id='$orgc_id' and lrd_attach_type='SP_M'
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
#--------------------

$rootpath="http://".$server; 
//$main=$rootpath."/"."_cld_attach";
//$path_server=$main."/".$link."/".$folder_way_id."/".$folder_file_type;
#-----------------------------------------------------------------------------
 $server="/_cld_attach/".$link."/".$folder_way_id."/".$folder_file_type;
$filename = $rs['filename_ref'];


$filename = $rootpath.$server.'/'.$filename;

$file_extension = explode(".",$filename); //echo $file_extension ;exit;
$file_extension=$file_extension[1];//echo $file_extension;exit;
#-------------------------------
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
	       if (!file_exists($filename)) { die("NO FILE HERE");           }        
		      header("Pragma: public");           
			  header("Expires: 0");          
			   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");     
			   header("Cache-Control: private",false);          
			 header("Content-Type: $ctype");           
	header("Content-Disposition: attachment; filename=\"".basename($filename)."\";");      			              header("Content-Transfer-Encoding: binary");        
			header("Content-Length: ".@filesize($filename));         
			  set_time_limit(0);           
			  @readfile("$filename") or die("File not found.");
             exit;
           //funtion p ohme
			   public function file_get_contents_curl($url) {
        /*$ch = curl_init();

		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       

		$data = curl_exec($ch);
		curl_close($ch);

		return $data;*/

		curl_setopt($ch=curl_init(), CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
    }
			  ?>
