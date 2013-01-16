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


define('TOP_SECRET','The Top Secret From Drr Developer By Prapad Nedpakdee'); 
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

        require_once('nusoap095/lib/nusoap.php');

	$host = "http://winti.pte.co.th";
	$wsdlAuthen = $host."/cld_usermanage/services/UserAuthen?wsdl";
	$wsdlAuthorize = $host."/cld_usermanage/services/UserAuthorize?wsdl";

	$username = "$user_post";
	$password = "$pass_post";

	//=========== login via web service ==========
	$client = new nusoap_client($wsdlAuthen, true);          //send 1
	$proxy = $client->getProxy();
	$result = $proxy->authentication(array("in0"=>$username, "in1"=>$password));

	echo "<pre>";
	echo "====== Call service authentication() ======<br/>";
	var_dump($result);
	echo "</pre>";

	//=========== get user role ==========
	$loginSuccess = $result['out']['anyType'][0];
	$keyVerify = $result['out']['anyType'][1];
	
	if($loginSuccess){
		echo ">>> login success";
		$client = new nusoap_client($wsdlAuthorize, true);          //send 2
		$proxy = $client->getProxy();
		$result = $proxy->getUserRole(array("in0"=>$username, "in1"=>$keyVerify));

		echo "<pre>";
		echo "====== Call service getUserRole() ======<br/>";
		var_dump($result);
		echo "</pre>";

		$rolename = $result['out']['string'];

		echo ">>> username : ".$username;
		echo "<br/>>>> password : ".$password;
		echo "<br/>>>> rolename : ".$rolename;
	}else{
		echo ">>> login fail";
	}

//////////////////////////////////////////////////////////////////////////////////////////////////


	if ($num==0||md5($_POST['password_per'].TOP_SECRET) != $password_per){ ?> <!--เอาค่าจาก text มาบวกกับ top_secret เพื่อตรวจสอบว่าตรงกันใหมกับค่าในฐานข้อมูล(ค่าในฐานข้อมูลถูก บวกtopsecret ไว้ตอนสมัคร)-->

	<script>
	//	alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');history.back();
					</script>
			<?		//exit;	}

			else{
            //อันนี้สำหรับ แปลงค่า logtype
            /*
            1=admin(ROLE_ADMIN)
            2=สสท.(ROLE_DRR_LOCDEV)
            3=สทช.(ROLE_DRR_BUREAU)
            4=ทชจ.(ROLE_DRR_PROV)      */




			   // register แบบ รับค่าเลย **ไม่เคยเห็น
							 $_SESSION['LOGID']=$id_personnel;
							 $_SESSION['LOGUSER']=$username_per;
							 $_SESSION['LOGPASS']=$password_per;  //เอามาจากฐานข้อมูลทั้งนั้น สำหรับตัวนี้ บวก topsecret ให้แล้ว
							 $_SESSION['LOGNAME']=$name_personnel;
							 $_SESSION['LOGTYPE']=$type_personnel; //กำหนด เมนู,  admind เท่านั้นเป็น 1
	if (getenv(HTTP_X_FORWARDED_FOR)){

 $ip=getenv(HTTP_X_FORWARDED_FOR);

}else{$ip=getenv(REMOTE_ADDR); }      //get ip address

                           //เก็บค่า log ของการ login เก็บ ip เวลา คนเข้า
                       // insert data  โดยไม่ต้องใช้คำสั่ง sql ทำได้ไง *****แล้วฟังชั่น add_data มาจากไหน????
							 $data['id_personnel']=$_SESSION['LOGID'];
							 $data['date_time']=date("Y-m-d H:i:s");
 							 $data['ip_login']=$ip;
							//$add_data = $db->add_data($tb_name,$data,$funcs) ; เก็บ logfile
						  if($_SESSION['LOGTYPE']!=5){?>
						  
						<script language="JavaScript">
								//--alert('ยินดีต้อนรับเข้าสู่ระบบ');
							 // --window.location.href = 'manage.php' ;
						  </script> 
						<? }else if($_SESSION['LOGTYPE']==5){?>
						<script language="JavaScript">
							//	--alert('ยินดีต้อนรับเข้าสู่ระบบ');
							 //-- window.location.href = 'main.php' ; //หน้านี้สำหรับ คนทั่วไป (คือ 5) เข้าไปดูรายงานได้อย่างเดียว
						  </script> 
						
					<? }	
		$db->close_db();	}
			
?>
</body>
</html>