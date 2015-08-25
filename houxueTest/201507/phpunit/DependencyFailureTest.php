<?php
/**
 * @author:  chenxi
 * @date:    2015-07-03
 * @version: $Id$
 */

class DependencyFailureTest extends  PHPUnit_Framework_TestCase
{
    public function testOne()
    {
        $this->assertTrue(true);
    }

    /**
     * @depends testOne
     */
    public function testTwo()
    {
        var_dump(123);
    }
}