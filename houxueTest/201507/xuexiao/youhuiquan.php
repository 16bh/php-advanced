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
if($_SESSION["Admin"]["id"] == "8") $time_start = microtime(true);

if($_SERVER["HTTP_HOST"] == "m.houxue.com")
{
	include_once("../m/distribute.php");
	exit();
}

//检查url，并且重新定位url
if ("www.houxue.com" != $_SERVER["HTTP_HOST"] )
{
	//二级域名不正确，做成死链接，解决百度收录
	header("HTTP/1.0 404 Not Found");
	exit();
}
?>
<?php global $cfg;?>
<?php require_once("../config.inc.php");?>
<?php require_once('Smarty.class.php');?>
<?php require_once('../config.php');?>
<?php require_once(HOUXUE_ROOT.'/modules/mydbh.class.php');?>
<?php require_once(HOUXUE_ROOT.'/modules/mydbh2.class.php');?>
<?php include_once(HOUXUE_ROOT.'/modules/login.class.php');?>
<?php require_once(HOUXUE_ROOT.'/modules/area.class.php');?>
<?php require_once(HOUXUE_ROOT.'/modules/category.class.php');?>
<?php require_once(HOUXUE_ROOT.'/modules/order.class.php');?>
<?php require_once(HOUXUE_ROOT.'/modules/school.class.php');?>
<?php require_once(HOUXUE_ROOT.'/modules/course.class.php');?>
<?php require_once(HOUXUE_ROOT.'/modules/videostore.class.php');?>
<?php include_once(HOUXUE_ROOT.'/modules/pageView.class.php');?>
<?php

?>
<?php
if ($_REQUEST["id"] <= 0 || $_REQUEST["id"] == "")
{
	header("location:/");
	exit();
}
?>
<?php
$dbh2 = Mydbh2::getInstance();

//取得学校信息
$objschool = new School($_REQUEST["id"]);
$school = $objschool->getData();
if ($school["LoginId"] != $_REQUEST["id"])
{
        //header("HTTP/1.0 404 Not Found");
		include("../missing.html");
        exit();
}

$CompanyLabel = "学校";
if($school["CompanyLabel"] == "organization") $CompanyLabel = "机构";

$flag= $_REQUEST["flag"];

$file = HOUXUE_ROOT."/xuexiao/style/".($school["DisplayStyle"]+0)."/youhuiquan.php";
if(file_exists($file))
{
	include_once($file);
}
else
{
	include_once(HOUXUE_ROOT."/missing.html");
}
