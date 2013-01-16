<? include("header.php");
#-------------------------------
   global $FTP;
   $ftp=array();
  $ftp = $FTP;
  $server=$ftp['server'];
  	$domain_data=$ftp['domain_data'];
  //echo "$server";
 // exit;
#-------------------------------
	$orgc_id=$_GET['orgc_id'];
	/*$sql="SELECT
	province.province_id,
	province_name,
	drop_name,
	org_comunity.orgc_name,
	name_residence,
attachment.proj_id,
attachment.record_id,
attachment.attach_type,
attachment.filename_ref,
lrd_attachment.lrd_attach_type
FROM
  org_comunity
  INNER JOIN attachment ON org_comunity.orgc_id=attachment.record_ref_id
  INNER JOIN lrd_attachment ON attachment.attach_id=lrd_attachment.attach_id
  INNER JOIN org_comunity_detail ON (org_comunity.orgc_id=org_comunity_detail.orgc_id)
  INNER JOIN amphur ON (org_comunity.amphur_id=amphur.amphur_id)
  INNER JOIN province ON (amphur.province_id = province.province_id)
  INNER JOIN residence ON (province.id_residence = residence.id_residence)
  where org_comunity.orgc_id='$orgc_id' and lrd_attach_type='SP_M'";  */

$sql="SELECT
province.province_id,
	province_name,
	drop_name,
	org_comunity.orgc_name,
	name_residence,
   org_comunity.orgc_id,

attachment.proj_id,
attachment.record_ref_id,
attachment.attach_type,
attachment.filename_ref,
lrd_attachment.lrd_attach_type,
attachment.filename_attach
FROM
province
INNER JOIN residence ON residence.id_residence = province.id_residence
INNER JOIN amphur ON amphur.province_id=province.province_id
INNER JOIN org_comunity ON amphur.amphur_id = org_comunity.amphur_id

INNER JOIN attachment ON org_comunity.orgc_id=attachment.record_ref_id
INNER JOIN lrd_attachment ON attachment.attach_id=lrd_attachment.attach_id
where org_comunity.orgc_id='$orgc_id' and lrd_attach_type='SP_M'";
  $result=$db->query($sql);
  $rs=$db->fetch_array($result);
   #----------------------------------------------------------------------------
