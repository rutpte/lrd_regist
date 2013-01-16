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
$province_id=$_GET['province_id'];
$list_year=$_GET['list_year'];
$show 		= $_GET['show'];
$dd = $disp->displaydateS(date("Y-m-d"));
if($show==1){
$dd1 = "";
}else if($show==2){
 $show_date = date('Y-m-d',strtotime($_GET['s_date']));
 $end_date = date('Y-m-d',strtotime($_GET['e_date']));
 $con="and way.cre_date between '$show_date' and '$end_date'";
 $dd1=$disp->displaydateS($show_date)." ถึง วันที่ ".$disp->displaydateS1($end_date);
}
	
$sqlN="select province.province_name,residence.id_residence,residence.name_residence FROM
  residence
  INNER JOIN province ON (residence.id_residence = province.id_residence) where province_id='$province_id'";
$resultN=$db->query($sqlN);
$rsN=$db->fetch_array($resultN); 

require('fpdf.php');

class PDF extends FPDF {
	function SetThaiFont() {
		$this->AddFont('AngsanaNew','','angsa.php');
		$this->AddFont('AngsanaNew','B','angsab.php');
		$this->AddFont('AngsanaNew','I','angsai.php');
		$this->AddFont('AngsanaNew','IB','angsaz.php');
		
	}
	
