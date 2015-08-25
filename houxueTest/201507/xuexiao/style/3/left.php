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


//取得学校师资力量
$sSql  = " select T_Teacher.Id,Name,FaceImageId,Description from T_Teacher";
$sSql .= " where T_Teacher.SchoolLoginId='".$school["LoginId"]."' and FaceImageId>0";
$sSql .= " order by T_Teacher.SortId asc";
$teacherlist = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);
if( empty($teacherlist) )
{
	$sSql  = " select T_Teacher.Id,Name,FaceImageId,Description from T_Teacher";
	$sSql .= " where T_Teacher.SchoolLoginId='".$school["LoginId"]."'";
	$sSql .= " order by T_Teacher.SortId asc";
	$teacherlist = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);
}
$smarty->assign("teacherlist", $teacherlist);

//取得学校环境
$sSql  = " select * from T_School_Env where LoginId='".$school["LoginId"]."' order by Id asc";
$envlist = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);
$smarty->assign("envlist", $envlist);

//取得学校分校记录
$sSql  = " select * from T_School_Sub where T_School_Sub.LoginId = '".$school["LoginId"]."' order by Id asc";
$sublist = $dbh2->query($sSql)->fetchAll(PDO::FETCH_ASSOC);
$smarty->assign("sublist", $sublist);

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