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
require_once(HOUXUE_ROOT.'/modules/login.class.php');

//模版文件名
$smarty = new Smarty();  //建立smarty实例对象$smarty
$smarty->config_dir = $cfg["SMARTY_CONFIG_DIR"]; //设置配置目录
$smarty->plugins_dir = $cfg["SMARTY_PLUGINS_DIR"]; //设置插件目录
$smarty->cache_dir = $cfg["SMARTY_CACHE_DIR"];//设置缓存目录
$smarty->left_delimiter = $cfg["SMARTY_LEFT_DELIMITER"];
$smarty->right_delimiter = $cfg["SMARTY_RIGHT_DELIMITER"];
$displayStylePath = HOUXUE_ROOT."/xuexiao/style/".($school["DisplayStyle"]+0);
$smarty->template_dir = $displayStylePath."/".$cfg["SMARTY_TEMPLATE_DIR"]; //设置模板目录
$smarty->compile_dir = $displayStylePath."/".$cfg["SMARTY_COMPILE_DIR"]; //设置编译目录
$tplFile = "shipin.htm"; //使用框架结构式模板

$smarty->assign("CONFIG", $CONFIG);
$smarty->assign("school", $school);
$smarty->assign("CompanyLabel", $CompanyLabel);
$smarty->assign("area", $area);
$smarty->assign("category", $category);

$flag= $_REQUEST["flag"]=="detail" ? "detail" : "list";
$smarty->assign("flag", $flag);

