<?php
if($to=="" || $subject=="" || $message=="" || $from=="" )//��Ǩ�ͺ����觢�ͤ�����Ҥú�������
{
		echo"<center>��͡���������ú<br>";
		echo"<a href=javascript:history.back();>��Ѻ����</a></center>";
		exit();

}else{//��Ҷ١��ͧ���Թ��������������

if (mail($to, $subject, $message, $from))
	{
	
	echo "<center>��й������������� $to ���º��������</br>";
	echo"<a href=formmail.html>��Ѻ��觵���ա</a></center>";

	}
}
?>

