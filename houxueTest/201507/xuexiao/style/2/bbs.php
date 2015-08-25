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

include_once(HOUXUE_ROOT.'/modules/bbs/BbsBoard.class.php');
include_once(HOUXUE_ROOT.'/modules/imagestore.class.php');
require_once('Smarty.class.php');
//模版文件名
$smarty = new Smarty();  //建立smarty实例对象$smarty
//$smarty->template_dir = $cfg["SMARTY_TEMPLATE_DIR"]; //设置模板目录
//$smarty->compile_dir = $cfg["SMARTY_COMPILE_DIR"]; //设置编译目录
$smarty->config_dir = $cfg["SMARTY_CONFIG_DIR"]; //设置配置目录
$smarty->plugins_dir = $cfg["SMARTY_PLUGINS_DIR"]; //设置插件目录
$smarty->cache_dir = $cfg["SMARTY_CACHE_DIR"];//设置缓存目录
$smarty->left_delimiter = $cfg["SMARTY_LEFT_DELIMITER"];
$smarty->right_delimiter = $cfg["SMARTY_RIGHT_DELIMITER"];
$displayStylePath = HOUXUE_ROOT."/xuexiao/style/".($school["DisplayStyle"]+0);
$smarty->template_dir = $displayStylePath."/".$cfg["SMARTY_TEMPLATE_DIR"]; //设置模板目录
$smarty->compile_dir = $displayStylePath."/".$cfg["SMARTY_COMPILE_DIR"]; //设置编译目录
$tplFile = "bbs.htm"; //使用框架结构式模板

$smarty->assign("CONFIG", $CONFIG);
$smarty->assign("school", $school);
$smarty->assign("CompanyLabel", $CompanyLabel);
$smarty->assign("area", $area);
$smarty->assign("category", $category);

if($school["AllowBbs"]=='yes')
{
	$sSql="select * from T_Bbs_Board where LoginId='".$school["LoginId"]."' limit 1";
	$bbsBoard = $dbh2->query($sSql)->fetch(PDO::FETCH_ASSOC);
}
if(!$bbsBoard["Id"])
{
	$smarty->display($tplFile);
	exit();
}
$smarty->assign("bbsBoard", $bbsBoard);

$flag= $_REQUEST["flag"];
$smarty->assign("flag", $flag);

if($flag=='uploadimg')
{
	error_reporting(0);
	$param["imageSource"] = "upload";
	$param["uploadFileVar"]="Filedata";
	$param["pWidth"] = 600;
	$param["pHeight"] = 600;
	$param["pImageId"] = "";
	$rtn = ImageStore::saveFromParam($param);
	if ($rtn["errcode"] == "ok")
	{
		echo $rtn["imageid"];exit();
	}
}


