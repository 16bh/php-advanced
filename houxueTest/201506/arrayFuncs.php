<?php
/**
 * 数组函数
 *
 * @author:  chenxi
 * @date:    2015-06-03
 * @version: $Id$
 */

/*
 * array_change_key_case函数   返回字符串键名全为小写或大写的数组
 *
 * array array_change_key_case ( array $input [, int $case = CASE_LOWER ] )
 * array_change_key_case() 将 input 数组中的所有键名改为全小写或大写。改变是根据后一个选项 case 参数来进行的。本函数不改变数字索引。
 *
 * 参数：
 * input 需要操作的数组。
 * case 可以在这里用两个常量，CASE_UPPER 或 CASE_LOWER（默认值）。
 * 返回值：
 * 返回一个键全是小写或者全是大写的数组；如果输入值（input）不是一个数组，那么返回FALSE
 *
 * 注意：
 * 如果一个数组中的多个键名经过本函数后变成一样的话（例如 "keY" 和 "kEY"），最后一个值将覆盖其它的值。
 */
$input_array = ['First'=>1, 'SecOnd'=>2, 'second'=>3];
var_dump($input_array);
var_dump(array_change_key_case($input_array, CASE_UPPER));
var_dump(array_change_key_case($input_array, CASE_LOWER));

/*
 * array_chunk — 将一个数组分割成多个
 *
 * array array_chunk ( array $input , int $size [, bool $preserve_keys = false ] )
 * 将一个数组分割成多个数组，其中每个数组的单元数目由 size 决定。最后一个数组的单元数目可能会少于 size 个。
 *
 * 参数：
 * input 需要操作的数组
 * size 每个数组的单元数目
 * preserve_keys 设为 TRUE，可以使 PHP 保留输入数组中原来的键名。如果你指定了 FALSE，那每个结果数组将用从零开始的新数字索引。默认值是 FALSE。
 * 返回值
 * 得到的数组是一个多维数组中的单元，其索引从零开始，每一维包含了 size 个元素。
 */
$input_array = array('a', 'b', 'c', 'd', 'e', 'f', 'g');
var_dump(array_chunk($input_array, 2, false));
var_dump(array_chunk($input_array, 3, true));

/*
 * array_column — 返回数组中指定的一列
 *
 * array array_column ( array $input , mixed $column_key [, mixed $index_key ] )
 * array_column() 返回input数组中键值为column_key的列， 如果指定了可选参数index_key，那么input数组中的这一列的值将作为返回数组中对应值的键。
 *
 * 参数：
 * input 需要取出数组列的多维数组（或结果集）
 * column_key 需要返回值的列，它可以是索引数组的列索引，或者是关联数组的列的键。 也可以是NULL，此时将返回整个数组（配合index_key参数来重置数组键的时候，非常管用）
 * index_key 作为返回数组的索引/键的列，它可以是该列的整数索引，或者字符串键值。
 *
 */
$records = array(
    array(
        'id' => 2135,
        'first_name' => 'John',
        'last_name' => 'Doe',
    ),
    array(
        'id' => 3245,
        'first_name' => 'Sally',
        'last_name' => 'Smith',
    ),
    array(
        'id' => 5342,
        'first_name' => 'Jane',
        'last_name' => 'Jones',
    ),
    array(
        'id' => 5623,
        'first_name' => 'Peter',
        'last_name' => 'Doe',
    )
);

var_dump(array_column($records, 'first_name'));
var_dump(array_column($records, 'last_name', 'id'));

/*
 * array_combine — 创建一个数组，用一个数组的值作为其键名，另一个数组的值作为其值
 *
 * array array_combine ( array $keys , array $values )
 * 返回一个 array，用来自 keys 数组的值作为键名，来自 values 数组的值作为相应的值。
 *
 * 参数：
 * keys 将被作为新数组的键。非法的值将会被转换为字符串类型（string）。
 * values 将被作为数组的值。
 *
 * 返回值：
 * 返回合并的 array，如果两个数组的单元数不同则返回 FALSE。
 *
 */
