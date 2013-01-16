<? session_start();  include "../include/config.inc.php";


class db {

    var $conn_id;
    var $result;
    var $record;
    var $db = array();
    var $port;
    var $query_count=0;
	var $sql;
	var $SID='';
	var $typeConn;

    function db() {        ////////////////// ??????????????????????????  port 5432 pg
        global $DB,$SID;
        $this->db = $DB;
        if(ereg(":",$this->db['host'])) {
            list($host,$port) = explode(":",$this->db['host']);
            $this->port = $port;
        } else {
            $this->port = 3306;
        }
		$this->SID = $SID;
		$this->typeConn = 'pgsql';
    }
    /////////////////////////////////////////////////////////////////////////
    function connect() {
        
		if ($this->typeConn=='mysql'){
		 $this->conn_id = mysql_connect($this->db['host'].":".$this->port,$this->db['user'],$this->db['pass']);
	mysql_query("SET NAMES 'UTF8' ");
		}
		///
		else if ($this->typeConn=='mssql'){
             $this->conn_id = mssql_connect($this->db['host'],$this->db['user'],$this->db['pass']); 
		}
		////
		else if ($this->typeConn=='pgsql'){         ////add new postgress
			// pg_connect("host=sheep port=5432 dbname=mary user=lamb password=foo");
             $this->conn_id = pg_connect('host='.$this->db['host'].' port=5432 dbname='.$this->db['dbName'].' user='.$this->db['user'].' password='.$this->db['pass']);
		}
		///
        if ($this->conn_id == 0) {
            $this->sql_error("Connection Error");
        }
        ////////////////////
      
	if ($this->typeConn=='mysql') { 
	 	if (!mysql_select_db($this->db['dbName'], $this->conn_id)) {
            $this->sql_error("Database Error");
        }
	}else if ($this->typeConn=='mssql') {
		if (!mssql_select_db($this->db['dbName'], $this->conn_id)) {
            $this->sql_error("Database Error");
        }
	}//else if ($this->typeConn=='pgsql'){             // เพิ่ม else if ในส่วนของ database postgress
     //if (!pg_select_db($this->db['dbName'], $this->conn_id)) {  // posgres ไม่มีการเลือก db
            //$this->sql_error("Database Error");
	//}// postg
        return $this->conn_id;
    }  //end function connect

    //////////////////////////////////////////////////////////////////////////////////////////////////

