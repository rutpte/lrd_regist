<?     session_start();
include "check.php";
$orgc_id=$_GET['orgc_id'];
$REFEREF=$_SERVER['HTTP_REFERER'];
$proc=$_REQUEST['proc'];
$way_id=$_GET['way_id'];

/////////////

if($proc=='edit'){
include "unset_regis.php";
}
/////////////
$sql="SELECT amphur_name,province_name,drop_name,org_comunity.orgc_name,org_comunity_detail.num_orders,name_residence
FROM
  org_comunity
  INNER JOIN org_comunity_detail ON (org_comunity.orgc_id=org_comunity_detail.orgc_id)
  INNER JOIN amphur ON (org_comunity.amphur_id = amphur.amphur_id)
  INNER JOIN province ON (amphur.province_id=province.province_id)
  INNER JOIN residence ON (province.id_residence = residence.id_residence)
  where org_comunity.orgc_id='$orgc_id'";  //คิดว่าไม่ได้ใช้ org_comunity.amount_way,org_comunity.amount_phase_way, เพราะมันไม่มีในตาราง แต่ต้องมา sum เอาเอง
  $result=$db->query($sql);
  $rs=$db->fetch_array($result);                                       

  /////////////////////////////////////////////////////////////////////////////////////////
  //echo"provin=";var_dump($rs['province_name']); echo"<br>";      ////// เดี๋ยวค่อยเอาออก
 // echo"id_regis_detail=";var_dump($_REQUEST['id_regis_detail']);echo"<br>";
  // echo"orgc_id=";var_dump($_GET['orgc_id']); echo"<br>";
  // echo"way_id=";var_dump($_GET['way_id']);
 //////////////////////////////////////////////////////////////////////////////////////////
 if($rs['num_orders']<10){
 $exN="ตย. 0001";
 $numN=4;
  $size=36;

 }
 else  if($rs['num_orders']>=10&&$rs['num_orders']<100){
  $exN="ตย. 001";
   $numN=3;
   $size=40;
 }
  else  if($rs['num_orders']>=100&&$rs['num_orders']<1000){
  $exN="ตย. 01";
   $numN=2;
   $size=48;
 }
 else  if($rs['num_orders']>=1000){
  $exN="ตย. 1";
   $numN=1;
   $size=55;
 }
  if($rs['amount_phase_way']!=""){
  $_SESSION['amount_phase_way']=$rs['amount_phase_way']; //คือค่า sum (distance_total) where orgc_id=$orgc_id
  }
 
///////////////////////////  for add new  //////////////////////////////////////////////////////////////

