<?php

/**
 * @author: chenxi
 * @date: 2015-08-06
 * @version: $Id$
 */
class Animal
{
    public $name;

    public function __construct($animal_name)
    {
        $this->name = $animal_name;
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

class Cat extends Animal
{
    public function climb()
    {
        echo '<p>' . $this->name . ' is climbing...</p>';
    }

    public function play()
    {
        echo '<p>' . $this->name . ' is climbing...</p>';
    }
}

class Dog extends Animal
{
    public function fetch()
    {
        echo '<p>' . $this->name . ' is fetching...</p>';
    }

    public function play()
    {
        echo '<p>' . $this->name . ' is fetching...</p>';
    }
}

$cat = new Cat('cc');
$cat->eat();
$cat->sleep();
$cat->climb();
$cat->play();

$dog = new Dog('dd');
$dog->eat();
$dog->sleep();
$dog->fetch();
$dog->play();

unset($cat, $dog);