<?php
class display{
	var $db='';
	var $page='0';
	function display ()	{
		global $CLASS,$PAGE,$SID;
		$this->db = $CLASS["db"];	
		$this->page = $PAGE;
		if (empty($this->page)){
		              $this->page=1;
	           }
	}// End Function

	function get_data($sql,$data){
		$query_get=$this->db->query($sql);
		$rec=$this->db->fetch_array($query_get);
		 return $rec[$data]; 	
	
	}


	function get_data2($tb,$data,$where){
	 	$sql  = "select  $data   from $tb  $where";
		$query_get=$this->db->query($sql);
		$rec=$this->db->fetch_array($query_get);
		 return $rec[$data]; 	
	
	}


function ctrl_page_design_limit_show ($sql,$page_show,$page_size,$txt_colr,$link_colr,$char_sub,$link_value) {
	global $startPage,$endPage;
      $totalpage= $this->find_totalpage ($sql,$page_size);
	  if ($page_show >= $totalpage)
		    $page_show=$totalpage;
	 // echo $this->page;
		   if ($this->page==1){
                 $startPage = 1;
			    $endPage = $page_show;
		   }else if ($this->page == $endPage && $this->page != $totalpage)  {
               $startPage = $this->page;
			   $endPage  +=($page_show-1); 
			  if ($endPage > $totalpage)
				    $endPage = $totalpage;
			}else if ($this->page < $startPage) {
				 $endPage = $startPage;
				$startPage = ($endPage-$page_show)+1;
			}else if($this->page == $totalpage){
				$endPage = $totalpage;
				 $startPage=$totalpage-$page_show+1;
				if($startPage< '0' ){
				$endPage ="" ;
				$startPage="";
				}
			}

     $link_value .="&startPage=$startPage&endPage=$endPage";
      if ($this->page != 1){ // Prvious
						    $prev_page = $this->page-1;
							$ctrlPage.= "<a href='$PHP_SELF?page_size=$page_size&PAGE=1$link_value'><font color='$link_colr'>|&lt;  </font></a>&nbsp;";
						    $ctrlPage.= "<a href='$PHP_SELF?page_size=$page_size&PAGE=$prev_page$link_value'><font color='$link_colr'>&lt;&lt;  </font></a>&nbsp;";
						   }
				if ($totalpage > 1) {
					for($i=$startPage ; $i<$this->page ; $i++) 
						{
							$ctrlPage.= "<a href='$PHP_SELF?page_size=$page_size&PAGE=$i$link_value'><font color=$link_colr>$i</font></a> $char_sub ";
						}

					        $ctrlPage.= "<font color=$txt_colr><b>".$this->page."</b></font> $char_sub ";
				
					for($i=$this->page+1 ; $i<=$endPage ; $i++) 
						{
							$ctrlPage.= "<a href='$PHP_SELF?page_size=$page_size&PAGE=$i$link_value'><font color=$link_colr>$i</font></a> $char_sub ";
						} 
						  if (($this->page != $totalpage) && ($totalpage !=0)){
						    $next_page = $this->page+1;
						    $ctrlPage.= "<a href='$PHP_SELF?page_size=$page_size&PAGE=$next_page$link_value'><font color='$link_colr'>&gt;&gt;</font></a>";
							$ctrlPage.= "&nbsp;<a href='$PHP_SELF?page_size=$page_size&PAGE=$totalpage$link_value'><font color='$link_colr'>&gt;|</font></a>";
						   }
					    }else{
							$ctrlPage =1;
						}
						return $ctrlPage;
					}
function find_totalpage ($sql_str,$page_size) {
 $rows = $this->db->num_rows($this->db->query($sql_str));
  $rt = $rows%$page_size;	// หาจำนวนหน้าทั้งหมด
     if($rt!=0) 
		{ 
			$totalpage = floor($rows/$page_size)+1; 
		}
	else 
		{
			$totalpage = floor($rows/$page_size); 
		}
		return $totalpage;
	}
  function ddw_list_selected ($sql_str,$f_name,$f_value,$select_value)
  {
	  $this->db->query ($sql_str);
	   while ($this->db->fetch_array($this->db->result))
	  {
          if ($this->db->record[$f_value] == $select_value)
			   $str_selected = "selected";
		  else
               $str_selected = ""; 
		  print "<option value='".$this->db->record[$f_value]."'".$str_selected.">".$this->db->record[$f_name]."</option>";
	  }
  }
	function chg_date ($date_input)
    {
		if($date_input){
			$arr_date = explode ("/",$date_input); 
			$date = $arr_date[0];
			$mont = $arr_date[1];
			 $year_th = $arr_date[2];
			$year = $year_th-543;
			return $year."-".$mont."-".$date;
		}else{
			return "";
		}
	}	