if($proc==""){

$sqlS="SELECT 
way.distance_total
FROM
  way
  INNER JOIN org_comunity ON (way.orgc_id = org_comunity.orgc_id) where way.orgc_id='$orgc_id'
  and (way.active='t') 
  ";
  $resultS=$db->query($sqlS);
 $_SESSION['numD']=$db->num_rows($resultS); //session numD รับค่า จำนวนเรคคอร์ด distance_total
$amount_ways1= $_SESSION['numD'];//รอบวก 1   line 86   $amount_ways1 รับ จำนวนที่ลงทะเบียนทั้งหมดของ อปท นี้
  $j=0;      //ให้ j รับค่า 0
 while($rsS=$db->fetch_array($resultS)){  //นำค่า ระยะทางรวม มาใส่ session ทีละตัว ใส่ค่าอินเด็กให้
	if($rsS['distance_total']){
 	$_SESSION['sess_distance_regis2'][$j]=$rsS['distance_total'];

	}
	$j++;}	
$proc="add";

//สรุป ถ้ากด ลงทะเบียนใหม่ จะให้   1.>$_SESSION['numD']=จำนวนเรคคอร์ด ของระยะทางรวม (หรือ จำนวนข้อมูลที่ลงทะเบียนทั้งหมดมีกี่เรคคอร์ด)
//                   2.>$amount_ways1=รับค่า $_SESSION['numD']
//                   3.>$j=0 ++;
//                   4.>$_SESSION['sess_distance_regis2'][$j]=$rsS['distance_total']ทั้งหมดที่มีในตาราง
//                   5.>$proc=add


//////////////////////////////////////// edit ////////////////////////////////////////////////////

}else if($proc=="edit"){

#-----------------------------------  for check upload pic
                                    $sql_chek_filename_ref="select filename_ref
            from attachment t1
            inner join lrd_attachment t2 ON (t1.attach_id=t2.attach_id)
            where record_ref_id=$way_id and lrd_attach_type='P_M'
             ";
           $result_filename_ref=$db->query($sql_chek_filename_ref);                                                                                   #
           $rs_filename_ref=$db->fetch_array($result_filename_ref);

           $filename_ref=$rs_filename_ref['filename_ref'];
           //var_dump( $filename_ref);
#----------------------------------
///////////////////////////////////////////////////////
$sqlS_num="select * from way
inner join register_road_detail on way.way_id=register_road_detail.way_id
where register_road_detail.way_id='$way_id' ";
 $resultS_num=$db->query($sqlS_num);
 $numforid=$db->num_rows($resultS_num);
if($numforid==""){
          $s="select * from way
         where way_id='$way_id' ";
         $s=$db->query($s);
         $rsS=$db->fetch_array($s);
         $sr=explode("+",$rsS['start_road']);
         $er=explode("+",$rsS['end_road']);
         $sum_se_sr=((($er[0].$er[1])-($sr[0].$sr[1]))/1000); 
         $_SESSION['sess_sum_distance12']=$sum_se_sr;
         
        // var_dump($rsS['way_name']);echo"<br>";
        // var_dump($way_id);
         
         $proc="edit2";       //ไม่ต้องสร้าง session ข้อมูล detail
    //exit;
  }
/////////////////////////////////////////////////////
else{
$sqlS="select * from way
inner join register_road_detail on way.way_id=register_road_detail.way_id
where register_road_detail.way_id='$way_id' ";  
 $resultS=$db->query($sqlS);
// $numforid=$db->num_rows($resultS);
 $rsS=$db->fetch_array($resultS);// var_dump($rsS['district_raod']); exit;
 
/////////////////

$sr=explode("+",$rsS['start_road']);
$er=explode("+",$rsS['end_road']);     //จับแยกด้วยเครื่องหมาย +

$sum_se_sr=((($er[0].$er[1])-($sr[0].$sr[1]))/1000);   //เปลี่ยนจากเครื่องหมาย+ เป็น .เพื่อเอามาต่อกัน เอาตัวหลังลบ ตัวหน้า แล้วหารพัน เพื่อให้มันเป็นทศนิยม สามหลัก
$_SESSION['sess_sum_distance12']=$sum_se_sr;
//////////////////
$sqlT="select layer_road_detail from register_road_detail where id_regis_detail='$rsS[id_regis_detail]'";
$resultT=$db->query($sqlT);    
$rsT=$db->fetch_array($resultT);
$sqlS1="SELECT 
way.distance_total
FROM
  way
  INNER JOIN org_comunity ON (way.orgc_id = org_comunity.orgc_id)
  where way.orgc_id='$rsS[orgc_id]' and way_id!='$way_id'";
  $resultS1=$db->query($sqlS1);
 $_SESSION['numD']=$db->num_rows($resultS1);
$amount_ways1= $_SESSION['numD']+1;//ตัวแปร $amount_way1 เอามาบวก 1    line 55

  $j=0;
 while($rsS1=$db->fetch_array($resultS1)){
	if($rsS1['distance_total']){
		
 	$_SESSION['sess_distance_regis2'][$j]=$rsS1['distance_total'];
	$_SESSION['sum_d2'][$j]=$rsS1['distance_total'];

	}//if
	$j++;}//while	
	 
$sql_detail="select * from register_road_detail where way_id='$way_id' order by period_regis  asc";
$result_detail=$db->query($sql_detail);
 // เอาไปทำไร 
$a=0;
$k=$_SESSION['numD'];
while($rs_detail=$db->fetch_array($result_detail)){
// for road_tran.php    เพื่อที่จะเอามาโชว์ตอนเปิดครั้งแรก
$_SESSION['sess_period_regis1'][$a]=$rs_detail['period_regis']; //คือว่าอะไร =ช่วงสายทาง
$_SESSION['sess_period_regis'][$a]=$rs_detail['period_regis'];
$_SESSION['sess_kate_regis'][$a]=$rs_detail['kate_regis'];
$_SESSION['sess_distance_regis'][$a]=$rs_detail['distance_regis'];
$_SESSION['sess_distance_regis1'][$a]=$rs_detail['distance_regis'];
$_SESSION['sess_jarat_road'][$a]=$rs_detail['jarat_road'];
$_SESSION['sess_type_ja'][$a]=$rs_detail['type_ja'];
$_SESSION['sess_width_ja'][$a]=$rs_detail['width_ja'];
$_SESSION['sess_type_sh'][$a]=$rs_detail['type_sh'];
$_SESSION['sess_width_sh'][$a]=$rs_detail['width_sh'];
$_SESSION['sess_type_fo'][$a]=$rs_detail['type_fo'];
$_SESSION['sess_width_fo'][$a]=$rs_detail['width_fo']; 
$_SESSION['sess_note'][$a]=$rs_detail['note']; 
$_SESSION['sess_distance_regis2'][$k]=$rs_detail['distance_regis'];
$_SESSION['sess_way_id']=$way_id;

$a++;
$k++;

;
if($rs_detail['distance_regis']!=""){ $_SESSION['sess_sum_distance']=array_sum($_SESSION['sess_distance_regis']);
$_SESSION['sess_sum_distance1']=array_sum($_SESSION['sess_distance_regis1']);
}

}//end while
}
} //end if proc =edit   /////////////////////////////////////////////////////////////////////////
 ////--->>
?>



<script type = "text/javascript" src = "myAjaxFramework.js"></script>
<script language="JavaScript">

function display(text){

	document.getElementById("div1").innerHTML = text;     // div1 รับค่าtext respone มาจาก road_tran.php ที่ฟังชั่น ppostDataReturnText ()
	
}
function display1(text){

	document.getElementById("div2").innerHTML = text;
	
}
/*function display2(text){

	document.getElementById("div3").innerHTML = text;
	
}
*/

