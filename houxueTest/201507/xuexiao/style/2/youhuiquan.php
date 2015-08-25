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
if ($_REQUEST["id"] <= 0 || $_REQUEST["id"] == ""){
	header("location:/");
	exit();
}
?>
<?php
$dbh2 = Mydbh2::getInstance();

//取得学校信息
$objschool = new School($_REQUEST["id"]);
$school = $objschool->getData();
if ($school["LoginId"] != $_REQUEST["id"]){
	include("../missing.html");
    exit();
}
$smarty->assign("school", $school);

//留言时预选选项
$prepareTextList = array();
$idlist = $dbh2->fetchAll("select * from T_Order_Prepare_Select_Text WHERE LoginId='".$school["LoginId"]."' ORDER BY SortId DESC,Id DESC limit 5");
if(!empty($idlist) && is_array($idlist)){
	foreach($idlist as $value){
		$sSql = "select * from T_Order_Prepare_Select_TextContent WHERE OPSTId='".$value["Id"]."' and LoginId='".$school["LoginId"]."' ORDER BY SortId DESC,Id DESC limit 5";
		$value["T_Content"] = $dbh2->fetchAll($sSql);
		if($value["T_Content"]) $prepareTextList[] = $value;
	}
}
$smarty->assign("prepareTextList", $prepareTextList);

// 移动微信二维码展示
$sSql = " select WeiXin_QRCode_8CM_ImageId from T_MP_Auth_WeiXin where LoginId = '".$school["LoginId"] ."' limit 1";
$mpAuth = $dbh2->query($sSql)->fetch(PDO::FETCH_ASSOC);
$smarty->assign("mpAuth", $mpAuth);

$CompanyLabel = "学校";
if($school["CompanyLabel"] == "organization") $CompanyLabel = "机构";
$smarty->assign("CompanyLabel", $CompanyLabel);

//保存访问记录   功能：点击付费
include_once(HOUXUE_ROOT.'/modules/loginuservisitedlog.class.php');
$LoginUserVisitedLog=new LoginUserVisitedLog($dbh2);
$LoginUserVisitedLog->insert($school["LoginId"]);

$displayStylePath = HOUXUE_ROOT."/xuexiao/style/".($school["DisplayStyle"]+0);
$smarty->template_dir = $displayStylePath."/".$cfg["SMARTY_TEMPLATE_DIR"]; //设置模板目录
$smarty->compile_dir = $displayStylePath."/".$cfg["SMARTY_COMPILE_DIR"]; //设置编译目录
$tplFile = "youhuiquan.htm"; //使用框架结构式模板

$area = Area::getAreaById($school["AreaId"]);
$smarty->assign("area", $area);

$category = Category::getCategoryById($school["CategoryId"]);
$smarty->assign("category", $category);

$flag= $_REQUEST["flag"]=="detail" ? "detail" : "list";
$smarty->assign("flag", $flag);

require_once(dirname(__FILE__).'/left.php');


if($flag=="detail"){
	$id=intval($_REQUEST["zid"]);

	//优惠券or代金券T_Coupon_Publish
	$row = $dbh2->fetch("select * from T_Coupon_Publish where Id='".$id."' and IsOpen='yes' limit 1");
	if($row["Id"]!=$id){
		include("../missing.html");
		exit();
	}
	$smarty->assign("row", $row);

	if($row["ProductId"] <= 0){//优惠券
		//优惠券和优惠券学校关系对应判断
		if($row["LoginId"] != $school["LoginId"]){
			include(HOUXUE_ROOT."/missing.html");
			exit();
		}
	}else if($row["ProductId"] > 0){//代金券
		//代金券和代金券学校关系对应判断
		unset($data);
		$data = $dbh2->fetch("select Id from T_Coupon_Relation_Course where CouponPublishId='".$id."' and LoginId='".$school['LoginId']."' limit 1");
		if(!$data['Id']){
			include(HOUXUE_ROOT."/missing.html");
			exit();
		}

		//支持课程
		unset($dataList);
		$dataList = $dbh2->fetchAll("select distinct CourseId from T_Coupon_Relation_Course where CouponPublishId='".$id."' and LoginId='".$school["LoginId"]."'");
		if($dataList){
			$courseList = array();
			foreach($dataList as $key=>$value){
				unset($row);
				$row = $dbh2->fetch("select a.Id,a.Name,a.AreaId,a.DT,a.Price,b.CategoryName from T_Course as a,T_Category as b where a.CategoryId=b.Id and a.Id='".$value["CourseId"]."' limit 1");
				if($row){
					unset($area);
					$area = Area::getAreaById($row["AreaId"]);
					$row["href"] = "http://".$area["Domain"].".houxue.com/kecheng-".$row["Id"]."/";
					$courseList[] = $row;
				}
			}
			$smarty->assign("courseList", $courseList);
		}


		//学校代金券使用条件
		$condition = $dbh2->fetch("select CouponUseCondition from T_School_Content where LoginId='".$school["LoginId"]."' limit 1");
		$smarty->assign("condition", nl2br($condition["CouponUseCondition"]));
	}

	//浏览数+1
	$sSql="update T_Coupon_Publish set Click=".$row["Click"]."+1 where Id='".$row["Id"]."'  limit 1";
	$rtn = $dbh2->exec($sSql);
	$tplFile = "youhuiquan_detail.htm";
}else{

	//一页的记录数
	$pager_limit = $_REQUEST["pager_limit"]==""? 20 : $_REQUEST["pager_limit"];
	// 计算 limit ,处理翻页
	$pager_rownum = $_REQUEST["pager_rownum"] <=0 ? 0 : $_REQUEST["pager_rownum"];
	$slimit = " limit " . $pager_rownum . " , $pager_limit ";

	//取得列表
	$sSql  = " select SQL_CALC_FOUND_ROWS Id from T_Coupon_Publish where 1=1 and LoginId='".$school["LoginId"]."' and ProductId<=0 order by Id DESC $slimit";
	$idlist = $dbh2->fetchAll($sSql);

	//---------------------------------------------------------
	//取得总的纪录数，除去limit的限制
	$sSql = "SELECT FOUND_ROWS() as rowcount;";
	$data = $dbh2->fetch($sSql);
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

	if(!empty($idlist)){
		foreach($idlist as $value){
			$sSql="select Id,Title,ImageId,HoldStartDtt,ExpireDtt from T_Coupon_Publish where Id=".$value["Id"];
			$row = $dbh2->fetch($sSql);

			$List[]=$row;
		}
	}
	$smarty->assign("List", $List);
}

//页面访问日志
PageView::insertLog();

$dbh2 = null;

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
	$tpl_output =preg_replace('/youhuiquan\.php\?id=([0-9]+)*&pager_rownum=([0-9]+)*/','\1/youhuiquan/list-\2.htm', $tpl_output);
	return $tpl_output;
}
