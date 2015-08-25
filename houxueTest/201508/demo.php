<?php
	header("content-type:text/html;charset=utf-8");
	var_dump(
    preg_match(
    '^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)?((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.[a-zA-Z]{2,4})(\:[0-9]+)?(/[^/][a-zA-Z0-9\.\,\?\'\\/\+&amp;%\$#\=~_\-@]*)*$', 
		'www.houxue.com', 
		$matches));
	var_dump($matches);


    function uhtml($str)     
    {     
        $farr = array(     
            "/\s+/", //过滤多余空白     
             //过滤 <script>等可能引入恶意内容或恶意改变显示布局的代码,如果不需要插入flash等,还可以加入<object>的过滤     
            "/<(\/?)(script|i?frame|style|html|body|title|link|meta|\?|\%)([^>]*?)>/isU",    
            "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",//过滤javascript的on事件     
       );     
       $tarr = array(     
            " ",     
            "＜\1\2\3＞",//如果要直接清除不安全的标签，这里可以留空     
            "\1\2",     
       );     
      $str = preg_replace( $farr,$tarr,$str);     
       return $str;     
    }  
    var_dump(uhtml('<html><script>alert(123)</script><body></body></html>'));

    function filterJsAndHtml($str)
    {
        $find = '#<script(.*)</script>#isU';
        $replace = '';
        $str = preg_replace($find, $replace, $str);
        $str = strip_tags($str);
        return $str;
    }

    var_dump(filterJsAndHtml('http://www.houxue.com'));
    var_dump(filterJsAndHtml('chenxi@houxue.com'));
?>