function addData(){    //ฟังชั่นนี้ใช้ ไดมามิก html รับค่า เพิ่มข้อมูลลักษณะสายทาง



	
	var param="add_data=1";

	postDataReturnText("road_tran.php",param,display);   //ฟังชั่นนี้เป็นของ myAjaxFramework.js
	



}
/////////////////////////////////////////////////////////////////////////
function delSData(x,y){  // ฟังชั่นนี้ใช้ลบ ตัวที่responetext ให้ เพิ่มข้อมูลลักษณะสายทาง

	var active1=1;
	var paramdel="sess_road_del="+x;
	var paramdel1="sess_ba_del="+y;

	postDataReturnText("road_tran.php",paramdel,display);
	postDataReturnText("sum_distance_road.php",paramdel,display1);
	//postDataReturnText("sum_ba_dis.php",paramdel1,display2);

}
function editData(){   //ฟังชั่นนี้ ใช้ ตรวจสอบค่าความถูกต้องของการเพิ่มใหม่ของข้อมูลลักษณะสายทาง (ที่เมนูresponsetext html เพิ่มข้อมูลลักษณะสายทาง)      //////////////////////////////////////

var numS=document.getElementById("numS").value;
//var sum_amount_phase_wayB=document.getElementById("sum_amount_phase_wayB").value;
//var sum_d2=document.getElementById("sum_d2").value;
var start_road1=document.getElementById("start_road1").value;
var start_road2=document.getElementById("start_road2").value;
var start_road3=document.getElementById("start_road3").value;
var start_road4=document.getElementById("start_road4").value;
var end_road1=document.getElementById("end_road1").value;
var end_road2=document.getElementById("end_road2").value;
var end_road3=document.getElementById("end_road3").value;
var end_road4=document.getElementById("end_road4").value;

var send_edit_kate_regis="";
var send_edit_distance_regis="";
var send_edit_jarat_road="";
var send_edit_type_ja="";
var send_edit_width_ja="";
var send_edit_type_sh="";
var send_edit_width_sh="";
var send_edit_type_fo="";
var send_edit_width_fo="";
var send_edit_note="";

var sum_se_road1=(end_road1+end_road2+end_road3+end_road4)-(start_road1+start_road2+start_road3+start_road4);
var sum_se_road2=parseInt(sum_se_road1);  //รับค่าจำนวนเต็มบวก ไม่มีทศนิยม

var sum_se_road=(sum_se_road2/1000);

var sum_keep=parseFloat(0); //รับค่าเลขทศนิยม ค่าคือ 0.0
var str1="กรุณากรอกเขตทางช่วงที่ ";
var str2="กรุณากรอกระยะทางช่วงที่ ";
var str3="กรุณากรอกจำนวนช่องการจราจรต่อทิศทางช่วงที่ ";
var str4="กรุณากรอกผิวจราจรกว้างช่วงที่ ";
var str5="กรุณากรอกไหล่ทางกว้างช่วงที่ ";
var str6="กรุณากรอกทางเท้ากว้างช่วงที่ ";
var str="";
var str1_1="";
var str2_1="";
var str3_1="";
var str4_1="";
var str5_1="";
var str6_1="";
var numL=numS-1;
var a=0; 
var b=0;
var c=0;
var d=0;
var e=0;
var f=0;
for(i=0;i<numS;i++){
j=i+1;
if(i==numL){
var m="";

}else{
m=",";

}
var edit_kate_regis=document.getElementById("edit_kate_regis"+i).value;
var edit_distance_regis=document.getElementById("edit_distance_regis"+i).value;
var edit_jarat_road=document.getElementById("edit_jarat_road"+i).value;
var edit_type_ja=document.getElementById("edit_type_ja"+i).value;
var edit_width_ja=document.getElementById("edit_width_ja"+i).value;
var edit_type_sh=document.getElementById("edit_type_sh"+i).value;
var edit_width_sh=document.getElementById("edit_width_sh"+i).value;
var edit_type_fo=document.getElementById("edit_type_fo"+i).value;
var edit_width_fo=document.getElementById("edit_width_fo"+i).value;
var edit_note=document.getElementById("edit_note"+i).value;


sum_keep+=parseFloat(edit_distance_regis);
sum_keep=sum_keep.toFixed(3);
sum_keep=parseFloat(sum_keep);

	if(edit_kate_regis==""){ 

a++; 
	if(a>1){
	var na=",";
	}else if(a==1){
	var na="";
	}
	str1_1 =str1_1+na+j;}
	if(edit_distance_regis==""){ 
	b++; 
	if(b>1){
	var ma=",";
	}else if(b==1){
	var ma="";
	}

	 str2_1 =str2_1+ma+j; }
	if(edit_jarat_road==""){  
		c++; 
	if(c>1){
	var oa=",";
	}else if(c==1){
	var oa="";
	}
		
	str3_1 =str3_1+oa+j;}
	if(edit_width_ja==""){ 
			d++; 
	if(d>1){
	var pa=",";
	}else if(d==1){
	var pa="";
	}
	
	 str4_1 =str4_1+pa+j;}
	if(edit_type_sh!=""&&edit_width_sh==""){  
			e++; 
	if(e>1){
	var qa=",";
	}else if(e==1){
	var qa="";
	}
	str5_1 =str5_1+qa+j; }
	if(edit_type_fo!=""&&edit_width_fo==""){ 
		f++; 
	if(f>1){
	var ra=",";
	}else if(f==1){
	var ra="";
	}
	str6_1 =str6_1+ra+j; }

	
	 send_edit_kate_regis+=edit_kate_regis+m;
	send_edit_distance_regis+=edit_distance_regis+m;
	send_edit_jarat_road+=edit_jarat_road+m;
	send_edit_type_ja+=edit_type_ja+m;
	send_edit_width_ja+=edit_width_ja+m;
	
                  if(parseInt(edit_type_sh)==0){
                      var sh_width="";
                  }else{
                      var sh_width=edit_width_sh;
                  }
                  if(parseInt(edit_type_fo)==0){
                      var fo_width="";
                  }
                  else{
                     var fo_width=edit_width_fo;
                  }
	
	
	send_edit_type_sh+=edit_type_sh+m;
	send_edit_width_sh+=sh_width+m;
	send_edit_type_fo+=edit_type_fo+m;
	send_edit_width_fo+=fo_width+m;
	send_edit_note+=edit_note+m;


} /////////////////////////////////////////////////////////////////////////endfor


if(sum_keep>parseFloat(sum_se_road)){ 
		alert("คุณกรอกจำนวนระยะทางช่วงเกินกว่าจำนวนระยะทางที่ลงทะเบียนกรุณาตรวจสอบ \n");
		document.getElementById('edit_distance_regis'+i).focus();
		return false;
		
		 }

if(str1_1!=""){
str=str+str1+str1_1+"\n";}
 if(str2_1!=""){
str=str+str2+str2_1+"\n";
}
 if(str3_1!=""){
str=str+str3+str3_1+"\n";
}
 if(str4_1!=""){
str=str+str4+str4_1+"\n";
}
 if(str5_1!=""){
str=str+str5+str5_1+"\n";
}
 if(str6_1!=""){
str=str+str6+str6_1+"\n";
}
if(str!=""){
		alert(str);
		return false;
	}


/*var paramedit="send_edit_kate_regis="+send_edit_kate_regis+"&send_edit_distance_regis="+send_edit_distance_regis+"&send_edit_jarat_road="+send_edit_jarat_road+"&send_edit_type_ja="+send_edit_type_ja+"&send_edit_width_ja="+send_edit_width_ja+"&send_edit_type_sh="+send_edit_type_sh+"&send_edit_width_sh="+send_edit_width_sh+"&send_edit_type_fo="+send_edit_type_fo+"&send_edit_width_fo="+send_edit_width_fo+"&send_edit_note="+send_edit_note+"&edit=1&numS="+numS;*/

var paramedit="send_edit_note="+send_edit_note+"&send_edit_kate_regis="+send_edit_kate_regis+"&send_edit_distance_regis="+send_edit_distance_regis+"&send_edit_jarat_road="+send_edit_jarat_road+"&send_edit_type_ja="+send_edit_type_ja+"&send_edit_width_ja="+send_edit_width_ja+"&send_edit_type_sh="+send_edit_type_sh+"&send_edit_width_sh="+send_edit_width_sh+"&send_edit_type_fo="+send_edit_type_fo+"&send_edit_width_fo="+send_edit_width_fo+"&edit=1&numS="+numS;
var paramedit2="numS="+numS
var paramedit3="send_edit_distance_regis="+send_edit_distance_regis+"&sum_se_road="+sum_se_road;

	postDataReturnText("road_tran.php",paramedit,display);
	postDataReturnText("sum_distance_road.php",paramedit3,display1);
	//postDataReturnText("sum_ba_dis.php",paramedit3,display2);

}



