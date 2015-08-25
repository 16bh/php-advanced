<?php
/**
 * @author:  chenxi
 * @date:    2015-06-11
 * @version: $Id$
 */
/*
 * addcslashes 以 C 语言风格使用反斜线转义字符串中的字符
 *
 * string addcslashes ( string $str , string $charlist )
 * 返回字符串，该字符串在属于参数 charlist 列表中的字符前都加上了反斜线。
 */
echo addcslashes('foo[]', 'A-z').'<br />';

/*
 * rtrim — 删除字符串末端的空白字符（或者其他字符）
 *
 * string rtrim ( string $str [, string $character_mask ] )
 * 该函数删除 str 末端的空白字符并返回。
 */

/*
 * implode|join
 */
$arr = array(1,2,3,4,5,6,7,8,9);
var_dump(implode(',', $arr));

/*
 * explode
 */
$str = '1:2:3:4:5:6:7:8:9:0';
var_dump(explode(':', $str));

/*
 * print-输出字符串
 *
 * int print ( string $arg )
 */
print 'hello world!';

print <<<END
<HTML>
<H1>TEST</H1>
</HTML>
END;

/*
 * printf — 输出格式化字符串
 *
 * int printf ( string $format [, mixed $args [, mixed $... ]] )
 * 依据 format 格式参数产生输出。
 */
$num = 2.123;
printf('%.1f', $num);
printf('%d', $num);

/*
 * sprintf — Return a formatted string
 *
 * string sprintf ( string $format [, mixed $args [, mixed $... ]] )
 * Returns a string produced according to the formatting string format.
 */
$num = 5;
$location = 'tree';

$format = '<br />There are %.1f monkeys in the %s<br />';
echo sprintf($format, $num, $location);