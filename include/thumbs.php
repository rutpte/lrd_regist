<?php
$REFERER  = $_SERVER['HTTP_REFERER'];
//define a maxim size for the uploaded images
define ("MAX_SIZE","200");
define ("WIDTH","150");
define ("HEIGHT","100");

// this is the function that will create the thumbnail image from the uploaded image
// the resize will be done considering the width and height defined, but without deforming the image
function make_thumb($img_name,$filename,$new_w,$new_h)
{
//get image extension.
$ext=getExtension($img_name);
//creates the new image using the appropriate function from gd library
if(!strcmp("jpg",$ext) || !strcmp("jpeg",$ext))
$src_img=imagecreatefromjpeg($img_name);

if(!strcmp("png",$ext))
$src_img=imagecreatefrompng($img_name);

if(!strcmp("gif",$ext))
$src_img=imagecreatefromgif($img_name);

//gets the dimmensions of the image
$old_x=imageSX($src_img);
$old_y=imageSY($src_img);

// next we will calculate the new dimmensions for the thumbnail image
// the next steps will be taken:
// 1. calculate the ratio by dividing the old dimmensions with the new ones
// 2. if the ratio for the width is higher, the width will remain the one define in WIDTH variable
// and the height will be calculated so the image ratio will not change
// 3. otherwise we will use the height ratio for the image
// as a result, only one of the dimmensions will be from the fixed ones
$ratio1=$old_x/$new_w;
$ratio2=$old_y/$new_h;
if($ratio1>$ratio2) {
$thumb_w=$new_w;
$thumb_h=$old_y/$ratio1;
}
else {
$thumb_h=$new_h;
$thumb_w=$old_x/$ratio2;
}

// we create a new image with the new dimmensions
$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);

// resize the big image to the new created one
imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);

// output the created image to the file. Now we will have the thumbnail into the file named by $filename
if(!strcmp("png",$ext))
imagepng($dst_img,$filename);
else
imagejpeg($dst_img,$filename);

//destroys source and destination images.
imagedestroy($dst_img);
imagedestroy($src_img);
}

// This function reads the extension of the file.
// It is used to determine if the file is an image by checking the extension.
function getExtension($str) {
$i = strrpos($str,".");
if (!$i) { return ""; }
$l = strlen($str) - $i;
$ext = substr($str,$i+1,$l);
return $ext;
}

function resize($img_name,$filename){

$ext=getExtension($img_name);

if(!strcmp("jpg",$ext) || !strcmp("jpeg",$ext))
$src_img=imagecreatefromjpeg($img_name);

if(!strcmp("png",$ext))
$src_img=imagecreatefrompng($img_name);

if(!strcmp("gif",$ext))
$src_img=imagecreatefromgif($img_name);
	
	$old_x=imageSX($src_img);
$old_y=imageSY($src_img);
	if ($old_x>100||$old_y>100) {
		$new_w = 100; 
		$new_h = 100;
		
$dst_img= imagecreatetruecolor($new_w, $new_h);
		imagecopyresized(	$dst_img, $src_img,0,0,0,0,$new_w, $new_h,$old_x,$old_y);
		if(!strcmp("png",$ext))
imagepng($dst_img,$filename);
else
imagejpeg($dst_img,$filename);

//destroys source and destination images.
imagedestroy($dst_img);
imagedestroy($src_img);}

}
function resize_created($file,$mainpath,$path){

$errors=0;
		$image=$file['name'];
	if ($image){
		$filename = stripslashes($file['name']);
		$extension = getExtension($filename);
		$extension = strtolower($extension);
		if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png")&& ($extension != "gif")){
					echo '<h1>Unknown extension!</h1>';   //ª√–‡¿∑‰ø≈Ï
		$errors=1;
		}else{
				$size=getimagesize($file['tmp_name']);
				
	$ori_w = $size[0]; 
	$ori_h = $size[1];
	if($ori_w<100||$ori_h <100){
	echo "<script>alert('√Ÿª¿“æµÈÕß¢π“¥ 100*100 ¢÷Èπ‰ª πË–§√—∫  ');	
				window.location = '../home.php';</script>";
				exit;
	}
				$sizekb=filesize($file['tmp_name']);
				if ($sizekb > MAX_SIZE*1024)	{
					echo '<h1>You have exceeded the size limit!</h1>';   //¢π“¥‰ø≈Ï
					$errors=1;
				}

			$image_name=time().'.'.$extension;    //™◊ËÕ‰ø≈Ï
		   //°ÍÕª‰ø≈Ï
			$newname=$mainpath.$path.$image_name;
			$filenaame['newname']=$path.$image_name;
			$copied = copy($file['tmp_name'], $newname);
			if (!$copied)	{
			echo '<h1>Copy unsuccessfull!</h1>';
			$errors=1;
			}	else	{
		//°ÍÕª‰ø≈Ï  temp
			$thumb_name=$mainpath.$path.'thumb/thumb_'.$image_name;
			$filenaame['thumb_name']=$path.'thumb/thumb_'.$image_name;
			$thumb=resize($newname,$thumb_name);
			}
	}

	}

	return  $filenaame;
}


function Thumbnail_created($file,$mainpath,$path){

$errors=0;
		$image=$file['name'];
	if ($image){
		$filename = stripslashes($file['name']);
		$extension = getExtension($filename);
		$extension = strtolower($extension);
		if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png")&& ($extension != "gif")){
					echo '<h1>Unknown extension!</h1>';   //ª√–‡¿∑‰ø≈Ï
		$errors=1;
		}else{
				$size=getimagesize($file['tmp_name']);
				$sizekb=filesize($file['tmp_name']);
				if ($sizekb > MAX_SIZE*1024)	{
					echo '<h1>You have exceeded the size limit!</h1>';   //¢π“¥‰ø≈Ï
					$errors=1;
				}

			$image_name=time().'.'.$extension;    //™◊ËÕ‰ø≈Ï
		   //°ÍÕª‰ø≈Ï
			$newname=$mainpath.$path.$image_name;
			$filenaame['newname']=$path.$image_name;
			$copied = copy($file['tmp_name'], $newname);
			if (!$copied)	{
			echo '<h1>Copy unsuccessfull!</h1>';
			$errors=1;
			}	else	{
		//°ÍÕª‰ø≈Ï  temp
			$thumb_name=$mainpath.$path.'thumb/thumb_'.$image_name;
			$filenaame['thumb_name']=$path.'thumb/thumb_'.$image_name;
			$thumb=make_thumb($newname,$thumb_name,WIDTH,HEIGHT);
			}
	}

	}

	return  $filenaame;
}

//If no errors registred, print the success message and show the thumbnail image created
//if(isset($_POST['Submit']) && !$errors){
//echo "<h1>Thumbnail created Successfully!</h1>";
//echo '<img src="'.$thumb_name.'">';
//}

?>
<!-- next comes the form, you must set the enctype to "multipart/form-data" and use an input type "file

<form name="newad" method="post" enctype="multipart/form-data" action="">
<table>
<tr><td><input type="file" name="image" ></td></tr>
<tr><td><input name="Submit" type="submit" value="Upload image"></td></tr>
</table>
</form>" -->