function checkData(){       ///////////////////////////////////////////////

var check=document.getElementById("check").value;
var distance_road1=document.getElementById("distance_road1").value;



if(check==1){
		alert('ได้มีการเพิ่มข้อมูลของลักษณะสายทาง กรุณาคลิกเพิ่ม/ปรับปรุงข้อมูลก่อนกดบันทึก');
		return false;
	}
if(distance_road1!=0){
		alert('คุณกรอกจำนวนระยะทางช่วงทางลงทะเบียนไม่ครบหรือไม่ถูกต้อง กรุณาตรวจสอบก่อนกดบันทึก');  //ตรงนี้ล่ะ ตัวที่บอกว่าตัวเลขระยะทางที่ลบแล้วไม่เท่ากับ 0 ของค่าที่ฟิกไว้   กับค่าระยะทางของ ลักษณะสายทางเพิ่มใหม่ ตรงresponsetext
		return false;
	}


} //end checkdata


//เติม , (คอมมา)
/*function dokeyup( obj )
{
var key = event.keyCode;
if( key != 37 & key != 39 & key != 110 )
{
var value = obj.value;
var svals = value.split( "." ); //แยกทศนิยมออก
var sval = svals[0]; //ตัวเลขจำนวนเต็ม

var n = 0;
var result = "";
var c = "";
for ( a = sval.length - 1; a >= 0 ; a-- )
{
c = sval.charAt(a);
if ( c != ',' )
{
n++;


result = c + result;
};
};
if(!svals[0]&&svals[1]){
result="0"+result;
}
if ( svals[1] )
{
result = result + '.' + svals[1];
};


obj.value = result;
};

};
*/
//ให้ text รับค่าเป็นตัวเลขอย่างเดียว
/*function checknumber()
{
key = event.keyCode;
if ( key != 46 & ( key < 48 || key > 57 ) )
{
event.returnValue = false;
};
};*/

//ให้ text รับค่าเป็นตัวเลขอย่างเดียว ///////////////////////////// บังคับ ให้ text รับค่าตัวเลขอย่างเดียว ////////////
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

};   ///end function check_num(e)
/////////////////////////////////////////////////////////////////////////////////////////////////

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

}; // end function check_num1(e)
/////////////////////////////////////////////////////////////////////////////////////////////

function ChangeStateRadio(caller,formobject,x,y) {
var x=document.getElementById("x").value;
var y=document.getElementById("y").value;

 if (caller.value == "0"||caller.value == "1") {
  	formobject.disabled = true;
	formobject.value = "0";
 	/*	formobject.value = "";
	formobject.style.display="none";
	formobject1.style.display="none";
	formobject2.style.display="none";
	formobject3.style.display="none";*/
 } else {

 formobject.disabled = false;


if(x.value ==0&&y==0){
 formobject.value = "1";
}
else if(x==0&&y==1){
formobject.value = "2";
}
else if(x==0&&y==2){
formobject.value = "3";
}
else if(x==0&&y==3){
formobject.value = "4";
}
else if(x==0&&y==4){
formobject.value = "5";
}
else if(x==1&&y==0){
formobject.value = "6";
}
else if(x==1&&y==1){
formobject.value = "7";
}
else if(x==1&&y==2){
formobject.value = "8";
}
else if(x==1&&y==3){
formobject.value = "9";
}
else if(x==1&&y==4){
formobject.value = "10";
}
else if(x==1&&y==5){
formobject.value = "11";
}
else if(x==1&&y==6){
formobject.value = "12";
}
else {
 formobject.value = "1";
}
}




}  //end function ChangeStateRadio(caller,formobject,x,y)

/////////////////////////////////////////////////////////////////////////////////////////////////////

function ChangeStateRadio1(caller,formobject,formobject1) {
 if (caller.value == "0") {
formobject.disabled = true;
 formobject.value = "N.A.";
 formobject1.disabled = false;
 } else {
  formobject.value = "0";
  formobject.disabled = false;
   formobject1.disabled = true;
  
 }
}  //end function ChangeStateRadio1(caller,formobject,formobject1)
//////////////////////////////////////////////////////////////////////////////////////////////////
function ChangeStateRadioE(caller,formobject,formobject1) {
 if (caller.value == "0") {
formobject.disabled = true;
 formobject.value = "N.A.";
 formobject1.disabled = false;
 } else {
  formobject.value = "0";
  formobject.disabled = false;
   formobject1.disabled = true;
  
 }
}   //end function ChangeStateRadioE(caller,formobject,formobject1)
//////////////////////////////////////////////////////////////////////////////////////////////////

function ChangeStateRadioE1(caller,formobject,formobject1) {
 if (caller.value == "0") {
formobject.disabled = true;
 formobject.value = "N.A.";
  formobject1.disabled = false;
 } else {
  formobject.value = "0";
  formobject.disabled = false;
  formobject1.disabled = true;
 }
}

 //////////////////////////////////////////////////////////////////////////////////////////////////