if($flag=="addThread")
{
	if($_SESSION["LoginUser"]["LoginId"]<=0)
	{
		header("Location:http://www.houxue.com/login.php?forward=http://www.houxue.com/xuexiao/".$school["LoginId"]."/bbs/add.htm");exit();
	}

	if($bbsBoard['IsAllowPost']!='yes')
	{
		echo "<script type=\"text/javascript\">alert('该学校设置不能发布新帖子');window.location.href='http://www.houxue.com/xuexiao/".$school["LoginId"]."/bbs/list-0.htm';</script>";exit();
	}

	$allow_file_upload_num=5-$alreadyNum>0 ? 5-$alreadyNum : 0;
	$smarty->assign("allow_file_upload_num", $allow_file_upload_num);

	$smarty->assign("session_id", session_id());

	$tplFile = "bbs_add.htm"; //使用框架结构式模板
}
elseif($flag=="addThreadSave")
{
	if($_SESSION["LoginUser"]["LoginId"]<=0)
	{
		header("Location:http://www.houxue.com/login.php?forward=http://www.houxue.com/xuexiao/".$school["LoginId"]."/bbs/add.htm");exit();
	}

	if($bbsBoard['IsAllowPost']!='yes')
	{
		echo "<script type=\"text/javascript\">alert('该学校设置不能发布新帖子');window.location.href='http://www.houxue.com/xuexiao/".$school["LoginId"]."/bbs/list-0.htm';</script>";exit();
	}

	unset($fieldList);
	$fieldList["BoardId"] = $bbsBoard["Id"];
	$fieldList["LoginId"] = $_SESSION["LoginUser"]["LoginId"];
	$fieldList["Subject"] = addslashes(trim($_POST["x_Subject"]));
	if($fieldList["Subject"]==''){echo "<script type=\"text/javascript\">alert('主题不能为空');history.go(-1);</script>";exit();}

	$fieldList["Content"] = addslashes(trim($_POST["x_Content"]));
	if($fieldList["Content"]==''){echo "<script type=\"text/javascript\">alert('帖子不能为空');history.go(-1);</script>";exit();}

	$fieldList["Dtt"]	  = time();
//	$fieldList["IsEssence"] = "";
//	$fieldList["IsTop"] = "";

	$StudyMaterial_Image=$_REQUEST["StudyMaterial_Image"];
	$StudyMaterial_Image_array=explode(",",$StudyMaterial_Image);
	if(!empty($StudyMaterial_Image_array))
	{
		$i=0;
		foreach($StudyMaterial_Image_array as $ImageId)
		{
			if($i>=5) break;
			if($ImageId>0)
			{
				$imagesIdList[]=$ImageId;
				$i++;
			}
		}
	}
	BbsBoard::insertThread($fieldList,$imagesIdList);
	header("Location:http://www.houxue.com/xuexiao/".$school["LoginId"]."/bbs/list-0.htm");exit();
}
elseif($flag=="addThreadReplySave")
{
	if($_SESSION["LoginUser"]["LoginId"]<=0)
	{
		header("Location:http://www.houxue.com/login.php?forward=http://www.houxue.com/xuexiao/".$school["LoginId"]."/bbs/add.htm");exit();
	}

	if($bbsBoard['IsAllowReply']!='yes')
	{
		echo "<script type=\"text/javascript\">alert('该学校设置不能回帖');window.location.href='http://www.houxue.com/xuexiao/".$school["LoginId"]."/bbs/list-0.htm';</script>";exit();
	}

	unset($fieldList);
	$fieldList["ThreadId"] = intval($_REQUEST["ThreadId"]);
	$fieldList["LoginId"] = $_SESSION["LoginUser"]["LoginId"];
	$fieldList["Content"] = addslashes(trim($_POST["x_Content"]));
	if($fieldList["Content"]==''){echo "<script type=\"text/javascript\">alert('帖子不能为空');history.go(-1);</script>";exit();}

	BbsBoard::insertThreadReply($fieldList);
	header("Location:http://www.houxue.com/xuexiao/".$school["LoginId"]."/bbs/thread-".intval($_REQUEST["ThreadId"])."-".intval($_REQUEST["pager_rownum"]).".htm");exit();
}
elseif($flag=="detail")
{
	$tplFile = "bbs_detail.htm"; //使用框架结构式模板

	//存在 LoginId 是否登录
	if($_SESSION["LoginUser"]["LoginId"]>0) $smarty->assign("LoginUserLoginId", $_SESSION["LoginUser"]["LoginId"]);

	$threadId=intval($_REQUEST["tid"]);
	$bbsThread=BbsBoard::getThreadDataById($threadId);
	if(!$bbsThread["Id"] || $bbsThread["BoardId"]!=$bbsBoard['Id'])
	{
		include(HOUXUE_ROOT."/missing.html");exit();
	}
	$userinfo=getUserInfo($bbsThread["LoginId"]);
	$bbsThread=array_merge($bbsThread,$userinfo);

	$smarty->assign("bbsThread", $bbsThread);

	//图片T_StudyMaterial_Image
	$sSql="select * from T_Bbs_Thread_Images where ThreadId='".$bbsThread["Id"]."' limit 5";
	$StudyMaterial_Image = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);
	$smarty->assign("StudyMaterial_Image", $StudyMaterial_Image);

	BbsBoard::increamentVisit($threadId);

	//存在“只看该作者” viewLoginId
	$viewLoginId=intval($_REQUEST["viewLoginId"]);
	if($viewLoginId) $viewLoginIdSql=" and LoginId='".$viewLoginId."'";

	//一页的记录数
	$pager_limit = $_REQUEST["pager_limit"]==""? 10 : $_REQUEST["pager_limit"];
	// 计算 limit ,处理翻页
	$pager_rownum = $_REQUEST["pager_rownum"] <=0 ? 0 : $_REQUEST["pager_rownum"];
	$slimit = " limit " . $pager_rownum . " , $pager_limit ";

	$smarty->assign("pager_rownum", $pager_rownum);

	//取得列表
	$sSql  = " select SQL_CALC_FOUND_ROWS * from T_Bbs_Thread_Reply where 1=1 and ThreadId='".$bbsThread["Id"]."' ".$viewLoginIdSql." order by Position ASC $slimit";
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
			$userinfo=getUserInfo($value["LoginId"]);
			$datas=array_merge($value,$userinfo);
			$bbsReplyList[]=$datas;
		}
	}
	$smarty->assign("bbsReplyList", $bbsReplyList);

	function change_url($tpl_output, &$smarty)
	{
		$tpl_output =preg_replace('/bbs\.php\?id=([0-9]+)*&flag=detail&tid=([0-9]+)*&pager_rownum=([0-9]+)*/','\1/bbs/thread-\2-\3.htm', $tpl_output);
		return $tpl_output;
	}
}
else
{

	//一页的记录数
	$pager_limit = $_REQUEST["pager_limit"]==""? 10 : $_REQUEST["pager_limit"];
	// 计算 limit ,处理翻页
	$pager_rownum = $_REQUEST["pager_rownum"] <=0 ? 0 : $_REQUEST["pager_rownum"];
	$slimit = " limit " . $pager_rownum . " , $pager_limit ";

	//取得列表
	$sSql  = " select SQL_CALC_FOUND_ROWS Id from T_Bbs_Thread where 1=1 and BoardId='".$bbsBoard['Id']."' order by IsTop asc,IsEssence asc,Id DESC $slimit";
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
			$sSql="select Id,LoginId,Subject,Dtt,Visit,ReplyCount,ImageCount,IsEssence,IsTop,LastReplyLoginId,LastReplyDtt from T_Bbs_Thread where Id=".$value["Id"];
			$data = $dbh2->query($sSql)->fetch(PDO::FETCH_ASSOC);
			if(!$data["LastReplyLoginId"])
			{
				$data["LastReplyLoginId"]=$data["LoginId"];
				$data["LastReplyDtt"]=$data["Dtt"];
			}
			$userinfo=getUserInfo($data["LastReplyLoginId"]);
			$data["LastReplName"]=$userinfo["Name"];

			$bbsThreadList[]=$data;
		}
	}
	$smarty->assign("bbsThreadList", $bbsThreadList);

	function change_url($tpl_output, &$smarty)
	{
		$tpl_output =preg_replace('/bbs\.php\?id=([0-9]+)*&flag=list&pager_rownum=([0-9]+)*/','\1/bbs/list-\2.htm', $tpl_output);
		return $tpl_output;
	}
}