	function conv($string) {
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
$txt = $pdf->conv("แบบ ทถ.7");
$pdf->Cell(20, 10, $txt, 1, 1, 'C');  

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("ตารางสรุปการลงทะเบียนทางหลวงท้องถิ่น");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("ในเขตพื้นที่ สำนักทางหลวงชนบทจังหวัด$rsN[province_name] $rsN[name_residence] กรมทางหลวงชนบท กระทรวงคมนาคม");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("รายงานเมื่อ $dd");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    

if($show==2){
$pdf->Ln(6);
$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("ตั้งแต่วันที่ $dd1");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
}
$pdf->Ln(10);




$pdf->SetFillColor(237,237,237);
$pdf->SetFont('AngsanaNew', 'B', 7);

$pdf->SetY(40); 
$pdf->SetX(5);
$txt = $pdf->conv("ชื่อ อปท.");
$pdf->Cell(24,20,$txt,1,0,'C',true);


$pdf->SetY(40); 
$pdf->SetX(29);
$txt = $pdf->conv("ถนนในเขตเมือง/ในเขตชุมชน");
$pdf->Cell(84,5,$txt,'1',0,'C',true);

$pdf->SetY(40); 
$pdf->SetX(113);
$txt = $pdf->conv("ถนนนอกเขตเมือง/นอกเขตชุมชน");
$pdf->Cell(112,5,$txt,'1',0,'C',true);


$pdf->SetY(40); 
$pdf->SetX(225);
$txt = $pdf->conv("ความก้าวหน้าของการลงทะเบียน");
$pdf->Cell(65,5,$txt,'1',0,'C',true);



$pdf->SetY(45); 
$pdf->SetX(29);
$txt = $pdf->conv("ชั้นพิเศษ");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(43);
$txt = $pdf->conv("ชั้นที่1");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(57);
$txt = $pdf->conv("ชั้นที่2");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(71);
$txt = $pdf->conv("ชั้นที่3");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(85);
$txt = $pdf->conv("ชั้นที่4");
$pdf->Cell(14,5,$txt,'1',0,'C',true);


$pdf->SetY(45); 
$pdf->SetX(99);
$txt = $pdf->conv("รวมในเขตชุมชน");
$pdf->Cell(14,5,$txt,'1',0,'C',true);


$pdf->SetY(45); 
$pdf->SetX(113);
$txt = $pdf->conv("ชั้นพิเศษ");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(127);
$txt = $pdf->conv("ชั้นที่1");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(141);
$txt = $pdf->conv("ชั้นที่2");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(155);
$txt = $pdf->conv("ชั้นที่3");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(169);
$txt = $pdf->conv("ชั้นที่4");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(183);
$txt = $pdf->conv("ชั้นที่5");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(197);
$txt = $pdf->conv("ชั้นที่6");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(211);
$txt = $pdf->conv("รวมนอกเขตชุมชน");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(225);
$txt = $pdf->conv("รวมทะเบียน");
$pdf->Cell(65,5,$txt,'1',0,'C',true);



$pdf->SetY(50); 
$pdf->SetX(29);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(36);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(43);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(50);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(57);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(64);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(71);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(78);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(85);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(92);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(99);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(106);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(113);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(120);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(127);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(134);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(141);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(148);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(155);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(162);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(169);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(176);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(183);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(190);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(197);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(204);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(211);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(218);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(225);
$txt = $pdf->conv("จำนวนสายทาง");
$pdf->Cell(32,10,$txt,'1',0,'C',true);



$pdf->SetY(50); 
$pdf->SetX(257);
$txt = $pdf->conv("ระยะทาง (กม.)");
$pdf->Cell(33,10,$txt,'1',0,'C',true);




$pdf->SetY(55); 
$pdf->SetX(29);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(36);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(43);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(50);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(57);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(64);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(71);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(78);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(85);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(92);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(99);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(106);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(113);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(120);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(127);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(134);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(141);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(148);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(155);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(162);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(169);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(176);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(183);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(190);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(197);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(204);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(211);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(218);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',1,'C',true);








                         //join org_comunity_detail ด้วย

$sql="SELECT org_comunity.orgc_id,org_comunity.orgc_name
FROM
  residence
  INNER JOIN province ON (residence.id_residence = province.id_residence)
  INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (org_comunity.amphur_id = amphur.amphur_id)
  INNER JOIN org_comunity_detail ON (org_comunity.orgc_id=org_comunity_detail.orgc_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)

  
     where province.province_id='$province_id' and (way.active='t') and way.flag_reg_road='t' $con
  GROUP BY org_comunity.orgc_id,org_comunity.orgc_name,org_comunity_detail.num_orders
 order by org_comunity_detail.num_orders asc";

 /*
 SELECT org_comunity.orgc_id,org_comunity.orgc_name
FROM
  residence
  INNER JOIN province ON (residence.id_residence = province.id_residence)
  INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (org_comunity.amphur_id = amphur.amphur_id)
  INNER JOIN org_comunity_detail ON (org_comunity.orgc_id=org_comunity_detail.orgc_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)
  INNER JOIN register_road_detail ON (register_road_detail.way_id=way.way_id)
  
     where  register_road_detail.id_regis_detail!=0  and province.province_id='$province_id' $con
  GROUP BY org_comunity.orgc_id,org_comunity.orgc_name,org_comunity_detail.num_orders
 order by org_comunity_detail.num_orders asc
 */
  $result=$db->query($sql);
$result=$db->query($sql);
  $num_r=$db->num_rows($result);


  
  $i=0; 
  $j=1;
     while($rs=$db->fetch_array($result)){

  $sqlSum="SELECT way.distance_total,way.type_road,way.layer_road
FROM
  residence
  INNER JOIN province ON (residence.id_residence = province.id_residence)
  INNER JOIN amphur ON (amphur.province_id=province.province_id)
  INNER JOIN org_comunity ON (org_comunity.amphur_id = amphur.amphur_id)
  INNER JOIN way ON (org_comunity.orgc_id = way.orgc_id)

  where org_comunity.orgc_id='$rs[orgc_id]' and (way.active='t') and way.flag_reg_road='t' $con";

  $resultSum=$db->query($sqlSum);
  while($rsSum=$db->fetch_array($resultSum)){

  if($rsSum['type_road']==0&&$rsSum['layer_road']==0){

  $class0+=1;
  $numP0+=$rsSum['distance_total'];
  }
  else if($rsSum['type_road']==0&&$rsSum['layer_road']==1){
  $class1+=1;
  $numP1+=$rsSum['distance_total'];
  }
  else if($rsSum['type_road']==0&&$rsSum['layer_road']==2){
  $class2+=1;
  $numP2+=$rsSum['distance_total'];
  }
  else if($rsSum['type_road']==0&&$rsSum['layer_road']==3){
  $class3+=1;
  $numP3+=$rsSum['distance_total'];


 
  }
  else if($rsSum['type_road']==0&&$rsSum['layer_road']==4){
  $class4+=1;
  $numP4+=$rsSum['distance_total'];
  }
  else if($rsSum['type_road']==1&&$rsSum['layer_road']==0){
  $class0_1+=1;
  $numP0_1+=$rsSum['distance_total'];
  }
  else if($rsSum['type_road']==1&&$rsSum['layer_road']==1){
  $class1_1+=1;
  $numP1_1+=$rsSum['distance_total'];
  }
  else if($rsSum['type_road']==1&&$rsSum['layer_road']==2){
  $class2_1+=1;
  $numP2_1+=$rsSum['distance_total'];
  }
  else if($rsSum['type_road']==1&&$rsSum['layer_road']==3){
  $class3_1+=1;
  $numP3_1+=$rsSum['distance_total'];
  }
  else if($rsSum['type_road']==1&&$rsSum['layer_road']==4){
  $class4_1+=1;
  $numP4_1+=$rsSum['distance_total'];
  }
   else if($rsSum['type_road']==1&&$rsSum['layer_road']==5){
  $class5_1+=1;
  $numP5_1+=$rsSum['distance_total'];
  }
   else if($rsSum['type_road']==1&&$rsSum['layer_road']==6){
  $class6_1+=1;
  $numP6_1+=$rsSum['distance_total'];
  } 
 
  

 
   $sumClassT1=$class0+$class1+$class2+$class3+$class4;
  $sumNumT1=$numP0+$numP1+$numP2+$numP3+$numP4;

  
    $sumClassT2=$class0_1+$class1_1+$class2_1+$class3_1+$class4_1+$class5_1+$class6_1;
  $sumNumT2=$numP0_1+$numP1_1+$numP2_1+$numP3_1+$numP4_1+$numP5_1+$numP6_1;
 
$sumClassT3=$sumClassT1+$sumClassT2;
$sumNumT3=$sumNumT1+$sumNumT2;
  //$perClass=($sumClassT3*100)/$sum_amount_way;
 // $perNum=($sumNumT3*100)/$sum_amount_phase_way;

  }

 //$sum_amount_wayS+=$sum_amount_way;
  //$sum_amount_phase_wayS+=$sum_amount_phase_way;

  $sum_c0+=$class0;
  $sum_p0+=$numP0;
  $sum_c1+=$class1;
  $sum_p1+=$numP1;
  $sum_c2+=$class2;
  $sum_p2+=$numP2;
  $sum_c3+=$class3;
  $sum_p3+=$numP3;
  $sum_c4+=$class4;
  $sum_p4+=$numP4;
  

  $sum_sumClassT1+=$sumClassT1;
  $sum_sumNumT1+=$sumNumT1;
  $sum_c0_1+=$class0_1;
  $sum_p0_1+=$numP0_1;
  $sum_c1_1+=$class1_1;
  $sum_p1_1+=$numP1_1;
  $sum_c2_1+=$class2_1;
  $sum_p2_1+=$numP2_1;
  $sum_c3_1+=$class3_1;
  $sum_p3_1+=$numP3_1;
  $sum_c4_1+=$class4_1;
  $sum_p4_1+=$numP4_1;
  $sum_c5_1+=$class5_1;
  $sum_p5_1+=$numP5_1;
  $sum_c6_1+=$class6_1;
  $sum_p6_1+=$numP6_1;
  $sum_sumClassT2+=$sumClassT2;
  $sum_sumNumT2+=$sumNumT2;

$sum_sumClassT3+=$sumClassT3;
$sum_sumNumT3+=$sumNumT3;

$pdf->SetFont('AngsanaNew', '', 6);
$txt = $pdf->conv("$rs[orgc_name]");
$pdf->Cell(24,5,$txt,1,0,'L',false);
$pdf->SetFont('AngsanaNew', 'B', 7);



if($class0!=""){
$class0 = number_format($class0,0,'.',','); 
}else{
$class0 = "-";
}
$txt = $pdf->conv("$class0");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP0!=""){
$numP0 = number_format($numP0,3,'.',','); 
}else{
$numP0 = "-";
}
$txt = $pdf->conv("$numP0");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class1!=""){
$class1 = number_format($class1,0,'.',','); 
}else{
$class1 = "-";
}
$txt = $pdf->conv("$class1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP1!=""){
$numP1 = number_format($numP1,3,'.',','); 
}else{
$numP1 = "-";
}
$txt = $pdf->conv("$numP1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class2!=""){
$class2 = number_format($class2,0,'.',','); 
}else{
$class2 = "-";
}
$txt = $pdf->conv("$class2");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP2!=""){
$numP2 = number_format($numP2,3,'.',','); 
}else{
$numP2 = "-";
}
$txt = $pdf->conv("$numP2");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class3!=""){
$class3 = number_format($class3,0,'.',','); 
}else{
$class3 = "-";
}
$txt = $pdf->conv("$class3");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP3!=""){
$numP3 = number_format($numP3,3,'.',','); 
}else{
$numP3 = "-";
}
$txt = $pdf->conv("$numP3");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class4!=""){
$class4 = number_format($class4,0,'.',','); 
}else{
$class4 = "-";
}
$txt = $pdf->conv("$class4");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP4!=""){
$numP4 = number_format($numP4,3,'.',','); 
}else{
$numP4 = "-";
}
$txt = $pdf->conv("$numP4");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($sumClassT1!=""){
$sumClassT1 = number_format($sumClassT1,0,'.',','); 
}else{
$sumClassT1 = "-";
}
$txt = $pdf->conv("$sumClassT1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($sumNumT1!=""){
$sumNumT1 = number_format($sumNumT1,3,'.',','); 
}else{
$sumNumT1 = "-";
}
$txt = $pdf->conv("$sumNumT1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class0_1!=""){
$class0_1 = number_format($class0_1,0,'.',','); 
}else{
$class0_1 = "-";
}
$txt = $pdf->conv("$class0_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP0_1!=""){
$numP0_1 = number_format($numP0_1,3,'.',','); 
}else{
$numP0_1 = "-";
}
$txt = $pdf->conv("$numP0_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class1_1!=""){
$class1_1 = number_format($class1_1,0,'.',','); 
}else{
$class1_1 = "-";
}
$txt = $pdf->conv("$class1_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP1_1!=""){
$numP1_1 = number_format($numP1_1,3,'.',','); 
}else{
$numP1_1 = "-";
}
$txt = $pdf->conv("$numP1_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class2_1!=""){
$class2_1 = number_format($class2_1,0,'.',','); 
}else{
$class2_1 = "-";
}
$txt = $pdf->conv("$class2_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP2_1!=""){
$numP2_1 = number_format($numP2_1,3,'.',','); 
}else{
$numP2_1 = "-";
}
$txt = $pdf->conv("$numP2_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class3_1!=""){
$class3_1 = number_format($class3_1,0,'.',','); 
}else{
$class3_1 = "-";
}
$txt = $pdf->conv("$class3_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP3_1!=""){
$numP3_1 = number_format($numP3_1,3,'.',','); 
}else{
$numP3_1 = "-";
}
$txt = $pdf->conv("$numP3_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class4_1!=""){
$class4_1 = number_format($class4_1,0,'.',','); 
}else{
$class4_1 = "-";
}
$txt = $pdf->conv("$class4_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP4_1!=""){
$numP4_1 = number_format($numP4_1,3,'.',','); 
}else{
$numP4_1 = "-";
}
$txt = $pdf->conv("$numP4_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class5_1!=""){
$class5_1 = number_format($class5_1,0,'.',','); 
}else{
$class5_1 = "-";
}
$txt = $pdf->conv("$class5_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP5_1!=""){
$numP5_1 = number_format($numP5_1,3,'.',','); 
}else{
$numP5_1 = "-";
}
$txt = $pdf->conv("$numP5_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($class6_1!=""){
$class6_1 = number_format($class6_1,0,'.',','); 
}else{
$class6_1 = "-";
}
$txt = $pdf->conv("$class6_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($numP6_1!=""){
$numP6_1 = number_format($numP6_1,3,'.',','); 
}else{
$numP6_1 = "-";
}
$txt = $pdf->conv("$numP6_1");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($sumClassT2!=""){
$sumClassT2 = number_format($sumClassT2,0,'.',','); 
}else{
$sumClassT2 = "-";
}
$txt = $pdf->conv("$sumClassT2");
$pdf->Cell(7,5,$txt,1,0,'C',false);

