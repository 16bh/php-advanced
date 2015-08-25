<?php

//------------------------------

//文件功能: 1. 判断二级域名，是城市分站，还是类别分站

//主要逻辑: 1.

//主要参数: 1.

//编制时间:

//编制人:

//修正时间:

//修正人:

//修正内容:

//------------------------------

//if ($_SERVER["HTTP_USER_AGENT"] == "Mozilla/4.0 (compatible; MSIE 6.0; Windows 5.1)") die("");

//if ($_SERVER["HTTP_USER_AGENT"] == "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; QQDownload 618; QQPinyin 730; CIBA; 360SE)") die("");



$find = array("\\", '"', "'");

$replace = array("","","");

$_SERVER["HTTP_HOST"] = str_replace($find, $replace, $_SERVER["HTTP_HOST"]);



$arr = explode(".", $_SERVER["HTTP_HOST"]);

$domain = $arr[0];



//进入www首页

if($domain === "www") {
	global $cfg;
	include_once("config.inc.php");
	require_once(HOUXUE_ROOT . "/modules/mydbh2.class.php");
	require_once 'modules/util/ipaddress/IpAddress.class.php';
	include_once(SMARTY_DIR.'Smarty.class.php');
	$smarty = new Smarty();  //建立smarty实例对象$smarty
	$smarty->template_dir = $cfg["SMARTY_TEMPLATE_DIR"]; //设置模板目录
	$smarty->compile_dir = $cfg["SMARTY_COMPILE_DIR"]; //设置编译目录
	$smarty->config_dir = $cfg["SMARTY_CONFIG_DIR"]; //设置配置目录
	$smarty->plugins_dir = $cfg["SMARTY_PLUGINS_DIR"]; //设置插件目录
	$smarty->cache_dir = $cfg["SMARTY_CACHE_DIR"];//设置缓存目录
	$smarty->left_delimiter = $cfg["SMARTY_LEFT_DELIMITER"];
	$smarty->right_delimiter = $cfg["SMARTY_RIGHT_DELIMITER"];

	//定位
	//取得ip所在地
	$objIpAddress = new IpAddress("modules/util/ipaddress/qqwry.dat");
	$ip = $_SERVER[REMOTE_ADDR];
	$location = $objIpAddress->getlocation($ip);
	$location["area"] = iconv("gb2312", "utf-8", $location["area"]);
	$location["operators"] = iconv("gb2312", "utf-8", $location["operators"]);
	//取得所在市
    $areas =explode("省",$location['area']);
	$length = (strlen($areas[1])-3)/3;
	$area = mb_substr($areas[1],0,$length,'utf-8');
	$dbh2 = Mydbh2::getInstance();
	$sSql = " select Id from T_Area where AreaName = '".$area."'limit 0,1";
	$areaid = $dbh2->query($sSql)->fetch(PDO::FETCH_ASSOC);
	setcookie('houxue_aid',$areaid['Id'],time()+3600);
	//取出导航数据
	//InNa是父id为0的,InNa1根据父id为索引存储的,InNa2同上根据每个上一个的父id为索引存储的
	$sql = "select * from www_index_nav_setting where PId ='0'";
	$InNa = $dbh2->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	foreach($InNa as $k=>$v)
	{
		$sql = "select * from www_index_nav_setting where PId ='".$v['Id']."'";
		$InNa1[$k] = $dbh2->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		foreach($InNa1[$k] as $k1=>$v1)
		{
			$sql = "select * from www_index_nav_setting where PId ='".$v1['Id']."'";
			$InNa2[$k1] = $dbh2->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	$smarty->assign("InNa",$InNa);
	$smarty->assign("InNa1",$InNa1);
	$smarty->assign("InNa2",$InNa2);
	$smarty->display("index_www.htm");
	exit();
}



//进入 ke.houxue.net 首页

if($domain === "ke") {

	global $cfg;

	require_once("config.inc.php");

	include_once("domain/distribute.php");exit();

}

if($domain === "baidu")

{

	global $cfg;

	require_once("config.inc.php");

	include_once("domain/distribute.php");exit();

}



//进入手机版页面   在.htaccess已经配置

//if( $_SERVER["HTTP_HOST"] == "m.houxue.net"

//	||	($domain != "" && substr($_SERVER["HTTP_HOST"], -13) === ".m.houxue.net")

//	) {include_once("m/distribute.php");exit();}



?>

<?php global $cfg;?>

<?php include_once("config.inc.php");?>

<?php include_once(HOUXUE_ROOT . '/modules/mydbh.class.php');?>

<?php



$dbh = Mydbh::getDbh();

$sSql = " select * from T_Area where Domain ='".$domain."'";

$area = $dbh->query($sSql)->fetch(PDO::FETCH_ASSOC);

if($area["Id"] > 0) {
    include_once(HOUXUE_ROOT . "/area/index.php");exit();}



$sSql = " select * from T_Category where Domain ='".$domain."'";

$category = $dbh->query($sSql)->fetch(PDO::FETCH_ASSOC);

if($category["Id"] > 0) {
    include_once(HOUXUE_ROOT . "/category/index.php");exit();}