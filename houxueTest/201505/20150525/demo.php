<?php
/**
 * @author:  chenxi
 * @date:    2015-05-25
 * @version: $Id$
 */

$pattern = "/^cat/";
$subject = "cat";

$pattern = "03[-./]19[-./]76";
$subject = "03.19.76";
preg_match($pattern, $subject, $matchs);
print_r($matchs);