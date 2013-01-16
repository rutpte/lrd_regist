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
///////////////////////////////////////////////////////////////////// UPLOAD _FILE //////////////////////////////////////////////////////
##########################################################################################################################################

function  upload_file($file,$mainpath,$path,$fir_dir,$way_id){

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

 if ((!$conn_id) || (!$login_result)) {
    return false;

 } else {}
$check_dir=$this->check_dir_id($conn_id,$fir_dir,$way_id);   //prepra dir
if($check_dir!=true){
  // echo "check_dir is false";
   exit;
}else{
   //echo "check_dir is true<br>";

 // var_dump($path);     echo "<br>";
  //var_dump($conn_id);     echo "<br>";
#------------------------------
 ftp_chdir($conn_id,$path);
// exit;
}      
 $upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY);  

 if (!$upload) {

     return false;
  }else{
  

   return  $destination_file;
  }
  
// close the FTP stream  
ftp_close($conn_id);//close 
 }

//////////////////////////////////////////////////////////////////////////////////////////////////////////
#****************************** check dir id and create doc image folder *************************************************************************
function check_dir_id($conn_id,$link,$way_id){
 // global $conn_id;
 // $conn_id = $conn_id;
 

 $dir_f=$link;
 $dir_id=$way_id;
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
                       ftp_chdir($conn_id, $current_path);
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
   function del_file_ftp($link,$way_id,$attach_type,$file_for_del){

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
       #--------------------------------------------------------------
          // $fil_del=$link."/".$way_id."/".$attach_type."/".$file_for_del;
           //$unlink =@unlink($fil_del);
       #--------------------------------------------------------------
             //$link_del=$this->ftp['server']."/".$link."/".$way_id."/".$attach_type."/".$file_for_del;
              $link_del=$link."/".$way_id."/".$attach_type."/".$file_for_del;
             //echo $link_del; exit;
     $unlink = @ftp_delete($conn_id,$link_del); //--แต่ถ้าทำชี้พาทแบบนี้ก็ต้องชี้ ftp ใน app cld_regis เลย
   if (!$unlink) {
     // echo" unlink failed";
     return false;
   }
      ftp_close($conn_id);
   } //end function
//**********************************************************************************

//**********************************************************************************
function get_file_ftp($link_file,$file_name_server,$path_temp){
$rootpath=$_SERVER['DOCUMENT_ROOT'];
  //$path_temp=$path_temp;
  $path_local= $rootpath."/".$path_temp;
// define some variables
$local_file = $path_local."/".$file_name_server;
$server_file = $link_file."/".$file_name_server;

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
      $getfile = @ftp_get($conn_id,$local_file,$server_file,FTP_ASCII);
               if (!$getfile) {
                     //echo" getfile failed";
                     return false;
               }else {
                     return $local_file;
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