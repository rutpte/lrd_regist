<? include "check.php";
include "unset_regis.php";
?>
<script type="text/javaScript">

function check_num(e) 


{
var keyPressed; 
    
    if(window.event){ 
        keyPressed = window.event.keyCode; // IE 
if ( keyPressed != 46 & ( keyPressed < 48 || keyPressed > 57 ) ){ window.event.returnValue = false; }
    }else{ 
        keyPressed = e.which; // Firefox        
   if ( keyPressed != 46 & ( keyPressed < 48 || keyPressed > 57 ) ){ keyPressed = e.preventDefault(); }
 } 

};
function check_num1(e) 


{
var keyPressed; 
    
    if(window.event){ 
        keyPressed = window.event.keyCode; // IE 
     if ((keyPressed < 48) || (keyPressed > 59)) window.event.returnValue = false; 
    }else{ 
        keyPressed = e.which; // Firefox        
   if ((keyPressed < 48) || (keyPressed > 59)) keyPressed = e.preventDefault(); 
 } 

};

</script>
  



<? 
$id_province =$_GET['id_province'];
$sqlN="select id_residence,name_province from province where id_province='$id_province'";
$resultN=$db->query($sqlN);
$rsN=$db->fetch_array($resultN);
 $sqlS="select name_residence from residence where id_residence='$rsN[id_residence]'";
  $resultS=$db->query($sqlS);
  $rsS=$db->fetch_array($resultS);
$sql="select * from municipality where id_province='$id_province' order by num_orders,id_mun asc";
$result=$db->query($sql);


?>

<!--<link href="css/register.css" rel="stylesheet" type="text/css" />-->
<form id="form1" name="form1" method="post" action="manage_mun_register_proc.php">


<table width="73%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="3" class="th14white"  align="left"><a href="manage.php?page=manage_province_register_mun" class="th_red12b"><<<กลับ</a></td>
  </tr>
  <tr>
    <td colspan="3" class="th14white" bgcolor="#336699" align="center">อปท.จังหวัด<? echo $rsN['name_province']?>&nbsp;<? echo $rsS['name_residence']?></td>
  </tr>

  <tr bgcolor="#CC9933">
      <td width="8%" class="th_head_back14" align="center">ลำดับ</td>


	<td width="34%" class="th_head_back14" align="center">ชื่อหน่วยงานอปท.</td>
     
     <td width="29%" class="th_head_back14" align="center">เพิ่ม/แก้ไข จำนวนระยะทาง (กม)</td>
  </tr>
  <? 
$a=1;  
   $num=$Page_start;
  while($rs=$db->fetch_array($result)){
     $num++;
   
   if($a%2==1){
 $bg="CCFF99";
 
 }else if($a%2==0){
 $bg="99FFFF";
 
 }
 
  ?>
  <tr bgcolor="<?  echo $bg?>">
  <td class="th_head_back12" align="center">&nbsp; <? echo  $num.".";?></td>
  
	
		<td class="th_head_back12" align="left">&nbsp; <? echo $rs['name_mun'];?></td>
 
  <td class="th12black" align="center"><input type="text" name="amount_phase_way[]" id="amount_phase_way[]" value="<? if($rs['amount_phase_way']!=""){echo number_format($rs['amount_phase_way'],3,'.',',');}?>" style="width:80px"  onkeypress="check_num(event)"  /> <input type="hidden" name="id_mun[]" id="id_mun[]" value="<? echo $rs['id_mun'];?>" /></td>
  <? if($a==15){?>
    <tr>
    <td colspan="3"  align="center" bgcolor="#00CCFF" class="th14white"><input type="submit" name="Submit" id="Submit" value="จัดเก็บข้อมูล/แก้ไขข้อมูล" /></td>
  </tr><? $a=0;}?>
  </tr><? $a++; $i++;} ?>
   <tr bgcolor="#00CCFF">
    <td colspan="3" align="center" bgcolor="#00CCFF" class="th12black"><input type="submit" name="Submit" value="จัดเก็บข้อมูล/แก้ไขข้อมูล" />&nbsp;
      
	  <input type="hidden" name="id_province" id="id_province" value="<? echo $id_province;?>" />
	 </td>
    </tr>
</table>
edt

</form>