function ChangeStateRadioEt(caller,formobject,formobject1) {
 if (caller.value == "3") {
formobject.disabled = true;

// formobject.value = "N.A.";
  formobject1.disabled = true;
 }
}
 //////////////////////////////////////////////////////////////////////////////////////////////////

function ChangeStateRadioD(caller,formobject) {

 if (caller.value == "1") {
  formobject.disabled = false;
 } else {
  formobject.value = "";
  formobject.disabled = true;
 }
}
 //////////////////////////////////////////////////////////////////////////////////////////////////

function ChangeStateRadioD1(caller,formobject,formobject1) {

 if (caller.value == "0") {
formobject.disabled = true;
 formobject.value = "N.A.";
  formobject1.disabled = false;
 } else {
  formobject.value = "0";
  formobject.disabled = false;
  formobject1.disabled = true;
 }
}
 //////////////////////////////////////////////////////////////////////////////////////////////////
function ChangeStateRadioC(caller,formobject) {

 if (caller.value != "0") {
formobject[0].disabled = true;
formobject[1].disabled = true;
 } else {


formobject[0].disabled = false;
formobject[1].disabled = false;
 }
}
</script>

<link href="css/register.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationTextField1.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationRadio.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField1.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationRadio.css" rel="stylesheet" type="text/css" />

<? /////////////////////////////////////////// form insert data ////////////////////////////////////////?>
    <? //function getDataReturnText มาเข้าจาก ajax เฟมเวิค ?>
<body onLoad="getDataReturnText('road_tran.php',display);getDataReturnText('sum_distance_road.php',display1);">

<table width="601" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="th_head_back14" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="th_head_back"  align="center"><p>ลงทะเบียนรายละเอียดเส้นทางของ&nbsp;<? echo $rs['orgc_name'];?></p>
          </td>
      </tr>
	     <tr>
        <td class="th14bgray"  align="center">ทชจ.&nbsp;<? echo $rs['province_name'];?>&nbsp;&nbsp;<? echo $rs['name_residence']?>          </td>
      </tr>
      
    </table></td>
  </tr>
</table>
<br/>
<table width="950" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="0">
<tr><td align="left"><a href="manage.php?page=manage_register&orgc_id=<? echo $orgc_id; ?>" class="th_red12b"><<<กลับ</a></td></tr></table>
  <table width="950" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006666">
  <tr><td align="center"><br/>
<form name="Form1" id="Form1" method="post" action="register_road_proc.php" enctype="multipart/form-data">

<table width="900" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#B5B8C7">
  <tr>
    <td><table width="900" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td class="th14bgreen_line" align="left">ข้อมูลสายทาง</td>
        <td colspan="5" align="left" class="th11bred">&nbsp;</td>
        </tr>
		
		     
      <tr>
        <td width="178" class="th14bgray"  align="left">รหัสสายทาง&nbsp;&nbsp; &nbsp; &nbsp;  <?
        if($proc=="add"or$proc=="edit2"){?>
         <input name="way_code_head" type="text" id="way_code_head"  style="border:0;width:<? echo $size;?>px  " class="th_green11b"
          value="<? echo $rs['drop_name'];?>.ถ<? echo $rs['num_orders'];?>-" readonly=""/><?
         }else if($proc=="edit"){?>
         <input name="way_code_head" type="text" id="way_code_head"  style="border:0;width:<? echo $size;?>px " class="th_green11b"
          value="<? echo $rs['drop_name'];?>.ถ<? echo $rs['num_orders'];?>" readonly=""/><? }?></td>  <?//////////////////// na_road ไม่มีแล้ว แต่มี way_code_full?>

        <td width="151" align="left" class="th11bred"><span id="sprytextfield1">
            <input name="way_code_tail" type="text" id="way_code_tail"  style="width:53px" onKeyPress="check_num1(event)"

 maxlength="<? echo $numN;?>" value="<? echo $rsS['way_code_tail'];?>"/>  <?////////id_road ก็ไม่มีแล้ว มีแต่ way_code_full?>
            <? echo $exN;?><br/><span class="textfieldInvalidFormatMsg">กรอกรหัสสายทางให้ครบตามตัวอย่าง</span></span></td>
        <td width="69" align="left"><span class="th14bgray">ชื่อสายทาง</span></td>
		 <td width="261" align="left" class="th11bred"><span id="sprytextfield2">
		   <input type="text" id="way_name" name="way_name" value="<? echo $rsS['way_name'];?>" style="width:200px"/>
		 </span></td>
		   <td width="55" align="left"><span class="th14bgray">ตำบล</span></td>
	      <td width="148" align="left" class="th11black"><span id="sprytextfield3">  
	        <input type="text" id="tumbol_road" name="tumbol_road" value="<? echo $rsS['tumbol_road'];?>" style="width:100px" />
	      </span></td>
      </tr>
      <tr>
        <td  class="th14bgray" align="left">อำเภอ</td>
        <td align="left" class="th11bred"><span id="sprytextfield4"> <input type="text" id="district_road" name="district_road" value="<? if($rsS['district_raod']==""){ echo $rs['amphur_name'];}else{ echo $rsS['district_raod'];}?>" style="width:100px"/>
        </span></td>
        <td  class="th14bgray" align="left">จังหวัด</td> 
        <td align="left" class="th11bred"><span id="sprytextfield5"><input type="text" id="province_road" name="province_road" style="width:100px;" value="<? echo $rs['province_name']; ?>"  disabled="disabled"/>  <? //ถ้า disable จะส่งข้อมูลไปไม่ได้//ไม่เห็นมี autocomplete ไม่ให้จดจำค่าที่เคยกรอกไว้?>
         </span></td>
		<td  class="th14bgray" align="left">ระยะทาง</td>
        <td align="left" ><span id="div2" ><?// /////////////////////  ผลลัพธ์ของการ onload body ฟังชั่นอันที่สอง ?>
	    <? //div 2 ไม่รู้เอาไว้ใส่ผลลัพธ์อะไร จากฟังชั่น onload body  อันที่สอง  ตอบ = เอาไว้ใส่ค่า ระยะทางรวม ว่าเป็น 0.00 ใหม   ?>
	</span></td>      
	  </tr>

    </table></td>
  </tr>
