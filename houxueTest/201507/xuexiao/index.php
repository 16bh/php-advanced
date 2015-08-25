<?php
//分配文件
//********************************************* 分类二级域名 start ************************
$arr = explode(".", $_SERVER["HTTP_HOST"]);
$domain = $arr[0];
if($domain!='www' && $domain!='')
{
    global $cfg;
	require_once("../config.inc.php");
	include_once(HOUXUE_ROOT."/modules/category.class.php");
	$category = Category::getCategoryByDomain($domain);
	if($category["Id"])
	{
		$phpfile = HOUXUE_ROOT."/category/school.php";
		if(file_exists($phpfile))
			include_once($phpfile);
		else
			header("HTTP/1.0 404 Not Found");
		exit();
	}
}
//********************************************* 分类二级域名  end ************************

//二级域名不正确，做成死链接，解决百度收录
if ("www.houxue.com" != $_SERVER["HTTP_HOST"] )
{
	header("HTTP/1.0 404 Not Found");
	exit();
}


$file = '';
$mod = 'home';
if( $_GET['mod'] && in_array($_GET['mod'], array('home','jieshao','kecheng','laoshi','huanjing','xinwen','pingjia','xiaoqu','fenxiao','baoming','lianxi','xxyp','xxyp_detail','qiuxue','shipin','bbs')) ) $mod = $_GET['mod'];

//求学时采用POST提交
if( $_POST['mod'] && in_array($_POST['mod'], array('qiuxue')) ) $mod = $_POST['mod'];

//存在 $mod 和 id 时
if($mod && intval($_REQUEST["id"]))
{
	global $cfg;
	require_once("../config.inc.php");
	require_once('../config.php');
	require_once(HOUXUE_ROOT.'/modules/mydbh2.class.php');
	require_once(HOUXUE_ROOT.'/modules/area.class.php');
	require_once(HOUXUE_ROOT.'/modules/category.class.php');
	require_once(HOUXUE_ROOT.'/modules/school.class.php');
	require_once(HOUXUE_ROOT.'/modules/loginuservisitedlog.class.php');
	include_once(HOUXUE_ROOT.'/modules/pageView.class.php');

	if($_SESSION["Admin"]["id"] == "8") $time_start = microtime(true);

	$objschool = new School( intval($_REQUEST["id"]) );
	$school = $objschool->getData();

	if($school["LoginId"])
	{
		$file = "./style/".$school["DisplayStyle"]."/".$mod.".php";

		$dbh2 = Mydbh2::getInstance();

		//保存访问记录   功能：点击付费
		$LoginUserVisitedLog=new LoginUserVisitedLog($dbh2);
		$LoginUserVisitedLog->insert($school["LoginId"]);

		//页面访问日志
		PageView::insertLog();

		$CompanyLabel = "学校";
		if($school["CompanyLabel"] == "organization") $CompanyLabel = "机构";

		$area = Area::getAreaById($school["AreaId"]);
		$category = Category::getCategoryById($school["CategoryId"]);
	}
}

if( file_exists($file) )
{
	require_once($file);
	if($_SESSION["Admin"]["id"] == "8")
	{
		$time_end = microtime(true);
		$time = $time_end - $time_start;
		echo "页面执行时间:".$time." 秒 t1=$t1 t2=$t2 t3=$t3";
	}
	exit();
}
else
{
	header("location:http://www.houxue.com/missing.html");exit();
}