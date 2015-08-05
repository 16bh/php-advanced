<?php
/**
 * @author: chenxi
 * @date: 2015-08-05
 * @version: $Id$
 */
require('includes/utilities.inc.php');
set_include_path('D:/wamp/bin/php/php5.5.12/pear/');
require('HTML/QuickForm2.php');

$form = new HTML_QuickForm2('loginForm');

$pageTitle = 'Login';
include('includes/header.inc.php');
include('views/login.html');
include('includes/footer.inc.php');