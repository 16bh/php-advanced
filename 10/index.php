<?php
/**
 * @author: chenxi
 * @date: 2015-08-17
 * @version: $Id$
 */
$url = "http://localhost/php-advanced/10/service.php";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_FAILONERROR, 1);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($curl, CURLOPT_TIMEOUT, 5);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, 'name=foo&pass=bar&format=csv');
$curl_info = curl_getinfo($curl);
$r = curl_exec($curl);
curl_close($curl);
var_dump($r);
var_dump($curl_info);