$a = array('green', 'red', 'blue', 'yellow');
$b = array('orange', 'apple', 'banana','pink');
var_dump(array_combine($a, $b));

/*
 * array_count_values — 统计数组中所有的值出现的次数
 *
 * array array_count_values ( array $input )
 * array_count_values() 返回一个数组，该数组用 input 数组中的值作为键名，该值在 input 数组中出现的次数作为值。
 *
 * 参数：
 * input 统计这个数组的值
 *
 * 返回值：
 * 返回一个关联数组，用 input 数组中的值作为键名，该值在数组中出现的次数作为值。
 */
$array = array(1, "hello", 1, "world", "hello");
var_dump(array_count_values($array));

/*
 * array_diff_assoc — 带索引检查计算数组的差集
 *
 * array array_diff_assoc ( array $array1 , array $array2 [, array $... ] )
 * array_diff_assoc() 返回一个数组，该数组包括了所有在 array1 中但是不在任何其它参数数组中的值。注意和 array_diff() 不同的是键名也用于比较。
 */
$array1 = ["a" => "green", "b" => "brown", "c" => "blue", "red"];
$array2 = ["a" => "green", "yellow", "red"];
var_dump(array_diff_assoc($array1, $array2));

/*
 * array_diff_key — 使用键名比较计算数组的差集
 *
 * array array_diff_key ( array $array1 , array $array2 [, array $... ] )
 * 根据 array1 中的键名和 array2 进行比较，返回不同键名的项。 本函数和 array_diff() 相同只除了比较是根据键名而不是值来进行的。
 */
var_dump(array_diff_key($array1, $array2));

/*
 * array_diff_uassoc — 用用户提供的回调函数做索引检查来计算数组的差集
 *
 * array array_diff_uassoc ( array $array1 , array $array2 [, array $... ], callable $key_compare_func )
 *
 * 参数：
 * array1 待比较的数组
 * array2 和这个数组在进行比较
 * ... 更多的数组
 * key_compare_func 回调函数
 *
 */
function key_compare_func($a, $b)
{
    if ($a === $b) {
        return 0;
    }
    return ($a > $b)? 1:-1;
}
var_dump(array_diff_uassoc($array1, $array2, 'key_compare_func'));

/*
 * array_diff_ukey — 用回调函数对键名比较计算数组的差集
 *
 * array array_diff_ukey ( array $array1 , array $array2 [, array $ ... ], callable $key_compare_func )
 * array_diff_ukey() 返回一个数组，该数组包括了所有出现在 array1 中但是未出现在任何其它参数数组中的键名的值。注意关联关系保留不变。本函数和 array_diff() 相同只除了比较是根据键名而不是值来进行的。
 */


/*
 * array_diff — 计算数组的差集
 *
 * array array_diff ( array $array1 , array $array2 [, array $... ] )
 * 对比返回在 array1 中但是不在 array2 及任何其它参数数组中的值。
 *
 * 返回一个数组，该数组包括了所有在 array1 中但是不在任何其它参数数组中的值。注意键名保留不变。
 */
var_dump(array_diff($array1, $array2));

/*
 * array_fill_keys — 使用指定的键和值填充数组
 *
 * array array_fill_keys ( array $keys , mixed $value )
 * 使用 value 参数的值作为值，使用 keys 数组的值作为键来填充一个数组。
 *
 * 参数：
 * keys 使用该数组的值作为键。非法值将被转换为字符串。
 * value 填充使用的值
 *
 * 返回值：
 * 返回填充后的数组
 *
 * 注意 与array_combine()的区别
 */
$keys = ['a', 'b', 'c', 'd'];
$v1 = 'x';
$v2 = ['x', 'y', 'z'];
var_dump(array_fill_keys($keys, $v1));
var_dump(array_fill_keys($keys, $v2));

/*
 * array_fill — 用给定的值填充数组
 *
 * array array_fill ( int $start_index , int $num , mixed $value )
 * array_fill() 用 value 参数的值将一个数组填充 num 个条目，键名由 start_index 参数指定的开始。
 *
 */
