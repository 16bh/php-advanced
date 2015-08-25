<?php
/**
 * @author:  chenxi
 * @date:    2015-07-03
 * @version: $Id$
 */
class myIterator implements Iterator
{
    private $position = 0;
    private $array = array(
        array(0,0,0),
        array(0,1,1),
        array(1,0,1),
        array(1,1,2),
    );

    function current()
    {
        return $this->array[$this->position];
    }

    function key()
    {
        return $this->position;
    }

    function next()
    {
        ++$this->position;
    }

    function valid()
    {
        return isset($this->array[$this->position]);
    }

    function rewind()
    {
        $this->position = 0;
    }
}


class DataTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider add_provider
     */
    public function testAdd($a, $b, $c)
    {
        $this->assertEquals($c, $a+$b);
    }

    public function add_provider()
    {
        return new myIterator();
//        return array(
//            array(0,0,0),
//            array(0,1,1),
//            array(1,0,1),
//            array(1,1,3),
//        );
    }
}