$proj_id=$rs['proj_id'];
if($proj_id==1){
    $link="WAY";
}else if($proj_id==10){
    $link="LRD_MAP_PIC";
}else{echo"no have:$proj_ida";exit;
}
#----------------------------------------------------------------------------
/*
$folder_way_id=$rs['record_id'];
$folder_file_type=$rs['attach_type'];
$path_server=$link."/".$folder_way_id."/".$folder_file_type;
//$rs['filename_ref'];
*/
$folder_way_id=$rs['record_ref_id'];
$folder_file_type=$rs['attach_type'];
$original_name=$rs['filename_attach'];
#------------------------------------------------------------------------------
$main="_cld_attach";
$rootpath=$domain_data;
//echo $rootpath;exit;
$download_path="http://".$rootpath."/"."util/download/index.php?src=D:/ms4w/apps/".$main."/".$link."/".$folder_way_id."/".$folder_file_type."/".$rs['filename_ref']." &name=".$original_name;
//echo $download_path; exit;     //http://cld.drr.go.th/util/download/index.php?src=D:/ms4w/apps/WAY/106509/image/9 &name=Penguins.jpg
$main=$rootpath."/"."_cld_attach";
//echo $main;exit;
//$path_server=$link."/".$folder_way_id."/".$folder_file_type;
$path_server=$main."/".$link."/".$folder_way_id."/".$folder_file_type;
//$path_server2="../_cld_attach/".$link."/".$folder_way_id."/".$folder_file_type;
//echo $path_server;exit;// $path_server ok
#-----------------------------------------------------------------------------
 /*
  $type_file=explode(".",$rs['filename_ref']);
  if($type_file[1]!="pdf"){
   if($rs['filename_ref']==""){
	$sa=@getimagesize("image/no_image.jpg");
	$shW=$sa[0]+300;
 $shH=$sa[1]+300;
   }
  else{     $path_temp="lrd_regis/Temp";
	         $file_get=$rs['filename_ref'];
            $file_for_resize=$app->get_file_ftp($path_server,$file_get,$path_temp);
            //var_dump($file_for_resize);exit;    /////////////////////////////////
            $sa=getimagesize($file_for_resize);
		$shW=$sa[0]+100;
 $shH=$sa[1]+100;
}}else if($type_file[1]=="pdf"){
		echo "<script>
				window.location.href('download_map.php?orgc_id=$orgc_id')</script>";
} */
$type_file=explode(".",$rs['filename_ref']);
  if($type_file[1]!="pdf"){
   $file_get=$rs['filename_ref'];
   $file_for_resize=$path_server."/".$file_get;

                        /*   if($rs['filename_ref']==""){
                                 $sa=@getimagesize("image/no_image.jpg");
                                 $shW=$sa[0]+300;
                                 $shH=$sa[1]+300;
                           }
                           else{     //echo "$rs[filename_ref]";exit;
                                /* $path_temp="lrd_regis/Temp";

                                 $file_get=$rs['filename_ref'];
                                 $file_for_resize=$app->get_file_ftp($path_server,$file_get,$path_temp);
                                 //var_dump($file_for_resize);exit;    /////////////////////////////////
                                
                                 $file_get=$rs['filename_ref'];
                                 $file_for_resize=$path_server."/".$file_get;
                                 $file_for_resize2=$path_server2."/".$file_get;
                                 //echo  $file_for_resize;exit; //pic ok
                                 $sa=@getimagesize($file_for_resize2);
                                 if(!$sa){
                                 //echo "no";
                                      $no_pic="1";
                                       //exit;
                                 }
                           //$shW=$sa[0]+100;
                           //$shH=$sa[1]+100;
                            $shW=$sa[0]+100;
                           $shH=$sa[1]+100;    //<?php echo $download_path; ?>
                           }     */
 }else if($type_file[1]=="pdf"){
		/*echo "<script>
					//window.location.href('download_map.php?orgc_id=$orgc_id')
               window.location.href('$download_path')
					</script>";   */
					header('Location:'. $download_path);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type ="text/javascript" language="javascript" >
var img = new Image();
img.onload = function() {
  //console.debug(this.width + 'x' + this.height);
   window.resizeTo(this.width, this.height);
}
img.src = 'http://<?php echo $file_for_resize; ?>';
/*
function resize_(){
    window.resizeTo(<? echo $shW;?>,<? echo $shH;?>);

	moveTo(350,0);
}   */
</script>


<style type="text/css">




@media print {
				input#printButton 
					{
						display: none;
					}
				input#pic_print 
					{
						display: none;
					}
					input#printDownload 
					{
						display: none;
					}
			}

</style>


<link href="css/register.css" rel="stylesheet" type="text/css" />
</head>

<body onload="javascript:resize_();">

<div align="center"><br/>
 <input name="pic_print" id="pic_print" type="image"   src="image/b_print.gif" onClick="javascript:window.print();"/><input type="button" id="printButton" onClick="javascript:window.print();" value="พิมพ์แผนที่" /><br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <!--a href="download_map.php?orgc_id=<? echo $orgc_id; ?>"> ดาวน์โหลด</a-->
 <a href="<? echo  $download_path;?>"> ดาวน์โหลด</a>
 <!-- <input type="button" id="printButton" onClick="javascript:window.print();" value="พิมพ์แผนที่" />
   "javascript:window.location.href('download_map.php?orgc_id=<? echo $orgc_id; ?>');" value="ดาวน์โหลด" />-->
  &nbsp;&nbsp;
 
  
</div><br/>
<table width="601" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="">

     
	    <tr>
        <td class="th14bgray"  align="center">ทชจ.&nbsp;<? echo $rs['province_name'];?>&nbsp;&nbsp;<? echo $rs['name_residence']?>
          </td>
      </tr>
	     <tr>
        <td class="th14bgray_line"  align="center">หน่วยงาน&nbsp;<? echo $rs['orgc_name'];?>  </td>
      </tr>
      
    </table>
<table  border="0" align="center">
 <?php $link_check="http://".$file_for_resize;

// Checks URL for a working page. Returns true if link is valid.
function checkLink($link){
    flush();
    $fp = @fopen($link, "r");
    @fclose($fp);
    if (!$fp){ return false;}else{ return true;}
}
// Call the function
if (checkLink($link_check))
{
   $link_ok=1;
}else {
   $link_ok=0;
}

?>

  <tr>
    <!--td align="center"><? if($rs['filename_ref']!=""){?><img src="<? echo $file_for_resize;?>"  /><? }else{?><img src="image/no_image.jpg"  /><? }?></td-->
    <td align="center"><? if($rs['filename_ref']=="" or $link_ok==0){?><img src="http://<?php echo $rootpath ?>/lrd_regis/image/no_image.png"  /><? }else{?><img src="http://<?php echo $file_for_resize; ?>"  /><? }?></td>
  </tr>

</table>    

</body>
</html>
