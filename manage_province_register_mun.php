<?php session_start();
 include "check.php";
include "unset_regis.php";
////////////---------------->LOGTYPE']==4
if($_SESSION['LOGTYPE']==4){
/*  old waiting p'o
$sqlI="select id_province from personnel where id_personnel='$_SESSION[LOGID]'";   //เพื่อที่จะเอา  id_province ไปกำหนดเื่งื่อนไขให้ $con ถ้าเป็น logtype=4 (อยากรู้ว่าคนที่เข้ามาอยู่จังหวัดไหน)
	$resultI=$db->query($sqlI);
	$rsI=$db->fetch_array($resultI);//fetch ก่อนเลยอันแรก เอาid จังหวัดมาได้แล้ว ต่อไปคือ---->เอาใส่ $con
$con="where province_id='$rsI[id_province]'";//สร้างขึ้นมา เพื่อจำกัดสิทธิ์ของ logtype=4	เห็นแต่จังหวัดตัวเอง  แก้ไขระยะทางรวมได้แค่ จังหวัดเดียวคือตัวเอง
*/

$con="where province_id='$_SESSION[id_province]'";//สร้างขึ้นมา เพื่อจำกัดสิทธิ์ของ logtype=4	เห็นแต่จังหวัดตัวเอง  แก้ไขระยะทางรวมได้แค่ จังหวัดเดียวคือตัวเอง
}else{
$con="where id_residence is not null and id_residence<19";        //ต้องใส่ตัวนี้ด้วยถ้า list ออกมาได้แต่ยังมี error
}

/////////////   ------------------<
$sql="select * from province $con order by id_residence,num_orders asc";   //แต่ถ้า $con ไม่มีค่า ก็จะแสดงออกมาหมดเลย 
$result=$db->query($sql);     // นำไป fecth ที่ line 149 มี line 64 ลอกเลียนแบบ
/////////////////////////////////////////////////
$i=1;  //ตั้งมาให้งงอีกแล้ว
$list_year=$_REQUEST['list_year']; //ได้มาจากการส่งมาให้หน้าตัวเอง  ใช้ก็ต่อเมื่อ if ที่ else  line32 ถ้าlist_year มีข้อมูล
//$list_year=$_POST['list_year'];
////
	$sqlL="SELECT list_year,target,sum( amount_phase_way )
FROM annual_way
GROUP BY list_year,target
HAVING sum( amount_phase_way )>0
ORDER BY list_year DESC  limit 1 offset 0
";         // ฟังชั่น sum ปิดชั่วคราว ยังหาคำตอบไม่ได้ เพราะค่าที่รับมามันเป็น varchar มันแปลงแล้วเอามารวมกันไม่ได้




//seclect หาค่าเริ่มต้นให้ ถ้ายังไม่ส่ง list_year มา   ห้าค่าของปีที่ล่าสุด ที่มีการเพิ่มข้อมูลด้วย เพราะ sum_phases_way>0
//   FROM annual_way
//GROUP BY list_year    รอถาม ว่าอยู่ตรงไหน

//sum( amount_phase_way ) AS sum_phases_way     จับผลผลรวมระยะทางที่ลงทะเบียนไว้ มารวมกัน
// HAVING sum_phases_way >0 (เงื่อนไขของ group by) แต่ว่า sum_phases_way ต้องมากกว่า 0
// limit 0,1     กี่เรคคอร์ดนี่ เอาไว้ถามพี่ โอม


  $resultL=$db->query($sqlL);
  $rsL=$db->fetch_array($resultL);   //ปิดชั่วคราว

  $sql_target="select target from annual_way where list_year='$rsL[list_year]'";  //ถ้าเอาค่า fetch มาใส่ใน sql ก็เอา '' ออกด้วย
  $query_target=$db->query($sql_target);
  $rs_target=$db->fetch_array($query_target);



if($list_year==""){  $list_year=$rsL['list_year']; $target=$rs_target['target'];          //ถ้าค่าว่าง หรือยังไม่ได้กดเลือก "เลือกจัดการข้อมูลจำนวนสายทางและระยะทาง ปี"
//$list_year=$rsL['list_year'];    //รับค่าที่มีค่ามากที่สุดของ list_year (order by list_year DESC)line21
//$target=$rsL['target'];        //เป้าหมาย ของปีที่list_year

}else{  //echo"$list_year";exit;                        //แต่ถ้า่ค่า list_year มีค่าข้อมูล
	$sqlL1="SELECT target
FROM annual_way

where list_year='$list_year'
ORDER BY list_year DESC  limit 1 offset 0
";  //ก็จะได้ target ตัวล่าสุด ของปี ที่ส่งมา DESC 1 record    //  $_POST[list_year]//$_REQUEST[list_year] ใช้ได้ใหม
  $resultL1=$db->query($sqlL1);
  $rsL1=$db->fetch_array($resultL1);	
$list_year=$list_year;   //$list_year รับค่าตัวเองส่งให้ตัวเอง     $list_year=$_POST['list_year']
$target=$rsL1['target'];            // target ที่ร้องขอจากฐานข้อมูล  เรียกมาใช้อันเดียว เพราะ ปีละ target
}

