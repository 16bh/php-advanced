<?php
/**
 * @author: chenxi
 * @date: 2015-08-06
 * @version: $Id$
 */
require('test1.php');

$obj1 = new GoodClass();
var_dump($obj1 instanceof GoodClass);
$obj1->sayhello();
$obj2 = new goodclass();
$obj2->sayHello();