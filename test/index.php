<?php
/**
 * @author: chenxi
 * @date: 2015-08-21
 * @version: $Id$
 */
require "A.php";
require "B.php";
require "C.php";

use a\b\c\Apple;
use d\e\f\Apple as BApple;

$a_app = new Apple();
$b_app = new BApple();
$c_app = new \Apple();

$a_app->get_info();
$b_app->get_info();
$c_app->get_info();