//echo"target=$target<br>var_dump=";var_dump($target);
///////////////////////////////////////////////////////////////////////////////////
 // พอได้ค่า $list_year และ $target ก็เอาไปใส่ใน line   113 121
//////////////////////////////////////////////////////////////////////////////////

/*	 $Per_Page =50;
if ( !$Page ) 
	$Page = 1; 
$Prev_Page = $Page - 1; 
$Next_Page = $Page + 1; 
$result = $db->query($sql); 
$Page_start = ( $Per_Page * $Page ) - $Per_Page;  มันไม่ใช้เพราะว่า จังหวัดมีแค่ึ 78 จังหวัดเองเลยไม่ใช้
$Num_Rows = $db->num_rows( $result ); 
if ( $Num_Rows <= $Per_Page ) $Num_Pages = 1; 
else if ( ( $Num_Rows % $Per_Page ) == 0 ) $Num_Pages = ( $Num_Rows / $Per_Page ); 
else $Num_Pages = ( $Num_Rows / $Per_Page ) + 1; 

$Num_Pages = ( int ) $Num_Pages; 
if ( ( $Page > $Num_Pages ) || ( $Page < 0 ) ) 
	print "จำนวน $Page มากกว่า $Num_Pages";
$sql .= " LIMIT $Page_start, $Per_Page"; */
//$result = $db->query( $sql ); //สองตัวสุดท้ายนี้ไม่รู้ว่าเอาไว้ทำอะไร ตอนลบออกก็สามาถlistข้อมูลออกมาได้อยู่เหมือนเดิม  134     line 12 มีแล้ว
//$sqlT="select tar"            // ตัวแปร $sqlT มีแค่ตัวเดียวในหน้านี้ ไม่ได้นำเอาไปใช้

////////////////////////////////////////////////////////////////////////////

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
  


<table width="78%" border="0" cellspacing="2" cellpadding="2">
    <form id="form" name="form" method="post" action="manage.php?page=manage_province_register_mun"> <!--ส่งค่าตัวเองให้ตัวเอง list_year-->
  <tr>
    <td colspan="4" class="th16white" bgcolor="#336699" align="center">เลือกจัดการข้อมูลจำนวนสายทางและระยะทาง ปี 
  <select name="list_year" id="list_year" onchange="javascript:this.form.submit();"><? for($i=2554;$i<2561;$i++){?><option value="<? echo $i;?>" <? if($list_year==$i){?>selected="selected" <? }?>><? echo $i;?></option>
 <? } //javascript:this.form.submit();ถ้าเปลี่ยนแปลง ให้ submit ทันที?>
 <?//และถ้าค่า i มีค่าเท่้ากับlist_year ที่ส่งมา ก็ให้ตั้งค่า seleted ใสลูปนั้นๆเลย?>
    </select>&nbsp;  </td>
  </tr>
    </form>
  <form id="form1" name="form1" method="post" action="manage_province_register_proc.php">
  <tr>
    <td colspan="4" class="th16white" bgcolor="#336699" align="center">เป้าหมาย ปี <? echo $list_year;?> กำหนดไว้ที่   <input name="target" type="text"  style="width:30px" value="<? echo $target;?>"/>&nbsp;<span class="th_head_back12">%</span></td>
  </tr>


  <tr bgcolor="#CC9933">
      <td width="11%" class="th_head_back14" align="center">ลำดับ</td>
    <td width="30%" class="th_head_back14" align="center">สำนักทางหลวงชนบท</td>
	<td width="34%" class="th_head_back14" align="center">สำนักงานทางหลวงชนบทจังหวัด</td>
<!--	<td width="23%" class="th_head_back14" align="center">เพิ่ม/แก้ไข จำนวนสายทาง <br/>(สาย)</td>
-->     <td width="25%" class="th_head_back14" align="center">เพิ่ม/แก้ไข จำนวนระยะทาง <br/>(กม)</td>

  </tr>
  <? 
