<?php
/**
 * @author: chenxi
 * @date: 2015-08-25
 * @version: $Id$
 */

/**
 * 计算字符串长度（中英文）
 * @author chenxi
 * @param null $string
 * @return int
 */
function utf8_strlen($string = null)
{
    preg_match_all("/./us", $string, $match);
    return count($match[0]);
}


/**
 * 将字符串截取成固定长度
 * @author chenxi
 * @param string $str
 * @param int $len
 * @return string
 */
function cut_str($str = '', $len = 10)
{
    if(utf8_strlen($str) < $len){
        return $str;
    }
    return mb_substr($str, 0, $len, 'utf-8');
}