$dbh = null;

ob_start();
//返回一个模板的输出
$smarty->display($tplFile);
ob_end_flush();


$time_end = microtime(true);
$time = $time_end - $time_start;
if($_SESSION["Admin"]["id"] == "8")echo "页面执行时间:".$time." 秒 t1=$t1 t2=$t2 t3=$t3";

function getUserInfo($LoginId)
{
	global $dbh2;
	$result=array();
	$res = $dbh2->query("select LoginId,TypeId from T_LoginUser where LoginId='".$LoginId."'")->fetch(PDO::FETCH_ASSOC);
	switch($res["TypeId"])
	{
		case "1":
			$data=$dbh2->query("select Name from T_Person where LoginId='".$LoginId."'")->fetch(PDO::FETCH_ASSOC);
			$result["Name"]=$data["Name"];
			$result["HomeUrl"]='';
			break;
		case "2":
			$objschool = new School($LoginId);
			$data = $objschool->getData();
			$result["Name"]=$data["ShortName"];
			$result["ImageId"]=$data["LogoImageId"];
			$result["HomeUrl"]='http://www.houxue.com/xuexiao/'.$LoginId.'/';
			break;
		case "3":
			$objTeacher=new TeacherByLoginId($dbh2,$LoginId);
			$data = $objTeacher->getData();
			$result["Name"]=$data["Name"];
			$result["ImageId"]=$data["FaceImageId"];
			$result["HomeUrl"]='http://www.houxue.com/laoshi/'.$LoginId.'/';
			break;
		default:
			$result["Name"]='未知';
	}
	return $result;
}

function dgmdate($timestamp)
{
	$nowtimestamp=time();
	$todaytimestamp = $nowtimestamp - $nowtimestamp % 86400;
	$time = $nowtimestamp - $timestamp;
	if($timestamp >= $todaytimestamp) {
		if($time > 3600) {
			$return = intval($time / 3600).'&nbsp;时前';
		} elseif($time > 1800) {
			$return = "半时前";
		} elseif($time > 60) {
			$return = intval($time / 60).'&nbsp;分前';
		} elseif($time > 0) {
			$return = $time.'&nbsp;秒前';
		} elseif($time == 0) {
			$return = "刚刚";
		} else {
			$return = date("Y-m-d", $timestamp);
		}
	} elseif(($days = intval(($todaytimestamp - $timestamp) / 86400)) >= 0 && $days < 7) {
		if($days == 0) {
			$return = '昨天&nbsp;'.date("H:i", $timestamp);
		} elseif($days == 1) {
			$return = '前天&nbsp;'.date("H:i", $timestamp);
		} else {
			$return = ($days + 1).'&nbsp;天前';
		}
	} else {
		$return = date("Y-m-d", $timestamp);
	}
	return $return;
}

?>