var_dump(array_fill(5, 6, 'x'));
var_dump(array_fill(-9, 2, 'y'));
var_dump(array_fill(0, 10, 0));
var_dump(array_fill(0, 10, [1,2,3]));

/*
 * array_filter — 用回调函数过滤数组中的单元
 *
 * array array_filter ( array $input [, callable $callback = "" ] )
 * 依次将 input 数组中的每个值传递到 callback 函数。如果 callback 函数返回 TRUE，则 input 数组的当前值会被包含在返回的结果数组中。数组的键名保留不变。
 *
 * 参数：
 * input 要循环的数组
 * callback 使用的回调函数 如果没有提供 callback 函数，将删除 input 中所有等值为 FALSE 的条目。
 *
 * 返回值：
 * 返回过滤后的数组
 *
 *
 */
function odd($var){
    return ($var & 1);
}
function even($var){
    return (!($var & 1));
}
var_dump(array_filter(['a'=>1, 'b'=>2, 'c'=>3, 'd'=>4, 'e'=>5], 'odd'));
var_dump(array_filter(['a'=>1, 'b'=>2, 'c'=>3, 'd'=>4, 'e'=>5], 'even'));

/*
 * array_flip — 交换数组中的键和值
 *
 * array array_flip ( array $trans )
 * array_flip() 返回一个反转后的 array，例如 trans 中的键名变成了值，而 trans 中的值成了键名。
 *
 * 注意 trans 中的值需要能够作为合法的键名，例如需要是 integer 或者 string。如果值的类型不对将发出一个警告，并且有问题的键／值对将不会反转。
 * 如果同一个值出现了多次，则最后一个键名将作为它的值，所有其它的都丢失了。
 *
 * 参数：
 * trans 要交换键值的数组
 *
 * 返回值：
 * 成功时返回交换后的数组，如果失败返回 NULL。
 */
var_dump(array_flip(['a'=>1, 'b'=>2, 'c'=>3, 'd'=>4, 'e'=>5]));
var_dump(array_flip(['a'=>1, 'b'=>1, 'c'=>3, 'd'=>3, 'e'=>5]));

/*
 * array_intersect — 计算数组的交集
 *
 * array array_intersect ( array $array1 , array $array2 [, array $ ... ] )
 * array_intersect() 返回一个数组，该数组包含了所有在 array1 中也同时出现在所有其它参数数组中的值。注意键名保留不变。
 *
 * 返回值：
 * 返回一个数组，该数组包含了所有在 array1 中也同时出现在所有其它参数数组中的值。
 */
$array1 = array("a" => "green", "red", "blue");
$array2 = array("b" => "green", "yellow", "red");
var_dump(array_intersect($array1, $array2));

/*
 * array_key_exists — 检查给定的键名或索引是否存在于数组中
 *
 * bool array_key_exists ( mixed $key , array $search )
 * array_key_exists() 在给定的 key 存在于数组中时返回 TRUE。key 可以是任何能作为数组索引的值。array_key_exists() 也可用于对象。
 *
 * 参数：
 * key 要检查的键
 * search 一个数组，包含待检查的键
 *
 * 返回值：
 * 成功时返回TRUE, 失败时返回FALSE
 */
$search = ['first'=>1, 'second'=>'2'];
var_dump(array_key_exists('first', $search));
var_dump(array_key_exists('third', $search));

/*
 * array_keys — 返回数组中部分的或所有的键名
 *
 * array array_keys ( array $array [, mixed $search_value [, bool $strict = false ]] )
 * array_keys() 返回 input 数组中的数字或者字符串的键名。
 * 如果指定了可选参数 search_value，则只返回该值的键名。否则 input 数组中的所有键名都会被返回。
 *
 * 参数：
 * input 一个数组，包含了要返回的键。
 * search_value 如果指定了这个参数，只有包含这些值的键才会返回。
 * strict 判断在搜索的时候是否该使用严格的比较（===）。
 *
 * 返回值：
 * 返回input里的所有键
 */
