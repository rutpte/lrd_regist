<? session_start();
include "header.php";
//$tb_name="log_login";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $project_title;?></title>
<link href="css/register.css" rel="stylesheet" type="text/css" /><? 
//check input capt with session captcha


//define('TOP_SECRET','The Top Secret From Drr Developer By Prapad Nedpakdee'); 
//--$sql="select * from personnel where username_per='$_POST[username_per]' and status_personnel='0' ";
    //var_dump($sql);
//--$result=$db->query($sql);
//--$num = $db->num_rows($result);
//--$rs=$db->fetch_array($result);
//--$id_personnel=$rs['id_personnel'];
//--$username_per=$rs['username_per'];
//--$password_per=$rs['password_per'];
//--$name_personnel=$rs['name_personnel'];
//--$type_personnel=$rs['type_personnel'];
                                                  // ถ้ารหัสไม่ตรงกันทั้งสอง

//var_dump($username_per,$password_per,md5($_POST['password_per'].TOP_SECRET));  //ตรวจสอบ ตัวแปร และค่าของตัวแปร
//var_dump(md5($_POST['password_per'].TOP_SECRET) == $password_per, md5($_POST['password_per'].TOP_SECRET), $password_per);
//exit;
//////////////////////////////////////////////////////////////////////////////////////////////////
$user_post=$_POST[username_per];
$pass_post=$_POST[password_per];
//-------------------------------//
        require_once('nusoap095/lib/nusoap.php');

	$host = "http://winti.pte.co.th";
	//$host="http://192.168.157.36";
	$wsdlAuthen = $host."/cld_usermanage/services/UserAuthen?wsdl";
	$wsdlAuthorize = $host."/cld_usermanage/services/UserAuthorize?wsdl";
	$wsdlUserInfo = $host."/cld_usermanage/services/UserInfoUtils?wsdl";

	$username = "$user_post";
	$password = "$pass_post";

	//=========== login via web service ==========
	$client = new nusoap_client($wsdlAuthen, true);          //send 1   
	$proxy = $client->getProxy();
	$result = $proxy->authentication(array("in0"=>$username, "in1"=>$password));

	//echo "<pre>";
	//echo "====== Call service authentication() ======<br/>";
	//var_dump($result);
	//echo "</pre>";

	//=========== get user role ==========
	$loginSuccess = $result['out']['anyType'][0];
	$keyVerify = $result['out']['anyType'][1];
	
	if($loginSuccess){
	#-------------------------- new ----------------------------------------

		//echo "========== login success ==========<br/>";
		$client = new nusoap_client($wsdlUserInfo, true); 
		$proxy = $client->getProxy();
		$result = $proxy->getUserInfo(array("in0"=>$username));

		//echo "<br/>>>> role name : ".$result['out']['roleName']['string'];
		//echo "<br/>>>> first name : ".$result['out']['firstName'];
		//echo "<br/>>>> province id : ".$result['out']['provinceId'];

      $rolename=$result['out']['roleName']['string'];
      $firstName=$result['out']['firstName'];
      $provinceID=$result['out']['provinceId'];
		//echo "<pre>";
		//var_dump($result);
	   // echo "</pre>";
      // exit;
	#----------------------------- old -------------------------------------
      /*
		//echo ">>> login success";
		$client = new nusoap_client($wsdlAuthorize, true);          //send 2
		$proxy = $client->getProxy();
		$result = $proxy->getUserRole(array("in0"=>$username, "in1"=>$keyVerify));
      #$result = $proxy->getUserRole(array("in0"=>$username, "in1"=>$keyVerify));
      #$result = $proxy->getUserRole(array("in0"=>$username, "in1"=>$keyVerify));

		//echo "<pre>";
		//echo "====== Call service getUserRole() ======<br/>";
		//var_dump($result);
		//echo "</pre>";

		$rolename = $result['out']['string'];
      # $fullname = $result['out']['string'];
      # $id_province = $result['out']['string'];

		//echo ">>> username : ".$username;
		//echo "<br/>>>> password : ".$password;
		//echo "<br/>>>> rolename : ".$rolename; //<<--นี่คือค่าที่เอามาตรวจสอบ เพื่อหาค่า logtype

      //ถ้า $rolename มีค่ามากกว่า 2 แสดงว่า มีค่าอื่นที่ไม่เกี่ยวข้องติดมาด้วย ก็ให้ลูปหาค่าที่ตรงกันมาใช้
      //echo"<br>";
      */
	}else{
		//echo ">>> login fail";  ?>
		       <script>
            alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');history.back();
					</script>
					<?
	}