if($flag=="detail")
{
	$id=intval($_REQUEST["zid"]);

	$sSql="select * from T_Article_Video where Id='".$id."' and LoginId='".$school["LoginId"]."' limit 1";
	$row = $dbh2->query($sSql)->fetch(PDO::FETCH_ASSOC);
	if($row["Id"]!=$id)
	{
		header("HTTP/1.0 404 Not Found");
		include("../missing.html");
		exit();
	}

	require_once(dirname(__FILE__).'/left.php');

	//获取分类
	$Category=Category::getCategoryById($row["CategoryId"]);
	$row["CategoryName"]=$Category["CategoryName"];
	//获取地区
	$Area = Area::getAreaById($row["AreaId"]);
	$row["AreaName"]=$Area["AreaName"];
	// T_Video 表
	$sSql="select * from T_Video where Id='".$row["VideoId"]."' and LoginId='".$school["LoginId"]."' limit 1";
	$data = $dbh2->query($sSql)->fetch(PDO::FETCH_ASSOC);
	$row["T_Video"]=$data;
	if(($row["T_Video"]["Height"]===null) || ($row["T_Video"]["Width"]===null))
	{
		$row["T_Video"]["Width"]=500;
		$row["T_Video"]["Height"]=400;
	}

	//取得该学校的课程分类汇总
	$sSql  = " select T_School_Category.CategoryId, T_School_Category.CourseCount, T_Category.CategoryName from T_School_Category ";
	$sSql .= " inner join T_Category on T_School_Category.CategoryId = T_Category.Id ";
	$sSql .= " where LoginId = ".$school["LoginId"]." ";
	$SchoolCategory = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);
	for($i=0; $i < count($SchoolCategory); $i ++)
	{
		$sSql  = " select '".__FILE__." line ".__line__."',T_Course.Id, T_Course.Name, T_Course.LinkFlag, T_Course.OrderLink, T_Course.TryUrl, T_Course.DT, T_Course.Price, T_Course.Visit, T_Course.Recommend, T_Category.CategoryName, T_Area.Domain, T_Area.AreaName from T_Course";
		$sSql .= " left join T_Area on T_Course.AreaId = T_Area.Id";
		$sSql .= " left join T_Category on T_Course.CategoryId = T_Category.Id";
		$sSql .= " where LoginId='".$school["LoginId"]."' And T_Course.CategoryId='".$SchoolCategory[$i]["CategoryId"]."' Order By T_Category.Lft, T_Course.SortId desc, T_Course.Id desc ";
		$courselist = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);
		$SchoolCategory[$i]["courselist"] = $courselist;
		unset($courselist);
	}
	$smarty->assign("SchoolCategory", $SchoolCategory);

	//授权号码、姓名创建的帐号登录
	$isgetauthloginid=intval($_REQUEST["isgetauthloginid"]);
	if($isgetauthloginid)
	{
		$x_Cellphone=trim($_REQUEST["x_Cellphone"]);
		$x_Name=trim($_REQUEST["x_Name"]);
		include_once(HOUXUE_ROOT.'/modules/loginuser.class.php');
		$objLoginUser=new LoginUser();
		$authLoginId=$objLoginUser->getLoginIdByCellphoneName($x_Cellphone, $x_Name);
		if($authLoginId)
		{
			Login::loginAsId($authLoginId);
		}
		else
		{
			unset($response);
			$response["rtn"] = "error";
			$response["error_text"] = "无效的授权号码和授权姓名！";
			echo json_encode($response);exit();
		}
	}

	$isPlay=false;
	//判断是否能观看   1、如果视频免费直接观看  2、如果是收费，如果登录判断当前用户是否授权，未登录就不能观看
	if($row["T_Video"]["Price"]<=0)
	{
		//直接观看
		$isPlay=true;
	}
	else
	{
		$theLoginId = Login::getCurrentUserLoginId();
		if($theLoginId)
		{
			$sSql = "select Id,ExpireDtt from T_Video_Play_Auth where VideoId = '".$row["T_Video"]["Id"]."' and LoginId='".$theLoginId."' order by Id DESC limit 1";
			$data = $dbh2->query($sSql)->fetch(PDO::FETCH_ASSOC);
			if($data["Id"])
			{
				if($data["ExpireDtt"]>time())
				{
					$isPlay=true;
				}
				else
				{
					$isNotPlayText="抱歉，授权过期，不能观看！请联系当前学校管理人员。";
				}
			}
			else
			{
				$isNotPlayText="抱歉，当前用户未授权，不能观看！请联系当前学校管理人员。";
			}
		}
		else
		{
			$isNotPlayText="抱歉，只有授权的用户才可以观看此视频！";
		}
	}

	if($isPlay)
	{
		//获取hash
		$data=VideoStore::flashvars($row["T_Video"]["videostore_id"]);
		if($data["rtn"]=="ok")
		{
			//视频参数
			$flashvars=$data["data"];
			//flash地址
			$data=VideoStore::swfplayer();
			$swfplayer=$data["data"];
			//自定义参数
			unset($customParam);
			$customParam["PHPSESSID"]=session_id();
			$customParam["domain_id"]=1;
			$customParam["id"]=$row["T_Video"]["videostore_id"];
			$customParam=json_encode($customParam);
		}
	}

	if($isgetauthloginid)
	{
		if($isPlay)
		{
			unset($response);
			$response["rtn"] = "ok";
			$response["swfplayer"] = $swfplayer;
			$response["flashvars"] = $flashvars;
			$response["customParam"] = $customParam;
			echo json_encode($response);exit();
		}
		else
		{
			unset($response);
			$response["rtn"] = "error";
			$response["error_text"] = $isNotPlayText;
			echo json_encode($response);exit();
		}
	}

	$smarty->assign("isPlay", $isPlay);
	$smarty->assign("swfplayer", $swfplayer);
	$smarty->assign("flashvars", $flashvars);
	$smarty->assign("customParam", $customParam);
	$smarty->assign("row", $row);

	//浏览数+1
	$sSql="update T_Article_Video set Click=".$row["Click"]."+1 where Id='".$row["Id"]."'  limit 1";
	$rtn = $dbh2->exec($sSql);

	$tplFile = "shipin_detail.htm"; //使用框架结构式模板
}
else
{
	//一页的记录数
	$pager_limit = 20;
	// 计算 limit ,处理翻页
	$pager_rownum = intval($_REQUEST["pager_rownum"])>0 ? intval($_REQUEST["pager_rownum"]) : 0;
	$slimit = " limit " . $pager_rownum . " , $pager_limit ";

	//取得列表
	$sSql  = " select SQL_CALC_FOUND_ROWS Id from T_Article_Video where 1=1 and LoginId='".$school["LoginId"]."' order by Id DESC $slimit";
	$idlist = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);

	//---------------------------------------------------------
	//取得总的纪录数，除去limit的限制
	$sSql = "SELECT FOUND_ROWS() as rowcount;";
	$data = $dbh2->query($sSql)->fetch(PDO::FETCH_ASSOC);
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
			$sSql="select * from T_Article_Video where Id=".$value["Id"];
			$row = $dbh2->query($sSql)->fetch(PDO::FETCH_ASSOC);

			//获取分类
			$Category=Category::getCategoryById($row["CategoryId"]);
			$row["CategoryName"]=$Category["CategoryName"];

			//获取地区
			$Area = Area::getAreaById($row["AreaId"]);
			$row["AreaName"]=$Area["AreaName"];

			$List[]=$row;
		}
	}
	$smarty->assign("List", $List);
}

//返回一个模板的输出
$smarty->display($tplFile);

function change_url($tpl_output, &$smarty)
{
	$tpl_output =preg_replace('/index\.php\?id=([0-9]+)*&mod=shipin&pager_rownum=([0-9]+)*/','\1/shipin/list-\2.htm', $tpl_output);
	return $tpl_output;
}