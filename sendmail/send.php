<?php
if($_POST['to']=="" || $_POST['subject']=="" || $_POST['message']=="" || $_POST['from']=="" )//��Ǩ�ͺ����觢�ͤ�����Ҥú�������
{
		echo"<center>��͡���������ú<br>";
		echo"<a href=javascript:history.back();>��Ѻ����</a></center>";
		exit();

}else{//��Ҷ١��ͧ���Թ��������������

if (mail($_POST['to'], $_POST['subject'], $_POST['message'], $_POST['from']))
	{
	
	echo "<center>��й������������� $to ���º��������</br>";
	echo"<a href=formmail.html>��Ѻ��觵���ա</a></center>";

	}
}
?>

