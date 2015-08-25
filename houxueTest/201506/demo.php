<?php
	var_dump(getcwd());
	var_dump(realpath('./test.txt'));
	echo PHP_SAPI;
	echo dirname(__FILE__);
	echo dirname(dirname(__FILE__));
?>

