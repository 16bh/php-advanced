<?php
    $arr = array();
    for ($i = 0; $i < 100000; $i++) {
         $arr[] = 1;
    }

    $time = time();

    $step = 4;
    $show = array();
    $count = count($arr);
    for ($i = 0; $i < $count; $i += $step) {
         $show[] = array_slice($arr, $i, $step);
    }
    echo time() - $time;
?>
