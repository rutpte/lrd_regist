<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--[if lt IE 7.]>
<script defer type="text/javascript" src="pngfix.js"></script>
<![endif]-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SamuiFoodGuide.com</title>


</head>

<body>

		<?  
	
		$REFERER  = $_SERVER['HTTP_REFERER'];
			$data['name_contact']=$_POST['name'];
			$data['email_contact']=$_POST['email'];
			$data['message_contact']=$_POST['message'];
			$tb_name="contact";
	
		$sendTo ="contact@samuifoodguide.com";
		$subject = "ติดต่อจากคุณ $_POST[name]<$_POST[email]>";
		$headers  = 'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; 
		$headers .= "From: Contact www.samuifoodguide.com<contact@samuifoodguide.com> \r\n";
		$headers .= "Reply-To: $_POST[email] \r\n";
		$headers .= "Return-path: $_POST[email]";	
		
		$message =$_POST['message'];
	
		
		mail($sendTo, $subject, $message, $headers);
	echo "<script>alert('ได้รับการติดต่อจากคุณแล้ว');	
				window.location ='$REFERER';</script>
				";
			
		?>
</body>
</html>