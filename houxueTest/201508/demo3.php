<?php
	function utf8_strlen($string = null)
	{
	    preg_match_all("/./us", $string, $match);
	    return count($match[0]);
	}

	var_dump(utf8_strlen('中国rejkh'));//7
	var_dump(utf8_strlen('jshsdasdasa'));//11
?>