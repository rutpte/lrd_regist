<?php
$to = 'admin@localroadregis.drr.go.th';
$subject = 'test mail server';
$message = 'This is my first  e-mail in my life';
 
$header = "MIME-Version: 1.0\r\n" ;
$header .= "Content-type: text/html; charset=UTF-8\r\n" ;
$header .= "From:user@localroadregis.drr.go.th\r\n" ;
 
if( mail( $to , $subject , $message , $header ) ){ 
	echo 'Complete.';
}else{
	echo 'Incomplete.';
}
?>