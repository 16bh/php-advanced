<?php
/**
 * @author: chenxi
 * @date: 2015-08-17
 * @version: $Id$
 */
function get10_1($x){
    if($x == 0 || $x == 1)
        return 1;
    else
        return $x * get10_1($x - 1);
}

var_dump(get10_1(5));