<?php

/**
 * @author: chenxi
 * @date: 2015-08-06
 * @version: $Id$
 */
class GoodClass
{
    public $var1 = 123;
    public $var2 = 'string';
    public $var3 = array(1,2,3);

    public function sayHello($language='english')
    {
        switch($language){
            case 'chinese':
                echo '你好！';
                break;
            case 'english':
            default:
                echo 'Hello!';
                break;
        }
    }
}