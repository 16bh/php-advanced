<?php

/**
 * @author: chenxi
 * @date: 2015-08-07
 * @version: $Id$
 */
class Triangle extends Shape
{
    private $_sides = array();
    private $_perimeter = NULL;
    public function __construct($s0 = 0, $s1 = 0, $s2 = 0)
    {
        $this->_sides[] = $s0;
        $this->_sides[] = $s1;
        $this->_sides[] = $s2;

        $this->_perimeter = array_sum($this->_sides);
    }

    public function getArea()
    {
        return sqrt(($this->_perimeter/2)*($this->_perimeter/2 - $this->_sides[0])*($this->_perimeter/2 - $this->_sides[1])*($this->_perimeter/2 - $this->_sides[2]));
    }

    public function getPerimeter()
    {
        return $this->_perimeter;
    }
}