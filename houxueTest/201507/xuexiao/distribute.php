<?php
//------------------------------
//文件功能: 1.  根据请求路径，引入正确的php文件
//主要逻辑: 1.
//主要参数: 1.
//编制时间:
//编制人:
//修正时间:
//修正人:
//修正内容:
//------------------------------
?>
<?php
include_once("../config.inc.php");

$time_start = microtime(true);
$arr = explode(".", $_SERVER["HTTP_HOST"]);
$domain = $arr[0];

$_SERVER["REQUEST_URI"] = str_replace("/xuexiao/", "", $_SERVER["REQUEST_URI"]);

$phpfile = $_SERVER["REQUEST_URI"];

//判断文件：左侧导航栏
$rtn1 = preg_match('/^([a-z]*)[-]?(\d*)\.htm$/', $_SERVER["REQUEST_URI"], $matchs);

if($rtn1 == 1)
{
	switch($matchs[1])
	{
		case "list":
			// "list-0.htm" 格式，打开分类画面的学校列表界面
			$phpfile = HOUXUE_ROOT."/category/school.php";
			$_REQUEST["pager_rownum"] = $matchs[2]+0;
			break;
		default:
			break;
	}
}

//分类画面的学校搜索页
if(preg_match('/^list\.php([\?&].*)?$/', $_SERVER["REQUEST_URI"], $matchs))
{
	$phpfile = HOUXUE_ROOT."/category/school.php";
}


////www学校的独立展示画面
//$rtn1 = preg_match('/^(\d*)\/([a-z]*)\/(.*)\.htm$/', $_SERVER["REQUEST_URI"], $matchs);
//if($rtn1 == 1)
//{
//	$loginid = $matchs[1];
//
//	switch($matchs[2])
//	{
//		case "youhuiquan":
//			break;
//		default:
//			break;
//	}
//}


// 访问  其它php文件，直接调用
switch($phpfile)
{
	case "":
		include_once(dirname(__FILE__)."/index.php");
		break;
	default:
		$phpfile = substr($phpfile, 0, strpos($phpfile, ".php")).".php";
		if(file_exists($phpfile)) include_once($phpfile);
}
$time_end = microtime(true);
$time = $time_end - $time_start;
//if($_SESSION["Admin"]["id"] == "8")echo "页面执行时间:".$time." 秒 t1=$t1 t2=$t2 t3=$t3";
?>