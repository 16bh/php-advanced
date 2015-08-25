<?php 
	$a = [
		['key1'=>940, 'key2'=>'blah'],
		['key1'=>23, 'key2'=>'this'],
		['key1'=>894, 'key2'=>'that'],
	];	

	var_dump($a);

	function asc_number_sort($x, $y){
		if($x['key1'] > $y['key1']){
			return true;
		}elseif ($x['key1'] < $y['key1']) {
			return false;
		}else{
			return 0;
		}
	}

	echo '<pre>';
	uasort($a, 'asc_number_sort');
	print_r($a);
	echo '</pre>';
?>