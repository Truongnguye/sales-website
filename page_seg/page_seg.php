<?php
function segment($array,$max_item_in_page)
{
	$pagecount = (int)(count($array) / $max_item_in_page) + ((count($array) % $max_item_in_page)? 1:0);
	echo "$pagecount";
	$array_of_page = array();
	for ( $i=0; $i< $pagecount; $i++) {
		if ($pagecount - 1 == $i){
			array_push($array_of_page,$array);
		} else {
			$item = array_slice($array,0,$max_item_in_page);
			$array = array_slice($array,$max_item_in_page);
			array_push($array_of_page,$item);
		}
	}
	return $array_of_page;
}
?>