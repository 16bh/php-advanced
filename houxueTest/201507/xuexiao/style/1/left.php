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
include_once(HOUXUE_ROOT."/modules/course.class.php");

//留言时预选选项
$prepareTextList = array();
$idlist = $dbh2->fetchAll("select * from T_Order_Prepare_Select_Text WHERE LoginId='".$school["LoginId"]."' ORDER BY SortId DESC,Id DESC limit 5");
if(!empty($idlist) && is_array($idlist))
{
	foreach($idlist as $value)
	{
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

//取得学校分校记录
$sSql  = " select * from T_School_Sub where T_School_Sub.LoginId = '".$school["LoginId"]."' order by Id asc";
$sublist = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);
$smarty->assign("sublist", $sublist);

//报名学员
$sSql  = " select '".__FILE__." line ".__line__."', T_Order.Id, T_Order.Name, T_Order.Phone, T_Order.Dtt, T_Order.CourseId, T_Course.Name as CourseName, T_Area.Domain";
$sSql .= " from T_Order";
$sSql .= "      left join T_Course on T_Order.CourseId = T_Course.Id ";
$sSql .= "      left join T_Area on T_Course.AreaId = T_Area.Id ";
$sSql .= " where T_Order.SchoolLoginId = '".$school["LoginId"]."' order by T_Order.Id desc limit 20";
$orderlist = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);
$smarty->assign("orderlist", $orderlist);

//取得学校评论
$sSql  = " select * from T_School_Comments where LoginId = '".$school["LoginId"]."' order by Id desc limit 10";
$commentlist = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);
$smarty->assign("commentlist", $commentlist);

//取得该学校的特别推荐课程
$courselist_recommend = array();
$sSql = " select '".__FILE__." line ".__line__."', T_Course.Id from T_Course where T_Course.LoginId = '".$school["LoginId"]."' and Recommend = 'yes' limit 0,8";
$idlist = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);
for($j = 0; $j < count($idlist); $j++)
{
	$objcourse = new Course($idlist[$j]["Id"]);
	$courselist_recommend[] = $objcourse->getData();
	$objcourse = null;
}
$smarty->assign("courselist_recommend", $courselist_recommend);

//取得该学校的新闻
$sSql  = " select Id,Title,DTT,AreaId,CategoryId,Click from T_News where T_News.LoginId='".$school["LoginId"]."' order by T_News.Id desc limit 10";
$newslist = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);
$smarty->assign("newslist", $newslist);


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