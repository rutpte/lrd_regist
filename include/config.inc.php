<?php
 // database ตัวใหม่ล่าสุด วันนี้วันที่ 18/10/2555
 
// winti new
/*
$DB["host"]   = "172.16.9.222";
$DB["dbName"] = "drr_cld_db_king";
$DB["user"]   = "rut";
$DB["pass"]   = "pgpteadmin";  */
 //*ค่านี้เอาไว้ติดต่อดาต้าเบส ใน winti เก่า
/*
$DB["host"]   = "172.23.0.36";
$DB["dbName"] = "drr_cld_db";             #<<#####################################################
$DB["user"]   = "postgres";
$DB["pass"]   = "--";
                                      */
 /////////////////////////////////////  -->ของโปรแกรมเมอร์เก่าที่ทำโปรเจ็คนี้
//$DB["host"]   = "--";
//$DB["dbName"] = "--";
//$DB["user"]   = "--";
//$DB["pass"]   = "--";

//for depoid
 // winti
$DB["host"]   = "172.16.9.222";
$DB["dbName"] = "--";
$DB["user"]   = "postgres";
$DB["pass"]   = "pgpteadmin";

#------------------  FTP     --------------------------------------------------------
    //**********************************************#
             $FTP["server"] = "127.0.0.1";         #
            $FTP["user_name"] = "cld";         #
            $FTP["user_pass"] = "cld";
            $FTP["domain_data"] = "127.0.0.1";
               #
           /*   $FTP["server"] = "--";         #
            $FTP["user_name"] = "--";         #
            $FTP["user_pass"] = "--";
            $FTP["domain_data"] = "--";  */
   //***********************************************#
#-------------------------------------------------------------------------------------
	$SELF = $HTTP_SERVER_VARS['PHP_SELF'];
	if(empty($SID))
	  $SID = Session_ID(); // Create session id referent (Require session_start() and PHP4 up)
	
	$$SELF = $HTTP_SERVER_VARS['PHP_SELF'];
	if(empty($SID))
	  $SID = Session_ID(); // Create session id referent (Require session_start() and PHP4 up)
	
	$TODAY = date('d/m/Y H:i:s');
	$TIMESTAMP = date('YmdHis');

	$project_title = "ระบบรายงานผลการลงทะเบียนข้อมูลทางหลวงท้องถิ่น";

?>