	function chg_date_eng ($date_input)
    {
		if($date_input){
			$arr_date = explode ("-",$date_input); 
			$date = $arr_date[2];
			$mont = $arr_date[1];
			 $year_th = $arr_date[0];
			$year = $year_th+543;
			return $date."/".$mont."/".$year;
		}else{
			return "";
		}
	}	


	function sleep_date_bg ($date_input,$techer_id){
		 $strSQL  ="select  daysleep_id     from  daysleepdetail   where  techer_id ='$techer_id'    and    daysleepdetail_date  ='$date_input'  ";
		$query = $this->db->query ($strSQL);
	  	$row = $this->db->num_rows($query);

		if($row > 8){
			$bg="#FF0000";
		}else if($row <= 8  &&  $row >4){
			$bg="#FFFF00";
		}else if($row >=0){
			$bg="#FFFFFF";
		}
		return   $bg;
	}


	function sleep_date_time ($date_input,$techer_id){
		 $strSQL  ="select  daysleepdetail_time     from  daysleepdetail   where  techer_id ='$techer_id'    and    daysleepdetail_date  ='$date_input'  ";
		$query = $this->db->query ($strSQL);
	  	while($row = $this->db->fetch_array($query)){
			$chk_box[$row['daysleepdetail_time']] ="checked";	
	}
	return  $chk_box;
	}


	function station2tech_check ($techer_id){
		 $strSQL  ="select  station_id     from  station2tech   where  techer_id ='$techer_id'   ";
		$query = $this->db->query ($strSQL);
	  	while($row = $this->db->fetch_array($query)){
			$chk_box[$row['station_id']] ="checked";	
	}
	return  $chk_box;
	}

function techer2subject_check ($techer_id){
		 $strSQL  ="select  subject_id     from  techer2subject   where  techer_id ='$techer_id'   ";
		$query = $this->db->query ($strSQL);
	  	while($row = $this->db->fetch_array($query)){
			$chk_box[$row['subject_id']] ="checked";	
	}
	return  $chk_box;
	}
function passwdgen($len){
$code="abcdefghijklmnopqrstuvwxyz123456789";
srand((double)microtime()*1000000);
for($i=0;$i<$len;$i++){
$passwd.=$code[rand()%strlen($code)];

}

return $passwd;


} 	
	
	function useronline($ses_id,$ipaddr){
		$datetimestamp = date("Y-m-d H:i:s");
		$datetimeold = date("Y-m-d H:i:s",(time()-300));

		$where = "where datetimestamp  <  '$datetimeold'  ";		;
		$tb_name = 'useronline';
		$this->db->del_data ($tb_name,$where) ;

		$sql = "select  ses_id  from  useronline where ses_id =  '$ses_id'  ";
		$query = $this->db->query ($sql);
		$row = $this->db->fetch_array($query);

		if($row['ses_id']){
			$where = "where  ses_id  ='$ses_id'    ";
			$data['datetimestamp'] =$datetimestamp;
			$data['ipaddr'] =$ipaddr;
				 $this->db->update_data ($tb_name,$data,$funcs,$where) ;

		}else{
			$data['datetimestamp'] =$datetimestamp;
			$data['ses_id'] =$ses_id;
			$data['ipaddr'] =$ipaddr;
			$add_data = $this->db->add_data ($tb_name,$data,$funcs) ;
		}
		
		$sql = "select  count(ses_id) as useronline  from  useronline ";
		$query = $this->db->query ($sql);
		$row = $this->db->fetch_array($query);
		return $row['useronline']; 

	}
			