    function query($query_string) {
		if ($this->typeConn=='mysql') 
            $this->result = mysql_query($query_string,$this->conn_id);
		else if ($this->typeConn=='mssql') 
           $this->result = mssql_query($query_string,$this->conn_id);
      else if ($this->typeConn=='pgsql')
           $this->result = pg_query($this->conn_id,$query_string);  // new add postgre query
           
		$this->sql = $query_string;
        $this->query_count++;
        if (!$this->result) {
            $this->sql_error("Query Error zerokung");
        }
        return $this->result;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////

    function fetch_array($query_id) {
        if ($this->typeConn=='mysql') 
		    $this->record = mysql_fetch_array($query_id,MYSQL_ASSOC);
		else  if ($this->typeConn=='mssql') 
            $this->record = mssql_fetch_array($query_id);
      else  if ($this->typeConn=='pgsql')               // new add postgre query
            $this->record = pg_fetch_array($query_id);
        return $this->record;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////
    function num_rows($query_id) {
         if ($this->typeConn=='mysql') 
		         return ($query_id) ? mysql_num_rows($query_id) : 0;
		 else  if ($this->typeConn=='mssql') 
                return ($query_id) ? mssql_num_rows($query_id) : 0;
       else  if ($this->typeConn=='pgsql')
                return ($query_id) ? pg_num_rows($query_id) : 0;   // new add postgre query
    }

    function num_fields($query_id) {
		 if ($this->typeConn=='mysql') 
                 return ($query_id) ? mysql_num_fields($query_id) : 0;
		 else   if ($this->typeConn=='mssql') 
                  return ($query_id) ? mssql_num_fields($query_id) : 0;
       else   if ($this->typeConn=='pgsql')
                  return ($query_id) ? pg_num_fields($query_id) : 0;   // new add postgre query
    }
   ///////////////////////////////////////////////////////////////////////////////////////////////////
    function free_result($query_id) {
         if ($this->typeConn=='mysql') 
		     return mysql_free_result($query_id);
		 else  if ($this->typeConn=='mssql') 
			 return mssql_free_result($query_id);
		else  if ($this->typeConn=='pgsql')
			 return pg_free_result($query_id);                      // new add postgre query

    }
    //////////////////////////////////////////////////////////////////////////////////////////////////
	   function fetch_assoc($query_id) {
         if ($this->typeConn=='mysql') 
		     return mysql_fetch_assoc($query_id);
		 else  if ($this->typeConn=='mssql') 
			 return mssql_fetch_assoc($query_id);
		 else  if ($this->typeConn=='pgsql')
			 return pg_fetch_assoc($query_id);            // new add postgre query

    }

   /* function affected_rows() {
        return mysql_affected_rows($this->conn_id);
    }*/

    function close_db() {
    if ($this->typeConn=='mysql') {
		if($this->conn_id) {
            return mysql_close($this->conn_id);
        } else {
            return false;
        }
	}else  if ($this->typeConn=='mssql') {
		 if($this->conn_id) {
            return mssql_close($this->conn_id);
        } else {
            return false;
        }
	}else  if ($this->typeConn=='pgsql') {            // new add postgre query
		 if($this->conn_id) {
            return pg_close($this->conn_id);
        } else {
            return false;
        }
	}
 }
   ////////////////////////////////////////////////////////////////////////////////////////////////
    function sql_error($message) {
        if ($this->typeConn=='mysql') { 
        $description = mysql_error();
        $number = mysql_errno();
		}else if ($this->typeConn=='mssql') {
			 //$description = msql_error();
            // $number = sql_errno(); 
		}else if ($this->typeConn=='pgsql') {
        $description = pg_result_error();     // new add postgre query ??? rigth??
       // $number = pg_result_error_field();
        }
        $error ="MySQL Error : $message\n";
		$error ="Sql is :".$this->sql."\n";
		$error.="zero        :zero\n";
       // $error.="Error Number: $number $description\n";
       $error.="Error        : $description\n";
        $error.="Date        : ".date("D, F j, Y H:i:s")."\n";
        $error.="IP          : ".getenv("REMOTE_ADDR")."\n";
        $error.="Browser     : ".getenv("HTTP_USER_AGENT")."\n";
        $error.="Referer     : ".getenv("HTTP_REFERER")."\n";
        $error.="PHP Version : ".PHP_VERSION."\n";
        $error.="OS          : ".PHP_OS."\n";
        $error.="Server      : ".getenv("SERVER_SOFTWARE")."\n";
        $error.="Server Name : ".getenv("SERVER_NAME")."\n";
        $error.="Script Name : ".getenv("SCRIPT_NAME")."\n";
        echo "<b><font size=4 face=Arial>$message</font></b><hr>";
        echo "<pre>$error</pre>";
        exit();
    }
    /////////////////////////////////////////////////////////////////////////////////////////

function update_data ($tb_name,$fields,$funcs,$str_pk) {
reset($fields); //เป็นฟังชั่น ที่ใช้ชี้ไปยัง element ตัวแรก เช่น array("ตัวแรก","ตัวที่สอง");
if (!empty($funcs))
	 reset ($funcs);//เป็นฟังชั่น ที่ใช้ชี้ไปยัง element ตัวแรก เช่น array("ตัวแรก","ตัวที่สอง");

if($str_pk!="") // Update data maode
{
    $str_pk = stripslashes($str_pk); //function stripslashes(); เป็นฟังชั่น ในการตัด slash "/"
    $valuelist = '';
    while(list($key, $val) = each($fields))
    {
        switch (strtolower($val)) 
        {
	        case null:
	        $val ='null'; 
		        break;
	        case '$set$':
		        $f = "field_$key";
		        $val = "'".($$f?implode(',',$$f):'')."'";   //เชื่อมข้อมูลด้วย ","(comma)  ex. aaa,bbb
		        break;
	        default:
                $val = "'$val'";
		        break;
	    }
       $valuelist .= "$key = $val, ";
       if (!empty($funcs)){
		   if(!empty($funcs[$key]))
               $valuelist .= "$key = $funcs[$key]($val), ";
	   }
    }
    $valuelist = ereg_replace(', $', '', $valuelist);
   
    $query = "UPDATE $tb_name SET $valuelist  $str_pk";  //$str_pk=where
  
}
else // Add data mode
{
    $fieldlist = '';
    $valuelist = '';
    while(list($key, $val) = each($fields))
    {
        $fieldlist .= "$key, ";
        switch (strtolower($val)) 
        {
	        case null:
	           $val ='null';       //เพิ่มค่า null ให้ใหม่/ ''  ใช้งานได้แล้ว นี่คือ ถ้าค่าเป็น null อยากให้ใส่ null เข้าไปต้องใส่ '' ด้วย มันถึงจะเป็นค่าnull 
		        break;
	        case '$set$':
		        $f = "field_$key";
		        $val = "'".($$f?implode(',',$$f):'')."'";
		        break;
	        default:
                $val = "'$val'";  // สงสัยตัวนี้ ที่ทำให้ ค่า null กลายเป็น empty string ''
		        break;
	        }
        if(empty($funcs[$key]))
            $valuelist .= "$val, ";
        else
            $valuelist .= "$funcs[$key]($val), ";
    }
    $fieldlist = ereg_replace(', $', '', $fieldlist);  //ใช้ตรวจสอบว่า มีข้อความตาม pattern ที่กำหนด ใน text หรือไม่
    $valuelist = ereg_replace(', $', '', $valuelist);
    $query = "INSERT INTO $tb_name($fieldlist) VALUES ($valuelist)";
    
} 
   $this->query($query);
}

    function add_data ($tb_name,$fields,$funcs) 
	{
          $this->update_data($tb_name,$fields,$funcs,"");
    }
	function del_data ($tb_name,$str_pk)
	{
		 if (empty($str_pk)) {
			  print "Wraning \$str_pk is not empty in method del_data.... (you want to delete all please select function empty_tb )";
         }else{
			  $this->query("DELETE FROM ".$tb_name." ".$str_pk);
		 }
	}

	function empty_tb ($tb_name) //Empty Table (all data lose)
	{
          $this->query("DELETE FROM ".$tb_name);
	}
	 function set_cfm_action () { //Java script source

     $java_str= "<script language=\"javascript1.2\">";
     $java_str.="        function cfm_action(value_send,goto_page,cfm_value,msg) {";
     $java_str.="                     result = confirm(msg+\" \"+cfm_value+\" ?????????? ?\");";
	 $java_str.="		             if (result == true) {";
	 $java_str.="			                 self.location.href = goto_page+\"?\"+value_send;";
	 $java_str.="		             }";
	 $java_str.="	     } ";  
     $java_str.="  </script>";
     print ($java_str);
     }

	  function set_cfm_action_en () { //Java script source

     $java_str= "<script language=\"javascript1.2\">";
     $java_str.="        function cfm_action(value_send,goto_page,cfm_value,msg) {";
     $java_str.="                     result = confirm(msg+\" \"+cfm_value+\" \");";
	 $java_str.="		             if (result == true) {";
	 $java_str.="			                 self.location.href = goto_page+\"?\"+value_send;";
	 $java_str.="		             }";
	 $java_str.="	     } ";  
     $java_str.="  </script>";
     print ($java_str);
     }


	 function find_max ($tb_name,$field_id) {
       $result = $this->fetch_array ($this->query("select MAX($field_id) from $tb_name"));
       $max_field = "MAX($field_id)";
	   if (empty($result[$max_field]))
              return "0";
	   else
             return $result[$max_field];
   }
    
	function find_max_cond ($tb_name,$field_id,$field_cond,$value_cond) {
       $result = $this->fetch_array ($this->query("select MAX($field_id) from $tb_name where $field_cond like '$value_cond' "));
       $max_field = "MAX($field_id)";
	   if (empty($result[$max_field]))
              return "0";
	   else
             return $result[$max_field];
   }

   function find_max_cond2 ($tb_name,$field_id,$str_cond) {
       $result = $this->fetch_array ($this->query("select MAX($field_id) from $tb_name $str_cond "));
       $max_field = "MAX($field_id)";
	   if (empty($result[$max_field]))
              return "0";
	   else
             return $result[$max_field];
   }

   function get_field_type ($field_name,$tb_name)
  {
           $num_fields = $this->num_fields($this->query("select * from $tb_name"));
		   for ($i =0;$i< $num_fields;$i++) 
	      {
			   if ($field_name == mysql_field_name($this->result,$i))
		           return mysql_field_type($this->result,$i);
	      }
   }

   function get_field_type_f_sql ($field_name,$sql)
  {
           $num_fields = $this->num_fields($this->query($sql));
		   for ($i =0;$i< $num_fields;$i++) 
	      {
			   if ($field_name == mysql_field_name($this->result,$i))
		           return mysql_field_type($this->result,$i);
	      }
   }
  function get_data_rec ($sql_str)
	{
	    return $this->fetch_array($this->query ($sql_str));
	}

	function get_data_field ($sql_str,$field_name)
	{
	    $rec = $this->fetch_array($this->query ($sql_str));
		return $rec[$field_name];
	}

  function num_rows_f_sql ($sql) {
	  return $this->num_rows($this->query($sql));
  }

  function limit_sql($sql,$page_size,$page) {
     $num_row=$this->num_rows_f_sql ($sql);
		if ($page =="" || $page =="0" ) {
		     $page=1;
		}
	$goto = ($page-1)*$page_size;	// ???????????????????
    $sql_limit = $sql." limit $goto,$page_size";
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}

	function limit_sql_mssql($tbName,$fieldOrderby,$page_size,$page) {
	  if ($page =="" || $page =="0" ) {
		         $page=1;
		    }
	 $goto = ($page-1)*$page_size;	// ???????????????????

	$sql_limit = "select top ".$page_size." * from ".$tbName." where ".$fieldOrderby." not in (select top ".$goto." ".$fieldOrderby." from ".$tbName." order by ".$fieldOrderby.") order by ".$fieldOrderby;
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}

	/*function limit_sql_mssql_cond($tbName,$cond,$fieldOrderby,$page_size,$page) {
	  if ($page =="" || $page =="0" ) {
		         $page=1;
		    }
	 $goto = ($page-1)*$page_size;	// ???????????????????

	$sql_limit = "select top ".$page_size." * from ".$tbName." where ".$fieldOrderby." not in (select top ".$goto." ".$fieldOrderby." from ".$tbName." where ".$cond." order by ".$fieldOrderby.") and ".$cond." order by ".$fieldOrderby;
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}*/
	
	function limit_sql_mssql_cond($tbName,$cond,$fieldOrderby,$page_size,$page) {
	  if ($page =="" || $page =="0" ) {
		         $page=1;
		    }
	 $goto = ($page-1)*$page_size;	// ???????????????????

	$sql_limit = "select top ".$page_size." * from ".$tbName." where ".$fieldOrderby." not in (select top ".$goto." ".$fieldOrderby." from ".$tbName." where ".$cond." order by ".$fieldOrderby.") and ".$cond." order by ".$fieldOrderby;
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}

	function limit_sql_mssql_cond_order($tbName,$cond,$typeOrder,$fieldOrderby,$page_size,$page) {
	  if ($page =="" || $page =="0" ) {
		         $page=1;
		    }
	 $goto = ($page-1)*$page_size;	// ???????????????????

	$sql_limit = "select top ".$page_size." * from ".$tbName." where ".$fieldOrderby." not in (select top ".$goto." ".$fieldOrderby." from ".$tbName." where ".$cond." order by ".$fieldOrderby." ".$typeOrder.") and ".$cond." order by ".$fieldOrderby." ".$typeOrder;
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}
	
	function limit_sql_mssql_cond_order_join($tbName,$join,$cond,$typeOrder,$fieldOrderby,$page_size,$page) {
	  if ($page =="" || $page =="0" ) {
		         $page=1;
		    }
	 $goto = ($page-1)*$page_size;	// ???????????????????

	$sql_limit = "select top ".$page_size." * from ".$tbName." ".$join." where ".$fieldOrderby." not in (select top ".$goto." ".$fieldOrderby." from ".$tbName." ".$join." where ".$cond." order by ".$typeOrder.") and ".$cond." order by ".$typeOrder;
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}
	function limit_sql_mssql_cond_order_join_fileds($tbName,$fileds,$join,$cond,$typeOrder,$fieldOrderby,$page_size,$page) {
	  if ($page =="" || $page =="0" ) {
		         $page=1;
		    }
	 $goto = ($page-1)*$page_size;	//calculatle page

echo 	$sql_limit = "select top ".$page_size." ".$fileds." from ".$tbName." ".$join." where ".$fieldOrderby." not in (select top ".$goto." ".$fieldOrderby." from ".$tbName." ".$join." where ".$cond." order by ".$typeOrder.") and ".$cond." order by ".$typeOrder;
    $dbquery_limit = $this->query($sql_limit);
	return $dbquery_limit;
	}

	 function __destruct()
	 {
       $this->close_db();
    }
	
}//end class
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
				  function displaydateyear($x)
				{ 
					

               $a=explode(" ",$x);
               $b1=$a[0];
               $b2=$a[1];

               $c=explode("-",$b1);

               $y=$c[0];
               $m=$c[1]-1;
               $d=$c[2];




               $m=$thai_m[$m];
						$y=$y+543;
							$displaydate="$y";
							return  $displaydate;

?>
                 <script language="javascript">

                 </script>

                <?
			    }
				function displaydateY($x)  
				{ 
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
$CLASS['db']   = new db();
$CLASS['db']->connect ();
 $CLASS['disp'] = new display();
$db   = $CLASS['db'];
$disp = $CLASS['disp'];
$app = $CLASS['app'];

/*****************************************************************************************************************************/
$orgc_id=$_GET['orgc_id'];
$list_year=$_GET['list_year'];
$search=$_GET['search'];
$dd = $disp->displaydateS(date("Y-m-d"));
if($search==""||$search==1){
$conT="";
$text_s="ทั้งหมด";
}
else if($search==2){
$conT="and file_t2!=''";	
$text_s="ที่ ผวจ. อนุมัติแล้ว";
}
else if($search==3){
$conT="and file_t2=''";	
$text_s="ที่ ผวจ. ยังไม่อนุมัติ";
}

	$show 		= $_GET['show'];
if($show==1){
$dd1 = "";
}else if($show==2){
 $show_date = date('Y-m-d',strtotime($_GET['s_date']));
 $end_date = date('Y-m-d',strtotime($_GET['e_date']));
 $con="and way.cre_date between '$show_date' and '$end_date'";
 $dd1=$disp->displaydateS($show_date)." ถึง วันที่ ".$disp->displaydateS1($end_date);
}
	
 
$sql="SELECT province.province_id,province_name,drop_name,org_comunity.orgc_name,org_comunity_detail.num_orders,count(way_id)as amount_way,sum(distance_total)as amount_phase_way,name_residence
FROM
  org_comunity
  INNER JOIN way ON (org_comunity.orgc_id=way.orgc_id)
  INNER JOIN org_comunity_detail ON (org_comunity.orgc_id=org_comunity_detail.orgc_id)
  INNER JOIN amphur ON (org_comunity.amphur_id=amphur.amphur_id)
  INNER JOIN province ON (amphur.province_id = province.province_id)
  INNER JOIN residence ON (province.id_residence = residence.id_residence)
  where org_comunity.orgc_id='$orgc_id' and (way.active='t') and way.flag_reg_road='t'
   GROUP BY province.province_id,province.province_name,province.drop_name,org_comunity.orgc_name,org_comunity_detail.num_orders,residence.name_residence
  ";    //new GROUP BY province.province_id,province.province_name,province.drop_name,org_comunity.orgc_name,org_comunity_detail.num_orders,residence.name_residence
  $result=$db->query($sql);
  $rs=$db->fetch_array($result);
    $sqlSu="select sum(distance_total) as sum_dis FROM
 way where way.orgc_id='$orgc_id' $conT $con and (way.active='t') and way.flag_reg_road='t' ";
  $resultSu=$db->query($sqlSu);
  $rsSu=$db->fetch_array($resultSu);
  $sqlS="SELECT *
FROM
  way
 where way.orgc_id='$orgc_id' $conT $con and (way.active='t') and way.flag_reg_road='t' order by way_code_tail asc";
 $resultS=$db->query($sqlS);
 $numS=$db->num_rows($resultS);
  $sqlS1="SELECT *
FROM
  way
 where way.orgc_id='$orgc_id' and cre_type='1' $conT $con ";
 $resultS1=$db->query($sqlS1);
 $numS1=$db->num_rows($resultS1);

if($numS1>0){
$alertN="        หมายเหตุ ถ้ามีเครื่องหมาย * หน้าลำดับที่ คือสายทางที่อปท. $rs[orgc_name]เลือกกำหนดมาตรฐานชั้นทางเอง";

}
 require('fpdf.php');

class PDF extends FPDF {
	function SetThaiFont() {
		$this->AddFont('AngsanaNew','','angsa.php');
		$this->AddFont('AngsanaNew','B','angsab.php');
		$this->AddFont('AngsanaNew','I','angsai.php');
		$this->AddFont('AngsanaNew','IB','angsaz.php');
		
	}
	
	function conv($string) {
		//return iconv('UTF-8', 'TIS-620', $string);   ///////////////////////////////////////////////////////////////
        return iconv('UTF-8', 'TIS-620', $string);
	}
	//Override คำสั่ง (เมธอด) Footer
	function Footer()	{
 
		//นับจากขอบกระดาษด้านล่างขึ้นมา 10 มม.
		$this->SetY( -10 );
 
		//กำหนดใช้ตัวอักษร Arial ตัวเอียง ขนาด 5
		$this->SetFont('AngsanaNew','I',7);
 
		$this->Cell(0,10,'Time '. date('d').'/'. date('m').'/'.(  date('Y')+543 ).' '. date('H:i:s') ,0,0,'L');
		$this->Cell(0,10, '' ,0,0,'L');
 
		//พิมพ์ หมายเลขหน้า ตรงมุมขวาล่าง
		$this->Cell(0,10, 'page '.$this->PageNo().' of  tp' ,0,0,'R');
 
	}
}


$pdf = new PDF( 'L' , 'mm' , 'A4' );

$pdf->SetThaiFont();


$pdf->SetMargins(5, 5);
$pdf->AliasNbPages( 'tp' );

$pdf->AddPage();

$pdf->Cell(255);
$pdf->SetFont('AngsanaNew', 'B', 10);
$txt = $pdf->conv("แบบ ทถ.6");
$pdf->Cell(20, 10, $txt, 1, 1, 'C');  

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("สมุดลงทะเบียนคุมสายทางหลวงท้องถิ่น");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("ทชจ.$rs[province_name] $rs[name_residence]");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("หน่วยงาน $rs[orgc_name]");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("รายงานเมื่อ $dd");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    

if($show==2){
$pdf->Ln(4);
$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("ตั้งแต่วันที่ $dd1");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
}
$pdf->Ln(6);







$pdf->SetFillColor(237,237,237);
$pdf->SetFont('AngsanaNew', 'B', 9);

$pdf->SetY(40); 
$pdf->SetX(5);
$numS_a = number_format($numS,0,'.',',');
$amount_phase_way = number_format($rsSu['sum_dis'],3,'.',',');
$txt = $pdf->conv("รวมสายทางลงทะเบียน$text_s จำนวน $numS_a เส้น รวมระยะทางลงทะเบียนจำนวน $amount_phase_way (กม.) $alertN" );
$pdf->Cell(285,5,$txt,1,1,'C',true);

$pdf->SetY(45); 
$pdf->SetX(5);
$txt = $pdf->conv("ลำดับ");
$pdf->Cell(6,20,$txt,1,0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(11);
$txt = $pdf->conv("รหัสสายทาง");
$pdf->Cell(18,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(29);
$txt = $pdf->conv("ชื่อสายทาง");
$pdf->Cell(38,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(67);
$txt = $pdf->conv("ชั้นทางในเขตเมือง");
$pdf->Cell(22,10,$txt,'LTR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(67);
$txt = $pdf->conv("หรือในเขตชุมชน (ชั้น)");
$pdf->Cell(22,10,$txt,'LBR',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(89);
$txt = $pdf->conv("ชั้นทางนอกเขตเมือง");
$pdf->Cell(22,10,$txt,'LTR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(89);
$txt = $pdf->conv("หรือนอกเขตชุมชน (ชั้น)");
$pdf->Cell(22,10,$txt,'LBR',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(111);
$txt = $pdf->conv("ระยะทาง (กม.)");
$pdf->Cell(18,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(129);
$txt = $pdf->conv("ผิวจราจรกว้าง (ม.)");
$pdf->Cell(55,15,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(129);
$txt = $pdf->conv("คสล.");
$pdf->Cell(11,5,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(140);
$txt = $pdf->conv("ลาดยาง");
$pdf->Cell(11,5,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(151);
$txt = $pdf->conv("ลูกรัง");
$pdf->Cell(11,5,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(162);
$txt = $pdf->conv("ไหล่ทาง");
$pdf->Cell(11,5,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(173);
$txt = $pdf->conv("ทางเท้า");
$pdf->Cell(11,5,$txt,'1',0,'C',true);


$pdf->SetY(45); 
$pdf->SetX(184);
$txt = $pdf->conv("เขตทางกว้าง (ม.)");
$pdf->Cell(17,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(201);
$txt = $pdf->conv("ปีที่สร้าง (พ.ศ.)");
$pdf->Cell(17,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(218);
$txt = $pdf->conv("ลงทะเบียนเมื่อ");
$pdf->Cell(17,10,$txt,'LTR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(218);
$txt = $pdf->conv("(วัน / เดือน / ปี)");
$pdf->Cell(17,10,$txt,'LBR',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(235);
$txt = $pdf->conv("เจ้าหน้าที่รับผิดชอบ");
$pdf->Cell(25,20,$txt,'LTR',0,'C',true);


$pdf->SetY(45); 
$pdf->SetX(260);
$txt = $pdf->conv("หมายเหตุ");
$pdf->Cell(30,20,$txt,'1',1,'C',true);


 
 $i=1;
 $j=1;
  while($rsS=$db->fetch_array($resultS)){    //line 856 select * form way
if($rsS['cre_type']==1){
$an="*";	
}else {
$an="";	
}
$sql1="select id_regis_detail,type_ja,width_ja,type_sh,width_sh,type_fo,width_fo,kate_regis from register_road_detail where way_id='$rsS[way_id]' order by type_ja asc,width_ja asc,type_sh asc,width_sh asc,type_fo asc,width_fo asc,kate_regis asc";
$result1=$db->query($sql1);

while($rs1=$db->fetch_array($result1)){
$ks[]=$rs1['kate_regis'];
sort($ks);
if($rs1['type_sh']!=0){
$lt[]=$rs1['width_sh'];
sort($lt);
}
else if($rs1['type_fo']!=0){
$tt[]=$rs1['width_fo'];
sort($tt);
}
if($rs1['type_ja']==1){
$wt1[]=$rs1['width_ja'];
sort($wt1);
}else if($rs1['type_ja']==2){
$wt2[]=$rs1['width_ja'];
sort($wt2);
}
else if($rs1['type_ja']==3){
$wt3[]=$rs1['width_ja'];
sort($wt3);
}
   $id_regis_detail=$rs1['id_regis_detail'];      //ยังไงซะมันก็เรียกทีละ way_id เพราะว่า type_road กับ layer_road มันเหมือนกัน ค่านี้มันจะเก็บไปถึงรอบสุดท้ายก็ยังเป้นค่าเดิมอยู่ดี
}//end while


 
  
				   
$pdf->SetFont('AngsanaNew', 'B', 10);

$txt = $pdf->conv("$an$i");
$pdf->Cell(6,7,$txt,1,0,'C',false);

$txt = $pdf->conv("$rsS[way_code_head]$rsS[way_code_tail]");
$pdf->Cell(18,7,$txt,1,0,'C',false);

$txt = $pdf->conv("$rsS[way_name]");
$pdf->Cell(38,7,$txt,1,0,'C',false);

///////////////
if( $id_regis_detail!=0&&$rsS['type_road']==0&&$rsS['cre_type']!=2 ){ if($rsS['layer_road']==0){
$layer_road = "พิเศษ"; 
}else{
$layer_road = $rsS['layer_road']; 
}}else{ 
$layer_road = "-";
}
$txt = $pdf->conv("$layer_road");
$pdf->Cell(22,7,$txt,1,0,'C',false);

//////////////
if( $id_regis_detail!=0&&$rsS['type_road']==1&&$rsS['cre_type']!=2 ){ if($rsS['layer_road']==0){ 
$layer_road = "พิเศษ"; 
}else{
$layer_road = $rsS['layer_road']; 
}}else{ 
$layer_road = "-";
}
//////////////////
$txt = $pdf->conv("$layer_road");
$pdf->Cell(22,7,$txt,1,0,'C',false);

$distance_total = number_format($rsS['distance_total'],3,'.',',');
$txt = $pdf->conv("$distance_total");
$pdf->Cell(18,7,$txt,1,0,'C',false);


$cw1=count($wt1);  if($cw1!=0 ){ if($cw1>0&&$wt1[0]!=$wt1[$cw1-1]){
$aa = number_format($wt1[0],2,'.',',')."-".number_format($wt1[$cw1-1],2,'.',','); 
}else if($wt1[0]==$wt1[$cw1-1]) {
$aa = number_format($wt1[0],2,'.',',');} }else{ 
$aa = "-";}
$txt = $pdf->conv("$aa");
$pdf->Cell(11,7,$txt,1,0,'C',false);

$cw2=count($wt2); if($cw2!=0 ){ if($cw2>0&&$wt2[0]!=$wt2[$cw2-1]){
$bb = number_format($wt2[0],2,'.',',')."-".number_format($wt2[$cw2-1],2,'.',','); }else if($wt2[0]==$wt2[$cw2-1]) {
$bb = $wt2[0];} }else{ 
$bb = "-";}
$txt = $pdf->conv("$bb");
$pdf->Cell(11,7,$txt,1,0,'C',false);

$cw3=count($wt3); if($cw3!=0 ){ if($cw3>0&&$wt3[0]!=$wt3[$cw3-1]){
$cc = number_format($wt3[0],2,'.',',')."-".number_format($wt3[$cw3-1],2,'.',','); }else if($wt3[0]==$wt3[$cw3-1]) {
$cc = $wt3[0];} }else{ 
$cc = "-";}
$txt = $pdf->conv("$cc");
$pdf->Cell(11,7,$txt,1,0,'C',false);

$clt=count($lt); if($clt!=0 ){ if($clt>0&&$lt[0]!=$lt[$clt-1]){
$dd = number_format($lt[0],2,'.',',')."-".number_format($lt[$clt-1],2,'.',',');}
else if($lt[0]==$lt[$clt-1]) {
$dd = number_format($lt[0],2,'.',',');}}
else{ 
$dd = "-";}
$txt = $pdf->conv("$dd");
$pdf->Cell(11,7,$txt,1,0,'C',false);

$ctt=count($tt); if($ctt!=0 ){ if($ctt>0&&$tt[0]!=$tt[$ctt-1]){
$ee = number_format($tt[0],2,'.',',')."-".number_format($tt[$clt-1],2,'.',',');}
else if($tt[0]==$tt[$ctt-1]) {$ee = number_format($tt[0],2,'.',',');}}
else{ $ee = "-";}
$txt = $pdf->conv("$ee");
$pdf->Cell(11,7,$txt,1,0,'C',false);

$cks=count($ks); if($cks!=0 ){ if($cks>0&&$ks[0]!=$ks[$cks-1]){      //  $cks-1=ค่า array ตัวสุดท้าย
$ff = number_format($ks[0],2,'.',',')."-".number_format($ks[$cks-1],2,'.',',');}
else if($ks[0]==$ks[$cks-1]) {$ff = number_format($ks[0],2,'.',',');}} else{ $ff = "-";}
$txt = $pdf->conv("$ff");   //คนเก่าวางยานี่หว่า ไปใช้ ตัวแปรอื่นเฉยเลย $ee
$pdf->Cell(17,7,$txt,1,0,'C',false);

if($rsS['1cre_date']!=""){$yr =$disp->displaydateyear($rsS['1cre_date']);}else{ //ปีที่สร้าง//ในตารางไม่ได้เก็บค่า ปีไว้แล้ว  ไปเลือกค่าปีที่สร้าง ไปดึงเอาแต่ปี จากวันที่สร้าง
$yr = "-";}
$txt = $pdf->conv("$yr");
$pdf->Cell(17,7,$txt,1,0,'C',false);

if($rsS['cre_date']!=""){$cre_date=$disp->displaydateY($rsS['cre_date']);}else{ //ปี
$cre_date = "-";}
$txt = $pdf->conv("$cre_date");
$pdf->Cell(17,7,$txt,1,0,'C',false);

if($rsS['user_key_in']!=""){ $name_per = $rsS['user_key_in']; }else{ $name_per = "-";} 
$txt = $pdf->conv("$name_per");
$pdf->Cell(25,7,$txt,1,0,'C',false);

$pdf->Cell(30,7,'',1,1,'C',false);

$i++;
$j++;
  $distance_totalS+=$distance_total;
unset($wt1);
unset($wt2);
unset($wt3);
unset($lt);
unset($tt);
unset($ks);
$distance_total="";
 if($j == 15)
   {
     $j = 1;
	 $pdf->AliasNbPages( 'tp' );
    $pdf->AddPage();
	
	$pdf->Cell(255);
$pdf->SetFont('AngsanaNew', 'B', 10);
$txt = $pdf->conv("แบบ ทถ.6");
$pdf->Cell(20, 10, $txt, 1, 1, 'C');  

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("สมุดลงทะเบียนคุมสายทางหลวงท้องถิ่น");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("ทชจ.$rs[province_name] $rs[name_residence]");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("หน่วยงาน $rs[orgc_name]");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("รายงานเมื่อ $ddd");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    

if($show==2){
$pdf->Ln(4);
$pdf->SetFont('AngsanaNew', 'B', 10);
$txt = $pdf->conv("ตั้งแต่วันที่ $dd1");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
}
$pdf->Ln(6);




$pdf->SetFillColor(237,237,237);
$pdf->SetFont('AngsanaNew', 'B', 9);

$pdf->SetY(40); 
$pdf->SetX(5);
$numS_a = number_format($numS,0,'.',',');
$amount_phase_way = number_format($rsSu['sum_dis'],3,'.',',');
$txt = $pdf->conv("รวมสายทางลงทะเบียน$text_s จำนวน $numS_a เส้น รวมระยะทางลงทะเบียนจำนวน $amount_phase_way (กม.) $alertN" );
$pdf->Cell(285,5,$txt,1,1,'C',true);

$pdf->SetY(45); 
$pdf->SetX(5);
$txt = $pdf->conv("ลำดับ");
$pdf->Cell(6,20,$txt,1,0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(11);
$txt = $pdf->conv("รหัสสายทาง");
$pdf->Cell(18,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(29);
$txt = $pdf->conv("ชื่อสายทาง");
$pdf->Cell(38,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(67);
$txt = $pdf->conv("ชั้นทางในเขตเมือง");
$pdf->Cell(22,10,$txt,'LTR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(67);
$txt = $pdf->conv("หรือในเขตชุมชน (ชั้น)");
$pdf->Cell(22,10,$txt,'LBR',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(89);
$txt = $pdf->conv("ชั้นทางนอกเขตเมือง");
$pdf->Cell(22,10,$txt,'LTR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(89);
$txt = $pdf->conv("หรือนอกเขตชุมชน (ชั้น)");
$pdf->Cell(22,10,$txt,'LBR',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(111);
$txt = $pdf->conv("ระยะทาง (กม.)");
$pdf->Cell(18,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(129);
$txt = $pdf->conv("ผิวจราจรกว้าง (ม.)");
$pdf->Cell(55,15,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(129);
$txt = $pdf->conv("คสล.");
$pdf->Cell(11,5,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(140);
$txt = $pdf->conv("ลาดยาง");
$pdf->Cell(11,5,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(151);
$txt = $pdf->conv("ลูกรัง");
$pdf->Cell(11,5,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(162);
$txt = $pdf->conv("ไหล่ทาง");
$pdf->Cell(11,5,$txt,'1',0,'C',true);

$pdf->SetY(60); 
$pdf->SetX(173);
$txt = $pdf->conv("ทางเท้า");
$pdf->Cell(11,5,$txt,'1',0,'C',true);


$pdf->SetY(45); 
$pdf->SetX(184);
$txt = $pdf->conv("เขตทางกว้าง (ม.)");
$pdf->Cell(17,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(201);
$txt = $pdf->conv("ปีที่สร้าง (พ.ศ.)");
$pdf->Cell(17,20,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(218);
$txt = $pdf->conv("ลงทะเบียนเมื่อ");
$pdf->Cell(17,10,$txt,'LTR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(218);
$txt = $pdf->conv("(วัน / เดือน / ปี)");
$pdf->Cell(17,10,$txt,'LBR',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(235);
$txt = $pdf->conv("เจ้าหน้าที่รับผิดชอบ");
$pdf->Cell(25,20,$txt,'LTR',0,'C',true);


$pdf->SetY(45); 
$pdf->SetX(260);
$txt = $pdf->conv("หมายเหตุ");
$pdf->Cell(30,20,$txt,'1',1,'C',true);

   }
   }


$pdf->SetFillColor(239,253,255);
	$pdf->SetFont('AngsanaNew', 'B', 11);

$txt = $pdf->conv("รวม");
$pdf->Cell(24,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(38,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(22,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(22,10,$txt,1,0,'C',true);

$distance_totalS = number_format($distance_totalS,3,'.',',');
$txt = $pdf->conv("$distance_totalS");
$pdf->Cell(18,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(11,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(11,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(11,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(11,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(11,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(17,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(17,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(17,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(25,10,$txt,1,0,'C',true);
$txt = $pdf->conv("-");
$pdf->Cell(30,10,$txt,1,1,'C',true);


$pdf->Output();
   

	?>


	


