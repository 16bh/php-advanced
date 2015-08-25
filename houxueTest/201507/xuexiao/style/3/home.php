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

require_once(HOUXUE_ROOT.'/modules/course.class.php');

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
$tplFile = "main.htm"; //使用框架结构式模板

$smarty->assign("CONFIG", $CONFIG);
$smarty->assign("school", $school);
$smarty->assign("CompanyLabel", $CompanyLabel);
$smarty->assign("area", $area);
$smarty->assign("category", $category);

require_once(dirname(__FILE__).'/left.php');

//培训学员
$sSql  = " select T_Order.Id, T_Order.Name, T_Order.Phone, T_Order.Dtt, T_Order.CourseId, T_Course.Name as CourseName";
$sSql .= " from T_Order";
$sSql .= "      left join T_Course on T_Order.CourseId = T_Course.Id ";
$sSql .= " where T_Order.SchoolLoginId = '".$school["LoginId"]."' order by T_Order.Id desc limit 20";
$orderlist = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);
$smarty->assign("orderlist", $orderlist);

//取得该学校的特别推荐课程
$courselist_recommend = array();
$sSql = " select '".__FILE__." line ".__line__."', T_Course.Id from T_Course where T_Course.LoginId = '".$school["LoginId"]."' and Recommend = 'yes' limit 5";
$idlist = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);
for($j = 0; $j < count($idlist); $j++)
{
	$objcourse = new Course($idlist[$j]["Id"]);
	$courselist_recommend[] = $objcourse->getData();
	$objcourse = null;
}
$smarty->assign("courselist_recommend", $courselist_recommend);

//新闻咨询
$sSql  = " select Id,Title from T_News where LoginId='".$school["LoginId"]."' order by Id desc limit 5";
$newslist = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);
$smarty->assign("newslist", $newslist);

//返回一个模板的输出
$smarty->display($tplFile);