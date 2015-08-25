<?php 
	$temp = array(
		'a'=>1,
		'b'=>2,
		'c'=>3,
		);

	$str = http_build_query($temp,'', '-');
	$str = str_replace('=', '', $str);
	var_dump($str);
	if(''){
		echo 123;
	}
?>