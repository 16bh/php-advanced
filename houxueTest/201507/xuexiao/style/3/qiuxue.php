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
$tplFile = "qxzs.htm"; //使用框架结构式模板

$smarty->assign("CONFIG", $CONFIG);
$smarty->assign("school", $school);
$smarty->assign("CompanyLabel", $CompanyLabel);
$smarty->assign("area", $area);
$smarty->assign("category", $category);

require_once(dirname(__FILE__).'/left.php');

$pager_limit = $_REQUEST["pager_limit"]==""? 20 : $_REQUEST["pager_limit"];//一页的记录数
//----------------------------------------------------------
// 计算 limit ,处理翻页
$pager_rownum = $_REQUEST["pager_rownum"] == "" ? 0 : $_REQUEST["pager_rownum"];
settype($pager_rownum, "int");
$pager_rownum = $pager_rownum<=0?0:$pager_rownum;
$slimit = " limit " . $pager_rownum . " , $pager_limit ";

//取得列表
$sSql  = " select SQL_CALC_FOUND_ROWS T_Order_Contact.Id";
$sSql .= " from T_Order_Contact left join T_Order on T_Order.Id=T_Order_Contact.OrderId WHERE T_Order_Contact.LoginId=".$school["LoginId"]." and T_Order.PursueEduFlag = 'yes'";
$sSql .= " ORDER BY T_Order_Contact.Id DESC";
$sSql .= $slimit;
$idlist = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);

//---------------------------------------------------------
//取得总的纪录数，除去limit的限制
$sSql = "SELECT FOUND_ROWS() as rowcount;";
$data = $dbh2->query($sSql)->fetch(PDO::FETCH_ASSOC);
$pager["rowcount_all"] = $data["rowcount"];//总的纪录数
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

foreach($idlist as $row)
{
	$sSql  = " select T_Order_Contact.*,T_Order.Name,T_Order.Phone";
	$sSql .= " from T_Order_Contact left join T_Order on T_Order.Id=T_Order_Contact.OrderId WHERE T_Order_Contact.Id=".$row["Id"];
	$contact = $dbh2->query($sSql)->fetch(PDO::FETCH_ASSOC);
	$qxzsList[]=$contact;
}
$smarty->assign("qxzsList", $qxzsList);

//返回一个模板的输出
$smarty->display($tplFile);

function change_url($tpl_output, &$smarty)
{
	$tpl_output =preg_replace('/main\.php\?id=([0-9]+)*&tplfile=qxzs\.htm&pager_rownum=([0-9]+)*/','\1/qxzs-\2.htm', $tpl_output);
	return $tpl_output;
}
function myfiltercontent($rtn)
{
	$find = array('http','://',':/','www','com','net','.cn','.html','.asp','.php','.cc','.org','blog','&nbsp;','..','\t');
	$rtn = str_ireplace($find, '****', $rtn);

	$find = array("０","１","２","３","４","５","６","７","８","９","－");
	$replace = array("0","1","2","3","4","5","6","7","8","9","-");
	$rtn = str_replace($find, $replace, $rtn);

	$find = array("O","①","②","③","④","⑤","⑥","⑦","⑧","⑨");
	$replace = array("0","1","2","3","4","5","6","7","8","9");
	$rtn = str_replace($find, $replace, $rtn);

	$find = array("零");
	$replace = array("0");
	$rtn = str_replace($find, $replace, $rtn);

	//过滤可能的电话号码，数字
	$pattern  = '/[l\d\-\[\]\s]{7,}/isu';
	$replacement  = "******";
	$rtn = preg_replace( $pattern,$replacement,$rtn);

	//过滤外链
	$rtn = preg_replace('/<a[^>]*href=.*(http:\/\/)?([^ \'"]+).*>(.*)<\/a>/i','filterlink', $rtn);

	return $rtn;
}