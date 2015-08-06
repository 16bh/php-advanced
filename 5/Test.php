<?php

/**
 * @author: chenxi
 * @date: 2015-08-06
 * @version: $Id$
 */
class Test
{
    public $public = 'public';
    protected $protected = 'protected';
    private $_private = 'private';

    function printVar($var){
        echo "<p>in test, \$$var : {$this->$var}</p>";
    }
}

class LittleTest extends Test
{
    function printVar($var){
        echo "<p>in littletest, \$$var : {$this->$var}</p>";
    }
}

$parent = new Test();
$child = new LittleTest();

echo '<h1>Public</h1>';
echo '<h2>Initially...</h2>';
$parent->printVar('public');
$child->printVar('public');

echo '<h2>Modifying $parent->public...</h2>';
$parent->public = 'modified';
$parent->printVar('public');
$child->printVar('public');//public 属性在两个类里代表不同的实体

echo '<hr><h1>Protected</h1>';
echo '<h2>Initially...</h2>';
$parent->printVar('protected');
$child->printVar('protected');

echo '<h2>attempt to Modify $parent->protected...</h2>';
//$parent->protected = 'modified';
$parent->printVar('protected');
$child->printVar('protected');