<?php include "../include/config.inc.php";

function connectToDB() {
      global $DB;
 $link=pg_connect("host=".$DB['host']." port=5432 dbname=".$DB['dbName']." user=".$DB['user']." password=".$DB['pass']);

    return $link;
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
?>