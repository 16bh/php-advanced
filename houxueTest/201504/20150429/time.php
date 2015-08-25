<?php
    header("Content-type:text/html;charset=utf-8");
    echo 'time函数返回的时间戳：'.time().'<p>';
    echo 'now:'.date('Y-m-d', time()).'<p>';
    $nextweek = time() + (7*24*60*60);
    echo 'now:'.date('Y-m-d', $nextweek).'<p>';

    echo 'DATE_ATOM='.date(DATE_ATOM);
    echo '<P>DATE_COOKIE='.date(DATE_COOKIE);
    echo '<P>DATE_ISO8601='.date(DATE_ISO8601);
    echo '<P>DATE_RFC822='.date(DATE_RFC822);
    echo '<P>DATE_RFC850='.date(DATE_RFC850);
    echo '<P>DATE_RSS='.date(DATE_RSS);
    echo '<P>DATE_W3C='.date(DATE_W3C);
    var_dump(getdate());
