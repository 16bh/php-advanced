<?php
/**
 * @author:  chenxi
 * @date:    2015-07-06
 * @version: $Id$
 */

class DataTese2 extends PHPUnit_Framework_TestCase
{
    public function testA()
    {
        return 5;
    }

    /**
     * @dataProvider add_provider
     * @depends testA
     */
    public function testB($a, $b, $c)
    {
        $this->assertEquals($a, $b);
        return $a;
    }

    /**
     * @depends testB
     */
    public function testC($a)
    {
        var_dump($a);
    }

    public function testProducerFirst()
    {
        $this->assertTrue(true);
        return 'first';
    }

    public function testProducerSecond()
    {
        $this->assertTrue(true);
        return 'second';
    }


    /**
     * @depends testProducerFirst
     * @depends testProducerSecond
     */
    public function testConsumer()
    {
        $this->assertEquals(
            array('first', 'second'),
            func_get_args()
        );
    }

    public function add_provider()
    {
        return array(
            array(1,1),
            array(2,2),
            array(3,3)
        );
    }
}