if($sumNumT2!=""){
$sumNumT2 = number_format($sumNumT2,3,'.',','); 
}else{
$sumNumT2 = "-";
}
$txt = $pdf->conv("$sumNumT2");
$pdf->Cell(7,5,$txt,1,0,'C',false);




if($sumClassT3!=""){
$sumClassT3 = number_format($sumClassT3,0,'.',','); 
}else{
$sumClassT3 = "-";
}
$txt = $pdf->conv("$sumClassT3");
$pdf->Cell(32,5,$txt,1,0,'C',false);

if($sumNumT3!=""){
$sumNumT3 = number_format($sumNumT3,3,'.',','); 
}else{
$sumNumT3 = "-";
}
$txt = $pdf->conv("$sumNumT3");
$pdf->Cell(33,5,$txt,1,1,'C',false);





$i++;
$j++;


 
  


  
 $class0="";
$class1="";
$class2="";
$class3="";
$class4="";
 $numP0="";
 $numP1="";
 $numP2="";
 $numP3="";
 $numP4="";  
   $sumClassT1="";
    $sumNumT1="";
	//$sum_amount_way="";


 
   $class0_1="";
$class1_1="";
$class2_1="";
$class3_1="";
$class4_1="";
$class5_1="";
$class6_1="";
 $numP0_1="";
 $numP1_1="";
 $numP2_1="";
 $numP3_1="";
 $numP4_1=""; 
 $numP5_1="";
 $numP6_1=""; 
   $sumClassT2="";
  $sumNumT2="";
    




