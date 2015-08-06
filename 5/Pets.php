<?php

/**
 * @author: chenxi
 * @date: 2015-08-06
 * @version: $Id$
 */
class Pets
{
    protected $name;
    private static $_count = 0;

    function __construct($pet_name)
    {
        $this->name = $pet_name;
        self::$_count++;
    }

    function __destruct()
    {
        self::$_count--;
    }

    public static function getCount()
    {
        return $this->name;
        return self::$_count;
    }
}

class Cat extends Pets{}
class Dog extends Pets{}
class Ferret extends Pets{}
class PygmyMarmoset extends Pets{}

$cat = new Cat('cc');
var_dump($cat->getCount());