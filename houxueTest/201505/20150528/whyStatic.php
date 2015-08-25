<?php
/**
 * @author:  chenxi
 * @date:    2015-05-28
 * @version: $Id$
 */

class whyStatic 
{
    public function demo()
    {
        $time_start = time();
        $x = 1;
        for($i = 0; $i < 100000; $i++){
            $x++;
        }
        $delTime = time() - $time_start;
        echo $delTime;
    }

    public static function demos()
    {
        $time_start = time();
        $x = 1;
        for($i = 0; $i < 100000; $i++){
            $x++;
        }
        $delTime = time() - $time_start;
        echo $delTime;
    }
}

$whyStatic = new whyStatic();

$whyStatic->demo();
echo '<br />';
$whyStatic::demos();

