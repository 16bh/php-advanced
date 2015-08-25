<?php
	function foo(){
		$numbers = func_num_args();
		echo "number of arguments : $numbers<br />\n";
		if($numbers >= 2){
			echo "Second arguments is :".func_get_arg(1)."<br />\n";
		}
		var_dump(func_get_args());
	}

	foo(1,2,3,4,5);

	function fn(){
		$var = "contents";
	}
	fn();
	echo $var;

	function fn1(){
		echo "inside the function, \$var = ".$var."<br />";
		$var = "content2";
		echo "inside the function, \$var = ".$var."<br />";
	}

	$var = "content1";
	fn1();
	echo "outside the function , \$var = ".$var."<br />";
?>