<? session_start();  
  //หน้านี้คือ หน้าที่ฟังชั่น postDataReturnText ร้องขอมา
?>
<!DOCTYPE>         <!--html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="css/register.css" rel="stylesheet" type="text/css" />
</head>

<body> <? //var_dump($_POST['sess_road_del']); var_dump($_POST['add_data']); var_dump($_POST['edit']); var_dump($_POST['numS']); ?>
<? ////////////////////////////////////////////////////////////////////////////////////////////
if($_POST['sess_road_del']!=""){
$chk[]=$_POST['sess_road_del'];

for ($i=0;$i<count($_SESSION['sess_period_regis']);$i++) {

		if (!in_array($_SESSION['sess_period_regis'][$i],$chk)) {  //      ค้นหาค่าอาเรย์ ในตัวแปรอาเรย์
		
			$temp_period_regis[]=$_SESSION['sess_period_regis'][$i];
			$temp_kate_regis[]=$_SESSION['sess_kate_regis'][$i];
			$temp_distance_regis[]=$_SESSION['sess_distance_regis'][$i];
			$temp_jarat_road[]=$_SESSION['sess_jarat_road'][$i];
			$temp_type_ja[]=$_SESSION['sess_type_ja'][$i];
			$temp_width_ja[]=$_SESSION['sess_width_ja'][$i];
			$temp_type_sh[]=$_SESSION['sess_type_sh'][$i];
			$temp_width_sh[]=$_SESSION['sess_width_sh'][$i];
			$temp_type_fo[]=$_SESSION['sess_type_fo'][$i];
			$temp_width_fo[]=$_SESSION['sess_width_fo'][$i];
			$temp_note[]=$_SESSION['sess_note'][$i];
		}
}   //end for

$_SESSION['sess_period_regis']=$temp_period_regis;
$_SESSION['sess_kate_regis']=$temp_kate_regis;
$_SESSION['sess_distance_regis']=$temp_distance_regis;
$_SESSION['sess_jarat_road']=$temp_jarat_road;
$_SESSION['sess_type_ja']=$temp_type_ja;
$_SESSION['sess_width_ja']=$temp_width_ja;
$_SESSION['sess_type_sh']=$temp_type_sh;
$_SESSION['sess_width_sh']=$temp_width_sh;
$_SESSION['sess_type_fo']=$temp_type_fo;
$_SESSION['sess_width_fo']=$temp_width_fo;
$_SESSION['sess_note']=$temp_note;
if($_SESSION['sess_distance_regis']!=""){
$_SESSION['sess_sum_distance']=array_sum($_SESSION['sess_distance_regis']); //รวมระยะทาง//หาผลรวมของค่าทั้งหมดในตัวแปร อาเรย์มาบวกกัน 
}//end if line 46
 }    //end if  line 17

 /////////////////////////////////// if  post=add_data////////////////////////////////////////////////////