</table>
<br/>
<table width="900" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#B5B8C7">
  <tr>
    <td><table width="900" border="0" cellspacing="2" cellpadding="2">
      
      <tr>
        <td width="140"  align="left"><span class="th14bgray">จุดเริ่มต้นสายทาง</span><span class="th11black">(กม.)</span></td>
        <td width="191" align="left" class="th11black"><span id="sprytextfield7">
          <input type="text" id="start_road1" name="start_road1" value="<? echo $sr[0];?>" style="width:30px" onKeyPress="check_num1(event)" /> </span>
          + <span id="sprytextfield13">
          <input type="text" id="start_road2" name="start_road2" value="<? echo substr($sr[1],0,1);?>" style="width:10px"  maxlength="1" onKeyPress="check_num1(event)" /> </span>
          
         <span id="sprytextfield14"> <input type="text" id="start_road3" name="start_road3" value="<? echo substr($sr[1],1,1);?>" style="width:10px"  maxlength="1" onKeyPress="check_num1(event)" /> </span>
         <span id="sprytextfield15">   
          <input type="text" id="start_road4" name="start_road4" value="<? echo substr($sr[1],2,2);?>" style="width:10px"  maxlength="1" onKeyPress="check_num1(event)" />
        </span></td>
        <td width="75" align="left"><span class="th14bgray">พิกัด N </span></td>
		 <td width="193" align="left"><input type="text" id="trariff_start_road_n" name="trariff_start_road_n" value="<? echo $rsS['trariff_start_road_n'];?>" style="width:100px" onKeyPress="check_num(event)"/>
	      <span class="th11black">(ถ้ามี)</span></td>
		   <td width="53" class="th14bgray" align="left">พิกัด E </td>
	      <td width="210" class="th11black" align="left"><input type="text" id="trariff_start_road_e" name="trariff_start_road_e" value="<? echo $rsS['trariff_start_road_e'];?>" style="width:100px" onKeyPress="check_num(event)"/>&nbsp;
        <span class="th11black"> (ถ้ามี)</span></td>
      </tr>
      <tr>
        <td  align="left"><span class="th14bgray">จุดสิ้นสุดสายทาง</span><span class="th11black">(กม.)</span></td>
        <td align="left" class="th11black"><span id="sprytextfield8"><input type="text" id="end_road1" name="end_road1" value="<? echo $er[0];?>" style="width:30px" onKeyPress="check_num1(event)" /></span> 
          + 
          <span id="sprytextfield16">   <input type="text" id="end_road2" name="end_road2" value="<? echo substr($er[1],0,1);?>" style="width:10px"  maxlength="1" onKeyPress="check_num1(event)" /> </span>
          
          <span id="sprytextfield17">   <input type="text" id="end_road3" name="end_road3" value="<? echo substr($er[1],1,1);?>" style="width:10px"  maxlength="1" onKeyPress="check_num1(event)" /> </span>
           
           <span id="sprytextfield18">  <input type="text" id="end_road4" name="end_road4" value="<? echo substr($er[1],2,2);?>" style="width:10px"  maxlength="1" onKeyPress="check_num1(event)" />
        </span></td>
        <td  class="th14bgray" align="left">พิกัด N </td>
        <td align="left"><input type="text" id="trariff_end_road_n" name="trariff_end_road_n" value="<? echo $rsS['trariff_end_road_n'];?>" style="width:100px" onKeyPress="check_num(event)"/>
          <span class="th11black">(ถ้ามี)</span></td>
		<td  class="th14bgray" align="left">พิกัด E</td>
        <td align="left" class="th11black"><input type="text" id="trariff_end_road_e" name="trariff_end_road_e" value="<? echo $rsS['trariff_end_road_e'];?>" style="width:100px" onKeyPress="check_num(event)"/>&nbsp;
          (ถ้ามี)</td>      
	  </tr>
    </table></td>
  </tr>
</table>
<br/><table width="940" border="0" align="center" cellpadding="0" cellspacing="0"><tr>
  <td align="right" class="th12bblue"><a href="#li" onClick="editData();addData();" ><img src="image/add-icon.png" border="0" /></a>    <a href="#li" onClick="editData();addData();"  >เพิ่มข้อมูลลักษณะสายทาง</a></td>
</tr></table>
<span id="div1"></span> <?/////////////////////  ตรงนี้คือที่ responetext มาจาก road_tran.php ของฟังชั่น postDataReturnText ////////////////////////////////////////////?>
<br/><table width="900" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#B5B8C7">
  <tr>
    <td><table width="900" border="0" cellspacing="3" cellpadding="3">
 <tr>
   <td align="left"><span class="th14bgray_line">ประเภทถนน</span></td>
   <td align="left" class="th14bgray">&nbsp;</td>
 </tr>
 <tr>
    <td width="264" align="left">&nbsp;</td>
    <td width="615" align="left" class="th14bgray"> <input name="type_road" id="type_road" type="radio" value="0"  <? if($rsS['type_road']==0||$rsS['type_road']==""){ ?> checked="checked" <? }?>  onclick="ChangeStateRadio(this,class_standard);ChangeStateRadioC(this,type_ditch_road);"/>
          ในเขตชุมชน  </td>
  </tr>
  <tr>
    <!--<td align="left"><span class="th14bgray">ทางระบายน้ำหรือท่อระบายน้ำสองข้างทาง</span></td>  -->
    <!--<td align="left" class="th14bgray"><span id="RadioWidget1"><input id="type_ditch_road" name="type_ditch_road" type="radio" value="0" disabled="disabled" /> -->   <!--<? if($rsS['type_ditch_road']==0&&$rsS['type_ditch_road']!=""){?>checked="checked"  <? }?>  <? if($rsS['type_road']!=0||$rsS['type_road']!=""){  echo "disabled";}?>-->
 <!--<span class="th14bgray">  มี</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="type_ditch_road" name="type_ditch_road" type="radio" value="1" disabled="disabled" /> --> <!--<? if($rsS['type_ditch_road']==1){?>checked="checked" <? }?>   <? if($rsS['type_road']!=0||$rsS['type_road']!=""){  echo "disabled";}?>-->
       ไม่มี &nbsp;&nbsp;&nbsp;<span class="radioRequiredMsg">* กรุณาเลือก</span>    </span>
      
      </td>
  </tr>
