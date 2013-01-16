<?
function CalSplitPage($numrowslist, $offset, $limit){
	if($numrowslist != 0){
		// Set $begin and $end to record range of the current page 
		$begin =($offset+1); 
		$end = ($begin+($limit-1)); 
		if ($end > $numrowslist) { 
			$end = $numrowslist; 
		} 
		$include_limit .= "   LIMIT $offset, $limit";
	} 
	return $include_limit;
}
function CalShowPage($numrowslist, $offset, $startoffset, $limit, $variables, $page_show='15'){
	if ($offset !=1) {   
		 $prevoffset=$offset; 
		if($offset==0){ $startoffsetprev=$startoffset-$page_show; }
		else  if(($offset%$startoffset) == '1') {				
		$startoffsetprev=(floor($offset/15)-1)*15;
		}else{
			$startoffsetprev=$startoffset;
		}
			$show.= "<a href='".$HTTP_SERVER_VARS['PHP_SELF']."?offset=1".$variables."' title='Go to first page' style='text-decoration:none;'>|<</a>&nbsp;";
			$show.= "<a href='".$HTTP_SERVER_VARS['PHP_SELF']."?offset=".($offset-1).$variables."&startoffset=".$startoffsetprev."' title='Previous' style='text-decoration:none;'><</a>";
        }
		$pages = intval($numrowslist/$limit); // Calculate total number of pages in result 
		if ($numrowslist%$limit) { // $pages now contains total number of pages needed unless there is a remainder from division  
			 $pages++;// has remainder so add one page  
		}  
		for ($i=1;$i<=$page_show;$i++) {// Now loop through the pages to create numbered links // ex. 1 2 3 4 5 NEXT 
			if($startoffset<>'') { $show_no=$startoffset+$i; }  else { $show_no=$i; $startoffset=0; }
			if ( ($offset) ==  ($show_no) ) { 		// Check if on current page 
				$show.= " <font color=\"red\"><u>".$show_no."</u></font> "; // $i is equal to current page, so don't display a link 
			}else{ 
				
				$newoffset= ($show_no); 	// $i is NOT the current page, so display a link to page $i  
				$show.=  " <a href='".$HTTP_SERVER_VARS['PHP_SELF']."?offset=".$newoffset.$variables."&startoffset=".$startoffset."' style='text-decoration:none;'>";
				$show.=  "$show_no";
				$show.=  "</a> ";
			} 
			if($show_no>=$pages) break;		
		} 
		
		if (!((($offset))==$pages) && $pages!=1) { // Check to see if current page is last page 
			$newoffset=$offset; // Not on the last page yet, so display a NEXT Link 
			if(($offset)%$page_show==0){ $startoffset=$startoffset+$page_show; }
			$show.= "<a href='".$HTTP_SERVER_VARS['PHP_SELF']."?offset=".($offset+1).$variables."&startoffset=".$startoffset."' title='Next'  style='text-decoration:none;'>></a>";
			$mod1 = $numrowslist%$limit;
			if($mod1==0){
				$pagelast = $numrowslist/$limit;
			}else {
				$pagelast=floor($numrowslist/$limit)+1;
			}	
			$val_page_last=$pagelast/$limit+1;
			$mod_page_last=$val_page_last%$page_show;
			if($mod_page_last==0){ 
				$startoffset=$val_page_last-$page_show; 
				if($startoffset<0) $startoffset=0;
			} else{ 
				//$startoffset=$pages-$mod_page_last;
				$startoffset=floor($pagelast/15)*15;
				if($startoffset<0) $startoffset=0;
			 }	
			$show.= "&nbsp;<a href='".$HTTP_SERVER_VARS['PHP_SELF']."?offset=".$pagelast.$variables."&startoffset=".$startoffset."' title='Go To Last Page'  style='text-decoration:none;'>>|</a>";
		}
		if($numrowslist==0){
			$show='';
		}
		return $show;
}
?>