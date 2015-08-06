<?php

/**
 * @author: chenxi
 * @date: 2015-08-06
 * @version: $Id$
 */
abstract class Abstract_Test
{
    protected $_name;
    abstract public function getName();
    abstract public function getType($id);
}
