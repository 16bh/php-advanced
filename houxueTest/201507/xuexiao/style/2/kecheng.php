<?php
if(!defined('HOUXUE_ROOT')) {
	exit('Access Denied');
}

require_once('Smarty.class.php');
$smarty = new Smarty();  //建立smarty实例对象$smarty
$smarty->config_dir = $cfg["SMARTY_CONFIG_DIR"]; //设置配置目录
$smarty->plugins_dir = $cfg["SMARTY_PLUGINS_DIR"]; //设置插件目录
$smarty->cache_dir = $cfg["SMARTY_CACHE_DIR"];//设置缓存目录
$smarty->left_delimiter = $cfg["SMARTY_LEFT_DELIMITER"];
$smarty->right_delimiter = $cfg["SMARTY_RIGHT_DELIMITER"];
$displayStylePath = HOUXUE_ROOT."/xuexiao/style/".($school["DisplayStyle"]+0);
$smarty->template_dir = $displayStylePath."/".$cfg["SMARTY_TEMPLATE_DIR"]; //设置模板目录
$smarty->compile_dir = $displayStylePath."/".$cfg["SMARTY_COMPILE_DIR"]; //设置编译目录
$tplFile = "kecheng.htm"; //使用框架结构式模板

$smarty->assign("CONFIG", $CONFIG);
$smarty->assign("school", $school);
$smarty->assign("CompanyLabel", $CompanyLabel);
$smarty->assign("area", $area);
$smarty->assign("category", $category);

require_once(dirname(__FILE__).'/left.php');

//取得该学校的课程分类汇总
$sSql  = " select T_School_Category.CategoryId, T_School_Category.CourseCount, T_Category.CategoryName from T_School_Category ";
$sSql .= " inner join T_Category on T_School_Category.CategoryId = T_Category.Id ";
$sSql .= " where LoginId = ".$school["LoginId"]." and T_School_Category.CourseCount > 0";
$SchoolCategory = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);

for($i=0; $i < count($SchoolCategory); $i ++)
{
	$sSql  = " select '".__FILE__." line ".__line__."',T_Course.Id, T_Course.Name, T_Course.LinkFlag, T_Course.OrderLink, T_Course.TryUrl, T_Course.DT, T_Course.Price, T_Course.Visit, T_Course.Recommend, T_Category.CategoryName, T_Area.Domain, T_Area.AreaName from T_Course";
	$sSql .= " left join T_Area on T_Course.AreaId = T_Area.Id";
	$sSql .= " left join T_Category on T_Course.CategoryId = T_Category.Id";
	$sSql .= " where LoginId='".$school["LoginId"]."' And T_Course.CategoryId='".$SchoolCategory[$i]["CategoryId"]."' Order By T_Category.Lft, T_Course.SortId desc, T_Course.Id desc limit 100";
	$courselist = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);
	$SchoolCategory[$i]["courselist"] = $courselist;
	unset($courselist);
}
$smarty->assign("SchoolCategory", $SchoolCategory);

//返回一个模板的输出
$smarty->display($tplFile);