$sumClassT3="";
$sumNumT3="";

  $sum_amount_phase_way="";
 $perNum="";

 if($j == 26)
   {
     $j = 1;
	 $pdf->AliasNbPages( 'tp' );
    $pdf->AddPage();
	
	$pdf->Cell(255);
$pdf->SetFont('AngsanaNew', 'B', 10);
$txt = $pdf->conv("แบบ ทถ.7");
$pdf->Cell(20, 10, $txt, 1, 1, 'C');  

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("ตารางสรุปการลงทะเบียนทางหลวงท้องถิ่น");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("ในเขตพื้นที่ สำนักทางหลวงชนบทจังหวัด$rsN[province_name] $rsN[name_residence] กรมทางหลวงชนบท กระทรวงคมนาคม");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
$pdf->Ln(6);

$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("รายงานเมื่อ $dd");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    

if($show==2){
$pdf->Ln(6);
$pdf->SetFont('AngsanaNew', 'B', 12);
$txt = $pdf->conv("ตั้งแต่วันที่ $dd1");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');    
}
$pdf->Ln(10);



$pdf->SetFillColor(237,237,237);
$pdf->SetFont('AngsanaNew', 'B', 7);

$pdf->SetY(40); 
$pdf->SetX(5);
$txt = $pdf->conv("ชื่อ อปท.");
$pdf->Cell(24,20,$txt,1,0,'C',true);


$pdf->SetY(40); 
$pdf->SetX(29);
$txt = $pdf->conv("ถนนในเขตเมือง/ในเขตชุมชน");
$pdf->Cell(84,5,$txt,'1',0,'C',true);

$pdf->SetY(40); 
$pdf->SetX(113);
$txt = $pdf->conv("ถนนนอกเขตเมือง/นอกเขตชุมชน");
$pdf->Cell(112,5,$txt,'1',0,'C',true);


$pdf->SetY(40); 
$pdf->SetX(225);
$txt = $pdf->conv("ความก้าวหน้าของการลงทะเบียน");
$pdf->Cell(65,5,$txt,'1',0,'C',true);



$pdf->SetY(45); 
$pdf->SetX(29);
$txt = $pdf->conv("ชั้นพิเศษ");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(43);
$txt = $pdf->conv("ชั้นที่1");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(57);
$txt = $pdf->conv("ชั้นที่2");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(71);
$txt = $pdf->conv("ชั้นที่3");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(85);
$txt = $pdf->conv("ชั้นที่4");
$pdf->Cell(14,5,$txt,'1',0,'C',true);


$pdf->SetY(45); 
$pdf->SetX(99);
$txt = $pdf->conv("รวมในเขตชุมชน");
$pdf->Cell(14,5,$txt,'1',0,'C',true);


$pdf->SetY(45); 
$pdf->SetX(113);
$txt = $pdf->conv("ชั้นพิเศษ");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(127);
$txt = $pdf->conv("ชั้นที่1");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(141);
$txt = $pdf->conv("ชั้นที่2");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(155);
$txt = $pdf->conv("ชั้นที่3");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(169);
$txt = $pdf->conv("ชั้นที่4");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(183);
$txt = $pdf->conv("ชั้นที่5");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(197);
$txt = $pdf->conv("ชั้นที่6");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(211);
$txt = $pdf->conv("รวมนอกเขตชุมชน");
$pdf->Cell(14,5,$txt,'1',0,'C',true);

$pdf->SetY(45); 
$pdf->SetX(225);
$txt = $pdf->conv("รวมทะเบียน");
$pdf->Cell(65,5,$txt,'1',0,'C',true);



$pdf->SetY(50); 
$pdf->SetX(29);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(36);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(43);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(50);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(57);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(64);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(71);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(78);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(85);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(92);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(99);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(106);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(113);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(120);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(127);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(134);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(141);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(148);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(155);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(162);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(169);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(176);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(183);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(190);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(197);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(204);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(211);
$txt = $pdf->conv("จำนวน");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(218);
$txt = $pdf->conv("ระยะทาง");
$pdf->Cell(7,5,$txt,'LTR',0,'C',true);

$pdf->SetY(50); 
$pdf->SetX(225);
$txt = $pdf->conv("จำนวนสายทาง");
$pdf->Cell(32,10,$txt,'1',0,'C',true);



$pdf->SetY(50); 
$pdf->SetX(257);
$txt = $pdf->conv("ระยะทาง (กม.)");
$pdf->Cell(33,10,$txt,'1',0,'C',true);




$pdf->SetY(55); 
$pdf->SetX(29);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(36);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(43);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(50);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(57);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(64);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(71);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(78);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(85);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(92);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(99);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(106);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(113);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(120);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(127);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(134);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(141);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(148);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(155);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(162);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(169);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(176);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(183);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(190);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(197);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(204);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(211);
$txt = $pdf->conv("สายทาง");
$pdf->Cell(7,5,$txt,'LBR',0,'C',true);

$pdf->SetY(55); 
$pdf->SetX(218);
$txt = $pdf->conv("(กม.)");
$pdf->Cell(7,5,$txt,'LBR',1,'C',true);


   }
   }


    if($i>0){
	 // $sum_perClass=($sum_sumClassT3*100)/$sum_amount_wayS;
	 $pdf->SetFillColor(239,253,255);
	$pdf->SetFont('AngsanaNew', 'B', 7);


$txt = $pdf->conv("รวม");
$pdf->Cell(24,10,$txt,1,0,'C',true);


	
if($sum_c0!=""){

$sum_c0 = number_format($sum_c0,0,'.',','); 
}else{
$sum_c0 = "-";
}
$txt = $pdf->conv("$sum_c0");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p0!=""){
$sum_p0 = number_format($sum_p0,3,'.',','); 
}else{
$sum_p0 = "-";
}
$txt = $pdf->conv("$sum_p0");
$pdf->Cell(7,10,$txt,1,0,'C',true);
		
