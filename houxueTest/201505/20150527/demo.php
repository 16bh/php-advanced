<?php
/**
 * @author:  chenxi
 * @date:    2015-05-27
 * @version: $Id$
 */
var_dump(md5('240610708'));
var_dump(md5('QNKCDZO'));
var_dump(md5('240610708') == md5('QNKCDZO'));
echo '-------------------------------------<br />';
var_dump(md5('aabg7XSs'));
var_dump(md5('aabC9RqS'));
var_dump(md5('aabg7XSs') == md5('aabC9RqS'));
echo '-------------------------------------<br />';
var_dump(sha1('aaroZmOk'));
var_dump(sha1('aaK1STfY'));
var_dump(sha1('aaroZmOk') == sha1('aaK1STfY'));
echo '-------------------------------------<br />';
var_dump(sha1('aaO8zKZF'));
var_dump(sha1('aa3OFF9m'));
var_dump(sha1('aaO8zKZF') === sha1('aa3OFF9m'));
echo '-------------------------------------<br />';
var_dump('0010e2');
var_dump('1e3');
var_dump('0010e2' === '1e3');
echo '-------------------------------------<br />';
var_dump('0x1234Ab');
var_dump('1193131');
var_dump('0x1234Ab' === '1193131');
echo '-------------------------------------<br />';
var_dump('0xABCdef');
var_dump(' 0xABCdef');
var_dump('0xABCdef' === ' 0xABCdef');
echo '-------------------------------------<br />';
var_dump(0);
var_dump('abcdefg');
var_dump(0 === 'abcdefg');
echo '-------------------------------------<br />';
var_dump(1);
var_dump('1abcdef');
var_dump(1 === '1abcdef');
echo '-------------------------------------<br />';
echo password_hash('chenxi', PASSWORD_DEFAULT);
$salt='g7h&t4$jk;02';
echo '<br />';
echo md5('chenxi'.$salt);

echo '-------------------------------------<br />';

$email = '1003681345@qq.com';
var_dump(filter_var($email, FILTER_VALIDATE_EMAIL));
var_dump(checkdnsrr($email, 'MX'));