if($_POST['add_data']!=""){     //ตอนกดปุ่ม แอด เพิ่มข้อมูลลักษณะสายทาง


$nums=count($_SESSION['sess_period_regis']);
$_SESSION['sess_period_regis'][]=$nums;
$_SESSION['sess_kate_regis'][]=$_POST['kate_regis'];
$_SESSION['sess_distance_regis'][]=$_POST['distance_regis'];
$_SESSION['sess_jarat_road'][]=$_POST['jarat_road'];
$_SESSION['sess_type_ja'][]=$_POST['type_ja'];
$_SESSION['sess_width_ja'][]=$_POST['width_ja'];
$_SESSION['sess_type_sh'][]=$_POST['type_sh'];
$_SESSION['sess_width_sh'][]=$_POST['width_sh'];
$_SESSION['sess_type_fo'][]=$_POST['type_fo'];
$_SESSION['sess_width_fo'][]=$_POST['width_fo']; 
$_SESSION['sess_note'][]=$_POST['note']; 
$_SESSION['sess_sum_distance']=array_sum($_SESSION['sess_distance_regis']);
$_SESSION['check']=1;

}
/////////////////////////////////////if post=edit/////ปุ่มปรับปรุ่งข้อมูล////////////////////////////////////
if($_POST['edit']==1){
		unset($_SESSION['sess_period_regis']);
		unset($_SESSION['sess_kate_regis']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_jarat_road']);
		unset($_SESSION['sess_type_ja']);
		unset($_SESSION['sess_width_ja']);
		unset($_SESSION['sess_type_sh']);
		unset($_SESSION['sess_width_sh']);
		unset($_SESSION['sess_type_fo']);
		unset($_SESSION['sess_width_fo']);
		unset($_SESSION['sess_note']);
		unset($_SESSION['sess_distance_regis']);
		unset($_SESSION['sess_sum_distance']);
	
		$arrayKate=explode(",",$_POST['send_edit_kate_regis']);
		$arrayDistance=explode(",",$_POST['send_edit_distance_regis']);
		$arrayJarat_road=explode(",",$_POST['send_edit_jarat_road']);
		$arrayType_ja=explode(",",$_POST['send_edit_type_ja']);
		$arrayWidth_ja=explode(",",$_POST['send_edit_width_ja']);
		$arrayType_sh=explode(",",$_POST['send_edit_type_sh']);
		$arrayWidth_sh=explode(",",$_POST['send_edit_width_sh']);
		$arrayType_fo=explode(",",$_POST['send_edit_type_fo']);
		$arrayWidth_fo=explode(",",$_POST['send_edit_width_fo']);
		$arrayEdit_note=explode(",",$_POST['send_edit_note']);   //////////>>>

   if($_POST['numS']!=""){
         for($i=0;$i<$_POST['numS'];$i++){
            $_SESSION['sess_period_regis'][]=$i;
            $_SESSION['sess_kate_regis'][]=$arrayKate[$i];
            $_SESSION['sess_distance_regis'][]=$arrayDistance[$i];
            $_SESSION['sess_jarat_road'][]=$arrayJarat_road[$i];
            $_SESSION['sess_type_ja'][]=$arrayType_ja[$i];
            $_SESSION['sess_width_ja'][]=$arrayWidth_ja[$i];
            $_SESSION['sess_type_sh'][]=$arrayType_sh[$i];
            $_SESSION['sess_width_sh'][]=$arrayWidth_sh[$i];
            $_SESSION['sess_type_fo'][]=$arrayType_fo[$i];
            $_SESSION['sess_width_fo'][]=$arrayWidth_fo[$i];
            $_SESSION['sess_note'][]=$arrayEdit_note[$i];     ///////////////>>>
         }
         if($_SESSION['sess_distance_regis']){
                $_SESSION['sess_sum_distance']=array_sum($_SESSION['sess_distance_regis']);
         }
   $_SESSION['check']=2;
   }

	

}
//////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<table width="940" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
  <tr bgcolor="#8AACE8">
    <td width="42" rowspan="2" class="th16white" align="center">ช่วงที่</td>
    <td width="57" rowspan="2" align="center" class="th16white" >เขตทาง<br/>
      กว้าง
    (ม.)</td>
    <td width="44" rowspan="2" align="center" class="th16white" >ระยะ<br/>
      ทาง<br/>
    (กม.)</td>
	
    <td width="51" rowspan="2" align="center" bgcolor="#8AACE8" class="th16white" >จำนวน<br/>
      ช่อง<br/>จราจร<br/>
      ต่อทิศ<br/>ทาง<br/>
    (ช่อง)</td>
    <td colspan="2" align="center" class="th16white">ผิวจราจร 2 ทิศทาง</td>
    <td colspan="2" align="center" class="th16white">ไหล่ทาง</td>
	<td colspan="2" align="center" class="th16white">ทางเท้า</td>
	<td width="104" rowspan="2" align="center" class="th16white">หมายเหตุ</td>
	
    <td width="22" rowspan="2" align="center" class="th16white">&nbsp;</td>
  </tr>
    <tr>
    <td width="97" height="22" align="center" bgcolor="#8AACE8" class="th16white">ประเภท</td>
    <td width="55" align="center" bgcolor="#8AACE8" class="th16white">กว้าง (ม.)</td>
    <td width="97" align="center" bgcolor="#8AACE8" class="th16white">ประเภท</td>
    <td width="65" align="center" bgcolor="#8AACE8" class="th16white">กว้าง (ม.)</td>
	<td width="215" align="center" bgcolor="#8AACE8" class="th16white">ประเภท</td>
    <td width="65" align="center" bgcolor="#8AACE8" class="th16white">กว้าง (ม.)</td>
  </tr><? $numS=count($_SESSION['sess_period_regis']) ;
  
 $b=$_SESSION['numD'];
  for($i=0;$i<$numS;$i++){
?>
  <tr>
     <td  class="th14bgray" align="center"><? echo $i+1; ?>.</td>
     <td   align="center" class="th14bgray" ><input name = "edit_kate_regis<? echo $i;?>"  id = "edit_kate_regis<? echo $i;?>" value="<? if($_SESSION['sess_kate_regis'][$i]!=""){ echo number_format($_SESSION['sess_kate_regis'][$i],2,'.',''); }?>" style="width:40px;text-align:center"    onkeypress="check_num(event)" /></td>
    <td  align="center" class="th14bgray" ><input name="edit_distance_regis<? echo $i;?>" type="text" id="edit_distance_regis<? echo $i;?>" value="<? if($_SESSION['sess_distance_regis'][$i]!=""){ echo number_format($_SESSION['sess_distance_regis'][$i],3,'.',''); }?>" style="width:40px;text-align:center"    onkeypress="check_num(event)"/></td>
    <td   align="center" class="th14bgray" ><input name="edit_jarat_road<? echo $i;?>" type="text" id="edit_jarat_road<? echo $i;?>" value="<? if($_SESSION['sess_jarat_road'][$i]!=""){ echo number_format($_SESSION['sess_jarat_road'][$i],0,'.',''); }?>" style="width:40px;text-align:center"    onkeypress="check_num1(event)"/></td>
    <td  align="center" class="th14bgray" ><select name="edit_type_ja<? echo $i;?>" id="edit_type_ja<? echo $i;?>" onChange="ChangeStateRadioEt(this,edit_type_sh<? echo $i;?>,edit_type_fo<? echo $i;?>);" ><option value="1" <? if($_SESSION['sess_type_ja'][$i]==1){?>selected="selected"<? }?>>- คอนกรีต -</option>
 <option value="2" <? if($_SESSION['sess_type_ja'][$i]==2){?>selected="selected"<? }?>>- ลาดยาง -</option>
 <option value="3" <? if($_SESSION['sess_type_ja'][$i]==3){?>selected="selected"<? }?>>- ลูกรัง- </option>
	</select></td>
    <td  align="center" class="th14bgray" ><input name="edit_width_ja<? echo $i;?>" type="text" id="edit_width_ja<? echo $i;?>" value="<?  if($_SESSION['sess_width_ja'][$i]!=""){ echo  number_format($_SESSION['sess_width_ja'][$i],2,'.',','); }?>" style="width:40px;text-align:center"    onkeypress="check_num(event)"/></td>
    <td align="center" class="th14bgray" ><select name="edit_type_sh<? echo $i;?>" id="edit_type_sh<? echo $i;?>" onChange="ChangeStateRadioE(this,edit_width_sh<? echo $i;?>,edit_type_fo<? echo $i;?>);" >	
	<option value="0" <? if($_SESSION['sess_type_sh'][$i]==0||$_SESSION['sess_type_fo'][$i]=="0"){?>selected="selected"<? }?>>- ไม่มี -</option>  <!--type_sh เปลี่ยนค่า ไม่มีให้เป็น 9 จาก 0-->
	<option value="1" <? if($_SESSION['sess_type_sh'][$i]==1){?>selected="selected"<? }?>>- คอนกรีต -</option>
 <option value="2" <? if($_SESSION['sess_type_sh'][$i]==2){?>selected="selected"<? }?>>- ลาดยาง -</option>
 <option value="3" <? if($_SESSION['sess_type_sh'][$i]==3){?>selected="selected"<? }?>>- ลูกรัง- </option>
	</select></td>
    <td  align="center" class="th14bgray" ><?   if($_SESSION['sess_width_sh'][$i]!=""&&$_SESSION['sess_type_sh'][$i]!=0&&$_SESSION['sess_type_sh'][$i]!=9){ ?><input name="edit_width_sh<? echo $i;?>" type="text" id="edit_width_sh<? echo $i;?>" value="<? echo number_format($_SESSION['sess_width_sh'][$i],2,'.','');?>" style="width:40px;text-align:center"    onkeypress="check_num(event)" /><? }else{ ?> <input name="edit_width_sh<? echo $i;?>" type="text" id="edit_width_sh<? echo $i;?>" value="N.A." style="width:40px;text-align:center"    onkeypress="check_num(event)" disabled="disabled"/><? } ?></td>
	<td  align="center" class="th14bgray" ><select name="edit_type_fo<? echo $i;?>" id="edit_type_fo<? echo $i;?>" onChange="ChangeStateRadioE1(this,edit_width_fo<? echo $i;?>,edit_type_sh<? echo $i;?>);" >		
		<option value="0" <? if($_SESSION['sess_type_fo'][$i]==0||$_SESSION['sess_type_fo'][$i]=="0"){?>selected="selected"<? }?>>- ไม่มี -</option>   <!--type_fo เปลี่ยนค่า ไม่มีให้เป็น 9 จาก 0-->
	<option value="1" <? if($_SESSION['sess_type_fo'][$i]==1){?>selected="selected"<? }?>>- กระเบื้องคอนกรีตปูพื้น -</option>
 <option value="2" <? if($_SESSION['sess_type_fo'][$i]==2){?>selected="selected"<? }?>>- คอนกรีตบล็อกประสานปูพื้น -</option>
 <option value="3" <? if($_SESSION['sess_type_fo'][$i]==3){?>selected="selected"<? }?>>- กระเบื้องซีเมนต์ปูพื้น -</option>
  <option value="4" <? if($_SESSION['sess_type_fo'][$i]==4){?>selected="selected"<? }?>>- วัสดุปูทางเท้าอื่นๆ - </option>
	</select></td>
    <td  align="center" class="th14bgray" ><?   if($_SESSION['sess_width_fo'][$i]!=""&&$_SESSION['sess_type_fo'][$i]!=0&&$_SESSION['sess_type_sh'][$i]!=9){?> <input name="edit_width_fo<? echo $i;?>" type="text" id="edit_width_fo<? echo $i;?>" value="<? echo number_format($_SESSION['sess_width_fo'][$i],2,'.','');?>" style="width:40px;text-align:center"    onkeypress="check_num(event)"/><? }else{ ?><input name="edit_width_fo<? echo $i;?>" type="text" id="edit_width_fo<? echo $i;?>" value="N.A." style="width:40px;text-align:center"    onkeypress="check_num(event)" disabled="disabled"/><? } ?></td>
	<td  align="center" class="th14bgray" ><textarea name="edit_note<? echo $i;?>" id="edit_note<? echo $i;?>" cols="12" rows="3"><? echo $_SESSION['sess_note'][$i];?></textarea>	</td>
    <td  align="center" class="th14bgray" ><a href="#li" class="th12blue_love"  onclick="return delSData(<? echo $_SESSION['sess_period_regis'][$i]; ?>,<? echo $b;?>)" >ลบ</a></td>
  </tr>
  
  <?   /*echo $b."<br/>"; */$b++;

  }  ?><a name="#li"></a><tr>
    <td colspan="12" align="center"  class="th14bgray"><br/><input type="button" name="Submit2" id="Submit2"  value="เพิ่ม/ปรับปรุงข้อมูล"   onclick="return editData();"/><input name="numS" id="numS" type="hidden" value="<? echo $numS;?>" /><input name="check" id="check" type="hidden" value="<? echo $_SESSION['check'];?>" /></td>
    </tr> 
</table>
</body>
</html>
