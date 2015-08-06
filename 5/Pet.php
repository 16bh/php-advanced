<?php

/**
 * @author: chenxi
 * @date: 2015-08-06
 * @version: $Id$
 */
class Pet
{
    public $name;

    public function __construct($pet_name)
    {
        $this->name = $pet_name;
        self::sleep();
    }

    public function eat()
    {
        echo '<p>' . $this->name . ' is eating...</p>';
    }

    final public function sleep()
    {
        echo '<p>' . $this->name . ' is sleeping...</p>';
    }

    public function play()
    {
        echo '<p>' . $this->name . ' is playing...</p>';
    }
}

class Cat extends Pet
{
    function play(){
        Pet::play();
        parent::play();
        echo '<p>' . $this->name . ' is climbing...</p>';
    }
}

$cat = new Cat('cc');
$cat->play();