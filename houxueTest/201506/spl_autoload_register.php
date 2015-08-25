<?php
/**
 * @author:  chenxi
 * @date:    2015-06-15
 * @version: $Id$
 */

function my_autoload($class){
    include 'classes/'.$class.'.class.php';
}

spl_autoload_register('my_autoload');

spl_autoload_register(function($class){
    include 'class/'.$class.'.class.php';
});