//////////////////////////////////////////////////////////////////////////////////////////////////
//***************************************************************************************************
    $num_rol=count($rolename);  //นับ 0 ด้วย

    //--echo"num=$num_rol<br>";  //nan==2
    if($num_rol>1){
    for($i=0;$i<=$num_rol;$i++){
      // echo"rut_fect_array="; echo $rolename[$i]; echo"<br>";
       if($rolename[$i]=="ROLE_ADMIN"){
               $role="ROLE_ADMIN";
             }else if($rolename[$i]=="ROLE_DRR_LOCDEV"){
                 $role="ROLE_DRR_LOCDEV";
             }else if($rolename[$i]=="ROLE_DRR_BUREAU"){
                  $role="ROLE_DRR_BUREAU";
             }else if($rolename[$i]=="ROLE_DRR_PROV"){
                   $role="ROLE_DRR_PROV";
             }
       }
    } else{
        $role=$rolename;
    }
     //   echo"<br>";   echo "role=$role";  exit;
//***************************************************************************************************
         if($role=="ROLE_ADMIN"){
                $type_personnel=1;
             }else if($role=="ROLE_DRR_LOCDEV"){
                  $type_personnel=2;
             }else if($role=="ROLE_DRR_BUREAU"){
                   $type_personnel=3;
             }else if($role=="ROLE_DRR_PROV"){
                   $type_personnel=4;
             }else {
             //$type_personnel="";
             echo"<script>alert ('no have permission please connect administrator');</script>";
             echo"<script>history.back();</script>";
             exit;
              }

            // echo"<br>" ; echo"logtype=$type_personnel";
//----------------------------------------------------------------------------------------------------//
//exit;

            //อันนี้สำหรับ แปลงค่า logtype
            /*
            1=admin(ROLE_ADMIN)
            2=สสท.(ROLE_DRR_LOCDEV)
            3=สทช.(ROLE_DRR_BUREAU)
            4=ทชจ.(ROLE_DRR_PROV)      */

             //$id_personnel = "ถ้าเกิดว่าตัดไปล่ะ";
            // $username_per =  "";
             $name_personnel ="$firstName";
             $id_province="$provinceID";
             //-------------------------------------------------//
							//$_SESSION['LOGID']=$id_personnel;
							//$_SESSION['LOGID']=4;
							// $_SESSION['LOGUSER']=$username_per;
							// $_SESSION['LOGPASS']=$password_per;  //เอามาจากฐานข้อมูลทั้งนั้น สำหรับตัวนี้ บวก topsecret ให้แล้ว
							 $_SESSION['LOGNAME']=$name_personnel;
							 $_SESSION['LOGTYPE']=$type_personnel; //กำหนด เมนู,  admind เท่านั้นเป็น 1
                       $_SESSION['id_province']=$id_province;//<<---รอจากพี่โอม

    #------------------------------------------------------------------------#
                  if (getenv(HTTP_X_FORWARDED_FOR))                          #
                  {                                                          #
                                                                             #
                  $ip=getenv(HTTP_X_FORWARDED_FOR);                          #
                                                                             #
                  }                                                          #
                  else                                                       #
                  {                                                          #
                  $ip=getenv(REMOTE_ADDR);                                   #
                  }                                                          #
    #------------------------------------------------------------------------#
                          //get ip address

                           //เก็บค่า log ของการ login เก็บ ip เวลา คนเข้า
                       // insert data  โดยไม่ต้องใช้คำสั่ง sql ทำได้ไง *****แล้วฟังชั่น add_data มาจากไหน????
							 //$data['id_personnel']=$_SESSION['LOGID'];
							 //$data['date_time']=date("Y-m-d H:i:s");
 							// $data['ip_login']=$ip;
							//$add_data = $db->add_data($tb_name,$data,$funcs) ; เก็บ logfile
						  if($_SESSION['LOGTYPE']!=5){?>
						  
						<script language="JavaScript">
								alert('ยินดีต้อนรับเข้าสู่ระบบ');
							 window.location.href = 'manage.php' ;
						  </script> 
						<? }else if($_SESSION['LOGTYPE']==5){?>
						<script language="JavaScript">
							alert('ยินดีต้อนรับเข้าสู่ระบบ');
							 window.location.href = 'main.php' ; // this page no execute 
						  </script> 
						
					<? }	
		$db->close_db();	
			
?>
</body>
</html>