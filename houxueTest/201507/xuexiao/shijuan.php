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
<?php require_once(HOUXUE_ROOT.'/modules/area.class.php');?>
<?php require_once(HOUXUE_ROOT.'/modules/category.class.php');?>
<?php require_once(HOUXUE_ROOT.'/modules/order.class.php');?>
<?php require_once(HOUXUE_ROOT.'/modules/school.class.php');?>
<?php require_once(HOUXUE_ROOT.'/modules/course.class.php');?>
<?php include_once(HOUXUE_ROOT.'/modules/pageView.class.php');?>
<?php
//模版文件名
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

$smarty->assign("CONFIG", $CONFIG);
?>
<?php
if ($_REQUEST["id"] <= 0 || $_REQUEST["id"] == "")
{
	header("location:/");
	exit();
}
?>
<?php
$dbh = Mydbh::getDbh();

//取得学校信息
$objschool = new School($_REQUEST["id"]);
$school = $objschool->getData();
if ($school["LoginId"] != $_REQUEST["id"])
{
        //header("HTTP/1.0 404 Not Found");
		include("../missing.html");
        exit();
}
$smarty->assign("school", $school);

if($school["DisplayStyle"]!=1)											//暂时 支持模板1
{
	include("../missing.html");exit();
}

$CompanyLabel = "学校";
if($school["CompanyLabel"] == "organization") $CompanyLabel = "机构";
$smarty->assign("CompanyLabel", $CompanyLabel);

//保存访问记录   功能：点击付费
include_once(HOUXUE_ROOT.'/modules/loginuservisitedlog.class.php');
$LoginUserVisitedLog=new LoginUserVisitedLog($dbh);
$LoginUserVisitedLog->insert($school["LoginId"]);

$displayStylePath = HOUXUE_ROOT."/xuexiao/style/".($school["DisplayStyle"]+0);
$smarty->template_dir = $displayStylePath."/".$cfg["SMARTY_TEMPLATE_DIR"]; //设置模板目录
$smarty->compile_dir = $displayStylePath."/".$cfg["SMARTY_COMPILE_DIR"]; //设置编译目录
$tplFile = "shijuan.htm"; //使用框架结构式模板

$area = Area::getAreaById($school["AreaId"]);
$smarty->assign("area", $area);

$category = Category::getCategoryById($school["CategoryId"]);
$smarty->assign("category", $category);

//取得学校分校记录
$sSql  = " select T_School_Sub.*";
$sSql .= " from T_School_Sub";
$sSql .= " where T_School_Sub.LoginId = '".$_REQUEST["id"]."' order by T_School_Sub.Id asc";
$sublist = $dbh->query($sSql)->fetchAll(PDO::FETCH_ASSOC);
$smarty->assign("sublist", $sublist);

//一页的记录数
$pager_limit = $_REQUEST["pager_limit"]==""? 20 : $_REQUEST["pager_limit"];
// 计算 limit ,处理翻页
$pager_rownum = $_REQUEST["pager_rownum"] <=0 ? 0 : $_REQUEST["pager_rownum"];
$slimit = " limit " . $pager_rownum . " , $pager_limit ";

//取得列表
$sSql  = " select SQL_CALC_FOUND_ROWS T_TestPaper.Id from T_TestPaper where 1=1 and LoginId='".$school["LoginId"]."' order by Id DESC $slimit";
$idlist = $dbh->query($sSql)->fetchAll(PDO::FETCH_ASSOC);

//---------------------------------------------------------
//取得总的纪录数，除去limit的限制
$sSql = "SELECT FOUND_ROWS() as rowcount;";
$data = $dbh->query($sSql)->fetch(PDO::FETCH_ASSOC);
$pager["rowcount_all"] = $data["rowcount"];//总的纪录数
$pager["pagecount_all"] = ceil($data["rowcount"]/$pager_limit);//总的页数
$pager["rowcount"] = min($data["rowcount"], $pager_rownum + $pager_limit * 20 );//用于翻页的纪录数
$pager["limit"] = $pager_limit;
//smarty,pager插件参数的设置
$pager["posvar"] = "pager_rownum";
$pager["txt_pos"] = "side";
$arrs = $queryfields;
$pager["forwardvars"] = $arrs;//外部的参数传递
$pager["shift"] = 0;
$smarty->assign("pager", $pager);
$smarty->register_outputfilter('change_url');

if(!empty($idlist))
{
	foreach($idlist as $value)
	{
		$sSql="select * from T_TestPaper where Id=".$value["Id"];
		$row = $dbh->query($sSql)->fetch(PDO::FETCH_ASSOC);

		$List[]=$row;
	}
}
$smarty->assign("List", $List);


//页面访问日志
PageView::insertLog();

$dbh = null;

//返回一个模板的输出
$smarty->display($tplFile);



if($_SESSION["Admin"]["id"] == "8")
{
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	echo "页面执行时间:".$time." 秒 t1=$t1 t2=$t2 t3=$t3";
}

function change_url($tpl_output, &$smarty)
{
	$tpl_output =preg_replace('/shijuan\.php\?id=([0-9]+)*&pager_rownum=([0-9]+)*/','\1/shijuan/list-\2.htm', $tpl_output);
	return $tpl_output;
}

function getAreaPathName($areaid)
{
	$area = Area::getAreaById($areaid);
	$pathname = "";
	for($i=0; $i<count($area["Path"]); $i++) $pathname .= $area["Path"][$i]["AreaName"]."-";
	return trim($pathname, "-");
}

function star2text($star )
{
	$star_text[0] = "很差";
	$star_text[3] = "差";
	$star_text[6] = "一般";
	$star_text[8] = "好";
	$star_text[10] = "很好";
	$rtn = $star_text[$star];

	return $rtn;

}

function changeFileSize($fileSize) {
	if ($fileSize >= 1048576) {
		$fileSize = round($fileSize / 1048576, 2) . 'GB';
	} elseif ($fileSize >= 1024) {
		$fileSize = round($fileSize / 1024, 2) . 'MB';
	} else {
		$fileSize = $fileSize . 'KB';
	}
	return $fileSize;
}