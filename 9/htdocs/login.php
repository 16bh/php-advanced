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

$email = $form->addElement('text', 'email');
$email->setLabel('Email Address');
$email->addFilter('trim');
$email->addRule('required', 'Please enter your email adress.');
$email->addRule('email', 'Please enter your email address.');

$password = $form->addElement('password', 'pass');
$password->setLabel('Password');
$password->addFilter('trim');
$password->addRule('required', 'Please enter your password.');

$form->addElement('submit', 'submit', array('value'=>'Login'));

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($form->validate()){
        $q = 'SELECT id, userType, username, email FROM users WHERE email=:email AND pass=SHA1(:pass)';
        $stmt = $pdo->prepare($q);
        $r = $stmt->execute(array(':email'=>$email->getValue(), ':pass'=>$password->getValue()));

        if($r){
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $user = $stmt->fetch();
        }

        if($user){
            $_SESSION['user'] = $user;
            header("Location:index.php");
            exit;
        }
    }
}

$pageTitle = 'Login';
include('includes/header.inc.php');
include('views/login.html');
include('includes/footer.inc.php');