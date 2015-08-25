<?php
/**
 * @author: chenxi
 * @date: 2015-08-18
 * @version: $Id$
 */
function insert_sort($arr)
{
    $len = count($arr);
    if ($len <= 0)
        return false;
    for ($i = 1; $i < $len; $i++) {
        $tmp = $arr[$i];
        //内层循环控制，比较并插入
        for ($j = $i - 1; $j >= 0; $j--) {
            if ($tmp < $arr[$j]) {
                //发现插入的元素要小，交换位置，将后边的元素与前面的元素互换
                $arr[$j + 1] = $arr[$j];
                $arr[$j] = $tmp;
            } else {
                //如果碰到不需要移动的元素，由于是已经排序好是数组，则前面的就不需要再次比较了。
                break;
            }
        }
    }
    return $arr;
}

function bubble_sort($arr)
{
    $len = count($arr);
    if ($len <= 0)
        return false;
    for ($i = 0; $i < $len; $i++) {
        for ($j = $len - 1; $j > $i; $j--) {
            if ($arr[$j] < $arr[$j - 1]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$j - 1];
                $arr[$j - 1] = $temp;
            }
        }
    }
    return $arr;
}
function bubble_sort2($arr)
{
    $len = count($arr);
    if ($len <= 0)
        return false;
    for ($i = 1; $i < $len; $i++) {
        for ($j = 0; $j < $len - $i; $j++) {
            if ($arr[$j] > $arr[$j + 1]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$j + 1];
                $arr[$j + 1] = $temp;
            }
        }
    }
    return $arr;
}

$arr = [38, 65, 97, 76, 13, 27, 49];

var_dump(bubble_sort2($arr));