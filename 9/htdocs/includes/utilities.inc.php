<?php #utilities.inc.php

function class_loader($class){
    require('classes/'. $class . '.php');
}
spl_autoload_register('class_loader');

session_start();

$user = (isset($_SESSION['user'])) ? $_SESSION['user'] : null;

try{
    $pdo = new PDO('mysql:dbname=cms;host=localhost', 'root', '');
}catch(Exception $e){
    $pageTitle = 'Error!';
    include('includes/header.inc.php');
    include('views/error.html');
    include('include/footer.inc.php');
    exit();
}