</table>

    
    
    
    
    <br/><table width="900" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td width="264" align="left">&nbsp;</td>
    <td width="615" align="left" class="th14bgray"><input name="type_road" id="type_road" type="radio" value="1" <? if($rsS['type_road']==1){?>checked="checked" <? }?>  onclick="ChangeStateRadio(this,class_standard);ChangeStateRadioC(this,type_ditch_road);"/>
          นอกเขตชุมชน </td>
  </tr>
  
</table>

    
    
    
    

<br/>
<table width="900" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td width="264" align="left">&nbsp;</td>
    <td width="615" align="left" class="th14bgray">  <input name="type_road" id="type_road" type="radio" value="2" <? if($rsS['cre_type']==1){?>checked="checked" <? }?> 
onclick="ChangeStateRadio(this,class_standard,x,y);ChangeStateRadioC(this,type_ditch_road);"/>
          กำหนดมาตรฐานชั้นทางเอง<span class="radioRequiredMsg">* กรุณาเลือกชั้นทาง</span>    </span>
          <input name="x" id="x" value="<? echo $rsS['type_road'];?>" type="hidden">
          <input name="y" id="y" value="<? echo $rsS['layer_road'];?>" type="hidden">     </td>
  </tr>
  <tr>
    <td align="left"><span class="th14bgray">เลือกมาตรฐานชั้นทาง</span></td>
    <td align="left" class="th14bgray"><select name="class_standard" id="class_standard" <? if($rsS['cre_type']!=1){?> disabled="disabled"  <? }?>>
	   	   <option value="0"  selected="selected" disabled="disabled">- โปรแกรมวิเคราะห์ </option>
		   <option value="1" <? if($rsS['type_road']==0&&$rsS['layer_road']==0&&$rsS['type_road']!=""&&$rsS['cre_type']==1){?> selected="selected"<? }?>>- ในเมืองชั้นพิเศษ </option>
		   <option value="2" <? if($rsS['type_road']==0&&$rsS['layer_road']==1&&$rsS['cre_type']==1){?> selected="selected"<? }?>>- ในเมืองชั้นที่ 1 </option>
		   <option value="3" <? if($rsS['type_road']==0&&$rsS['layer_road']==2&&$rsS['cre_type']==1){?> selected="selected"<? }?>>- ในเมืองชั้นที่ 2 </option>
		   <option value="4" <? if($rsS['type_road']==0&&$rsS['layer_road']==3&&$rsS['cre_type']==1){?> selected="selected"<? }?>>- ในเมืองชั้นที่ 3 </option>
		   <option value="5" <? if($rsS['type_road']==0&&$rsS['layer_road']==4&&$rsS['cre_type']==1){?> selected="selected"<? }?>>- ในเมืองชั้นที่ 4 </option>
		   <option value="6" <? if($rsS['type_road']==1&&$rsS['layer_road']==0&&$rsS['cre_type']==1){?> selected="selected"<? }?>>- นอกเมืองชั้นพิเศษ </option>
		   <option value="7" <? if($rsS['type_road']==1&&$rsS['layer_road']==1&&$rsS['cre_type']==1){?> selected="selected"<? }?>>- นอกเมืองชั้นที่ 1 </option>
		   <option value="8" <? if($rsS['type_road']==1&&$rsS['layer_road']==2&&$rsS['cre_type']==1){?> selected="selected"<? }?>>- นอกเมืองชั้นที่ 2 </option>
		   <option value="9" <? if($rsS['type_road']==1&&$rsS['layer_road']==3&&$rsS['cre_type']==1){?> selected="selected"<? }?>>- นอกเมืองชั้นที่ 3 </option>
		   <option value="10" <? if($rsS['type_road']==1&&$rsS['layer_road']==4&&$rsS['cre_type']==1){?> selected="selected"<? }?>>- นอกเมืองชั้นที่ 4 </option>
		   <option value="11" <? if($rsS['type_road']==1&&$rsS['layer_road']==5&&$rsS['cre_type']==1){?> selected="selected"<? }?>>- นอกเมืองชั้นที่ 5 </option>
		   <option value="12" <? if($rsS['type_road']==1&&$rsS['layer_road']==6&&$rsS['cre_type']==1){?> selected="selected"<? }?>>- นอกเมืองชั้นที่ 6 </option>
		   </select></td>
  </tr>
</table></td>
  </tr>



</table>
  <br/><? if($filename_ref=="" && $proc!="edit"){?>
  <table width="900" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#B5B8C7">
  <tr>
    <td><table width="900" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td width="264" align="left"><span class="th14bgray">เพิ่มแผนที่สายทาง</span></td>
    <td width="615" align="left" class="th_black11b"><span id="sprytextfield19"><input name="file_load" type="file" id="file_load" size="0" style="width:200px"/>
    * นามสกุลไฟล์(jpg,jpeg,png,pdf)
    </span></td>
  </tr>
  
</table>   

    
    
    
    </td></tr></table><? }?>
<br/>
<p>
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
   <tr>
        <td width="722" align="right" class="th14bgray">เจ้าหน้าที่กรอกข้อมูล&nbsp;&nbsp;</td>
        <td width="178"  align="left" class="th11bred"><span id="sprytextfield12">
          <input type="text" id="user_key_in" name="user_key_in" value="<? echo $rsS['user_key_in'];?>" />  <? //ใช้ตัวไหนในตาราง way?>
      *</span></td>
    </tr></table><br/>

