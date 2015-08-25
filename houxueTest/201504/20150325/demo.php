<?php
    setcookie('username', 'chenxi', time()+3600*24);
    echo $_COOKIE['username'].'<br />';
    echo $HTTP_COOKIE_VARS['username'].'<br />';
    var_dump($_COOKIE);
?>