$a=1;  //เอาไว้เปลี่ยนสี สลับกัน
  $num=0;//$Page_start;  //page_start ตัวนี้ไม่ได้ใช้ เพราะจังหวัดมีแค่78 เองเลยใช้หน้าเดียว
  
  //select * from province $con order by id_residence,num_orders asc
  while($rs=$db->fetch_array($result)){   /////เจอแล้วหาตั้งนาน ตัวโชว์ข้อมูล ของจังหวัด  จาก line 12 /////////////////select * form province

     $num++; //มันบวกก่อนมันเลยได้ค่า 1 ตั้งแต่แรก (ลำดับ)
      //echo"$num";
      //sql ในลูปอีกที              //สรุปคือ จังหวัด 1 จังหวัดอาจมี id_residence เหมือนกัน หรือ 1 สำนักมีหลายจังหวัด เพื่อที่จะรู้ว่าจังหวัดแต่ละรอบ อยู่ สำนักไหน
  $sqlS="select name_residence
  from residence
  where id_residence='$rs[id_residence]' and id_residence < 19
  "; //จังหวัดค้นหาชื่อสำนัก เลยเอา id_residence มาขอชื่อสำนัก
  //var_dump($rs[id_residence]); //กทม ไม่มี id_residence
  $resultS=$db->query($sqlS);
  $rsS=$db->fetch_array($resultS);//fetch ในลูปของ$rs    $rsS=ชื่อสำนักทางหลวงชนบท
  ////
            if($a%2==1){   //เอา $a หารเอาเศษ
          $bg="CCFF99";
          
          }else if($a%2==0){
          $bg="99FFFF";

          }
  ////        
 $sqlA="select amount_way,amount_phase_way from annual_way where id_province='$rs[province_id]' and list_year='$list_year'"; //เงื่อนไขสองตัวแปรนี้ มาจากลูปแรก
  //เลือกจำนวนสายทาง,และระยะทางรวมของแต่ละสำนักของแต่ละปี
 $resultA=$db->query($sqlA);
 $rsA=$db->fetch_array($resultA); //ในระหว่างที่เราลูปเอาจังหวัด แต่ละรอบของลูปจังหวัดเราก็จะลูปเอาname_residenceออกมาในรอบนั้นๆเลย
  ?>
  <tr bgcolor="<?  echo $bg?>">
  <td class="th_head_back12" align="center">&nbsp; <? echo $num.".";?></td>
<td class="th_head_back12" align="left">&nbsp; <? echo $rsS['name_residence'];?></td>
	    <td class="th_head_back12" align="left">&nbsp; <? echo $rs['province_name'];?></td>
	<!--    <td class="th_head_back12" align="center"><input type="text" name="amount_way[]" id="amount_way[]" value="<? if($rsA['amount_way']!=""){ echo $rsA['amount_way'];}?>" style="width:40px"  onKeyPress="check_num1(event)"  /></td>-->
  <td class="th_head_back12" align="center"><input type="text" name="amount_phase_way[]" id="amount_phase_way[]" value="<? if($rsA['amount_phase_way']!=""){echo number_format($rsA['amount_phase_way'],3,'.','');}?>" style="width:80px"  onkeypress="check_num(event)"  /> <input type="hidden" name="province_id[]" id="province_id[]" value="<? echo $rs['province_id'];?>" /></td>

  <? $a++; $i++;} //end while line 127--และบวก i ไว้ทำไม?>   <?//number_format($rsA['amount_phase_way'],3,'.',''); มันคือ สั่งเอาทดสนิยม 3 ตัว ใช้จุดขั้น?> <? //สุดท้ายก็ส่งรหัส residence กับ รหัส จังหวัดไป?>
   </tr>
  <tr>
  <?php  // $sql_num="select * from province";      งงว่าำทำไมในฐานข้อมูลมี 84 แต่พอนับออกมาทำไมได้ 81 เพราะตัวเลขในฐานข้อมูลมันข้าม
         //  $num_row=$db->query($sql_num);
          // $num_row2=mysql_num_rows($num_row);
          // echo"$num_row2";

  ?>
    <td colspan="4" align="center" class="th_head_back12"><input type="submit" name="Submit" id="Submit" value="จัดเก็บข้อมูล/แก้ไขข้อมูล" />
    <input type="hidden" name="list_year1" id="list_year1" value="<? echo $list_year;?>" />  <!--list_year ส่งค่าจากฟอร์มนี้ไป 1 ค่า-->

    </td>
    </tr>
    </form>
</table>

  