				function displaydate($x)  
				{ 
					$thai_m=array ("มกราคม" ,"กุมภาพันธ์"," มีนาคม"," เมษายน"," พฤษภาคม"," มิถุนายน"," กรกฎาคม"," สิงหาคม"," กันยายน"," ตุลาคม","พฤศจิกายน"," ธันวาคม");
					$date_array=explode("-",$x);
					$y=$date_array[0];
					$m=$date_array[1] - 1;
					$d=$date_array[2];
						$m=$thai_m[$m];
						$y=$y+543;
							$displaydate="$d  $m  $y";
							return  $displaydate;
			    }
				
						function displaydateS($x)  
				{ 
					$thai_m=array ("มกราคม" ,"กุมภาพันธ์"," มีนาคม"," เมษายน"," พฤษภาคม"," มิถุนายน"," กรกฎาคม"," สิงหาคม"," กันยายน"," ตุลาคม","พฤศจิกายน"," ธันวาคม");
					$date_array=explode("-",$x);
					$y=$date_array[0];
					$m=$date_array[1] - 1;
					$d=$date_array[2];
						$m=$thai_m[$m];
						$y=$y+543;
							$displaydate="วันที่ $d  เดือน $m  พศ.$y";
							return  $displaydate;
			    }
					function displaydateS1($x)  
				{ 
					$thai_m=array ("มกราคม" ,"กุมภาพันธ์"," มีนาคม"," เมษายน"," พฤษภาคม"," มิถุนายน"," กรกฎาคม"," สิงหาคม"," กันยายน"," ตุลาคม","พฤศจิกายน"," ธันวาคม");
					$date_array=explode("-",$x);
					$y=$date_array[0];
					$m=$date_array[1] - 1;
					$d=$date_array[2];
						$m=$thai_m[$m];
						$y=$y+543;
							$displaydate="$d  เดือน $m  พศ.$y";
							return  $displaydate;
			    }
				
				function displaydateY($x)  
				{
				if($x==""){
              $back="ไม่มีข้อมูล";
				  return $back ;

				} else{
					$thai_m=array ("ม.ค." ,"ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");

               $a=explode(" ",$x);
               $b1=$a[0];
               $b2=$a[1];

               $c=explode("-",$b1);

               $y=$c[0];
               $m=$c[1]-1;
               $d=$c[2];


               // return $b1;

               $m=$thai_m[$m];
						$y=$y+543;
							$displaydate=" $d  $m  $y";
							return  $displaydate;



                      }









               /*
			 		$date_array=explode("-",$x);
					

					$y=$date_array[0];
					$m=$date_array[1] - 1;
					$d=$date_array[2];

					$d1=explode(":",$d);
					$d_1=$d1[0];
               $d_2=$d1[1];
               $d_3=$d1[2];

               $d2=explode(" ",$d1);
               $d2_1=$d2[0];
               $d2_2=$d2[1];

						$m=$thai_m[$m];
						$y=$y+543;
							$displaydate=" $d  $m  $y";
							return  $displaydate;        
							*/?>
                 <script language="javascript">
                   /*
                 thai_m=array ("ม.ค." ,"ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                 a=<?=$x?>.split(" ");
                 b1=a[0];
                 b2=a[1];

                   c=b1.split("-");

                y=c[0];
					m=c[1] - 1;
					d=c[2];

                 m=<?=$thai_m?>[m];
						y=y+543;
							displaydate=" d  m  y";
							return  displaydate;   */
                 </script>

                <?
			    }
				function chkmail($chkmail){
	if(ereg("^[^@ ]+@([a-zA-Z0-9\-]+\.)+(a-zA-Z0-9\-]{2}|net|com|gov|mil|org|edu|int)$",$chkmail)){
	return true;
	} else {
		return false;
	}
	}
}// Class
?>