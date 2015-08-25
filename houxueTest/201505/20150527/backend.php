<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
flush();
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<script type="text/javascript">
document.domain = 'houxue.com';
  // KHTML browser don't share javascripts between iframes
  var is_khtml = navigator.appName.match("Konqueror") || navigator.appVersion.match("KHTML");
  if (is_khtml)
  {
    var prototypejs = document.createElement('script');
    prototypejs.setAttribute('type','text/javascript');
    prototypejs.setAttribute('src','http://cdn.houxue.com/libs/jquery/1.11/jquery.min.js');
    var head = document.getElementsByTagName('head');
    head[0].appendChild(prototypejs);
  }
  // load the comet object
  var comet = window.parent.comet;
</script>

<?php
//实时显示输出
ob_end_flush(); //关闭php缓存，或者在flush前ob_flush();
//echo str_repeat(" ", 1024); //ie下 需要先发送256个字节, firefox 1024, chrome 2048
set_time_limit(0);
while(1) {
  echo '<script type="text/javascript">';
  echo 'comet.printServerRev(\''.date('Y-m-d H:i:s').'\');';
  echo '</script>';
  flush(); // used to send the echoed data to the client
  sleep(1); // a little break to unload the server CPU
}
?>
</body>
</html>