$input = ['first'=>'a', 2=>'b', 'third'=>'3', 4.0];
var_dump(array_keys($input));
var_dump(array_keys($input, 3, true));
var_dump(array_keys($input, 3, false));

/*
 * array_map — 将回调函数作用到给定数组的单元上
 *
 * array array_map ( callable $callback , array $arr1 [, array $... ] )
 * array_map() 返回一个数组，该数组包含了 arr1 中的所有单元经过 callback 作用过之后的单元。callback 接受的参数数目应该和传递给 array_map() 函数的数组数目一致。
 *
 */
function cube($n){
    return ($n * $n * $n);
}
var_dump(array_map('cube', [1,2,3,4,5]));
var_dump(array_map('cube', ['1','2',3,'4',5]));


/*
 * array_merge — 合并一个或多个数组
 *
 * array array_merge ( array $array1 [, array $... ] )
 * array_merge() 将一个或多个数组的单元合并起来，一个数组中的值附加在前一个数组的后面。返回作为结果的数组。
 * 如果输入的数组中有相同的字符串键名，则该键名后面的值将覆盖前一个值。然而，如果数组包含数字键名，后面的值将不会覆盖原来的值，而是附加到后面。
 * 如果只给了一个数组并且该数组是数字索引的，则键名会以连续方式重新索引。
 */
var_dump(array_merge([1,2,3,4,5], [4,5,6,7,8,9]));
var_dump(array_merge(['first'=>1, 'second'=>2, 'third'=>3, 4=>4], ['third'=>4, 4=>5]));
var_dump(['first'=>1, 'second'=>2, 'third'=>3, 4=>4] + ['third'=>4, 4=>5]);

/*
 * array_pad — 用值将数组填补到指定长度
 *
 * array array_pad ( array $input , int $pad_size , mixed $pad_value )
 * array_pad() 返回 input 的一个拷贝，并用 pad_value 将其填补到 pad_size 指定的长度。如果 pad_size 为正，则填补到数组的右侧，如果为负则从左侧开始填补。如果 pad_size 的绝对值小于或等于 input 数组的长度则没有任何填补。有可能一次最多填补 1048576 个单元。
 *
 *
 * 参数：
 * input 需要被填充的原始数组
 * pad_size 新数组的长度
 * pad_value 将被填充的值 只有在input的现有长度小于pad_size的长度时才有效
 *
 * 返回值：
 * 返回 input 用 pad_value 填充到 pad_size 指定的长度之后的一个副本。 如果 pad_size 为正，则填补到数组的右侧，如果为负则从左侧开始填补。 如果 pad_size 的绝对值小于或等于 input 数组的长度则没有任何填补。
 */
$input = [1,2,3];
var_dump(array_pad($input, 7, 'x'));
var_dump(array_pad($input, -9, ['1', '2']));
var_dump(array_pad($input, 2, 'noout'));

/*
 * array_pop — 将数组最后一个单元弹出（出栈）
 *
 * mixed array_pop ( array &$array )
 * array_pop() 弹出并返回 array 数组的最后一个单元，并将数组 array 的长度减一。如果 array 为空（或者不是数组）将返回 NULL。 此外如果被调用不是一个数则会产生一个 Warning。
 * 注意：使用此函数后会重置（reset()）array 指针。
 *
 * 参数：
 * array 需要做出栈的数组
 * 返回值：
 * 返回 array 的最后一个值。如果 array 是空（如果不是一个数组），将会返回 NULL 。
 */
$stack = ['orange', 'banana', 'apple'];
var_dump(array_pop($stack));
var_dump($stack);

/*
 * array_push — 将一个或多个单元压入数组的末尾（入栈）
 *
 * int array_push ( array &$array , mixed $var [, mixed $... ] )
 * array_push() 将 array 当成一个栈，并将传入的变量压入 array 的末尾。array 的长度将根据入栈变量的数目增加。
 *
 */
var_dump(array_push($stack, 'pear', 'applex'));
var_dump($stack);

/*
 * array_product — 计算数组中所有值的乘积
 *
 * number array_product ( array $array )
 *
 */