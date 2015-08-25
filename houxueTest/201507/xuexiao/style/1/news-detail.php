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
if(!defined('HOUXUE_ROOT')) {
	exit('Access Denied');
}

include_once(HOUXUE_ROOT."/modules/mydbh2.class.php");
require_once('Smarty.class.php');
$smarty = new Smarty();  //建立smarty实例对象$smarty
//$smarty->template_dir = $cfg["SMARTY_TEMPLATE_DIR"]; //设置模板目录
//$smarty->compile_dir = $cfg["SMARTY_COMPILE_DIR"]; //设置编译目录
$smarty->config_dir = $cfg["SMARTY_CONFIG_DIR"]; //设置配置目录
$smarty->plugins_dir = $cfg["SMARTY_PLUGINS_DIR"]; //设置插件目录
$smarty->cache_dir = $cfg["SMARTY_CACHE_DIR"];//设置缓存目录
$smarty->left_delimiter = $cfg["SMARTY_LEFT_DELIMITER"];
$smarty->right_delimiter = $cfg["SMARTY_RIGHT_DELIMITER"];
//$smarty->caching = false;
//$smarty->debugging = true;
$displayStylePath = HOUXUE_ROOT."/xuexiao/style/".($school["DisplayStyle"]+0);
$smarty->template_dir = $displayStylePath."/".$cfg["SMARTY_TEMPLATE_DIR"]; //设置模板目录
$smarty->compile_dir = $displayStylePath."/".$cfg["SMARTY_COMPILE_DIR"]; //设置编译目录
$tplFile = "news-detail.htm"; //使用框架结构式模板

$smarty->assign("CONFIG", $CONFIG);
$smarty->assign("school", $school);
$smarty->assign("CompanyLabel", $CompanyLabel);
$smarty->assign("area", $area);
$smarty->assign("category", $category);


$smarty->assign("newsdata", $newsdata);

$dbh2 = Mydbh2::getInstance();
//新闻点击+ 1
$sSql = "update T_News set Click = IFNULL(Click, 0) + 1 where Id='".$newsdata["Id"]."'";
$dbh2->exec($sSql);

//上一篇 下一篇
$sSql="select T_News.* from T_News where LoginId=".$newsdata["LoginId"]." and Id<".$newsdata["Id"]." limit 1";
$predata = $dbh2->query($sSql)->fetch(PDO::FETCH_ASSOC);

$sSql="select T_News.* from T_News where LoginId=".$newsdata["LoginId"]." and Id>".$newsdata["Id"]." limit 1";
$nextdata = $dbh2->query($sSql)->fetch(PDO::FETCH_ASSOC);

$smarty->assign("predata", $predata);
$smarty->assign("nextdata", $nextdata);


//返回一个模板的输出
$smarty->display($tplFile);