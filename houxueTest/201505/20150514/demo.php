<?php
/**
 * @author:  chenxi
 * @date:    2015-05-14
 * @version: $Id$
 */
function mSort($a)
{
    $len = count($a);
    for ($i = 0; $i < $len - 1; $i++) {
        for ($j = $i; $j < $len; $j++) {
            if ($a[$i] > $a[$j]) {
                $tmp = $a[$i];
                $a[$i] = $a[$j];
                $a[$j] = $tmp;
            }
        }
    }
    return $a;
}

$a = array('1'=>11, '2'=>33, 55, 77, 99, 88, 66, 44, 22);

print_r(mSort($a));


/**
 * 冒泡排序
 * @param array $arr
 * @return array
 */
function bubble(array $arr)
{
    $len = count($arr);
    for ($i = 0; $i < $len - 1; $i++) {
        for ($j = $i + 1; $j < $len; $j++) {
            if ($arr[$i] > $arr[$j]) {
                $tmp = $arr[$i];
                $arr[$i] = $arr[$j];
                $arr[$j] = $tmp;
            }
        }
    }
    return $arr;
}

var_dump(bubble($a));

/*
 * array_merge()
 * 把两个或多个数组合并为一个数组
 * 如果键名有重复，该键的键值为最后一个键名对应的值（后面的覆盖前面的）。如果数组是数字索引的，则键名会以连续方式重新索引
 * */

function array_marge_2($arr_1, $arr_2){
    $ret = array();
    foreach($arr_1 as $val){
        $ret[] = $val;
    }
    foreach($arr_2 as $val){
        $ret[] = $val;
    }
    return $ret;
}


$a1 = array('id'=>1, 'name'=>'chenxi', 'sex'=>'nan');
$a2 = array('id'=>2, 'name'=>'chenxi2', 'sex'=>'nan2');
$a3 = array(1, 'chenxi', 'nan');
$a4 = array(2, 'chenxi2', 'nan2');
var_dump(array_merge($a1, $a2));
var_dump(array_merge($a3, $a4));
echo '---------------------';
var_dump(array_marge_2($a1, $a2));


/*
 * 测试empty()，isset() 及 is_null()
 * */

$ta;
$tb = false;
$tc = '';
$td = 0;
$te = null;
$tf = array();

var_dump(empty($ta)); //boolean true
var_dump(empty($tb)); //boolean true
var_dump(empty($tc)); //boolean true
var_dump(empty($td)); //boolean true
var_dump(empty($te)); //boolean true
var_dump(empty($tf)); //boolean true
echo '---------------------';
var_dump(isset($ta)); //boolean false
var_dump(isset($tb)); //boolean true
var_dump(isset($tc)); //boolean true
var_dump(isset($td)); //boolean true
var_dump(isset($te)); //boolean false
var_dump(isset($tf)); //boolean true
echo '---------------------';
var_dump(is_null($ta)); //boolean true
var_dump(is_null($tb)); //boolean false
var_dump(is_null($tc)); //boolean false
var_dump(is_null($td)); //boolean false
var_dump(is_null($te)); //boolean true
var_dump(is_null($tf)); //boolean false