<?php
/**
 * @author: chenxi
 * @date: 2015-08-05
 * @version: $Id$
 */

require('db_sessions.inc.php');
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>DB Session Test</title>
    </head>
    <body>
    <?php
        if(empty($_SESSION)){
            $_SESSION['blah'] = 'umlaut';
            $_SESSION['this'] = 3615684.45;
            $_SESSION['that'] = 'blue';

            echo '<p>session data stored.</p>';
        }else{
            echo '<p>session data exists:<pre>'.print_r($_SESSION, 1).'</pre></pre>';
        }

        if(isset($_GET['logout'])){
            session_destroy();
            echo '<p>session destroyed.</p>';
        }else{
            echo '<a href="sessions.php?logout=true">log out</a>';
        }

        echo '<p>session data:<pre>'.print_r($_SESSION, 1).'</pre></p>';
        echo '</body></html>';
        session_write_close();
    ?>