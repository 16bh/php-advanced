<?php
	function __autoload($class_name){
		require_once $class_name.'.class.php';
		throw new Exception("unable to load".$class_name.".class.php");
	}
	try{
		$m1 = new Myclass1();
		$m2 = new Myclass2();
	}catch(Exception $e){
		echo $e->getMessage();
	}
?>