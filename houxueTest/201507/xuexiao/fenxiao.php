<?php
//------------------------------
//文件功能: 1.
//主要逻辑: 1.
//主要参数: 1.
//编制时间:
//编制人:
//修正时间:
//修正人:
//修正内容:
//------------------------------
$time_start = microtime(true);

//检查url，并且重新定位url
if ("www.houxue.com" != $_SERVER["HTTP_HOST"] )
{
	//二级域名不正确，做成死链接，解决百度收录
	header("HTTP/1.0 404 Not Found");
	exit();
}
?>
<?php
if ($_REQUEST["id"] <= 0 || $_REQUEST["id"] == "")
{
	header("location:/");
	exit();
}
?>
<?php require_once("../config.inc.php");?>
<?php require_once('../config.php');?>
<?php require_once(HOUXUE_ROOT.'/modules/mydbh.class.php');?>
<?php require_once(HOUXUE_ROOT.'/modules/school.class.php');?>
<?php
$dbh = Mydbh::getDbh();

//取得学校信息
$objschool = new School($_REQUEST["id"]);
$school = $objschool->getData();
if ($school["LoginId"] != $_REQUEST["id"])
{
        header("HTTP/1.0 404 Not Found");
        exit();
}

include_once("./style/".$school["DisplayStyle"]."/fenxiao.php");