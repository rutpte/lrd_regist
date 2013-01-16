<?php 
  class application {
  //*****************************************#
     // var   $ftp_server = "127.0.0.1";     #
      //var $ftp_user_name = "cldadmin";     #    อยู่ใน ไฟล์ config.inc.php แล้ว
     // var $ftp_user_pass = "CLDadmin1234"; #
   //****************************************#
     #
     var $ftp=array();
     #****************************************
	  var $db;
	  var $disp;
	  var $th_today;
	  function application () {
          global $CLASS;
         $this->db     = $CLASS['db'];
		 $this->disp  = $CLASS['disp'];
		 //$this->th_today = $this->disp->get_date_time_patn (date("Y-m-d"),"d_th");
	  }
function checksame ($data,$fields,$tb_name) {

	$strSQL ="select  $fields      from  $tb_name   where   $fields   = '$data' ";
	$query = $this->db->query($strSQL);
	$row  = $this->db->num_rows($query);
	if($row == 0){
		return false;
	}else{
		return true;
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////
function  upload_file($file,$mainpath,$path,$fir_dir,$way_id){

/*
 $ftp_server = "winti.pte.co.th";
 $ftp_user_name = "pte";
 $ftp_user_pass = "bdf21xu7";  */
 
// $ftp_server = "127.0.0.1";
//$ftp_user_name = "cldadmin";
//$ftp_user_pass = "CLDadmin1234";
######################################################
 global $FTP;
  $this->ftp = $FTP;
######################################################
 $file_load=$file['name'];
$file_upload= strtotime(date("Y-m-d H:i:s"))."_".$file_load;

 $destination_file = $file_upload;
 $source_file = $file['tmp_name'];
 $size_file=$file['size'];

 $conn_id = ftp_connect($this->ftp['server']);

  // login with username and password
 $login_result = @ftp_login($conn_id, $this->ftp['user_name'], $this->ftp['user_pass']);

 //ftp_chdir($conn_id,"htdocs/upload/store_file");
   // check connection  
 if ((!$conn_id) || (!$login_result)) {
     //echo "FTP connection has failed!";
    // echo "Attempted to connect to $ftp_server for user $ftp_user_name";
    return false;
     exit;
 } else {
     //echo "Connected to $ftp_server, for user $ftp_user_name<br/>";
      }
// upload the file
/*
 if($path=="file_t2/"){
    ftp_chdir($conn_id, 'file_t2' );
 }else if($path=="pic_map/"){
    ftp_chdir($conn_id, 'pic_map' );
 }else if($path=="pic_map_mun/"){
    ftp_chdir($conn_id, 'pic_map_mun' );     //pic_map_man ได้ไง
 } else{
    echo"no have folder for upload";
    exit;
 }  */

 ###########################################
  
#--------------------------------
  /*
   if($owner_file=="P_M" or $owner_file=="F_T2"){
       $fir_dir="/WAY";
   }else if($owner_file=="SP_M"){
       $fir_dir="/LRD_MAP_PIC";
   }else{
    echo "NO owner";exit;
   }

$_cld_attach=$root_path.$path;  */  #set new path   =>>D:/ms4w/apps/_cld_attach
#--------------------------------
 //echo $_cld_attach.$fir_dir."/".$way_id;exit;=>>//D:/ms4w/apps/_cld_attach/WAY
/*
 $last_fir_dir=$_cld_attach.$fir_dir;       #set new path   =>>D:/ms4w/apps/_cld_attach/WAY
 $way_id_dir=$last_fir_dir."/".$way_id;   #set new path   =>>D:/ms4w/apps/_cld_attach/WAY/last_id
 */
$check_dir=$this->check_dir_id($conn_id,$fir_dir,$way_id);
if($check_dir!=true){
   echo "check_dir is false";
}else{
   echo "check_dir is true";
}
 ftp_chdir($conn_id,$last_fir_dir);  #go inside wait for create new folder

//local for funtion $this->check_file_ftp();
 ##########################################
 ftp_chdir($conn_id, $path );      
 $upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY); //--แต่ถ้าทำชี้พาทแบบนี้ก็ต้องชี้ ftp ใน app cld_regis เลย
 //$upload = ftp_put($conn_id,$destination_file, $source_file, FTP_BINARY);
// check upload status

 if (!$upload) {
     //echo"failed";
     return false;
  }else{
  
    //echo "$path$destination_file";
   //return  $path.$destination_file;
   return  $path.$destination_file;
  }
  
// close the FTP stream  
ftp_close($conn_id);//close 
 //-------------------------------------


//*******************************************************************************
				/* old
$file_add =  $file['tmp_name'];
$file_name = $file['name'];
$file_size = $file['size'];


				$file_lname=explode(".",$file_name);
				$name_of_file = $file_lname[0];
				$num_file_lname=count($file_lname)-1;
				$file_lname=$file_lname[$num_file_lname];

				$file_name =strtotime(date("Y-m-d H:i:s")).".".$file_lname; 

				$chk_copy=copy ($file_add,$mainpath.$path.$file_name);	

				if($chk_copy){
					return  $path.$file_name;  //ส่งค่า ลิ้งให้คืน  เพื่อไปบันทึกลงในฐานข้อมูล
				}else{
					return false;
				}

				*/

	//var_dump($file);
//*******************************************************************************
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
#****************************** check dir id and create doc image folder *************************************************************************
function check_dir_id($conn_id,$link,$way_id){
 // global $conn_id;
 // $conn_id = $conn_id;
 

 $dir_f="$link";
 $dir_id="$way_id";
$path_to_id=$dir_f."/".$dir_id;

         $current_path=ftp_pwd($conn_id);
        if(@ftp_chdir($conn_id,$path_to_id))  {

            ftp_chdir($conn_id, $current_path);
           // echo "<br>have dir";
            return true;   //in this case if have this folder so it have sub folder "doc and image"
        }
        else
        {
           //echo "<br>NO have dir<br>";
           if(ftp_mkdir($conn_id,$path_to_id)){
             ftp_chdir($conn_id, $path_to_id);
              //echo "<br>created folder id";
                $image=@ftp_mkdir($conn_id,image);  //<<
                $doc=@ftp_mkdir($conn_id,doc);      //<<
                   if( $image && $doc){
                        //echo "<br>crated image and doc";
                       return true;
                   }else{
                       // echo "<br>can not create image or doc";
                        return false;
                   }
           }else{
             //echo "<br>can not create folder id";
             return false;
           }


        }

}//end function
#*************************************************************************************************************************

//************************   unlink   ********************************************
   function del_file_ftp($file_for_del){

 global $FTP;
  $this->ftp = $FTP;

      $conn_id = ftp_connect($this->ftp['server']);
      $login_result = @ftp_login($conn_id, $this->ftp['user_name'], $this->ftp['user_pass']);
   if ((!$conn_id) || (!$login_result)) {
      //echo "FTP connection for unlink has failed!";
      return false;
      exit;
   } else {
      //echo "Connected for unlink<br/>";
       }
      $unlink = @ftp_delete($conn_id,$this->ftp['server'].'/../'.$file_for_del); //--แต่ถ้าทำชี้พาทแบบนี้ก็ต้องชี้ ftp ใน app cld_regis เลย
   if (!$unlink) {
     // echo" unlink failed";
     return false;
   }
      ftp_close($conn_id);
   } //end function
//********************************************************************************

//**********************************************************************************
function get_file_ftp($link_file){
      global $FTP;
  $this->ftp = $FTP;

      $conn_id = ftp_connect($this->ftp['server']);
      $login_result = @ftp_login($conn_id, $this->ftp['user_name'], $this->ftp['user_pass']);
   if ((!$conn_id) || (!$login_result)) {
      //echo "FTP connection for get file has failed!";
      return false;
      exit;
   } else {
      //echo "Connected for getfile<br/>";
      //var_dump($link_file);exit;
      $getfile = @ftp_get($conn_id,$link_file,$link_file,FTP_ASCII);
               if (!$getfile) {
                     //echo" getfile failed";
                     return false;
               }else {
                     return $link_file;
               }

        }
        
  ftp_close($conn_id);
 }

//**********************************************************************************
function PHPalert($txt_alert){
	echo"	<script  language=\"javascript\">
			alert('".$txt_alert."');
		</script>";
}
function check_user($user_id){
	$sql="select * from employee where id_user='$user_id'"; //and Password='".$password."'";
	$ar_data =  $this->db->query($sql);

	$return  = $this->db->fetch_assoc($ar_data);
	return($return);
}

} // End Class
?>