<table width="900" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr><td align="center" class="th14bgray"><input type="submit" id="Submit" name="Submit" value="บันทึก" onClick="return checkData();" /> &nbsp;<input type="reset" id="Reset" name="Reset" value="ยกเลิก" /><input type="hidden" id="orgc_id" name="orgc_id" value="<? echo $orgc_id;?>" />    <?//ถ้าผ่านฟังชั่น เช็คมาได้ก็ action ไปหน้าเพจตามคำสั่งเลย?>
  <input type="hidden" id="proc" name="proc" value="<? echo $proc;?>" />  <?// ค่า  $proc มาจากการกด edit และส่งค่า edit ให้ $proc ของuser ที่หน้าqueryข้อมูล(manage.php?page=manage_register) ?>
  <input type="hidden" id="way_id" name="way_id" value="<? echo $way_id;?>" /></td>  <?// นี่ก็คือค่าที่ส่งมาเพื่อส่งไปยืนยันตัวตนว่าเป็นidไหน?>
  </tr></table>

</p>
</form> 
</td></tr></table>

</body>
</html>


<script type="text/javascript">
<!--
<? if($numN==4){?>
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {format:"phone_custom", pattern:"0000"}); <? }
else if($numN==3){
?>
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {format:"phone_custom", pattern:"000"}); <? }
else if($numN==2){
?>
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {format:"phone_custom", pattern:"00"}); <? }
else if($numN==1){
?>
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {format:"phone_custom", pattern:"0"}); <? }

?>
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9");
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10");
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11");
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12");
var sprytextfield13 = new Spry.Widget.ValidationTextField("sprytextfield13");
var sprytextfield14 = new Spry.Widget.ValidationTextField("sprytextfield14");
var sprytextfield15 = new Spry.Widget.ValidationTextField("sprytextfield15");
var sprytextfield16 = new Spry.Widget.ValidationTextField("sprytextfield16");
var sprytextfield17 = new Spry.Widget.ValidationTextField("sprytextfield17");
var sprytextfield18 = new Spry.Widget.ValidationTextField("sprytextfield18");
var sprytextfield19 = new Spry.Widget.ValidationTextField("sprytextfield19");
var RadioWidget  = new Spry.Widget.ValidationRadio("RadioWidget");
var RadioWidget1  = new Spry.Widget.ValidationRadio("RadioWidget1");
var RadioWidget2  = new Spry.Widget.ValidationRadio("RadioWidget2");
//var RadioWidget3  = new Spry.Widget.ValidationRadio("RadioWidget3");

/*var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect5 = new Spry.Widget.ValidationSelect("spryselect5");

var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");*/



</script>
<?php if(!isset($_GET['proc'])){?>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type='text/javascript' src="jquery.autocomplete.js"></script>
<link rel="stylesheet" type="text/css" href="jquery.autocomplete.css" />
<script type="text/javascript">
////////////////1//////////////////////<<---auto_complete of way_code_tail
$(document).ready(function() {

	$("#way_code_tail").autocomplete("searchid.php?orgc_id=<?=$orgc_id ?>", {
		width: 90,
		matchContains: true,
		//mustMatch: true,
		minChars: 2,
		
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false 
	});

	////////////////2//////////////////////<<--focusout of way_code_tail for make redirect (function)
	$('#way_code_tail').focusout(function() { //$('div.ac_results').slideUp();
  var data=$('#way_code_tail').val();
         var url="check_way_tail.php"; // ไฟล์ที่ต้องการรับค้า
         var dataSet={ way_code_tail: $("#way_code_tail").val(),orgc_id:<?=$orgc_id ?> }; // กำหนดชื่อและค่าที่ต้องการส่ง
            $.get(url,dataSet,function(data){
             // debugger;
            //console.debug( "111 focusout way_code_tail data=" +data+" orgc_id:"+<?=$orgc_id?> );
           //console.debug([data]);
            var data=data.split(",");
            
           if(data[0] > 0){


                 //console.debug( "data>0");

                                 var way_id=data[1];
                                 var orgc_id=<?=$orgc_id?>;
                                 redirect(way_id,orgc_id);  ///////////////---->>>>
           }else{

                        //console.debug('data==0');
                        
                              excute();
                      }
                     });

           //alert(data);
});
   ///////////////3////////////////////////    <<-- way_name focusin

	$('#way_name').focusin(function() {

            //console.debug('way_name_focusin');

                
                excute();


           //alert(data);
});
////////////////////////4////////////////////  <<--   auto_complete of way_name

	//ส่วนที่สองนี้น่าจะนำไปใส่ในการตรวจสอบเงื่อนไขตอน process fill way_code_head

function excute(){
     	$("#way_name").autocomplete("searchname.php?orgc_id=<?=$orgc_id ?>", {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		minChars: 2,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});  }

  ////////////////////5/////////////////////<<-- onfocusout of way_name for auto fill and slid up

  $('#way_name').focusout(function() { //$('div.ac_results').slideUp();
  var data=$('#way_name').val();
         var url="check_way_name.php"; // ไฟล์ที่ต้องการรับค้า
         var dataSet={ way_name: $("#way_name").val(),orgc_id:<?=$orgc_id ?> }; // กำหนดชื่อและค่าที่ต้องการส่ง


               $.ajax({
                     type: "GET",
                     url:url,
                     data:dataSet,
                           success: function(data){     //  console.debug("focusout เฉยๆ");
                            var data=data.split(",");
                           if(data[0]>0){
                              
                                 //console.debug( "Data way_id: " + data[1]+"orgc_id:"+<?=$orgc_id?> );
                                 var way_id=data[1]; 
                                 var orgc_id=<?=$orgc_id?>;

                                   redirect(way_id,orgc_id);  ///////////////---->>>>

                                   }
                           }

                    });
 });


  function redirect(way_id,orgc_id){  //console.debug(way_id);
      window.location="manage.php?page=register_road&way_id="+way_id+"&proc=edit&orgc_id="+orgc_id+"";
 }



////////////////////////---<<<<<<<<<<<<<
});

</script>
<? } ?>