if($sum_c1!=""){

$sum_c1 = number_format($sum_c1,0,'.',','); 
}else{
$sum_c1 = "-";
}
$txt = $pdf->conv("$sum_c1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p1!=""){

$sum_p1 = number_format($sum_p1,3,'.',','); 
}else{
$sum_p1 = "-";
}
$txt = $pdf->conv("$sum_p1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_c2!=""){

$sum_c2 = number_format($sum_c2,0,'.',','); 
}else{
$sum_c2 = "-";
}
$txt = $pdf->conv("$sum_c2");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p2!=""){

$sum_p2 = number_format($sum_p2,3,'.',','); 
}else{
$sum_p2 = "-";
}
$txt = $pdf->conv("$sum_p2");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_c3!=""){

$sum_c3 = number_format($sum_c3,0,'.',','); 
}else{
$sum_c3 = "-";
}
$txt = $pdf->conv("$sum_c3");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p3!=""){

$sum_p3 = number_format($sum_p3,3,'.',','); 
}else{
$sum_p3 = "-";
}
$txt = $pdf->conv("$sum_p3");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_c4!=""){

$sum_c4 = number_format($sum_c4,0,'.',','); 
}else{
$sum_c4 = "-";
}
$txt = $pdf->conv("$sum_c4");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p4!=""){

$sum_p4 = number_format($sum_p4,3,'.',','); 
}else{
$sum_p4 = "-";
}
$txt = $pdf->conv("$sum_p4");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_sumClassT1!=""){

$sum_sumClassT1 = number_format($sum_sumClassT1,0,'.',','); 
}else{
$sum_sumClassT1 = "-";
}
$txt = $pdf->conv("$sum_sumClassT1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_sumNumT1!=""){

$sum_sumNumT1 = number_format($sum_sumNumT1,3,'.',','); 
}else{
$sum_sumNumT1 = "-";
}
$txt = $pdf->conv("$sum_sumNumT1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_c0_1!=""){

$sum_c0_1 = number_format($sum_c0_1,0,'.',','); 
}else{
$sum_c0_1 = "-";
}
$txt = $pdf->conv("$sum_c0_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p0_1!=""){

$sum_p0_1 = number_format($sum_p0_1,3,'.',','); 
}else{
$sum_p0_1 = "-";
}
$txt = $pdf->conv("$sum_p0_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_c1_1!=""){

$sum_c1_1 = number_format($sum_c1_1,0,'.',','); 
}else{
$sum_c1_1 = "-";
}
$txt = $pdf->conv("$sum_c1_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p1_1!=""){

$sum_p1_1 = number_format($sum_p1_1,3,'.',','); 
}else{
$sum_p1_1 = "-";
}
$txt = $pdf->conv("$sum_p1_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);


if($sum_c2_1!=""){

$sum_c2_1 = number_format($sum_c2_1,0,'.',','); 
}else{
$sum_c2_1 = "-";
}
$txt = $pdf->conv("$sum_c2_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p2_1!=""){

$sum_p2_1 = number_format($sum_p2_1,3,'.',','); 
}else{
$sum_p2_1 = "-";
}
$txt = $pdf->conv("$sum_p2_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);


if($sum_c3_1!=""){

$sum_c3_1 = number_format($sum_c3_1,0,'.',','); 
}else{
$sum_c3_1 = "-";
}
$txt = $pdf->conv("$sum_c3_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p3_1!=""){

$sum_p3_1 = number_format($sum_p3_1,3,'.',','); 
}else{
$sum_p3_1 = "-";
}
$txt = $pdf->conv("$sum_p3_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);


if($sum_c4_1!=""){

$sum_c4_1 = number_format($sum_c4_1,0,'.',','); 
}else{
$sum_c4_1 = "-";
}
$txt = $pdf->conv("$sum_c4_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p4_1!=""){

$sum_p4_1 = number_format($sum_p4_1,3,'.',','); 
}else{
$sum_p4_1 = "-";
}
$txt = $pdf->conv("$sum_p4_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);


if($sum_c5_1!=""){

$sum_c5_1 = number_format($sum_c5_1,0,'.',','); 
}else{
$sum_c5_1 = "-";
}
$txt = $pdf->conv("$sum_c5_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p5_1!=""){

$sum_p5_1 = number_format($sum_p5_1,3,'.',','); 
}else{
$sum_p5_1 = "-";
}
$txt = $pdf->conv("$sum_p5_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);


if($sum_c6_1!=""){

$sum_c6_1 = number_format($sum_c6_1,0,'.',','); 
}else{
$sum_c6_1 = "-";
}
$txt = $pdf->conv("$sum_c6_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_p6_1!=""){

$sum_p6_1 = number_format($sum_p6_1,3,'.',','); 
}else{
$sum_p6_1 = "-";
}
$txt = $pdf->conv("$sum_p6_1");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_sumClassT2!=""){

$sum_sumClassT2 = number_format($sum_sumClassT2,0,'.',','); 
}else{
$sum_sumClassT2 = "-";
}
$txt = $pdf->conv("$sum_sumClassT2");
$pdf->Cell(7,10,$txt,1,0,'C',true);

if($sum_sumNumT2!=""){

$sum_sumNumT2 = number_format($sum_sumNumT2,3,'.',','); 
}else{
$sum_sumNumT2 = "-";
}
$txt = $pdf->conv("$sum_sumNumT2");
$pdf->Cell(7,10,$txt,1,0,'C',true);



if($sum_sumClassT3!=""){

$sum_sumClassT3 = number_format($sum_sumClassT3,0,'.',','); 
}else{
$sum_sumClassT3 = "-";
}
$txt = $pdf->conv("$sum_sumClassT3");
$pdf->Cell(32,10,$txt,1,0,'C',true);

if($sum_sumNumT3!=""){

$sum_sumNumT3 = number_format($sum_sumNumT3,3,'.',','); 
}else{
$sum_sumNumT3 = "-";
}
$txt = $pdf->conv("$sum_sumNumT3");
$pdf->Cell(33,10,$txt,1,1,'C',true);

}





$pdf->Output();
//}
 
	?>

	






