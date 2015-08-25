<?php
/**
 * @author:  chenxi
 * @date:    2015-06-10
 * @version: $Id$
 */
$a = array();
for($i=0;$i<600000;$i++){
    $a[$i] = $i;
}

foreach($a as $i)
{
    array_key_exists($i, $a);
}